<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">{{ $property->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Image Gallery -->
            <div class="mb-8" x-data="{ activeImage: 0, total: {{ $property->images->count() ?: 1 }} }">
                @if($property->images->count() > 0)
                <div class="relative w-full h-[300px] sm:h-[400px] lg:h-[500px] rounded-2xl overflow-hidden bg-gray-100">
                    @foreach($property->images->take(4) as $index => $image)
                        <img x-show="activeImage === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ $image->url }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $property->title }}">
                    @endforeach

                    @if($property->images->count() > 1)
                    <!-- Left/Right Navigation -->
                    <button @click="activeImage = (activeImage - 1 + total) % total" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="activeImage = (activeImage + 1) % total" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    <!-- Dots Indicator -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                        @foreach($property->images->take(4) as $index => $image)
                            <button @click="activeImage = {{ $index }}" class="w-2.5 h-2.5 rounded-full transition" :class="activeImage === {{ $index }} ? 'bg-white' : 'bg-white/50'"></button>
                        @endforeach
                    </div>
                    @endif
                </div>
                @else
                <div class="w-full h-[300px] sm:h-[400px] lg:h-[500px] bg-gray-200 rounded-2xl flex items-center justify-center">
                    <p class="text-gray-500">No images available</p>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Title & Price -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $property->title }}</h1>
                                <p class="text-gray-500 flex items-center mt-2">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $property->address }}, {{ $property->city }}, {{ $property->state }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl sm:text-3xl font-bold text-amber-600">{{ format_price($property->price, $property->currency) }}</p>
                                <span class="inline-block mt-2 bg-amber-100 text-amber-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $property->type->label() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Property Details</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            @if($property->bedrooms)
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <svg class="w-8 h-8 text-amber-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <p class="text-2xl font-bold text-slate-900">{{ $property->bedrooms }}</p>
                                <p class="text-sm text-gray-500">Bedrooms</p>
                            </div>
                            @endif
                            @if($property->bathrooms)
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <svg class="w-8 h-8 text-amber-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <p class="text-2xl font-bold text-slate-900">{{ $property->bathrooms }}</p>
                                <p class="text-sm text-gray-500">Bathrooms</p>
                            </div>
                            @endif
                            @if($property->toilets)
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <svg class="w-8 h-8 text-amber-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <p class="text-2xl font-bold text-slate-900">{{ $property->toilets }}</p>
                                <p class="text-sm text-gray-500">Toilets</p>
                            </div>
                            @endif
                            @if($property->area_sqft)
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <svg class="w-8 h-8 text-amber-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <p class="text-2xl font-bold text-slate-900">{{ number_format($property->area_sqft) }}</p>
                                <p class="text-sm text-gray-500">Sq Ft</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Description</h2>
                        <div class="prose prose-gray max-w-none">
                            {!! nl2br(e($property->description)) !!}
                        </div>
                    </div>

                    <!-- Features -->
                    @if($property->features && count($property->features) > 0)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Features</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($property->features as $feature)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-gray-700 text-sm">{{ $feature }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Merchant Info -->
                    @if($property->merchant)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Listed By</h3>
                        <div class="flex items-center gap-3 mb-4">
                            @if($property->merchant->isAdmin())
                                <img src="{{ asset('img/logo.png') }}" class="w-12 h-12 rounded-full object-cover" alt="Phantom 5">
                            @elseif($property->merchant->avatar)
                                <img src="{{ str_starts_with($property->merchant->avatar, 'http') ? $property->merchant->avatar : asset('storage/' . $property->merchant->avatar) }}" class="w-12 h-12 rounded-full object-cover" alt="{{ $property->merchant->name }}">
                            @else
                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <span class="text-amber-600 font-bold text-lg">{{ substr($property->merchant->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $property->merchant->isAdmin() ? 'Phantom 5 Merchant' : ($property->merchant->merchantProfile->business_name ?? $property->merchant->name) }}</p>
                                <p class="text-sm text-gray-500">{{ $property->merchant->isAdmin() ? 'Official Store' : 'Verified Merchant' }}</p>
                            </div>
                        </div>
                        @php
                            $propertyAddress = $property->merchant->merchantProfile->business_address ?? null;
                            $propertyPhone = $property->merchant->merchantProfile->business_phone ?? $property->merchant->phone ?? null;
                        @endphp
                        @if($propertyAddress)
                        <div class="flex items-start gap-2 mb-4 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $propertyAddress }}</span>
                        </div>
                        @endif
                        @if($propertyPhone)
                        <a href="tel:{{ $propertyPhone }}" class="flex items-center justify-center gap-2 w-full bg-slate-800 text-white py-3 rounded-lg font-semibold hover:bg-slate-900 transition mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Call Merchant
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $propertyPhone) }}?text={{ urlencode('Hi, I am interested in your property: ' . $property->title) }}" target="_blank" class="flex items-center justify-center gap-2 w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition mb-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Chat on WhatsApp
                        </a>
                        @endif

                        @if($property->merchant->isAdmin())
                            @auth
                                <form action="{{ route('customer.orders.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="merchant_id" value="{{ $property->user_id }}">
                                    <input type="hidden" name="items[0][itemable_type]" value="property">
                                    <input type="hidden" name="items[0][itemable_id]" value="{{ $property->id }}">
                                    <input type="hidden" name="items[0][quantity]" value="1">
                                    <button type="submit" class="flex items-center justify-center gap-2 w-full bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                        I'm Interested - Order Now
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition">
                                    Sign in to Order
                                </a>
                            @endauth
                        @endif
                    </div>
                    @endif

                    <!-- Category Badge -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-slate-900 mb-3">Category</h3>
                        <span class="inline-block bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg font-medium text-sm">{{ $property->category->label() }}</span>
                    </div>

                    <!-- Related Properties -->
                    @if(isset($relatedProperties) && $relatedProperties->count() > 0)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Related Properties</h3>
                        <div class="space-y-4">
                            @foreach($relatedProperties as $related)
                            <a href="{{ route('properties.show', $related) }}" class="group flex gap-3 hover:bg-gray-50 rounded-lg p-2 -mx-2 transition">
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    <img src="{{ $related->images->first() ? $related->images->first()->url : 'https://via.placeholder.com/200x200' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $related->title }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-slate-900 group-hover:text-amber-600 transition truncate">{{ $related->title }}</h4>
                                    <p class="text-gray-500 text-xs mt-0.5">{{ $related->city }}, {{ $related->state }}</p>
                                    <p class="text-amber-600 font-bold text-sm mt-1">{{ format_price($related->price, $related->currency) }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
