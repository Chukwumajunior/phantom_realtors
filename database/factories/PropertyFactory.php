<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Enums\PropertyCategory;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $cities = ['Lagos', 'Lekki', 'Victoria Island', 'Ikeja', 'Ikoyi', 'Ajah', 'Abuja', 'Port Harcourt'];
        $states = ['Lagos', 'FCT', 'Rivers', 'Ogun', 'Oyo'];

        return [
            'user_id' => User::factory()->merchant(),
            'title' => fake()->randomElement([
                'Luxury 4 Bedroom Duplex',
                'Modern 3 Bedroom Flat',
                'Spacious 5 Bedroom Detached House',
                'Elegant 2 Bedroom Apartment',
                'Commercial Office Space',
                'Prime Land for Development',
                'Serviced 3 Bedroom Terrace',
                'Furnished Studio Apartment',
            ]) . ' in ' . fake()->randomElement($cities),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomElement([5000000, 15000000, 25000000, 50000000, 75000000, 100000000, 250000000]),
            'type' => fake()->randomElement(PropertyType::cases()),
            'category' => fake()->randomElement(PropertyCategory::cases()),
            'status' => PropertyStatus::Available,
            'listing_status' => ListingStatus::Active,
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement($cities),
            'state' => fake()->randomElement($states),
            'lga' => fake()->randomElement(['Eti-Osa', 'Ikeja', 'Surulere', 'Ibeju-Lekki', 'Alimosho']),
            'bedrooms' => fake()->numberBetween(1, 6),
            'bathrooms' => fake()->numberBetween(1, 5),
            'toilets' => fake()->numberBetween(1, 6),
            'area_sqft' => fake()->numberBetween(800, 5000),
            'year_built' => fake()->numberBetween(2015, 2025),
            'features' => fake()->randomElements(['parking', 'swimming_pool', 'gym', 'security', 'garden', 'balcony', 'bq'], 3),
            'is_featured' => fake()->boolean(25),
            'views_count' => fake()->numberBetween(0, 500),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn() => ['is_featured' => true]);
    }
}
