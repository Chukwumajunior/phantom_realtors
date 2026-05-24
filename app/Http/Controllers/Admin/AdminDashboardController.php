<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MerchantStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_merchants' => MerchantProfile::pending()->count(),
            'pending_payments' => Payment::pending()->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'new_inquiries' => Inquiry::unread()->count(),
        ];

        $recentOrders = Order::with(['customer', 'merchant'])
            ->latest()->take(5)->get();

        $pendingMerchants = MerchantProfile::pending()
            ->with('user')->latest()->take(5)->get();

        $pendingPayments = Payment::pending()
            ->with(['order', 'user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingMerchants', 'pendingPayments'));
    }
}
