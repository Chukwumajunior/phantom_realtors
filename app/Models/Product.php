<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\ListingStatus;
use App\Enums\ProductCategory;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'category',
        'price',
        'currency',
        'stock_quantity',
        'listing_status',
        'brand',
        'condition',
        'specifications',
        'is_featured',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'category' => ProductCategory::class,
            'listing_status' => ListingStatus::class,
            'currency' => Currency::class,
            'specifications' => 'array',
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(6);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'itemable');
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return format_price($this->price, $this->currency);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('listing_status', ListingStatus::Active);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeOfCategory($query, ProductCategory $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePremiumVisible($query)
    {
        return $query->where('listing_status', ListingStatus::Active);
    }

    public function scopePubliclyVisible($query)
    {
        return $query->where('listing_status', ListingStatus::Active)
            ->whereHas('user', function ($q) {
                $q->where(function ($q2) {
                    $q2->where('role', UserRole::Admin)
                        ->orWhereHas('subscriptions', function ($q3) {
                            $q3->where('status', SubscriptionStatus::Active->value)
                                ->where('expires_at', '>', now());
                        });
                });
            });
    }
}
