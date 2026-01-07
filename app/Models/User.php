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
            ->withPivot(['role', 'is_default'])
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
     * Get user's role at a specific outlet.
     */
    public function roleAt(Outlet $outlet): ?string
    {
        $pivot = $this->outlets()->where('outlet_id', $outlet->id)->first();
        return $pivot?->pivot->role;
    }

    /**
     * Check if user has access to a specific outlet.
     */
    public function hasAccessTo(Outlet $outlet): bool
    {
        return $this->outlets()->where('outlet_id', $outlet->id)->exists();
    }

    /**
     * Check if user is owner/manager at any outlet.
     */
    public function isManager(): bool
    {
        return $this->outlets()
            ->wherePivotIn('role', ['owner', 'manager'])
            ->exists();
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

