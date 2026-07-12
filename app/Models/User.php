<?php

namespace App\Models;

use App\Enums\PosterTier;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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

    // Poster/Tier helpers

    public function posterProfile(): HasOne
    {
        return $this->hasOne(MerchantProfile::class);
    }

    /**
     * Get total posts count across all listing types.
     */
    public function totalPostsCount(): int
    {
        return $this->properties()->count()
             + $this->products()->count()
             + $this->services()->count();
    }

    /**
     * Get unique categories used across all listing types.
     */
    public function usedCategories(): array
    {
        $categories = [];

        $categories = array_merge(
            $categories,
            $this->properties()->distinct()->pluck('category')->toArray()
        );
        $categories = array_merge(
            $categories,
            $this->products()->distinct()->pluck('category')->toArray()
        );
        $categories = array_merge(
            $categories,
            $this->services()->distinct()->pluck('category')->toArray()
        );

        return array_unique($categories);
    }

    /**
     * Check if user can create a new post based on their tier limits.
     */
    public function canCreatePost(?string $newCategory = null): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $profile = $this->merchantProfile;
        if (! $profile) {
            return false;
        }

        $tier = $profile->tier;

        // Check post limit
        $maxPosts = $tier->maxPosts();
        if ($maxPosts !== null && $this->totalPostsCount() >= $maxPosts) {
            return false;
        }

        // Check category limit
        if ($newCategory) {
            $maxCategories = $tier->maxCategories();
            $usedCategories = $this->usedCategories();
            if ($maxCategories !== null && ! in_array($newCategory, $usedCategories) && count($usedCategories) >= $maxCategories) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get remaining posts allowed for the user's tier.
     */
    public function remainingPosts(): ?int
    {
        $profile = $this->merchantProfile;
        if (! $profile) {
            return 0;
        }

        $maxPosts = $profile->tier->maxPosts();
        if ($maxPosts === null) {
            return null; // unlimited
        }

        return max(0, $maxPosts - $this->totalPostsCount());
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
