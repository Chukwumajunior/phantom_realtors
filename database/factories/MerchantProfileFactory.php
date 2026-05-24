<?php

namespace Database\Factories;

use App\Enums\MerchantStatus;
use App\Models\MerchantProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchantProfileFactory extends Factory
{
    protected $model = MerchantProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->merchant(),
            'business_name' => fake()->company(),
            'business_description' => fake()->paragraph(),
            'business_address' => fake()->address(),
            'business_phone' => fake()->phoneNumber(),
            'business_email' => fake()->companyEmail(),
            'status' => MerchantStatus::Approved,
            'approved_at' => now(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn() => [
            'status' => MerchantStatus::Pending,
            'approved_at' => null,
        ]);
    }
}
