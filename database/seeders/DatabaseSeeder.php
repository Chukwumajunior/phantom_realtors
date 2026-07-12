<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SiteConfigSeeder::class,
            MerchantSeeder::class,
            PropertySeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
