<div>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b flex items-center gap-4">
            <select wire:model.live="filter" class="border-gray-300 rounded-lg text-sm">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="all">All</option>
            </select>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Business</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($merchants as $merchant)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $merchant->business_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $merchant->user->name }}</td>
                        <td class="px-6 py-4">
                            <x-status-badge :status="$merchant->status->label()" :color="$merchant->status->color()" />
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $merchant->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($merchant->isPending())
                                <button wire:click="approve({{ $merchant->id }})" class="text-xs px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">Approve</button>
                                <button wire:click="reject({{ $merchant->id }})" class="text-xs px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No merchants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $merchants->links() }}
        </div>
    </div>
</div>
