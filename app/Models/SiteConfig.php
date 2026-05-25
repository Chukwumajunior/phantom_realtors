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
}
