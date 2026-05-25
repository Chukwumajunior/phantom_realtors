<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Requests\SubmitPaymentProofRequest;
use App\Models\Order;
use App\Models\SiteConfig;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private PaymentService $paymentService,
    ) {}

    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with(['merchant', 'items.itemable', 'payment'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merchant_id' => ['required', 'exists:users,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.itemable_type' => ['required', 'string', 'in:property,product,service'],
            'items.*.itemable_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // Only admin-owned listings can be ordered
        $merchant = User::findOrFail($request->merchant_id);
        abort_unless($merchant->isAdmin(), 403, 'Orders can only be placed for platform-owned listings.');

        $order = $this->orderService->createOrder(
            $request->user(),
            $request->merchant_id,
            $request->items,
            $request->notes,
        );

        // Notify merchant of new order
        $order->load(['customer', 'items']);
        try {
            $order->merchant->notify(new NewOrderNotification($order));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Order placed successfully. Please submit payment.');
    }

    public function show(Order $order)
    {
        abort_unless($order->customer_id === auth()->id(), 403);

        $order->load(['merchant.merchantProfile', 'items.itemable.images', 'payment']);

        return view('customer.orders.show', [
            'order' => $order,
            'paymentMethods' => PaymentMethod::cases(),
            'bankDetails' => SiteConfig::getBankDetails(),
        ]);
    }

    public function submitPayment(SubmitPaymentProofRequest $request, Order $order)
    {
        abort_unless($order->customer_id === auth()->id(), 403);

        $data = $request->validated();

        if ($request->hasFile('proof_of_payment')) {
            $data['proof_of_payment'] = $request->file('proof_of_payment')
                ->store('payment-proofs', 'public');
        }

        $this->paymentService->createPayment(
            $order,
            PaymentMethod::from($data['payment_method']),
            $data,
        );

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Payment submitted. Awaiting confirmation.');
    }

    public function cancel(Order $order)
    {
        abort_unless($order->customer_id === auth()->id(), 403);

        $canCancel = $order->status === OrderStatus::Pending && !$order->payment;

        abort_unless($canCancel, 403, 'This order cannot be cancelled.');

        if ($order->payment) {
            $order->payment->delete();
        }
        $order->items()->delete();
        $order->delete();

        return redirect()->route('customer.orders.index')
            ->with('success', 'Order cancelled successfully.');
    }

}
