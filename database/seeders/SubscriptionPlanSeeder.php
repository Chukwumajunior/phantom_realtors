<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Monthly Plan',
            'description' => 'Access all merchant features for 30 days.',
            'price' => 5000,
            'duration_days' => 30,
            'is_active' => true,
            'is_premium' => false,
        ]);

        SubscriptionPlan::create([
            'name' => 'Yearly Plan',
            'description' => 'Best value! Access all merchant features for 365 days.',
            'price' => 48000,
            'duration_days' => 365,
            'is_active' => true,
            'is_premium' => false,
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium Yearly Plan',
            'description' => 'All merchant features plus featured homepage listings for 365 days.',
            'price' => 75000,
            'duration_days' => 365,
            'is_active' => true,
            'is_premium' => true,
        ]);
    }
}
