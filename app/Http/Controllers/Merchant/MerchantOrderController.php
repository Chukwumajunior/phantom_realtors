<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class MerchantOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->merchantOrders()
            ->with(['customer', 'payment'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(10);

        return view('merchant.orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function show(Order $order)
    {
        abort_unless(auth()->user()->isAdmin() || $order->merchant_id === auth()->id(), 403);

        $order->load(['customer', 'items.itemable', 'payment']);

        // Auto-fix stale payment status: if order is confirmed but payment is still pending
        if (in_array($order->status->value, ['confirmed', 'processing', 'completed']) && $order->payment) {
            if ($order->payment->payment_status->value === 'pending') {
                $order->payment->update([
                    'payment_status' => PaymentStatus::Confirmed,
                    'confirmed_at' => now(),
                ]);
                // Deduct stock for product items
                foreach ($order->items as $item) {
                    if ($item->itemable_type === Product::class) {
                        Product::where('id', $item->itemable_id)
                            ->where('stock_quantity', '>', 0)
                            ->decrement('stock_quantity', $item->quantity);
                    }
                }
                $order->payment->refresh();
            }
        }

        return view('merchant.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_unless(auth()->user()->isAdmin() || $order->merchant_id === auth()->id(), 403);

        // Prevent status change once order is confirmed/processing/completed
        if (in_array($order->status->value, ['confirmed', 'processing', 'completed'])) {
            return back()->with('error', 'Cannot change status. Order is already confirmed.');
        }

        $request->validate([
            'status' => ['required', 'string'],
        ]);

        $newStatus = OrderStatus::from($request->status);

        $order->update([
            'status' => $newStatus,
        ]);

        // When order is confirmed, also confirm the payment and deduct stock
        if (in_array($newStatus, [OrderStatus::Confirmed, OrderStatus::Processing, OrderStatus::Completed])) {
            $payment = $order->payment;
            if ($payment && $payment->payment_status === PaymentStatus::Pending) {
                $payment->update([
                    'payment_status' => PaymentStatus::Confirmed,
                    'confirmed_by' => auth()->id(),
                    'confirmed_at' => now(),
                ]);
                $order->load('items');
                foreach ($order->items as $item) {
                    if ($item->itemable_type === Product::class) {
                        Product::where('id', $item->itemable_id)
                            ->decrement('stock_quantity', $item->quantity);
                    }
                }
            }
        }

        return back()->with('success', 'Order status updated.');
    }
}
