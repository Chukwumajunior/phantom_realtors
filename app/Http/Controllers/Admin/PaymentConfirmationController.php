<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmPaymentRequest;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentConfirmationController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function index()
    {
        $payments = Payment::with(['order', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['order.items.itemable', 'user']);

        return view('admin.payments.show', compact('payment'));
    }

    public function confirm(Request $request, Payment $payment)
    {
        if ($payment->payment_status->value === 'confirmed') {
            return back()->with('error', 'This payment has already been confirmed and cannot be changed.');
        }

        $this->paymentService->confirmPayment(
            $payment,
            auth()->id(),
            $request->admin_notes,
        );

        return back()->with('success', 'Payment confirmed successfully.');
    }

    public function reject(Request $request, Payment $payment)
    {
        if ($payment->payment_status->value === 'confirmed') {
            return back()->with('error', 'This payment has already been confirmed and cannot be changed.');
        }

        $request->validate(['admin_notes' => 'nullable|string|max:1000']);

        $this->paymentService->rejectPayment(
            $payment,
            auth()->id(),
            $request->admin_notes,
        );

        return back()->with('success', 'Payment rejected.');
    }
}
