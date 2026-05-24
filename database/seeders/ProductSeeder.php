<?php

namespace Database\Seeders;

use App\Enums\MerchantStatus;
use App\Models\MerchantProfile;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    protected array $images = [
        'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800',
        'https://images.unsplash.com/photo-1581783898377-1c85bf937427?w=800',
        'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800',
        'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=800',
        'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800',
        'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?w=800',
        'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800',
        'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=800',
        'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=800',
        'https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=800',
        'https://images.unsplash.com/photo-1534349762230-e1d0b6b6681d?w=800',
        'https://images.unsplash.com/photo-1631679706909-1844bbd07221?w=800',
    ];

    public function run(): void
    {
        $merchantIds = MerchantProfile::where('status', MerchantStatus::Approved)
            ->pluck('user_id');

        foreach ($merchantIds as $merchantId) {
            $products = Product::factory(8)->create([
                'user_id' => $merchantId,
            ]);

            foreach ($products as $product) {
                $count = rand(1, 4);
                $selected = array_rand($this->images, $count);
                $selected = is_array($selected) ? $selected : [$selected];

                foreach ($selected as $i => $key) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $this->images[$key],
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }
}
