<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\ListingStatus;
use App\Enums\ServiceCategory;
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
