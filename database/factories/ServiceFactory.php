<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Enums\ServiceCategory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $category = fake()->randomElement(ServiceCategory::cases());

        $names = [
            'painting' => ['Interior House Painting', 'Exterior Wall Painting', 'Office Painting Service', 'Texture Painting'],
            'installation' => ['Electrical Installation', 'Plumbing Installation', 'AC Installation', 'CCTV Installation'],
            'welding_ironworks' => ['Gate Fabrication', 'Burglary Proof', 'Staircase Railing', 'Tank Stand Fabrication'],
            'water_borehole' => ['Borehole Drilling', 'Water Treatment Plant', 'Borehole Maintenance', 'Overhead Tank Installation'],
            'roofing' => ['Aluminum Roofing', 'Stone Coated Roofing', 'Roof Repair Service', 'Gutter Installation'],
            'carpentry_woodwork' => ['Kitchen Cabinet Making', 'Wardrobe Design', 'Ceiling Work', 'Door Frame Installation'],
            'cleaning' => ['Deep Cleaning Service', 'Post-Construction Cleaning', 'Office Cleaning', 'Fumigation Service'],
            'renovation' => ['Full House Renovation', 'Bathroom Renovation', 'Kitchen Remodeling', 'Office Space Renovation'],
        ];

        $name = fake()->randomElement($names[$category->value] ?? ['Professional Service']);

        $priceFrom = fake()->randomElement([10000, 25000, 50000, 100000, 200000, 500000]);

        return [
            'user_id' => User::factory()->merchant(),
            'name' => $name,
            'description' => fake()->paragraphs(2, true),
            'category' => $category,
            'price_from' => $priceFrom,
            'price_to' => $priceFrom * fake()->randomElement([2, 3, 5]),
            'is_negotiable' => fake()->boolean(70),
            'listing_status' => ListingStatus::Active,
            'service_area' => fake()->randomElement(['Lagos', 'Lagos & Ogun', 'Nationwide', 'South-West Nigeria']),
            'highlights' => fake()->randomElements(['Fast delivery', 'Quality materials', 'Experienced team', 'Warranty included', '24/7 support'], 3),
            'is_featured' => fake()->boolean(20),
            'views_count' => fake()->numberBetween(0, 150),
        ];
    }
}
