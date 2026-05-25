<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use App\Services\PaymentService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PaymentDetail extends Component
{
    public Payment $payment;
    public string $adminNotes = '';
    public string $message = '';
    public string $messageType = '';

    public function mount(Payment $payment): void
    {
        $this->payment = $payment->load(['order.items.itemable', 'user']);
    }

    public function confirmPayment(): void
    {
        if ($this->payment->payment_status->value === 'confirmed') {
            $this->message = 'This payment has already been confirmed and cannot be changed.';
            $this->messageType = 'error';
            return;
        }

        $paymentService = app(PaymentService::class);
        $paymentService->confirmPayment(
            $this->payment,
            auth()->id(),
            $this->adminNotes ?: null,
        );

        $this->payment->refresh();
        $this->message = 'Payment confirmed successfully.';
        $this->messageType = 'success';
        $this->adminNotes = '';
    }

    public function rejectPayment(): void
    {
        if ($this->payment->payment_status->value === 'confirmed') {
            $this->message = 'This payment has already been confirmed and cannot be changed.';
            $this->messageType = 'error';
            return;
        }

        $paymentService = app(PaymentService::class);
        $paymentService->rejectPayment(
            $this->payment,
            auth()->id(),
            $this->adminNotes ?: null,
        );

        $this->payment->refresh();
        $this->message = 'Payment rejected.';
        $this->messageType = 'success';
        $this->adminNotes = '';
    }

    public function render()
    {
        return view('livewire.admin.payment-detail')
            ->title('Payment Details');
    }
}
