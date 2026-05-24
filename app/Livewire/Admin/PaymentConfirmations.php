<?php

namespace App\Livewire\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentConfirmations extends Component
{
    use WithPagination;

    public string $filter = 'pending';

    public function confirm(int $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'payment_status' => PaymentStatus::Confirmed,
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        $payment->order->update(['status' => OrderStatus::Confirmed]);

        session()->flash('success', 'Payment confirmed.');
    }

    public function reject(int $id, string $notes = '')
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'payment_status' => PaymentStatus::Failed,
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
            'admin_notes' => $notes,
        ]);

        session()->flash('success', 'Payment rejected.');
    }

    public function render()
    {
        $payments = Payment::with(['order', 'user'])
            ->when($this->filter !== 'all', fn($q) => $q->where('payment_status', $this->filter))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.payment-confirmations', compact('payments'));
    }
}
