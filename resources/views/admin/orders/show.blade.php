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
                        <p class="text-slate-900 font-medium">{{ $order->merchant->isAdmin() ? 'Phantom 5 Merchant' : $order->merchant->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->merchant->email }}</p>
                    </div>
                </div>

                <div class="p-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-4">Order Items</h4>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                            <div class="w-14 h-14 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                @if($item->itemable && $item->itemable->images && $item->itemable->images->first())
                                    <img src="{{ $item->itemable->images->first()->url }}" alt="{{ $item->itemable->name ?? $item->itemable->title ?? 'Item' }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
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

                @if(in_array($order->status->value, ['completed']))
                <div class="p-6 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Order completed.</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="mt-6">
                <a wire:navigate href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Orders</a>
            </div>
        </div>
    </div>
</x-app-layout>
