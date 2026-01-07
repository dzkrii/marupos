<?php

namespace App\Models\Traits;

use App\Models\Scopes\OutletScope;

trait BelongsToOutlet
{
    /**
     * Boot the trait.
     *
     * Automatically applies OutletScope to filter queries by current outlet.
     * Also auto-sets outlet_id when creating new records.
     */
    public static function bootBelongsToOutlet(): void
    {
        // Apply outlet scope for automatic filtering
        static::addGlobalScope(new OutletScope);

        // Auto-set outlet_id when creating
        static::creating(function ($model) {
            if (empty($model->outlet_id)) {
                $model->outlet_id = static::getCurrentOutletId();
            }
        });
    }

    /**
     * Get current outlet ID.
     */
    protected static function getCurrentOutletId(): ?int
    {
        // First check session
        if (session()->has('current_outlet_id')) {
            return session('current_outlet_id');
        }

        // Fall back to user's default outlet
        $user = auth()->user();
        if ($user && method_exists($user, 'defaultOutlet')) {
            $outlet = $user->defaultOutlet();
            return $outlet?->id;
        }

        return null;
    }

    /**
     * Scope to query without outlet filter.
     *
     * Use this for cross-outlet reports or admin queries.
     */
    public function scopeWithoutOutletScope($query)
    {
        return $query->withoutGlobalScope(OutletScope::class);
    }

    /**
     * Scope to query specific outlet.
     */
    public function scopeForOutlet($query, int $outletId)
    {
        return $query->withoutGlobalScope(OutletScope::class)
            ->where('outlet_id', $outletId);
    }

    /**
     * Scope to query multiple outlets (for cross-outlet reports).
     */
    public function scopeForOutlets($query, array $outletIds)
    {
        return $query->withoutGlobalScope(OutletScope::class)
            ->whereIn('outlet_id', $outletIds);
    }
}
