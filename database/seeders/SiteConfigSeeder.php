<?php

namespace Database\Seeders;

use App\Models\SiteConfig;
use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
    public function run(): void
    {
        SiteConfig::set('bank_details', [
            'bank_name' => 'First Bank Nigeria',
            'account_name' => 'Phantom 5',
            'account_number' => '0123456789',
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
    }
}
