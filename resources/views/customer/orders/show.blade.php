<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Order #{{ $order->order_number }}</h2>
    </x-slot>

    @if(in_array($order->status->value, ['confirmed', 'processing', 'completed']))
    <style>
        @media print {
            body * { visibility: hidden; }
            #printable-receipt, #printable-receipt * { visibility: visible; }
            #printable-receipt { position: absolute; top: 0; left: 0; width: 100%; padding: 40px; }
            .no-print { display: none !important; }
        }
    </style>
    @endif

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="printable-receipt">
                {{-- Print-only header --}}
                <div class="hidden print:block text-center border-b-2 border-amber-500 pb-6 mb-6 p-6">
                    <h1 class="text-2xl font-extrabold text-amber-600">Phantom Realtors</h1>
                    <p class="text-gray-500 text-sm">Payment Receipt</p>
                </div>

                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <x-status-badge :status="$order->status->label()" :color="$order->status->color()" />
                        <p class="text-sm text-gray-500 mt-2">Placed {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <p class="text-2xl font-bold text-amber-600">{{ format_price($order->total_amount) }}</p>
                </div>

                {{-- Customer & Merchant info (visible on print) --}}
                <div class="hidden print:grid grid-cols-2 gap-6 p-6 border-b border-gray-100">
                    <div>
                        <p class="text-xs uppercase font-semibold text-gray-500">Customer</p>
                        <p class="font-semibold text-slate-900">{{ $order->customer->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->customer->email }}</p>
                        @if($order->customer->phone)
                            <p class="text-sm text-gray-500">{{ $order->customer->phone }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs uppercase font-semibold text-gray-500">Merchant</p>
                        <p class="font-semibold text-slate-900">{{ $order->merchant->merchantProfile->business_name ?? $order->merchant->name }}</p>
                        @if($order->merchant->merchantProfile && $order->merchant->merchantProfile->business_phone)
                            <p class="text-sm text-gray-500">{{ $order->merchant->merchantProfile->business_phone }}</p>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-4">Items</h4>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                            <div>
                                <p class="font-medium text-slate-900">{{ $item->itemable->name ?? $item->itemable->title ?? 'Item' }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} x {{ format_price($item->unit_price) }}</p>
                            </div>
                            <p class="font-semibold text-slate-900">{{ format_price($item->subtotal) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="p-6 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-4">Payment</h4>

                    @if($order->payment)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <p class="text-sm text-gray-600">Method: <span class="font-medium">{{ $order->payment->payment_method->label() }}</span></p>
                                    @if($order->payment->reference_number)
                                        <p class="text-sm text-gray-600">Ref: {{ $order->payment->reference_number }}</p>
                                    @endif
                                    @if($order->payment->bank_name)
                                        <p class="text-sm text-gray-600">Bank: {{ $order->payment->bank_name }}</p>
                                    @endif
                                </div>
                                <x-status-badge :status="$order->payment->payment_status->label()" :color="$order->payment->payment_status->color()" />
                            </div>
                            @if($order->payment->confirmed_at)
                                <p class="text-xs text-gray-500">Confirmed on {{ $order->payment->confirmed_at->format('M d, Y \a\t h:i A') }}</p>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('customer.orders.payment', $order) }}" method="POST" enctype="multipart/form-data" class="space-y-4 no-print">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                    <select name="payment_method" class="w-full border-gray-300 rounded-lg text-sm" required>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                                    <input type="text" name="reference_number" class="w-full border-gray-300 rounded-lg text-sm" placeholder="Transaction reference">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                                    <input type="text" name="bank_name" class="w-full border-gray-300 rounded-lg text-sm" placeholder="e.g. GTBank">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Name</label>
                                    <input type="text" name="account_name" class="w-full border-gray-300 rounded-lg text-sm" placeholder="Sender's name">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Proof of Payment</label>
                                <input type="file" name="proof_of_payment" class="w-full border-gray-300 rounded-lg text-sm" accept="image/*,.pdf">
                            </div>
                            <button type="submit" class="px-6 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">Submit Payment</button>
                        </form>
                    @endif
                </div>

                {{-- Print-only footer --}}
                <div class="hidden print:block text-center border-t border-gray-200 p-6">
                    <p class="text-sm font-semibold text-slate-900">Phantom Realtors</p>
                    <p class="text-xs text-gray-500 mt-1">Thank you for your purchase!</p>
                    <p class="text-xs text-gray-400 mt-1">This is a computer-generated receipt and does not require a signature.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between no-print">
                <a href="{{ route('customer.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Orders</a>
                <div class="flex items-center gap-3">
                    @if(in_array($order->status->value, ['confirmed', 'processing', 'completed']))
                    <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-900 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print Receipt
                    </button>
                    @endif
                    @if($order->status->value === 'pending' && (!$order->payment || $order->payment->payment_status->value !== 'confirmed'))
                    <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">Cancel Order</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
