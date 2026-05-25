<?php

namespace Database\Seeders;

use App\Enums\MerchantStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\MerchantProfile;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        $plans = SubscriptionPlan::all();

        // Create 5 approved merchants
        $approvedMerchants = User::factory(5)->merchant()->create();

        foreach ($approvedMerchants as $index => $merchant) {
            $plan = $plans->count() ? $plans->random() : null;

            MerchantProfile::factory()->create([
                'user_id' => $merchant->id,
                'status' => MerchantStatus::Approved,
                'approved_at' => now()->subDays(rand(7, 60)),
                'approved_by' => 1,
                'subscription_plan_id' => $plan?->id,
                'amount_paid' => $plan?->price,
            ]);

            // Give all approved merchants an active subscription
            if ($plan) {
                Subscription::create([
                    'user_id' => $merchant->id,
                    'subscription_plan_id' => $plan->id,
                    'status' => $index < 3 ? SubscriptionStatus::Active : SubscriptionStatus::Expired,
                    'starts_at' => now()->subDays(rand(1, 20)),
                    'expires_at' => $index < 3 ? now()->addDays(rand(10, $plan->duration_days)) : now()->subDays(rand(1, 5)),
                    'activated_at' => now()->subDays(rand(1, 20)),
                    'activated_by' => 1,
                ]);
            }
        }

        // Create 2 pending merchants
        $pendingMerchants = User::factory(2)->merchant()->create();

        foreach ($pendingMerchants as $merchant) {
            MerchantProfile::factory()->pending()->create([
                'user_id' => $merchant->id,
            ]);
        }

        // Create 10 customers
        User::factory(10)->create();
    }
}
