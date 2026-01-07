<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OutletScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * This scope automatically filters queries by the current outlet.
     * It reads the outlet ID from the session or authenticated user's default outlet.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $outletId = $this->getCurrentOutletId();

        if ($outletId) {
            $builder->where($model->getTable() . '.outlet_id', $outletId);
        }
    }

    /**
     * Get current outlet ID from session or user.
     */
    protected function getCurrentOutletId(): ?int
    {
        // First check session for active outlet
        if (session()->has('current_outlet_id')) {
            return session('current_outlet_id');
        }

        // Fall back to authenticated user's default outlet
        $user = auth()->user();
        if ($user && method_exists($user, 'defaultOutlet')) {
            $outlet = $user->defaultOutlet();
            return $outlet?->id;
        }

        return null;
    }
}
