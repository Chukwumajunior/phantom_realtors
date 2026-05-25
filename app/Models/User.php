<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'role',
        'status',
        'phone',
        'address',
        'city',
        'state',
        'avatar',
        'bio',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => UserStatus::class,
        ];
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isMerchant(): bool
    {
        return $this->role === UserRole::Merchant;
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    // Relationships
    public function merchantProfile(): HasOne
    {
        return $this->hasOne(MerchantProfile::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function merchantOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'merchant_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()->active()->latest('expires_at')->first();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->isAdmin() || $this->subscriptions()->active()->exists();
    }

    // Scopes
    public function scopeRole($query, UserRole $role)
    {
        return $query->where('role', $role);
    }

    public function scopeActive($query)
    {
        return $query->where('status', UserStatus::Active);
    }

    public function scopeMerchants($query)
    {
        return $query->where('role', UserRole::Merchant);
    }
}
