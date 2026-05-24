<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Orders</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Order #</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Customer</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->customer->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ format_price($order->total_amount) }}</td>
                                <td class="px-6 py-4">
                                    <x-status-badge :status="$order->status->label()" :color="$order->status->color()" />
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('merchant.orders.show', $order) }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No orders yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
