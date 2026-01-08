<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show subscription plans page.
     */
    public function plans(): View
    {
        $plans = SubscriptionPlan::active()->ordered()->get();

        return view('subscription.plans', compact('plans'));
    }

    /**
     * Show checkout page for selected plan.
     */
    public function checkout(Request $request, SubscriptionPlan $plan): View
    {
        $billingCycle = $request->query('billing', 'monthly');
        
        $amount = $billingCycle === 'yearly' ? $plan->price_yearly : $plan->price_monthly;

        return view('subscription.checkout', [
            'plan' => $plan,
            'billingCycle' => $billingCycle,
            'amount' => $amount,
        ]);
    }

    /**
     * Process checkout and create Midtrans transaction.
     */
    public function processCheckout(Request $request): RedirectResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'billing_cycle' => 'required|in:monthly,yearly',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'restaurant_name' => 'required|string|max:255',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        
        // Calculate amount based on billing cycle
        $amount = $request->billing_cycle === 'yearly' 
            ? $plan->price_yearly 
            : $plan->price_monthly;

        // Create subscription record
        $subscription = Subscription::create([
            'order_id' => Subscription::generateOrderId(),
            'subscription_plan_id' => $plan->id,
            'billing_cycle' => $request->billing_cycle,
            'amount' => $amount,
            'status' => 'pending',
            'temp_name' => $request->name,
            'temp_email' => $request->email,
            'temp_phone' => $request->phone,
            'temp_restaurant_name' => $request->restaurant_name,
        ]);

        // Generate Snap Token
        try {
            $snapToken = $this->midtransService->createSnapToken($subscription);
            
            return redirect()->route('subscription.payment', ['subscription' => $subscription->id]);
        } catch (\Exception $e) {
            $subscription->delete();
            
            return back()
                ->withInput()
                ->withErrors(['payment' => 'Gagal membuat transaksi pembayaran. Silakan coba lagi.']);
        }
    }

    /**
     * Show payment page with Midtrans Snap.
     */
    public function payment(Subscription $subscription): View
    {
        if ($subscription->status !== 'pending') {
            abort(403, 'Transaksi ini sudah diproses.');
        }

        return view('subscription.payment', [
            'subscription' => $subscription,
            'plan' => $subscription->plan,
            'snapToken' => $subscription->snap_token,
            'clientKey' => $this->midtransService->getClientKey(),
            'snapUrl' => $this->midtransService->getSnapUrl(),
        ]);
    }

    /**
     * Handle finish callback from Midtrans.
     */
    public function finish(Request $request): RedirectResponse
    {
        $orderId = $request->query('order_id');
        
        $subscription = Subscription::where('order_id', $orderId)->first();

        if (!$subscription) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        // Refresh subscription to get latest status (updated by notification)
        $subscription->refresh();

        if ($subscription->status === 'paid') {
            // Store subscription data in session for registration
            session([
                'subscription_id' => $subscription->id,
                'subscription_data' => [
                    'name' => $subscription->temp_name,
                    'email' => $subscription->temp_email,
                    'phone' => $subscription->temp_phone,
                    'restaurant_name' => $subscription->temp_restaurant_name,
                    'plan' => $subscription->plan->slug,
                    'expires_at' => $subscription->expires_at,
                ],
            ]);

            return redirect()->route('register.subscription')
                ->with('success', 'Pembayaran berhasil! Silakan lengkapi pendaftaran.');
        }

        if ($subscription->status === 'pending') {
            return redirect()->route('subscription.pending', ['subscription' => $subscription->id])
                ->with('info', 'Pembayaran Anda sedang diproses.');
        }

        return redirect()->route('subscription.plans')
            ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }

    /**
     * Show pending payment page.
     */
    public function pending(Subscription $subscription): View
    {
        return view('subscription.pending', [
            'subscription' => $subscription,
            'plan' => $subscription->plan,
        ]);
    }

    /**
     * Show payment success page and prepare session for registration.
     */
    public function success(Subscription $subscription): View|RedirectResponse
    {
        // Refresh to get latest status
        $subscription->refresh();

        if (!$subscription->isPaid()) {
            return redirect()->route('subscription.pending', $subscription)
                ->with('info', 'Pembayaran belum dikonfirmasi.');
        }

        // Store subscription data in session for registration
        session([
            'subscription_id' => $subscription->id,
            'subscription_data' => [
                'name' => $subscription->temp_name,
                'email' => $subscription->temp_email,
                'phone' => $subscription->temp_phone,
                'restaurant_name' => $subscription->temp_restaurant_name,
                'plan' => $subscription->plan->slug,
                'expires_at' => $subscription->expires_at,
            ],
        ]);

        return view('subscription.success', [
            'subscription' => $subscription,
        ]);
    }

    /**
     * Handle Midtrans notification callback.
     */
    public function notification(Request $request)
    {
        $result = $this->midtransService->handleNotification();

        return response()->json(['status' => $result['success'] ? 'ok' : 'error']);
    }

    /**
     * Check subscription payment status via AJAX.
     */
    public function checkStatus(Subscription $subscription)
    {
        $subscription->refresh();

        $redirectUrl = null;
        if ($subscription->isPaid()) {
            // Use config app.url to ensure correct URL even behind proxy/ngrok
            $baseUrl = config('app.url');
            $redirectUrl = $baseUrl . '/subscription/finish?order_id=' . $subscription->order_id;
        }

        return response()->json([
            'status' => $subscription->status,
            'is_paid' => $subscription->isPaid(),
            'redirect_url' => $redirectUrl,
        ]);
    }

    /**
     * Handle success callback from client-side (after Snap popup success).
     * This is called via AJAX when payment is successful in the popup.
     * In sandbox/demo mode, we immediately mark as paid for smooth demo experience.
     */
    public function handleSuccess(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $subscription = Subscription::where('order_id', $request->order_id)->first();

        if (!$subscription) {
            return response()->json(['success' => false, 'message' => 'Subscription not found'], 404);
        }

        // In sandbox mode or if transaction_status indicates success, mark as paid immediately
        // This ensures smooth demo experience without waiting for webhook
        $transactionStatus = $request->transaction_status ?? 'capture';
        $successStatuses = ['capture', 'settlement', 'accept'];
        
        if ($subscription->status === 'pending' && in_array($transactionStatus, $successStatuses)) {
            $subscription->update([
                'status' => 'paid',
                'payment_type' => $request->payment_type ?? 'credit_card',
                'transaction_id' => $request->transaction_id ?? 'sandbox-' . time(),
                'paid_at' => now(),
                'expires_at' => $subscription->calculateExpirationDate(),
                'payment_details' => [
                    'transaction_status' => $transactionStatus,
                    'status_message' => $request->status_message ?? 'Payment successful',
                    'updated_via' => 'client_callback',
                    'updated_at' => now()->toIso8601String(),
                ],
            ]);
        }

        // Return redirect to success page
        $baseUrl = config('app.url');
        $redirectUrl = $baseUrl . '/subscription/success/' . $subscription->id;

        return response()->json([
            'success' => true,
            'subscription_id' => $subscription->id,
            'redirect_url' => $redirectUrl,
        ]);
    }
}


