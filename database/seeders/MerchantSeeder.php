<?php

namespace Database\Seeders;

use App\Enums\MerchantStatus;
use App\Enums\PosterTier;
use App\Enums\UserRole;
use App\Models\MerchantProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        // Create 2 Tier 3 merchants (unlimited)
        $tier3Merchants = User::factory(2)->merchant()->create();
        foreach ($tier3Merchants as $merchant) {
            MerchantProfile::factory()->tier3()->create([
                'user_id' => $merchant->id,
            ]);
        }

        // Create 3 Tier 2 merchants (3 posts)
        $tier2Merchants = User::factory(3)->merchant()->create();
        foreach ($tier2Merchants as $merchant) {
            MerchantProfile::factory()->tier2()->create([
                'user_id' => $merchant->id,
            ]);
        }

        // Create 3 Tier 1 merchants (1 post)
        $tier1Merchants = User::factory(3)->merchant()->create();
        foreach ($tier1Merchants as $merchant) {
            MerchantProfile::factory()->tier1()->create([
                'user_id' => $merchant->id,
            ]);
        }

        // Create 10 regular customers
        User::factory(10)->create();
    }
}
