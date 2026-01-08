<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap Token for subscription payment.
     */
    public function createSnapToken(Subscription $subscription): string
    {
        $plan = $subscription->plan;

        $params = [
            'transaction_details' => [
                'order_id' => $subscription->order_id,
                'gross_amount' => $subscription->amount,
            ],
            'item_details' => [
                [
                    'id' => $plan->slug,
                    'price' => $subscription->amount,
                    'quantity' => 1,
                    'name' => "Langganan {$plan->name} ({$subscription->billing_cycle})",
                ],
            ],
            'customer_details' => [
                'first_name' => $subscription->temp_name,
                'email' => $subscription->temp_email,
                'phone' => $subscription->temp_phone ?? '',
            ],
            'callbacks' => [
                'finish' => route('subscription.finish', ['order_id' => $subscription->order_id]),
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 24,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        
        $subscription->update(['snap_token' => $snapToken]);

        return $snapToken;
    }

    /**
     * Handle notification callback from Midtrans.
     */
    public function handleNotification(): array
    {
        $notification = new Notification();

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $fraudStatus = $notification->fraud_status ?? 'accept';
        $transactionId = $notification->transaction_id;

        $subscription = Subscription::where('order_id', $orderId)->first();

        if (!$subscription) {
            return [
                'success' => false,
                'message' => 'Subscription not found',
            ];
        }

        $paymentDetails = [
            'transaction_status' => $transactionStatus,
            'payment_type' => $paymentType,
            'fraud_status' => $fraudStatus,
            'transaction_id' => $transactionId,
            'notification_time' => now()->toIso8601String(),
        ];

        // Handle transaction status
        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card') {
                if ($fraudStatus == 'accept') {
                    $this->markAsPaid($subscription, $paymentType, $transactionId, $paymentDetails);
                } else {
                    $subscription->markAsFailed($paymentDetails);
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $this->markAsPaid($subscription, $paymentType, $transactionId, $paymentDetails);
        } elseif ($transactionStatus == 'pending') {
            $subscription->update([
                'payment_type' => $paymentType,
                'transaction_id' => $transactionId,
                'payment_details' => array_merge($subscription->payment_details ?? [], $paymentDetails),
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $subscription->update([
                'status' => $transactionStatus === 'expire' ? 'expired' : 'failed',
                'payment_details' => array_merge($subscription->payment_details ?? [], $paymentDetails),
            ]);
        }

        return [
            'success' => true,
            'subscription' => $subscription,
            'status' => $transactionStatus,
        ];
    }

    /**
     * Mark subscription as paid and calculate expiration.
     */
    protected function markAsPaid(Subscription $subscription, string $paymentType, string $transactionId, array $paymentDetails): void
    {
        $subscription->update([
            'status' => 'paid',
            'payment_type' => $paymentType,
            'transaction_id' => $transactionId,
            'paid_at' => now(),
            'expires_at' => $subscription->calculateExpirationDate(),
            'payment_details' => array_merge($subscription->payment_details ?? [], $paymentDetails),
        ]);
    }

    /**
     * Get Snap URL for redirect.
     */
    public function getSnapUrl(): string
    {
        return config('midtrans.snap_url');
    }

    /**
     * Get Client Key for frontend.
     */
    public function getClientKey(): string
    {
        return config('midtrans.client_key');
    }
}
