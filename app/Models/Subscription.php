<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'subscription_plan_id',
        'company_id',
        'billing_cycle',
        'amount',
        'status',
        'payment_type',
        'transaction_id',
        'snap_token',
        'payment_details',
        'paid_at',
        'expires_at',
        'temp_name',
        'temp_email',
        'temp_phone',
        'temp_restaurant_name',
    ];

    protected $casts = [
        'payment_details' => 'array',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'amount' => 'integer',
    ];

    /**
     * Get the subscription plan.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * Get the company (tenant).
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Check if subscription is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if subscription is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if subscription is active (paid and not expired).
     */
    public function isActive(): bool
    {
        if (!$this->isPaid()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Mark subscription as paid.
     */
    public function markAsPaid(array $paymentDetails = []): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_details' => array_merge($this->payment_details ?? [], $paymentDetails),
        ]);
    }

    /**
     * Mark subscription as failed.
     */
    public function markAsFailed(array $paymentDetails = []): void
    {
        $this->update([
            'status' => 'failed',
            'payment_details' => array_merge($this->payment_details ?? [], $paymentDetails),
        ]);
    }

    /**
     * Generate unique order ID.
     */
    public static function generateOrderId(): string
    {
        return 'RESTOZEN-' . strtoupper(uniqid()) . '-' . time();
    }

    /**
     * Calculate expiration date based on billing cycle.
     */
    public function calculateExpirationDate(): \Carbon\Carbon
    {
        $startDate = $this->paid_at ?? now();
        
        return $this->billing_cycle === 'yearly' 
            ? $startDate->addYear() 
            : $startDate->addMonth();
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Scope for paid subscriptions.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope for pending subscriptions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
