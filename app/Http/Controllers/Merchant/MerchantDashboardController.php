<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $profile = $user->merchantProfile;

        $stats = [
            'total_properties' => $user->properties()->count(),
            'total_products' => $user->products()->count(),
            'total_services' => $user->services()->count(),
            'total_posts' => $user->totalPostsCount(),
            'posts_remaining' => $user->remainingPosts(),
            'categories_used' => count($user->usedCategories()),
            'max_categories' => $profile->tier->maxCategories(),
        ];

        $tier = $profile->tier;

        return view('merchant.dashboard', compact('stats', 'profile', 'tier'));
    }
}
