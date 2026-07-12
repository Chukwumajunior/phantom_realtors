<?php

namespace Database\Seeders;

use App\Models\SiteConfig;
use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
    public function run(): void
    {
        SiteConfig::set('bank_details', [
            'bank_name' => 'OPay',
            'account_name' => 'PHANTOM 5 REALTORS CONCEPTS',
            'account_number' => '6142210881',
        ]);

        SiteConfig::set('featured_settings', [
            'max_per_merchant' => 10,
            'rotation_seconds' => 5,
            'properties_per_page' => 6,
            'properties_per_row' => 3,
            'products_per_page' => 8,
            'products_per_row' => 4,
            'services_per_page' => 6,
            'services_per_row' => 3,
        ]);

        SiteConfig::set('tier_settings', [
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
        ]);
    }
}
