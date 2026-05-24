<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">My Orders</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-4">
                @forelse($orders as $order)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-3">
                                <h3 class="font-bold text-slate-900">{{ $order->order_number }}</h3>
                                <x-status-badge :status="$order->status->label()" :color="$order->status->color()" />
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                            <p class="text-sm text-gray-500">{{ $order->items->count() }} item(s)</p>
                            @if(in_array($order->status->value, ['confirmed', 'processing', 'completed']))
                                <p class="text-xs text-green-600 mt-1">Payment: <span class="font-medium">Confirmed</span></p>
                            @elseif($order->payment)
                                <p class="text-xs mt-1">Payment: <span class="font-medium">{{ $order->payment->payment_status->label() }}</span></p>
                            @else
                                <p class="text-xs text-red-600 mt-1">Payment not submitted</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-amber-600">{{ format_price($order->total_amount) }}</p>
                            <div class="flex items-center gap-3 mt-2 justify-end">
                                <a href="{{ route('customer.orders.show', $order) }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">View Details &rarr;</a>
                                @if($order->status->value === 'pending' && (!$order->payment || $order->payment->payment_status->value !== 'confirmed'))
                                <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">Cancel</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <p class="text-gray-500 text-lg">You have no orders yet.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block text-amber-600 hover:text-amber-700 font-medium">Browse Products</a>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
