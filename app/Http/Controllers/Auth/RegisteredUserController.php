<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Outlet;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * Redirect to subscription plans if no active subscription session.
     */
    public function create(): View|RedirectResponse
    {
        // Redirect to subscription plans - user must subscribe first
        return redirect()->route('subscription.plans');
    }

    /**
     * Display registration form for users with paid subscription.
     */
    public function createWithSubscription(): View|RedirectResponse
    {
        // Check if user has valid subscription session
        if (!session()->has('subscription_id') || !session()->has('subscription_data')) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Silakan pilih paket berlangganan terlebih dahulu.');
        }

        $subscriptionData = session('subscription_data');

        return view('auth.register-subscription', [
            'subscriptionData' => $subscriptionData,
        ]);
    }

    /**
     * Handle registration for users with paid subscription.
     */
    public function storeWithSubscription(Request $request): RedirectResponse
    {
        // Verify subscription session exists
        if (!session()->has('subscription_id') || !session()->has('subscription_data')) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Sesi pendaftaran tidak valid. Silakan ulangi proses berlangganan.');
        }

        $subscriptionId = session('subscription_id');
        $subscriptionData = session('subscription_data');

        // Verify subscription is still valid
        $subscription = Subscription::find($subscriptionId);
        if (!$subscription || !$subscription->isPaid()) {
            session()->forget(['subscription_id', 'subscription_data']);
            return redirect()->route('subscription.plans')
                ->with('error', 'Langganan tidak valid. Silakan ulangi proses pembayaran.');
        }

        // Check if email is already registered
        if (User::where('email', $subscriptionData['email'])->exists()) {
            session()->forget(['subscription_id', 'subscription_data']);
            return redirect()->route('login')
                ->with('error', 'Email sudah terdaftar. Silakan login.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Use transaction to ensure all or nothing
        $user = DB::transaction(function () use ($request, $subscription, $subscriptionData) {
            // Create company (tenant)
            $company = Company::create([
                'name' => $subscriptionData['restaurant_name'],
                'slug' => Str::slug($subscriptionData['restaurant_name']) . '-' . Str::random(5),
                'email' => $subscriptionData['email'],
                'phone' => $subscriptionData['phone'],
                'subscription_plan' => $subscriptionData['plan'],
                'subscription_expires_at' => $subscriptionData['expires_at'],
                'is_active' => true,
            ]);

            // Update subscription with company_id
            $subscription->update([
                'company_id' => $company->id,
            ]);

            // Create default outlet
            $outlet = Outlet::create([
                'company_id' => $company->id,
                'name' => $subscriptionData['restaurant_name'] . ' - Pusat',
                'slug' => 'pusat',
                'code' => strtoupper(Str::random(6)),
                'phone' => $subscriptionData['phone'],
                'timezone' => 'Asia/Jakarta',
                'is_active' => true,
            ]);

            // Create owner user
            $user = User::create([
                'company_id' => $company->id,
                'name' => $subscriptionData['name'],
                'email' => $subscriptionData['email'],
                'phone' => $subscriptionData['phone'],
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // Attach user to outlet as owner
            $user->outlets()->attach($outlet->id, [
                'role' => 'owner',
                'is_default' => true,
            ]);

            return $user;
        });

        // Clear subscription session
        session()->forget(['subscription_id', 'subscription_data']);

        event(new Registered($user));

        Auth::login($user);

        // Set current outlet in session
        session(['current_outlet_id' => $user->defaultOutlet()?->id]);

        return redirect(route('dashboard', absolute: false))
            ->with('success', 'Selamat datang di RestoZen! Akun Anda telah berhasil diaktifkan.');
    }

    /**
     * Handle an incoming registration request (legacy - redirects to subscription).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Redirect to subscription flow
        return redirect()->route('subscription.plans')
            ->with('info', 'Untuk mendaftar, silakan pilih paket berlangganan terlebih dahulu.');
    }
}

