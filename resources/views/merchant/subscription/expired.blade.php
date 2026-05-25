<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Subscription Expired</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <!-- Warning Icon -->
                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-slate-900 mb-3">Your Subscription Has Expired</h3>
                <p class="text-gray-600 mb-6">Your subscription expired{{ $lastSubscription ? ' on ' . $lastSubscription->expires_at->format('M d, Y') : '' }}. While your account is still active, the following restrictions apply:</p>

                <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span>You cannot create new listings (properties, products, or services)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span>You cannot edit existing listings</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span>Your listings are hidden from the public</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>You can still view and delete your listings</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>You can still view and manage existing orders</span>
                        </li>
                    </ul>
                </div>

                <!-- Available Plans -->
                @if($plans->count())
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-slate-900 mb-4">Renew Your Subscription</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($plans as $plan)
                            <div class="border border-gray-200 rounded-xl p-5 text-left">
                                <h5 class="font-bold text-slate-900">{{ $plan->name }}</h5>
                                <p class="text-2xl font-bold text-amber-600 mt-2">{{ $plan->formatted_price }}</p>
                                <p class="text-sm text-gray-500">{{ $plan->duration_days }} days</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @php $bankDetails = \App\Models\SiteConfig::getBankDetails(); @endphp
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 text-left mb-8">
                    <p class="font-medium text-amber-900 mb-2">To renew your subscription:</p>
                    <p class="text-sm text-amber-800">Make payment and contact the admin for activation. Your listings will become visible again once your subscription is renewed.</p>
                    @if($bankDetails['bank_name'] && $bankDetails['account_number'])
                    <div class="mt-3 pt-3 border-t border-amber-200">
                        <p class="text-sm font-medium text-amber-900 mb-1">Bank Transfer Details:</p>
                        <div class="text-sm text-amber-800">
                            <p><span class="font-medium">Bank:</span> {{ $bankDetails['bank_name'] }}</p>
                            <p><span class="font-medium">Account Name:</span> {{ $bankDetails['account_name'] }}</p>
                            <p><span class="font-medium">Account Number:</span> {{ $bankDetails['account_number'] }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a wire:navigate href="{{ route('merchant.subscription.index') }}" class="px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition">
                        View Subscription Details
                    </a>
                    <a wire:navigate href="{{ route('merchant.dashboard') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
