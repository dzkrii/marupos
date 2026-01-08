<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'avatar',
        'pin',
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the company that the user belongs to.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get all outlets that the user has access to.
     */
    public function outlets(): BelongsToMany
    {
        return $this->belongsToMany(Outlet::class, 'outlet_user')
            ->withPivot(['capabilities', 'is_default'])
            ->withTimestamps();
    }

    /**
     * Get the user's default outlet.
     */
    public function defaultOutlet(): ?Outlet
    {
        return $this->outlets()->wherePivot('is_default', true)->first()
            ?? $this->outlets()->first();
    }

    /**
     * Get user's capabilities at a specific outlet.
     */
    public function capabilitiesAt(Outlet $outlet): array
    {
        $pivot = $this->outlets()->where('outlet_id', $outlet->id)->first();
        
        if (!$pivot) {
            return [];
        }
        
        $capabilities = $pivot->pivot->capabilities ?? [];
        
        // Ensure it's an array
        if (is_string($capabilities)) {
            $capabilities = json_decode($capabilities, true) ?? [];
        }
        
        return $capabilities;
    }

    /**
     * Check if user has a specific capability at outlet.
     */
    public function hasCapability(string $capability, ?Outlet $outlet = null): bool
    {
        $outlet = $outlet ?? $this->current_outlet;
        
        if (!$outlet) {
            return false;
        }
        
        return in_array($capability, $this->capabilitiesAt($outlet));
    }

    /**
     * Check if user has any of the specified capabilities at outlet.
     */
    public function hasAnyCapability(array $capabilities, ?Outlet $outlet = null): bool
    {
        $outlet = $outlet ?? $this->current_outlet;
        
        if (!$outlet) {
            return false;
        }
        
        $userCapabilities = $this->capabilitiesAt($outlet);
        
        foreach ($capabilities as $capability) {
            if (in_array($capability, $userCapabilities)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if user has all of the specified capabilities at outlet.
     */
    public function hasAllCapabilities(array $capabilities, ?Outlet $outlet = null): bool
    {
        $outlet = $outlet ?? $this->current_outlet;
        
        if (!$outlet) {
            return false;
        }
        
        $userCapabilities = $this->capabilitiesAt($outlet);
        
        foreach ($capabilities as $capability) {
            if (!in_array($capability, $userCapabilities)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get user's display role based on capabilities (for backward compatibility).
     */
    public function displayRoleAt(Outlet $outlet): string
    {
        $capabilities = $this->capabilitiesAt($outlet);
        
        // Determine display role based on capabilities
        if (count($capabilities) >= 7 && in_array('employees', $capabilities) && in_array('reports', $capabilities)) {
            return 'Owner';
        }
        
        if (in_array('employees', $capabilities) || in_array('reports', $capabilities)) {
            return 'Manager';
        }
        
        if (in_array('cashier', $capabilities) && in_array('kitchen', $capabilities)) {
            return 'Kasir + Kitchen';
        }
        
        if (in_array('cashier', $capabilities)) {
            return 'Kasir';
        }
        
        if (in_array('kitchen', $capabilities)) {
            return 'Kitchen';
        }
        
        if (in_array('orders', $capabilities)) {
            return 'Pelayan';
        }
        
        return 'Staff';
    }

    /**
     * Check if user has access to a specific outlet.
     */
    public function hasAccessTo(Outlet $outlet): bool
    {
        return $this->outlets()->where('outlet_id', $outlet->id)->exists();
    }

    /**
     * Check if user is owner/manager (has employees or reports capability) at current outlet.
     */
    public function isManager(): bool
    {
        $outlet = $this->current_outlet;
        
        if (!$outlet) {
            return false;
        }
        
        return $this->hasAnyCapability(['employees', 'reports'], $outlet);
    }

    /**
     * Get the current active outlet from session or default.
     */
    public function getCurrentOutletAttribute(): ?Outlet
    {
        $outletId = session('current_outlet_id');

        if ($outletId) {
            $outlet = $this->outlets()->where('outlet_id', $outletId)->first();
            if ($outlet) {
                return $outlet;
            }
        }

        return $this->defaultOutlet();
    }
}

