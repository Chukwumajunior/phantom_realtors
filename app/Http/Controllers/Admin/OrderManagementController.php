<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? 'pending';

        $orders = Order::with(['customer', 'merchant'])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'merchant.merchantProfile', 'items.itemable.images', 'payments']);

        // Auto-fix stale payment status: if order is confirmed but payment is still pending
        if (in_array($order->status->value, ['confirmed', 'processing', 'completed'])) {
            $order->payments->each(function ($payment) use ($order) {
                if ($payment->payment_status->value === 'pending') {
                    $payment->update([
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
                    $payment->refresh();
                }
            });
        }

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Prevent status change once order is confirmed/processing/completed or payment is confirmed
        $hasConfirmedPayment = $order->payments()
            ->where('payment_status', PaymentStatus::Confirmed)
            ->exists();

        $orderAlreadyConfirmed = in_array($order->status->value, ['confirmed', 'processing', 'completed']);

        if ($hasConfirmedPayment || $orderAlreadyConfirmed) {
            return back()->with('error', 'Cannot change status. Order is already confirmed.');
        }

        $request->validate([
            'status' => ['required', 'string'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $newStatus = OrderStatus::from($request->status);

        $order->update([
            'status' => $newStatus,
            'admin_notes' => $request->admin_notes,
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
                // Deduct stock for product items
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
