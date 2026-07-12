<?php

namespace Database\Factories;

use App\Enums\MerchantStatus;
use App\Enums\PosterTier;
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
            'tier' => fake()->randomElement(PosterTier::cases()),
            'house_number' => fake()->buildingNumber(),
            'street_name' => fake()->streetName(),
            'area' => fake()->randomElement(['Bariga', 'Surulere', 'Ikeja', 'Yaba', 'Lekki', 'Ajah', 'Ikoyi']),
            'lga' => fake()->randomElement(['Somolu', 'Surulere', 'Ikeja', 'Lagos Mainland', 'Eti-Osa', 'Alimosho']),
            'state' => fake()->randomElement(['Lagos', 'Abuja', 'Rivers', 'Ogun', 'Oyo', 'Enugu']),
            'country' => 'Nigeria',
        ];
    }

    public function tier1(): static
    {
        return $this->state(fn () => ['tier' => PosterTier::Tier1]);
    }

    public function tier2(): static
    {
        return $this->state(fn () => ['tier' => PosterTier::Tier2]);
    }

    public function tier3(): static
    {
        return $this->state(fn () => [
            'tier' => PosterTier::Tier3,
            'company_name' => fake()->company() . ' Ltd',
            'cac_document' => 'cac_documents/sample.pdf',
        ]);
    }
}
