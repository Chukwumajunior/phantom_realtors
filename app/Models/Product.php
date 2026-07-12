<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\ListingStatus;
use App\Enums\ProductCategory;
use App\Enums\ProductSubCategory;
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
        'sub_category',
        'price',
        'currency',
        'stock_quantity',
        'listing_status',
        'brand',
        'condition',
        'specifications',
        'location_house_number',
        'location_street_name',
        'location_area',
        'location_lga',
        'location_state',
        'location_zip_code',
        'location_country',
        'is_featured',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'category' => ProductCategory::class,
            'sub_category' => ProductSubCategory::class,
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
        return $query->where('listing_status', ListingStatus::Active)
            ->whereHas('user');
    }

    public function scopePubliclyVisible($query)
    {
        return $query->where('listing_status', ListingStatus::Active)
            ->whereHas('user');
    }

    public function scopeInState($query, string $state)
    {
        return $query->where('location_state', $state);
    }

    public function scopeInLga($query, string $lga)
    {
        return $query->where('location_lga', $lga);
    }

    public function scopeOfSubCategory($query, ProductSubCategory $subCategory)
    {
        return $query->where('sub_category', $subCategory);
    }

    public function getLocationAttribute(): string
    {
        $parts = array_filter([
            $this->location_area,
            $this->location_lga,
            $this->location_state,
        ]);

        return implode(', ', $parts);
    }
}
