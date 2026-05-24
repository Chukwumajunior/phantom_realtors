<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Merchant Details</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        @if($merchant->logo)
                            <img src="{{ asset('storage/' . $merchant->logo) }}" alt="{{ $merchant->business_name }}" class="w-16 h-16 rounded-lg object-cover">
                        @else
                            <div class="w-16 h-16 bg-amber-100 rounded-lg flex items-center justify-center">
                                <span class="text-amber-600 font-bold text-xl">{{ substr($merchant->business_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">{{ $merchant->business_name }}</h3>
                            <p class="text-sm text-gray-500">Owner: {{ $merchant->user->name }} ({{ $merchant->user->email }})</p>
                        </div>
                        <div class="ml-auto">
                            <x-status-badge :status="$merchant->status->label()" :color="$merchant->status->color()" />
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Business Phone</label>
                        <p class="text-slate-900">{{ $merchant->business_phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Business Address</label>
                        <p class="text-slate-900">{{ $merchant->business_address ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Business Description</label>
                        <p class="text-slate-900">{{ $merchant->business_description ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Applied On</label>
                        <p class="text-slate-900">{{ $merchant->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>

                    @if($merchant->rejection_reason)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Rejection Reason</label>
                        <p class="text-red-600">{{ $merchant->rejection_reason }}</p>
                    </div>
                    @endif
                </div>

                @if($merchant->isPending())
                <div class="p-6 border-t border-gray-100 flex items-center gap-3">
                    <form action="{{ route('admin.merchants.approve', $merchant) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">Approve</button>
                    </form>
                    <form action="{{ route('admin.merchants.reject', $merchant) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="text" name="rejection_reason" placeholder="Rejection reason..." class="border-gray-300 rounded-lg text-sm" required>
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">Reject</button>
                    </form>
                </div>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.merchants.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Merchants</a>
            </div>
        </div>
    </div>
</x-app-layout>
