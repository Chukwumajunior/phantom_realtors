<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Merchant Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Subscription Status Banner -->
            @if(isset($subscription) && $subscription)
                @if($subscriptionExpiringSoon)
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start sm:items-center gap-3">
                        <svg class="w-6 h-6 text-yellow-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div>
                            <p class="font-semibold text-yellow-800">Subscription expiring soon</p>
                            <p class="text-sm text-yellow-700">Your {{ $subscription->status->label() }} subscription expires in {{ $subscription->daysRemaining() }} day(s) on {{ $subscription->expires_at->format('M d, Y') }}.</p>
                        </div>
                    </div>
                    <a wire:navigate href="{{ route('merchant.subscription.index') }}" class="px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 transition text-center shrink-0">Renew</a>
                </div>
                @else
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start sm:items-center gap-3">
                        <svg class="w-6 h-6 text-green-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="font-semibold text-green-800">{{ $subscription->status->label() }} Subscription</p>
                            <p class="text-sm text-green-700">{{ $subscription->daysRemaining() }} day(s) remaining (expires {{ $subscription->expires_at->format('M d, Y') }})</p>
                        </div>
                    </div>
                    <a wire:navigate href="{{ route('merchant.subscription.index') }}" class="text-sm text-green-700 font-medium hover:text-green-800 shrink-0">View Details</a>
                </div>
                @endif
            @elseif(!auth()->user()->isAdmin())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start sm:items-center gap-3">
                        <svg class="w-6 h-6 text-red-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        <div>
                            <p class="font-semibold text-red-800">No Active Subscription</p>
                            <p class="text-sm text-red-700">You cannot create or edit listings. Contact admin to activate your subscription.</p>
                        </div>
                    </div>
                    <a wire:navigate href="{{ route('merchant.subscription.index') }}" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition text-center shrink-0">View Plans</a>
                </div>
            @endif

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Properties</p>
                            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_properties'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                    </div>
                    <a wire:navigate href="{{ route('merchant.properties.index') }}" class="text-sm text-amber-600 font-medium mt-3 inline-block hover:text-amber-700">View all &rarr;</a>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Products</p>
                            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_products'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <a wire:navigate href="{{ route('merchant.products.index') }}" class="text-sm text-amber-600 font-medium mt-3 inline-block hover:text-amber-700">View all &rarr;</a>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Services</p>
                            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_services'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <a wire:navigate href="{{ route('merchant.services.index') }}" class="text-sm text-amber-600 font-medium mt-3 inline-block hover:text-amber-700">View all &rarr;</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
