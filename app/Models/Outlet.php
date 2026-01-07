<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'code',
        'phone',
        'address',
        'city',
        'timezone',
        'opening_time',
        'closing_time',
        'is_active',
    ];

    protected $casts = [
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /**
     * Get the company that owns the outlet.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get all users that have access to this outlet.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'outlet_user')
            ->withPivot(['role', 'is_default'])
            ->withTimestamps();
    }

    /**
     * Get all menu categories for this outlet.
     */
    public function menuCategories(): HasMany
    {
        return $this->hasMany(MenuCategory::class);
    }

    /**
     * Get all menu items for this outlet.
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get all table areas for this outlet.
     */
    public function tableAreas(): HasMany
    {
        return $this->hasMany(TableArea::class);
    }

    /**
     * Get all tables for this outlet.
     */
    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }

    /**
     * Get all orders for this outlet.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if outlet is currently open.
     */
    public function isOpen(): bool
    {
        if (!$this->opening_time || !$this->closing_time) {
            return true; // No hours set = always open
        }

        $now = now()->setTimezone($this->timezone);
        $openTime = $now->copy()->setTimeFromTimeString($this->opening_time->format('H:i'));
        $closeTime = $now->copy()->setTimeFromTimeString($this->closing_time->format('H:i'));

        return $now->between($openTime, $closeTime);
    }
}
