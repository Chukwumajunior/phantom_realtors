<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Notifications\PaymentConfirmedNotification;
use App\Notifications\PaymentRejectedNotification;
use App\Notifications\PaymentSubmittedNotification;

class PaymentService
{
    public function createPayment(Order $order, PaymentMethod $method, array $data = []): Payment
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $order->customer_id,
            'amount' => $order->total_amount,
            'payment_method' => $method,
            'payment_status' => PaymentStatus::Pending,
            'reference_number' => $data['reference_number'] ?? null,
            'bank_name' => $data['bank_name'] ?? null,
            'account_name' => $data['account_name'] ?? null,
            'proof_of_payment' => $data['proof_of_payment'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        $payment->load('order');
        $payment->user->notify(new PaymentSubmittedNotification($payment));

        return $payment;
    }

    public function confirmPayment(Payment $payment, int $confirmedBy, ?string $adminNotes = null): Payment
    {
        $payment->update([
            'payment_status' => PaymentStatus::Confirmed,
            'confirmed_by' => $confirmedBy,
            'confirmed_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        $payment->order->update(['status' => OrderStatus::Completed]);

        // Deduct stock for product items
        $payment->order->load('items');
        foreach ($payment->order->items as $item) {
            if ($item->itemable_type === Product::class) {
                Product::where('id', $item->itemable_id)
                    ->decrement('stock_quantity', $item->quantity);
            }
        }

        $payment->load('order');
        $payment->user->notify(new PaymentConfirmedNotification($payment));

        return $payment;
    }

    public function rejectPayment(Payment $payment, int $confirmedBy, ?string $adminNotes = null): Payment
    {
        $payment->update([
            'payment_status' => PaymentStatus::Failed,
            'confirmed_by' => $confirmedBy,
            'confirmed_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        $payment->load('order');
        $payment->user->notify(new PaymentRejectedNotification($payment));

        return $payment;
    }
}
