<div>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b flex items-center gap-4">
            <select wire:model.live="filter" class="border-gray-300 rounded-lg text-sm">
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="failed">Rejected</option>
                <option value="all">All</option>
            </select>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $payment->order->order_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $payment->user->name }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">{{ format_price($payment->amount, null, 0) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $payment->payment_method->label() }}</td>
                        <td class="px-6 py-4">
                            <x-status-badge :status="$payment->payment_status->label()" :color="$payment->payment_status->color()" />
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($payment->isPending())
                                <button wire:click="confirm({{ $payment->id }})" class="text-xs px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">Confirm</button>
                                <button wire:click="reject({{ $payment->id }})" class="text-xs px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $payments->links() }}
        </div>
    </div>
</div>
