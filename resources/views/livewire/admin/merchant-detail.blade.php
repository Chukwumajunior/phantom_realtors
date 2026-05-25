<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Merchant Details</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Inline Flash Message -->
            @if($message)
            <div class="mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                <div class="flex items-center gap-3 p-4 rounded-lg border {{ $messageType === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800' }}">
                    @if($messageType === 'success')
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                    <p class="text-sm font-medium">{{ $message }}</p>
                    <button @click="show = false" class="ml-auto {{ $messageType === 'success' ? 'text-green-500 hover:text-green-700' : 'text-red-500 hover:text-red-700' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-start sm:items-center gap-4 flex-wrap">
                        @if($merchantProfile->user->avatar)
                            <a href="{{ str_starts_with($merchantProfile->user->avatar, 'http') ? $merchantProfile->user->avatar : asset('storage/' . $merchantProfile->user->avatar) }}" target="_blank">
                                <img src="{{ str_starts_with($merchantProfile->user->avatar, 'http') ? $merchantProfile->user->avatar : asset('storage/' . $merchantProfile->user->avatar) }}" alt="{{ $merchantProfile->user->name }}" class="w-24 h-24 sm:w-32 sm:h-32 rounded-xl object-cover border border-gray-200 shadow-sm hover:shadow-md transition">
                            </a>
                        @else
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-bold text-slate-900">{{ $merchantProfile->business_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $merchantProfile->user->name }} &middot; {{ $merchantProfile->user->email }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-status-badge :status="$merchantProfile->status->label()" :color="$merchantProfile->status->color()" />
                            <button wire:click="toggleEdit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition {{ $editing ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100' }}">
                                @if($editing)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Cancel
                                @else
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

                @if($editing)
                <form wire:submit="saveMerchant" class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500 mb-1 block">Owner Name</label>
                        <input wire:model="ownerName" type="text" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('ownerName') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 mb-1 block">Business Name</label>
                        <input wire:model="businessName" type="text" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('businessName') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 mb-1 block">Business Phone</label>
                        <input wire:model="businessPhone" type="text" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('businessPhone') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 mb-1 block">Business Address</label>
                        <input wire:model="businessAddress" type="text" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('businessAddress') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 mb-1 block">Business Description</label>
                        <textarea wire:model="businessDescription" rows="3" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
                        @error('businessDescription') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Applied On</label>
                        <p class="text-slate-900">{{ $merchantProfile->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-5 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition flex items-center gap-2">
                            <span wire:loading.remove wire:target="saveMerchant">Save Changes</span>
                            <span wire:loading wire:target="saveMerchant" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
                @else
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Owner Name</label>
                        <p class="text-slate-900">{{ $merchantProfile->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Business Phone</label>
                        <p class="text-slate-900">{{ $merchantProfile->business_phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Business Address</label>
                        <p class="text-slate-900">{{ $merchantProfile->business_address ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Business Description</label>
                        <p class="text-slate-900">{{ $merchantProfile->business_description ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Applied On</label>
                        <p class="text-slate-900">{{ $merchantProfile->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>

                    @if($merchantProfile->rejection_reason)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <label class="text-sm font-medium text-red-700">Rejection Reason</label>
                        <p class="text-red-600 mt-1">{{ $merchantProfile->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Payment Details Section -->
                <div class="p-6 border-t border-gray-100">
                    <h4 class="text-base font-bold text-slate-900 mb-4">Payment Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Selected Plan</label>
                            <p class="text-slate-900">{{ $merchantProfile->subscriptionPlan?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Amount Paid</label>
                            <p class="text-slate-900 font-semibold">{{ $merchantProfile->amount_paid ? '₦' . number_format($merchantProfile->amount_paid, 2) : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Payment Reference</label>
                            <p class="text-slate-900">{{ $merchantProfile->payment_reference ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($merchantProfile->payment_proof)
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-500 block mb-2">Proof of Payment</label>
                        <a href="{{ asset('storage/' . $merchantProfile->payment_proof) }}" target="_blank" class="inline-block">
                            <img src="{{ asset('storage/' . $merchantProfile->payment_proof) }}" alt="Payment proof" class="max-w-md rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition">
                        </a>
                        <p class="text-xs text-gray-500 mt-1">Click to view full size</p>
                    </div>
                    @else
                    <p class="text-sm text-gray-500 mt-4">No payment proof uploaded.</p>
                    @endif
                </div>

                @if($merchantProfile->isPending())
                <div class="p-6 border-t border-gray-100" x-data="{ showApproveModal: false }">
                    <div class="flex items-center gap-3 flex-wrap">
                        <button @click="showApproveModal = true" class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">Approve</button>

                        <div class="flex items-center gap-2">
                            <input
                                type="text"
                                wire:model="rejectionReason"
                                placeholder="What needs to be corrected..."
                                class="border-gray-300 rounded-lg text-sm"
                            >
                            <button
                                wire:click="reject"
                                wire:confirm="Are you sure you want to request a revision from this merchant?"
                                wire:loading.attr="disabled"
                                class="px-6 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 transition disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="reject">Request Revision</span>
                                <span wire:loading wire:target="reject">Processing...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Approve Confirmation Modal -->
                    <div x-show="showApproveModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="fixed inset-0 bg-black/50" @click="showApproveModal = false"></div>
                        <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto" @click.away="showApproveModal = false">
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-slate-900">Confirm Merchant Approval</h3>
                                <p class="text-sm text-gray-500 mt-1">Review payment details before approving this application.</p>
                            </div>

                            <div class="p-6 space-y-4">
                                {{-- Applicant passport --}}
                                <div class="flex items-center gap-3">
                                    @if($merchantProfile->user->avatar)
                                        <a href="{{ asset('storage/' . $merchantProfile->user->avatar) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $merchantProfile->user->avatar) }}" alt="{{ $merchantProfile->user->name }}" class="w-14 h-14 rounded-xl object-cover border border-gray-200 shadow-sm hover:shadow-md transition">
                                        </a>
                                    @else
                                        <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $merchantProfile->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $merchantProfile->user->email }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Plan</label>
                                        <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $merchantProfile->subscriptionPlan?->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Amount</label>
                                        <p class="text-sm font-semibold text-amber-600 mt-0.5">{{ $merchantProfile->amount_paid ? '₦' . number_format($merchantProfile->amount_paid, 2) : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Reference</label>
                                        <p class="text-sm text-slate-900 mt-0.5">{{ $merchantProfile->payment_reference ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase">Duration</label>
                                        <p class="text-sm text-slate-900 mt-0.5">{{ $merchantProfile->subscriptionPlan?->duration_days ? $merchantProfile->subscriptionPlan->duration_days . ' days' : 'N/A' }}</p>
                                    </div>
                                </div>

                                @if($merchantProfile->payment_proof)
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase block mb-2">Proof of Payment</label>
                                    <a href="{{ asset('storage/' . $merchantProfile->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $merchantProfile->payment_proof) }}" alt="Payment proof" class="w-full rounded-lg border border-gray-200">
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
                                <button
                                    wire:click="approve"
                                    wire:loading.attr="disabled"
                                    @click="showApproveModal = false"
                                    class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition disabled:opacity-50"
                                >
                                    <span wire:loading.remove wire:target="approve">Confirm Approval</span>
                                    <span wire:loading wire:target="approve">Processing...</span>
                                </button>
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
</div>
