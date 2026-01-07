<?php

namespace App\Models;

use App\Models\Traits\BelongsToOutlet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes, BelongsToOutlet;

    protected $fillable = [
        'outlet_id',
        'menu_category_id',
        'name',
        'slug',
        'sku',
        'description',
        'image',
        'price',
        'cost_price',
        'stock',
        'track_stock',
        'is_available',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'track_stock' => 'boolean',
        'is_available' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the outlet that owns this menu item.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Get the category of this menu item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    /**
     * Get all order items for this menu item.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope to only active and available items.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)->where('is_available', true);
    }

    /**
     * Check if item is in stock.
     */
    public function isInStock(): bool
    {
        if (!$this->track_stock || $this->stock === null) {
            return true;
        }
        return $this->stock > 0;
    }

    /**
     * Decrease stock by quantity.
     */
    public function decreaseStock(int $quantity): void
    {
        if ($this->track_stock && $this->stock !== null) {
            $this->decrement('stock', $quantity);
        }
    }
}
