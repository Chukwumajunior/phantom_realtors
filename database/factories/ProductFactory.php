<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Enums\ProductCategory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $category = fake()->randomElement(ProductCategory::cases());

        $names = [
            'electricals' => ['LED Panel Light', 'Circuit Breaker 60A', 'Extension Board 6-Way', 'Ceiling Fan'],
            'electronics' => ['Smart TV 55"', 'Home Theatre System', 'Standing Fan', 'Air Purifier'],
            'building_materials' => ['Dangote Cement 50kg', 'Iron Rod 12mm', 'Granite Chippings', 'Roofing Sheets'],
            'sanitary_ware' => ['Executive WC Set', 'Wall Basin', 'Shower Mixer', 'Bathtub Acrylic'],
            'furniture' => ['Executive Office Chair', 'L-Shaped Sofa', 'King Size Bed Frame', 'Dining Table Set'],
            'cooling_systems' => ['Split AC 1.5HP', 'Standing AC 2HP', 'Window AC 1HP', 'Inverter AC 2HP'],
            'windows' => ['Casement Window 4ft', 'Sliding Window 6ft', 'French Window', 'Aluminum Window Frame'],
            'curtains' => ['Blackout Curtains', 'Sheer Curtains', 'Velvet Curtains', 'Eyelet Curtains'],
            'window_blinds' => ['Venetian Blinds', 'Roller Blinds', 'Vertical Blinds', 'Day & Night Blinds'],
            'interior_decor' => ['Wall Art Canvas', 'Decorative Vase', 'Wall Clock Designer', 'Table Lamp Modern'],
        ];

        $name = fake()->randomElement($names[$category->value] ?? ['Premium Product']);

        return [
            'user_id' => User::factory()->merchant(),
            'name' => $name,
            'description' => fake()->paragraphs(2, true),
            'category' => $category,
            'price' => fake()->randomElement([5000, 15000, 25000, 50000, 75000, 150000, 350000, 500000]),
            'stock_quantity' => fake()->numberBetween(1, 100),
            'listing_status' => ListingStatus::Active,
            'brand' => fake()->randomElement(['LG', 'Samsung', 'Dangote', 'Generic', 'Premium', null]),
            'condition' => fake()->randomElement(['new', 'used', 'refurbished']),
            'is_featured' => fake()->boolean(20),
            'views_count' => fake()->numberBetween(0, 200),
        ];
    }
}
