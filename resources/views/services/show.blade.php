<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">{{ $service->name }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Full-width Image Gallery -->
            <div class="mb-8" x-data="{ activeImage: 0, total: {{ $service->images->count() ?: 1 }} }">
                @if($service->images->count() > 0)
                <div class="relative w-full h-[300px] sm:h-[400px] lg:h-[500px] rounded-2xl overflow-hidden bg-gray-100">
                    @foreach($service->images->take(4) as $index => $image)
                        <img x-show="activeImage === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ $image->url }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $service->name }}">
                    @endforeach

                    @if($service->images->count() > 1)
                    <!-- Left/Right Navigation -->
                    <button @click="activeImage = (activeImage - 1 + total) % total" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="activeImage = (activeImage + 1) % total" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    <!-- Dots Indicator -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                        @foreach($service->images->take(4) as $index => $image)
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

                <!-- Service Info (Left) -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="inline-block bg-gray-200 text-gray-700 text-xs font-medium px-3 py-1 rounded-full">{{ $service->category->group()->label() }}</span>
                            <span class="inline-block bg-emerald-600 text-white text-xs font-medium px-3 py-1 rounded-full">{{ $service->category->label() }}</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $service->name }}</h1>
                    </div>

                    <!-- Price Range -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                        <p class="text-sm text-amber-800 font-medium mb-1">Price Range</p>
                        <p class="text-2xl font-bold text-amber-700">
                            {{ format_price($service->price_from, $service->currency, 0) }} - {{ format_price($service->price_to, $service->currency, 0) }}
                        </p>
                        @if($service->is_negotiable)
                            <span class="inline-flex items-center gap-1 mt-2 text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Negotiable
                            </span>
                        @endif
                    </div>

                    <!-- Service Area -->
                    @if($service->service_area)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500 mb-1">Service Area</p>
                        <p class="font-semibold text-slate-900">{{ $service->service_area }}</p>
                    </div>
                    @endif

                    <!-- Description -->
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-3">Description</h2>
                        <div class="text-gray-600 leading-relaxed prose prose-sm max-w-none">
                            {!! nl2br(e($service->description)) !!}
                        </div>
                    </div>

                    <!-- Highlights -->
                    @if($service->highlights && count($service->highlights) > 0)
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-3">Highlights</h2>
                        <div class="space-y-2">
                            @foreach($service->highlights as $highlight)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-gray-700">{{ $highlight }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Merchant Info -->
                    @if($service->merchant)
                    <div class="bg-white border border-gray-200 rounded-2xl p-5">
                        <h3 class="text-lg font-bold text-slate-900 mb-3">Provided By</h3>
                        <div class="flex items-center gap-3 mb-4">
                            @if($service->merchant->avatar)
                                <img src="{{ str_starts_with($service->merchant->avatar, 'http') ? $service->merchant->avatar : asset('storage/' . $service->merchant->avatar) }}" class="w-12 h-12 rounded-full object-cover" alt="{{ $service->merchant->name }}">
                            @else
                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <span class="text-amber-600 font-bold text-lg">{{ substr($service->merchant->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $service->merchant->merchantProfile->business_name ?? $service->merchant->name }}</p>
                                <p class="text-sm text-gray-500">Verified Service Provider</p>
                            </div>
                        </div>
                        @if($service->merchant->merchantProfile && $service->merchant->merchantProfile->business_phone)
                        <a href="tel:{{ $service->merchant->merchantProfile->business_phone }}" class="flex items-center justify-center gap-2 w-full bg-slate-800 text-white py-3 rounded-lg font-semibold hover:bg-slate-900 transition mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Call Provider
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $service->merchant->merchantProfile->business_phone) }}?text={{ urlencode('Hi, I am interested in your service: ' . $service->name) }}" target="_blank" class="flex items-center justify-center gap-2 w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Chat on WhatsApp
                        </a>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Sidebar (Right) -->
                <div class="space-y-6">
                    <!-- Related Services -->
                    @if(isset($relatedServices) && $relatedServices->count() > 0)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Related Services</h3>
                        <div class="space-y-4">
                            @foreach($relatedServices as $related)
                            <a href="{{ route('services.show', $related) }}" class="group flex gap-3 hover:bg-gray-50 rounded-lg p-2 -mx-2 transition">
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    <img src="{{ $related->images->first() ? $related->images->first()->url : 'https://via.placeholder.com/200x200' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $related->name }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-slate-900 group-hover:text-amber-600 transition truncate">{{ $related->name }}</h4>
                                    <p class="text-amber-600 font-bold text-sm mt-1">{{ format_price($related->price_from, $related->currency, 0) }} - {{ format_price($related->price_to, $related->currency, 0) }}</p>
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
