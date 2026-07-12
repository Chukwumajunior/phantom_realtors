<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\ListingStatus;
use App\Enums\ServiceCategory;
use App\Enums\ServiceGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'category',
        'price_from',
        'price_to',
        'currency',
        'is_negotiable',
        'listing_status',
        'service_area',
        'highlights',
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
            'category' => ServiceCategory::class,
            'listing_status' => ListingStatus::class,
            'currency' => Currency::class,
            'highlights' => 'array',
            'is_negotiable' => 'boolean',
            'is_featured' => 'boolean',
            'price_from' => 'decimal:2',
            'price_to' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name) . '-' . Str::random(6);
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
        return $this->hasMany(ServiceImage::class)->orderBy('sort_order');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'itemable');
    }

    public function getPriceRangeAttribute(): string
    {
        if ($this->price_from && $this->price_to) {
            return format_price($this->price_from, $this->currency, 0) . ' - ' . format_price($this->price_to, $this->currency, 0);
        }
        if ($this->price_from) {
            return 'From ' . format_price($this->price_from, $this->currency, 0);
        }
        return 'Contact for pricing';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('listing_status', ListingStatus::Active);
    }

    public function scopeOfCategory($query, ServiceCategory $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOfGroup($query, ServiceGroup $group)
    {
        $values = array_map(fn (ServiceCategory $c) => $c->value, $group->categories());

        return $query->whereIn('category', $values);
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
