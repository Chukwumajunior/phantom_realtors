<?php

namespace Database\Seeders;

use App\Enums\MerchantStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\MerchantProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 approved merchants
        $approvedMerchants = User::factory(5)->merchant()->create();

        foreach ($approvedMerchants as $merchant) {
            MerchantProfile::factory()->create([
                'user_id' => $merchant->id,
                'status' => MerchantStatus::Approved,
                'approved_at' => now(),
                'approved_by' => 1,
            ]);
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
