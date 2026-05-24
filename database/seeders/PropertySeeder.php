<?php

namespace Database\Seeders;

use App\Enums\MerchantStatus;
use App\Models\MerchantProfile;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    protected array $images = [
        'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800',
        'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800',
        'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800',
        'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=800',
        'https://images.unsplash.com/photo-1600573472591-ee6981cf81f0?w=800',
        'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800',
        'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800',
        'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800',
        'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?w=800',
        'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800',
        'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=800',
        'https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=800',
        'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800',
        'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=800',
        'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?w=800',
        'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=800',
    ];

    public function run(): void
    {
        $merchantIds = MerchantProfile::where('status', MerchantStatus::Approved)
            ->pluck('user_id');

        foreach ($merchantIds as $merchantId) {
            $properties = Property::factory(10)->create([
                'user_id' => $merchantId,
            ]);

            foreach ($properties as $property) {
                $count = rand(1, 4);
                $selected = array_rand($this->images, $count);
                $selected = is_array($selected) ? $selected : [$selected];

                foreach ($selected as $i => $key) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image_path' => $this->images[$key],
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }
}
