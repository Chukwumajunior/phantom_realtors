<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Property;
use App\Models\Service;
use App\Models\SiteConfig;
use App\Models\User;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function __invoke()
    {
        $settings = SiteConfig::getFeaturedSettings();
        $maxPerMerchant = (int) $settings['max_per_merchant'];

        // Admin user IDs always featured
        $adminIds = User::where('role', UserRole::Admin)->pluck('id');

        // Featured listings are those marked as is_featured by merchants
        $featuredProperties = Property::premiumVisible()
            ->where('is_featured', true)
            ->with('images')
            ->latest()
            ->get();

        $featuredProducts = Product::premiumVisible()
            ->where('is_featured', true)
            ->with('images')
            ->latest()
            ->get();

        $featuredServices = Service::premiumVisible()
            ->where('is_featured', true)
            ->with('images')
            ->latest()
            ->get();

        // Build rotation order: admin listings first, then others by date
        $featuredProperties = $this->sortAdminFirst($featuredProperties, $adminIds, $maxPerMerchant);
        $featuredProducts = $this->sortAdminFirst($featuredProducts, $adminIds, $maxPerMerchant);
        $featuredServices = $this->sortAdminFirst($featuredServices, $adminIds, $maxPerMerchant);

        $banners = Banner::active()->get();

        // Always fetch latest listings so the page is never empty
        $latestProperties = Property::premiumVisible()->with('images')->latest()->take(12)->get();
        $latestProducts = Product::premiumVisible()->with('images')->latest()->take(16)->get();
        $latestServices = Service::premiumVisible()->with('images')->latest()->take(12)->get();

        return view('home', [
            'banners' => $banners,
            'featuredProperties' => $featuredProperties,
            'featuredProducts' => $featuredProducts,
            'featuredServices' => $featuredServices,
            'latestProperties' => $latestProperties,
            'latestProducts' => $latestProducts,
            'latestServices' => $latestServices,
            'featuredSettings' => $settings,
        ]);
    }

    /**
     * Sort featured listings with admin's listings first, then by date.
     * Limit per merchant to maxPerMerchant.
     */
    private function sortAdminFirst(Collection $listings, Collection $adminIds, int $maxPerMerchant): Collection
    {
        // Group by user_id and limit each user's contribution
        $grouped = $listings->groupBy('user_id')->map(fn ($items) => $items->take($maxPerMerchant));

        // Admin listings first, then others
        $result = collect();

        foreach ($adminIds as $adminId) {
            if ($grouped->has($adminId)) {
                $result = $result->merge($grouped->get($adminId));
            }
        }

        foreach ($grouped as $userId => $items) {
            if (!$adminIds->contains($userId)) {
                $result = $result->merge($items);
            }
        }

        return $result->values();
    }
}
