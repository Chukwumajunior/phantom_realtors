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
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <label class="text-sm font-medium text-red-700">Rejection Reason</label>
                        <p class="text-red-600 mt-1">{{ $merchant->rejection_reason }}</p>
                    </div>
                    @endif
                </div>

                <!-- Payment Details Section -->
                <div class="p-6 border-t border-gray-100">
                    <h4 class="text-base font-bold text-slate-900 mb-4">Payment Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Selected Plan</label>
                            <p class="text-slate-900">{{ $merchant->subscriptionPlan?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Amount Paid</label>
                            <p class="text-slate-900 font-semibold">{{ $merchant->amount_paid ? '₦' . number_format($merchant->amount_paid, 2) : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Payment Reference</label>
                            <p class="text-slate-900">{{ $merchant->payment_reference ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($merchant->payment_proof)
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-500 block mb-2">Proof of Payment</label>
                        <a href="{{ asset('storage/' . $merchant->payment_proof) }}" target="_blank" class="inline-block">
                            <img src="{{ asset('storage/' . $merchant->payment_proof) }}" alt="Payment proof" class="max-w-md rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition">
                        </a>
                        <p class="text-xs text-gray-500 mt-1">Click to view full size</p>
                    </div>
                    @else
                    <p class="text-sm text-gray-500 mt-4">No payment proof uploaded.</p>
                    @endif
                </div>

                @if($merchant->isPending())
                <div class="p-6 border-t border-gray-100 flex items-center gap-3" x-data="{ showApproveModal: false }">
                    <button @click="showApproveModal = true" class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">Approve</button>
                    <form action="{{ route('admin.merchants.reject', $merchant) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="text" name="rejection_reason" placeholder="What needs to be corrected..." class="border-gray-300 rounded-lg text-sm" required>
                        <button type="submit" class="px-6 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 transition">Request Revision</button>
                    </form>

                    <!-- Approve Confirmation Modal -->
                    <div x-show="showApproveModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="fixed inset-0 bg-black/50" @click="showApproveModal = false"></div>
                        <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto" @click.away="showApproveModal = false">
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-slate-900">Confirm Merchant Approval</h3>
                                <p class="text-sm text-gray-500 mt-1">Review payment details before approving this application.</p>
                            </div>

                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Plan</label>
                                        <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $merchant->subscriptionPlan?->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Amount</label>
                                        <p class="text-sm font-semibold text-amber-600 mt-0.5">{{ $merchant->amount_paid ? '₦' . number_format($merchant->amount_paid, 2) : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Reference</label>
                                        <p class="text-sm text-slate-900 mt-0.5">{{ $merchant->payment_reference ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Duration</label>
                                        <p class="text-sm text-slate-900 mt-0.5">{{ $merchant->subscriptionPlan?->duration_days ? $merchant->subscriptionPlan->duration_days . ' days' : 'N/A' }}</p>
                                    </div>
                                </div>

                                @if($merchant->payment_proof)
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase block mb-2">Proof of Payment</label>
                                    <a href="{{ asset('storage/' . $merchant->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $merchant->payment_proof) }}" alt="Payment proof" class="w-full rounded-lg border border-gray-200">
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">Click image to view full size</p>
                                </div>
                                @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <p class="text-sm text-yellow-800 font-medium">No payment proof uploaded.</p>
                                </div>
                                @endif
                            </div>

                            <div class="p-6 border-t border-gray-100 flex items-center justify-end gap-3">
                                <button @click="showApproveModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                                <form action="{{ route('admin.merchants.approve', $merchant) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">Confirm Approval</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="mt-6">
                <a wire:navigate href="{{ route('admin.merchants.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Merchants</a>
            </div>
        </div>
    </div>
</x-app-layout>
