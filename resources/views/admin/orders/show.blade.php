<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Order #{{ $order->order_number }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <x-status-badge :status="$order->status->label()" :color="$order->status->color()" />
                        <p class="text-sm text-gray-500 mt-2">Placed {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <p class="text-2xl font-bold text-amber-600">{{ format_price($order->total_amount) }}</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Customer</label>
                        <p class="text-slate-900 font-medium">{{ $order->customer->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->customer->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Merchant</label>
                        <p class="text-slate-900 font-medium">{{ $order->merchant->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->merchant->email }}</p>
                    </div>
                </div>

                <div class="p-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-4">Order Items</h4>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                            <div>
                                <p class="font-medium text-slate-900">{{ $item->itemable->name ?? $item->itemable->title ?? 'Item' }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} &times; {{ format_price($item->unit_price) }}</p>
                            </div>
                            <p class="font-semibold text-slate-900">{{ format_price($item->subtotal) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($order->notes)
                <div class="p-6 border-t border-gray-100">
                    <label class="text-sm font-medium text-gray-500">Notes</label>
                    <p class="text-slate-900 mt-1">{{ $order->notes }}</p>
                </div>
                @endif

                <!-- Payment Information -->
                <div class="p-6 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-4">Payment Information</h4>
                    @if($order->payments->count() > 0)
                        @foreach($order->payments as $payment)
                        <div class="bg-gray-50 rounded-lg p-4 mb-3 last:mb-0">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-xs text-gray-500">Payment Method</p>
                                    <p class="font-medium text-slate-900">{{ $payment->payment_method->label() }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Status</p>
                                    <x-status-badge :status="$payment->payment_status->label()" :color="$payment->payment_status->color()" />
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Amount</p>
                                    <p class="font-medium text-slate-900">{{ format_price($payment->amount) }}</p>
                                </div>
                                @if($payment->reference_number)
                                <div>
                                    <p class="text-xs text-gray-500">Reference Number</p>
                                    <p class="font-medium text-slate-900">{{ $payment->reference_number }}</p>
                                </div>
                                @endif
                                @if($payment->bank_name)
                                <div>
                                    <p class="text-xs text-gray-500">Bank Name</p>
                                    <p class="font-medium text-slate-900">{{ $payment->bank_name }}</p>
                                </div>
                                @endif
                                @if($payment->account_name)
                                <div>
                                    <p class="text-xs text-gray-500">Account Name</p>
                                    <p class="font-medium text-slate-900">{{ $payment->account_name }}</p>
                                </div>
                                @endif
                            </div>

                            @if($payment->proof_of_payment)
                            <div class="mt-3">
                                <p class="text-xs text-gray-500 mb-2">Proof of Payment</p>
                                <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-medium text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    View Proof
                                </a>
                                <img src="{{ asset('storage/' . $payment->proof_of_payment) }}" alt="Payment proof" class="mt-2 max-w-sm rounded-lg border border-gray-200">
                            </div>
                            @endif

                            @if($payment->notes)
                            <div class="mt-3">
                                <p class="text-xs text-gray-500">Customer Notes</p>
                                <p class="text-sm text-slate-900 mt-1">{{ $payment->notes }}</p>
                            </div>
                            @endif

                            @if($payment->isPending())
                            <div class="mt-4 flex items-center gap-2">
                                <form action="{{ route('admin.payments.confirm', $payment) }}" method="POST" onsubmit="return confirm('Are you sure you want to confirm this payment? This action cannot be undone and the order status will be locked.')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 transition">Confirm Payment</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this payment?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-lg hover:bg-red-700 transition">Reject Payment</button>
                                </form>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">No payment submitted yet.</p>
                    @endif
                </div>

                <div class="p-6 border-t border-gray-100">
                    @php
                        $paymentConfirmed = $order->payments->contains(fn($p) => $p->payment_status->value === 'confirmed');
                        $orderLocked = $paymentConfirmed || in_array($order->status->value, ['confirmed', 'processing', 'completed']);
                    @endphp
                    @if($orderLocked)
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Order status is locked at <strong>{{ $order->status->label() }}</strong>.</span>
                        </div>
                    @else
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border-gray-300 rounded-lg text-sm">
                                @foreach(\App\Enums\OrderStatus::cases() as $status)
                                    <option value="{{ $status->value }}" {{ $order->status === $status ? 'selected' : '' }}>{{ $status->label() }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">Update Status</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a wire:navigate href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Orders</a>
            </div>
        </div>
    </div>
</x-app-layout>
