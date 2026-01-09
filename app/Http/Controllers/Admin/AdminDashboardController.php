<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Platform Statistics
        $stats = [
            // User & Company Stats
            'total_companies' => Company::count(),
            'total_users' => User::count(),
            'total_outlets' => Outlet::count(),
            'active_companies' => Company::where('is_active', true)->count(),

            // Subscription Stats
            'total_subscriptions' => Subscription::count(),
            'active_subscriptions' => Subscription::where('status', 'paid')
                ->where(function ($q) {
                    $q->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })->count(),
            'pending_subscriptions' => Subscription::where('status', 'pending')->count(),
            'expired_subscriptions' => Subscription::where('status', 'paid')
                ->whereNotNull('expires_at')
                ->where('expires_at', '<', now())
                ->count(),

            // Revenue Stats
            'total_revenue' => Subscription::where('status', 'paid')->sum('amount'),
            'this_month_revenue' => Subscription::where('status', 'paid')
                ->whereBetween('paid_at', [$startOfMonth, $endOfMonth])
                ->sum('amount'),
            'last_month_revenue' => Subscription::where('status', 'paid')
                ->whereBetween('paid_at', [$startOfLastMonth, $endOfLastMonth])
                ->sum('amount'),

            // Growth calculations
            'revenue_growth' => 0,
            'companies_growth' => 0,

            // Order Stats (platform-wide)
            'total_orders' => Order::count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'total_transaction_value' => Order::where('status', Order::STATUS_COMPLETED)->sum('total_amount'),

            // Monthly data for charts
            'monthly_revenue' => [],
            'monthly_companies' => [],
            'months' => [],
        ];

        // Calculate growth
        if ($stats['last_month_revenue'] > 0) {
            $stats['revenue_growth'] = (($stats['this_month_revenue'] - $stats['last_month_revenue']) / $stats['last_month_revenue']) * 100;
        } elseif ($stats['this_month_revenue'] > 0) {
            $stats['revenue_growth'] = 100;
        }

        // Companies growth
        $thisMonthCompanies = Company::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $lastMonthCompanies = Company::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        
        if ($lastMonthCompanies > 0) {
            $stats['companies_growth'] = (($thisMonthCompanies - $lastMonthCompanies) / $lastMonthCompanies) * 100;
        } elseif ($thisMonthCompanies > 0) {
            $stats['companies_growth'] = 100;
        }

        // Monthly Revenue & Companies Chart Data (Last 12 months)
        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            $revenue = Subscription::where('status', 'paid')
                ->whereBetween('paid_at', [$start, $end])
                ->sum('amount');

            $companies = Company::whereBetween('created_at', [$start, $end])->count();

            $stats['monthly_revenue'][] = $revenue;
            $stats['monthly_companies'][] = $companies;
            $stats['months'][] = $date->format('M');
        }

        // Recent Subscriptions
        $recentSubscriptions = Subscription::with(['plan', 'company'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Companies
        $recentCompanies = Company::with('outlets')
            ->latest()
            ->take(5)
            ->get();

        // Subscription Plans Stats
        $planStats = SubscriptionPlan::withCount([
            'subscriptions as active_count' => function ($q) {
                $q->where('status', 'paid')
                    ->where(function ($q2) {
                        $q2->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    });
            }
        ])->active()->ordered()->get();

        // Expiring Soon (next 7 days)
        $expiringSoon = Subscription::with(['company', 'plan'])
            ->where('status', 'paid')
            ->whereBetween('expires_at', [now(), now()->addDays(7)])
            ->orderBy('expires_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentSubscriptions',
            'recentCompanies',
            'planStats',
            'expiringSoon'
        ));
    }

    /**
     * List all companies
     */
    public function companies(Request $request)
    {
        $query = Company::with(['outlets', 'users']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $companies = $query->latest()->paginate(15);

        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show company details
     */
    public function showCompany(Company $company)
    {
        $company->load(['outlets', 'users']);

        $subscriptions = Subscription::where('company_id', $company->id)
            ->with('plan')
            ->latest()
            ->get();

        // Company's total orders & revenue
        $outletIds = $company->outlets->pluck('id');
        $totalOrders = Order::whereIn('outlet_id', $outletIds)->count();
        $totalRevenue = Order::whereIn('outlet_id', $outletIds)
            ->where('status', Order::STATUS_COMPLETED)
            ->sum('total_amount');

        return view('admin.companies.show', compact(
            'company',
            'subscriptions',
            'totalOrders',
            'totalRevenue'
        ));
    }

    /**
     * List all subscriptions
     */
    public function subscriptions(Request $request)
    {
        $query = Subscription::with(['company', 'plan']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('subscription_plan_id', $request->plan);
        }

        $subscriptions = $query->latest()->paginate(15);
        $plans = SubscriptionPlan::active()->ordered()->get();

        return view('admin.subscriptions.index', compact('subscriptions', 'plans'));
    }
}
