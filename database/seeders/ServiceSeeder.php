<?php

namespace Database\Seeders;

use App\Enums\MerchantStatus;
use App\Models\MerchantProfile;
use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    protected array $images = [
        'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800',
        'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800',
        'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800',
        'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800',
        'https://images.unsplash.com/photo-1585128792020-803d29415281?w=800',
        'https://images.unsplash.com/photo-1562259929-b4e1fd3aef09?w=800',
        'https://images.unsplash.com/photo-1523413651479-597eb2da0ad6?w=800',
        'https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=800',
        'https://images.unsplash.com/photo-1517581177682-a085bb7ffb15?w=800',
        'https://images.unsplash.com/photo-1590479773265-7464e5d48118?w=800',
        'https://images.unsplash.com/photo-1625244724120-1fd1d34d00f6?w=800',
        'https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800',
    ];

    public function run(): void
    {
        $merchantIds = MerchantProfile::where('status', MerchantStatus::Approved)
            ->pluck('user_id');

        foreach ($merchantIds as $merchantId) {
            $services = Service::factory(6)->create([
                'user_id' => $merchantId,
            ]);

            foreach ($services as $service) {
                $count = rand(1, 4);
                $selected = array_rand($this->images, $count);
                $selected = is_array($selected) ? $selected : [$selected];

                foreach ($selected as $i => $key) {
                    ServiceImage::create([
                        'service_id' => $service->id,
                        'image_path' => $this->images[$key],
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }
}
