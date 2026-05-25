<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total_properties' => $user->properties()->count(),
            'total_products' => $user->products()->count(),
            'total_services' => $user->services()->count(),
        ];

        $subscription = $user->activeSubscription();
        $subscriptionExpiringSoon = $subscription && $subscription->daysRemaining() <= 7;

        return view('merchant.dashboard', compact('stats', 'subscription', 'subscriptionExpiringSoon'));
    }
}
