<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Create the banners directory
        Storage::disk('public')->makeDirectory('banners');

        // Create colorful placeholder banner images using simple SVGs converted to images
        $banners = [
            [
                'title' => 'Luxury Homes - Up to 30% Off',
                'media_type' => 'image',
                'link_url' => '/properties',
                'sort_order' => 1,
                'color' => ['from' => '#d97706', 'to' => '#ea580c'],
                'text' => 'LUXURY HOMES\n30% OFF',
            ],
            [
                'title' => 'Premium Building Materials',
                'media_type' => 'image',
                'link_url' => '/products',
                'sort_order' => 2,
                'color' => ['from' => '#2563eb', 'to' => '#7c3aed'],
                'text' => 'BUILDING MATERIALS\nBEST PRICES',
            ],
            [
                'title' => 'Professional Services Available',
                'media_type' => 'image',
                'link_url' => '/services',
                'sort_order' => 3,
                'color' => ['from' => '#059669', 'to' => '#0d9488'],
                'text' => 'PRO SERVICES\nHIRE TODAY',
            ],
            [
                'title' => 'New Arrivals This Week',
                'media_type' => 'image',
                'link_url' => '/products',
                'sort_order' => 4,
                'color' => ['from' => '#dc2626', 'to' => '#e11d48'],
                'text' => 'NEW ARRIVALS\nSHOP NOW',
            ],
            [
                'title' => 'Land For Sale - Prime Locations',
                'media_type' => 'image',
                'link_url' => '/properties',
                'sort_order' => 5,
                'color' => ['from' => '#7c3aed', 'to' => '#6366f1'],
                'text' => 'PRIME LAND\nINVEST NOW',
            ],
        ];

        foreach ($banners as $data) {
            // Generate an SVG banner image
            $svg = $this->generateBannerSvg($data['color']['from'], $data['color']['to'], $data['text']);
            $filename = 'banners/' . str()->slug($data['title']) . '.svg';
            Storage::disk('public')->put($filename, $svg);

            Banner::create([
                'title' => $data['title'],
                'media_path' => $filename,
                'media_type' => $data['media_type'],
                'link_url' => $data['link_url'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
            ]);
        }
    }

    private function generateBannerSvg(string $fromColor, string $toColor, string $text): string
    {
        $lines = explode('\n', $text);
        $line1 = $lines[0] ?? '';
        $line2 = $lines[1] ?? '';

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="400" viewBox="0 0 1200 400">
  <defs>
    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$fromColor};stop-opacity:1" />
      <stop offset="100%" style="stop-color:{$toColor};stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="1200" height="400" fill="url(#grad)"/>
  <circle cx="100" cy="80" r="60" fill="rgba(255,255,255,0.1)"/>
  <circle cx="1100" cy="320" r="80" fill="rgba(255,255,255,0.08)"/>
  <circle cx="900" cy="60" r="40" fill="rgba(255,255,255,0.06)"/>
  <rect x="50" y="300" width="200" height="60" rx="10" fill="rgba(255,255,255,0.1)"/>
  <text x="600" y="170" font-family="Arial, sans-serif" font-size="56" font-weight="bold" fill="white" text-anchor="middle">{$line1}</text>
  <text x="600" y="250" font-family="Arial, sans-serif" font-size="42" font-weight="bold" fill="rgba(255,255,255,0.9)" text-anchor="middle">{$line2}</text>
  <rect x="475" y="290" width="250" height="50" rx="25" fill="white"/>
  <text x="600" y="322" font-family="Arial, sans-serif" font-size="20" font-weight="bold" fill="{$fromColor}" text-anchor="middle">SHOP NOW</text>
</svg>
SVG;
    }
}
