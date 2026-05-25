<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\Property;
use App\Models\Service;
use App\Models\SiteConfig;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function __invoke()
    {
        $settings = SiteConfig::getFeaturedSettings();
        $maxPerMerchant = (int) $settings['max_per_merchant'];

        // Admin user IDs always featured (no subscription needed)
        $adminIds = User::where('role', UserRole::Admin)->pluck('id');

        // Premium merchant IDs ordered by subscription starts_at (earliest first)
        $premiumUserIds = Subscription::premiumActive()
            ->orderBy('starts_at')
            ->pluck('user_id')
            ->unique()
            ->values();

        // Admin comes first, then premium merchants
        $featuredUserIds = $adminIds->merge($premiumUserIds)->unique()->values();

        $allUserIds = $featuredUserIds->all();

        $featuredProperties = $this->buildRotation(
            Property::premiumVisible()->whereIn('user_id', $allUserIds)
                ->with('images')->latest()->get(),
            $featuredUserIds,
            $maxPerMerchant
        );

        $featuredProducts = $this->buildRotation(
            Product::premiumVisible()->whereIn('user_id', $allUserIds)
                ->with('images')->latest()->get(),
            $featuredUserIds,
            $maxPerMerchant
        );

        $featuredServices = $this->buildRotation(
            Service::premiumVisible()->whereIn('user_id', $allUserIds)
                ->with('images')->latest()->get(),
            $featuredUserIds,
            $maxPerMerchant
        );

        return view('home', [
            'featuredProperties' => $featuredProperties,
            'featuredProducts' => $featuredProducts,
            'featuredServices' => $featuredServices,
            'featuredSettings' => $settings,
        ]);
    }

    /**
     * Build round-based rotation from featured listings.
     *
     * Round 1: latest listing from each user (ordered by admin first, then subscription start)
     * Round 2: 2nd latest from each user
     * ...up to max_per_merchant rounds, then cycle repeats.
     */
    private function buildRotation(Collection $listings, Collection $featuredUserIds, int $maxPerMerchant): Collection
    {
        // Group by user, preserving order. Listings already sorted by latest.
        $grouped = collect();
        foreach ($featuredUserIds as $userId) {
            $userListings = $listings->where('user_id', $userId)->take($maxPerMerchant)->values();
            if ($userListings->isNotEmpty()) {
                $grouped->put($userId, $userListings);
            }
        }

        // Build rounds: Round N takes the Nth listing from each user
        $result = collect();
        for ($round = 0; $round < $maxPerMerchant; $round++) {
            foreach ($grouped as $userListings) {
                if (isset($userListings[$round])) {
                    $result->push($userListings[$round]);
                }
            }
        }

        return $result;
    }
}
