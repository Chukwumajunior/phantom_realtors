<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteConfig extends Model
{
    protected $fillable = ['key', 'value'];

    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    /**
     * Get a config value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $config = Cache::remember("site_config.{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        return $config?->value ?? $default;
    }

    /**
     * Set a config value by key.
     */
    public static function set(string $key, mixed $value): static
    {
        $config = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("site_config.{$key}");

        return $config;
    }

    /**
     * Get payment/bank account details.
     */
    public static function getBankDetails(): array
    {
        return static::get('bank_details', [
            'bank_name' => '',
            'account_name' => '',
            'account_number' => '',
        ]);
    }

    /**
     * Get featured listings settings.
     */
    public static function getFeaturedSettings(): array
    {
        return array_merge([
            'max_per_merchant' => 10,
            'rotation_seconds' => 5,
            'properties_per_page' => 6,
            'properties_per_row' => 3,
            'products_per_page' => 8,
            'products_per_row' => 4,
            'services_per_page' => 6,
            'services_per_row' => 3,
        ], static::get('featured_settings', []));
    }

    /**
     * Get tier pricing and configuration.
     */
    public static function getTierSettings(): array
    {
        return array_merge([
            'tier_2_price' => 10000,
            'tier_3_price' => 25000,
            'tier_1' => [
                'name' => 'Tier 1 - Basic',
                'posts' => 1,
                'categories' => 1,
                'description' => '1 post in 1 category. Perfect for getting started.',
            ],
            'tier_2' => [
                'name' => 'Tier 2 - Standard',
                'posts' => 3,
                'categories' => 3,
                'description' => 'Up to 3 posts across 3 categories. Great for growing businesses.',
            ],
            'tier_3' => [
                'name' => 'Tier 3 - Unlimited',
                'posts' => null,
                'categories' => null,
                'description' => 'Unlimited posts and categories. For established businesses.',
            ],
        ], static::get('tier_settings', []));
    }

    /**
     * Get the price for a specific tier.
     */
    public static function getTierPrice(string $tier): int
    {
        $settings = static::getTierSettings();

        return match ($tier) {
            'tier_1' => 0,
            'tier_2' => (int) ($settings['tier_2_price'] ?? 10000),
            'tier_3' => (int) ($settings['tier_3_price'] ?? 25000),
            default => 0,
        };
    }
}
