<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\OrderStatus;
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
            'total_orders' => $user->merchantOrders()->count(),
            'pending_orders' => $user->merchantOrders()->where('status', OrderStatus::Pending)->count(),
            'completed_orders' => $user->merchantOrders()->where('status', OrderStatus::Completed)->count(),
        ];

        $recentOrders = $user->merchantOrders()
            ->with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('merchant.dashboard', compact('stats', 'recentOrders'));
    }
}
