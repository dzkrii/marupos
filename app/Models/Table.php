<?php

namespace App\Models;

use App\Models\Traits\BelongsToOutlet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes, BelongsToOutlet;

    protected $fillable = [
        'outlet_id',
        'table_area_id',
        'number',
        'name',
        'capacity',
        'status',
        'qr_code',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    const STATUS_AVAILABLE = 'available';
    const STATUS_OCCUPIED = 'occupied';
    const STATUS_RESERVED = 'reserved';
    const STATUS_MAINTENANCE = 'maintenance';

    /**
     * Get the outlet that owns this table.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Get the area this table belongs to.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(TableArea::class, 'table_area_id');
    }

    /**
     * Get all orders for this table.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get current active order for this table.
     */
    public function currentOrder()
    {
        return $this->orders()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->first();
    }

    /**
     * Check if table is available.
     */
    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    /**
     * Mark table as occupied.
     */
    public function occupy(): void
    {
        $this->update(['status' => self::STATUS_OCCUPIED]);
    }

    /**
     * Mark table as available.
     */
    public function release(): void
    {
        $this->update(['status' => self::STATUS_AVAILABLE]);
    }
}
