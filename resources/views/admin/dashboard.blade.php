<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Users</p>
                            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_users'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Merchants</p>
                            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_merchants'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Orders</p>
                            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_orders'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending Payments</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending_payments'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Active Subscriptions</p>
                            <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active_subscriptions'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>
                </div>

                @if(($stats['expiring_soon'] ?? 0) > 0)
                <div class="bg-white rounded-xl p-6 shadow-sm border border-orange-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Expiring Soon (7 days)</p>
                            <p class="text-3xl font-bold text-orange-600 mt-1">{{ $stats['expiring_soon'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Pending Merchants -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-900">Pending Merchants</h3>
                        <a wire:navigate href="{{ route('admin.merchants.index') }}" class="text-sm text-amber-600 font-medium hover:text-amber-700">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Business</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pendingMerchants ?? [] as $merchant)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-900">{{ $merchant->business_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $merchant->user->name }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a wire:navigate href="{{ route('admin.merchants.show', $merchant) }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">Review</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-gray-500 text-sm">No pending merchants.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pending Payments -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-900">Pending Payments</h3>
                        <a wire:navigate href="{{ route('admin.payments.index') }}" class="text-sm text-amber-600 font-medium hover:text-amber-700">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">User</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pendingPayments ?? [] as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ format_price($payment->amount) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <a wire:navigate href="{{ route('admin.payments.show', $payment) }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">Review</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 text-sm">No pending payments.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-8">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-900">Recent Orders</h3>
                    <a wire:navigate href="{{ route('admin.orders.index') }}" class="text-sm text-amber-600 font-medium hover:text-amber-700">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Order #</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Customer</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentOrders ?? [] as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a wire:navigate href="{{ route('admin.orders.show', $order) }}" class="text-amber-600 hover:text-amber-700 font-medium text-sm">{{ $order->order_number }}</a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->customer->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ format_price($order->total_amount) }}</td>
                                <td class="px-6 py-4">
                                    <x-status-badge :status="$order->status->label()" :color="$order->status->color()" />
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 text-sm">No orders yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
