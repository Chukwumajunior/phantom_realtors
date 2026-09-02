<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-700">{{ session('info') }}</p>
            </div>
            @endif

            @if($profile && $profile->isPending())
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <h4 class="text-sm font-bold text-yellow-800">Payment Pending Confirmation</h4>
                        <p class="text-sm text-yellow-700 mt-1">Your {{ $tier->label() }} payment is being reviewed by admin. You'll be able to create listings once confirmed.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tier Info Card -->
            <div class="mb-6 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($tier === \App\Enums\PosterTier::Tier1) bg-gray-100 text-gray-800
                                @elseif($tier === \App\Enums\PosterTier::Tier2) bg-blue-100 text-blue-800
                                @else bg-purple-100 text-purple-800
                                @endif">
                                {{ $tier->label() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            @if($stats['posts_remaining'] === null)
                                Unlimited posts &middot; Unlimited categories
                            @else
                                {{ $stats['posts_remaining'] }} post(s) remaining &middot;
                                {{ $stats['categories_used'] }}/{{ $stats['max_categories'] }} categories used
                            @endif
                        </p>
                    </div>
                    @if(!(\App\Models\SiteConfig::isFreeMode()) && $tier !== \App\Enums\PosterTier::Tier3)
                        <a href="{{ route('merchant.profile.edit') }}" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition text-center shrink-0">
                            Upgrade Tier
                        </a>
                    @endif
                </div>
            </div>

            <!-- Upgrade Prompt for Tier 1 -->
            @if($tier === \App\Enums\PosterTier::Tier1)
                <x-upgrade-prompt />
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
