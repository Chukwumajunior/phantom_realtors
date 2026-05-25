<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\ListingStatus;
use App\Enums\PropertyCategory;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'price',
        'currency',
        'type',
        'category',
        'status',
        'listing_status',
        'address',
        'country',
        'city',
        'state',
        'lga',
        'bedrooms',
        'bathrooms',
        'toilets',
        'area_sqft',
        'year_built',
        'features',
        'is_featured',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'type' => PropertyType::class,
            'category' => PropertyCategory::class,
            'status' => PropertyStatus::class,
            'listing_status' => ListingStatus::class,
            'currency' => Currency::class,
            'features' => 'array',
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title) . '-' . Str::random(6);
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
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'itemable');
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', PropertyStatus::Available)
                     ->where('listing_status', ListingStatus::Active);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, PropertyType $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOfCategory($query, PropertyCategory $category)
    {
        return $query->where('category', $category);
    }

    public function scopeInCity($query, string $city)
    {
        return $query->where('city', $city);
    }

    public function scopePriceRange($query, ?float $min, ?float $max)
    {
        if ($min) $query->where('price', '>=', $min);
        if ($max) $query->where('price', '<=', $max);
        return $query;
    }

    public function scopePremiumVisible($query)
    {
        return $query->where('listing_status', ListingStatus::Active)
            ->where('status', PropertyStatus::Available);
    }

    public function scopePubliclyVisible($query)
    {
        return $query->where('listing_status', ListingStatus::Active)
            ->where('status', PropertyStatus::Available)
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

    // Accessors
    public function getFormattedPriceAttribute(): string
    {
        return format_price($this->price, $this->currency);
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $primary = $this->images->firstWhere('is_primary', true);
        return $primary ? asset('storage/' . $primary->image_path) : null;
    }
}
