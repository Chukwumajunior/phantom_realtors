<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Payment Details</h2>
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
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Order #{{ $payment->order->order_number }}</h3>
                        <p class="text-sm text-gray-500">Submitted {{ $payment->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <x-status-badge :status="$payment->payment_status->label()" :color="$payment->payment_status->color()" />
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Customer</label>
                        <p class="text-slate-900 font-medium">{{ $payment->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $payment->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Amount</label>
                        <p class="text-2xl font-bold text-amber-600">{{ format_price($payment->amount) }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Payment Method</label>
                        <p class="text-slate-900">{{ $payment->payment_method->label() }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Reference Number</label>
                        <p class="text-slate-900">{{ $payment->reference_number ?? 'N/A' }}</p>
                    </div>
                    @if($payment->bank_name)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Bank Name</label>
                        <p class="text-slate-900">{{ $payment->bank_name }}</p>
                    </div>
                    @endif
                    @if($payment->account_name)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Account Name</label>
                        <p class="text-slate-900">{{ $payment->account_name }}</p>
                    </div>
                    @endif
                </div>

                @if($payment->proof_of_payment)
                <div class="p-6 border-t border-gray-100">
                    <label class="text-sm font-medium text-gray-500 block mb-2">Proof of Payment</label>
                    <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-medium text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        View Proof
                    </a>
                </div>
                @endif

                @if($payment->isPending())
                <div class="p-6 border-t border-gray-100">
                    <div class="flex items-center gap-3 flex-wrap">
                        <button
                            wire:click="confirmPayment"
                            wire:confirm="Are you sure you want to confirm this payment? This action cannot be undone."
                            wire:loading.attr="disabled"
                            class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="confirmPayment">Confirm Payment</span>
                            <span wire:loading wire:target="confirmPayment">Processing...</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <input
                                type="text"
                                wire:model="adminNotes"
                                placeholder="Rejection reason..."
                                class="border-gray-300 rounded-lg text-sm"
                            >
                            <button
                                wire:click="rejectPayment"
                                wire:confirm="Are you sure you want to reject this payment?"
                                wire:loading.attr="disabled"
                                class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="rejectPayment">Reject</span>
                                <span wire:loading wire:target="rejectPayment">Processing...</span>
                            </button>
                        </div>
                    </div>
                </div>
                @elseif($payment->payment_status->value === 'confirmed')
                <div class="p-6 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-green-700 bg-green-50 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Payment confirmed on {{ $payment->confirmed_at?->format('M d, Y \a\t h:i A') }}. This action cannot be undone.</span>
                    </div>
                </div>
                @elseif($payment->payment_status->value === 'failed')
                <div class="p-6 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-red-700 bg-red-50 p-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Payment was rejected.{{ $payment->admin_notes ? ' Reason: ' . $payment->admin_notes : '' }}</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="mt-6">
                <a wire:navigate href="{{ route('admin.payments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Payments</a>
            </div>
        </div>
    </div>
</div>
