<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Order #{{ $order->order_number }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Order Details</h3>
                            <p class="text-sm text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <x-status-badge :status="$order->status->label()" :color="$order->status->color()" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Order Total</p>
                            <p class="text-xl font-bold text-slate-900">{{ format_price($order->total_amount) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Payment Status</p>
                            <p class="text-xl font-bold text-slate-900">
                                @if($order->payment)
                                    {{ $order->payment->payment_status->label() }}
                                @else
                                    Not Submitted
                                @endif
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Order Number</p>
                            <p class="text-xl font-bold text-slate-900">{{ $order->order_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-medium text-slate-900">{{ $order->customer->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium text-slate-900">{{ $order->customer->email }}</p>
                        </div>
                        @if($order->customer->phone)
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium text-slate-900">{{ $order->customer->phone }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $item->itemable->name ?? $item->itemable->title ?? 'Item' }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} &times; {{ format_price($item->unit_price) }}</p>
                                </div>
                            </div>
                            <p class="font-medium text-slate-900">{{ format_price($item->subtotal) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Info -->
                @if($order->payment)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Payment Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="font-medium text-slate-900">{{ $order->payment->payment_method?->label() ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Payment Status</p>
                            <x-status-badge :status="$order->payment->payment_status->label()" :color="$order->payment->payment_status->color()" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Amount</p>
                            <p class="font-medium text-slate-900">{{ format_price($order->payment->amount) }}</p>
                        </div>
                        @if($order->payment->reference_number)
                        <div>
                            <p class="text-sm text-gray-500">Reference Number</p>
                            <p class="font-medium text-slate-900">{{ $order->payment->reference_number }}</p>
                        </div>
                        @endif
                        @if($order->payment->bank_name)
                        <div>
                            <p class="text-sm text-gray-500">Bank Name</p>
                            <p class="font-medium text-slate-900">{{ $order->payment->bank_name }}</p>
                        </div>
                        @endif
                        @if($order->payment->account_name)
                        <div>
                            <p class="text-sm text-gray-500">Account Name</p>
                            <p class="font-medium text-slate-900">{{ $order->payment->account_name }}</p>
                        </div>
                        @endif
                    </div>

                    @if($order->payment->proof_of_payment)
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <p class="text-sm font-medium text-gray-500 mb-3">Proof of Payment</p>
                        <a href="{{ asset('storage/' . $order->payment->proof_of_payment) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->payment->proof_of_payment) }}" alt="Payment proof" class="max-w-md rounded-lg border border-gray-200 hover:shadow-lg transition">
                        </a>
                    </div>
                    @endif

                    @if($order->payment->notes)
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <p class="text-sm font-medium text-gray-500 mb-1">Customer Notes</p>
                        <p class="text-slate-900">{{ $order->payment->notes }}</p>
                    </div>
                    @endif
                </div>
                @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Payment Information</h3>
                    <p class="text-gray-500">No payment submitted yet by the customer.</p>
                </div>
                @endif

                <!-- Status Update Form -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    @php
                        $orderLocked = in_array($order->status->value, ['confirmed', 'processing', 'completed']) ||
                            ($order->payment && $order->payment->payment_status->value === 'confirmed');
                    @endphp
                    @if($orderLocked)
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Order status is locked at <strong>{{ $order->status->label() }}</strong>.</span>
                        </div>
                    @else
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Update Order Status</h3>
                        <form action="{{ route('merchant.orders.update-status', $order) }}" method="POST" class="flex items-end gap-4">
                            @csrf
                            @method('PATCH')
                            <div class="flex-1">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                                <select id="status" name="status" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                    @foreach(\App\Enums\OrderStatus::cases() as $status)
                                        <option value="{{ $status->value }}" {{ $order->status === $status ? 'selected' : '' }}>{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition">Update</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a wire:navigate href="{{ route('merchant.orders.index') }}" class="text-amber-600 hover:text-amber-700 font-medium text-sm">&larr; Back to Orders</a>
            </div>
        </div>
    </div>
</x-app-layout>
