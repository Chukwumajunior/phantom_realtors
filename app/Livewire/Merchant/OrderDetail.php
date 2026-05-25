<?php

namespace App\Livewire\Merchant;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class OrderDetail extends Component
{
    public Order $order;
    public string $selectedStatus = '';
    public string $notification = '';
    public string $notificationType = 'success';

    public function mount(Order $order): void
    {
        abort_unless($order->merchant_id === auth()->id(), 403);

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

        $this->order = $order;
        $this->selectedStatus = $order->status->value;
    }

    public function updateStatus(): void
    {
        abort_unless($this->order->merchant_id === auth()->id(), 403);

        // Prevent status change once order is confirmed/processing/completed
        if (in_array($this->order->status->value, ['confirmed', 'processing', 'completed'])) {
            $this->notification = 'Cannot change status. Order is already confirmed.';
            $this->notificationType = 'error';
            return;
        }

        $this->validate([
            'selectedStatus' => ['required', 'string'],
        ]);

        $newStatus = OrderStatus::from($this->selectedStatus);

        $this->order->update([
            'status' => $newStatus,
        ]);

        // When order is confirmed, also confirm the payment and deduct stock
        if (in_array($newStatus, [OrderStatus::Confirmed, OrderStatus::Processing, OrderStatus::Completed])) {
            $payment = $this->order->payment;
            if ($payment && $payment->payment_status === PaymentStatus::Pending) {
                $payment->update([
                    'payment_status' => PaymentStatus::Confirmed,
                    'confirmed_by' => auth()->id(),
                    'confirmed_at' => now(),
                ]);
                $this->order->load('items');
                foreach ($this->order->items as $item) {
                    if ($item->itemable_type === Product::class) {
                        Product::where('id', $item->itemable_id)
                            ->decrement('stock_quantity', $item->quantity);
                    }
                }
            }
        }

        $this->order->refresh();
        $this->order->load(['customer', 'items.itemable', 'payment']);

        $this->notification = 'Order status updated.';
        $this->notificationType = 'success';
    }

    public function render()
    {
        return view('livewire.merchant.order-detail')
            ->title('Order #' . $this->order->order_number);
    }
}
