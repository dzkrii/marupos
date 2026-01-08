<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'max_outlets',
        'max_tables',
        'max_employees',
        'features',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price_monthly' => 'integer',
        'price_yearly' => 'integer',
        'max_outlets' => 'integer',
        'max_tables' => 'integer',
        'max_employees' => 'integer',
    ];

    /**
     * Get all subscriptions for this plan.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get formatted monthly price.
     */
    public function getFormattedMonthlyPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_monthly, 0, ',', '.');
    }

    /**
     * Get formatted yearly price.
     */
    public function getFormattedYearlyPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_yearly, 0, ',', '.');
    }

    /**
     * Get yearly savings percentage.
     */
    public function getYearlySavingsPercentAttribute(): int
    {
        $monthlyTotal = $this->price_monthly * 12;
        if ($monthlyTotal <= 0) return 0;
        return (int) round((($monthlyTotal - $this->price_yearly) / $monthlyTotal) * 100);
    }

    /**
     * Scope for active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
