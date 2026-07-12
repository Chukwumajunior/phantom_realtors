<x-app-layout>
    <!-- Hero Section - Jumia Style -->
    <section class="bg-gray-100 pt-4 sm:pt-5 pb-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-4">
                <!-- Left Sidebar: Navigation + Ad below (hidden on mobile) -->
                <div class="hidden lg:flex lg:flex-col lg:gap-3 w-56 shrink-0 animate-[slideInLeft_0.4s_ease-out]">
                    <!-- Category Navigation -->
                    <nav class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <a href="{{ route('properties.index') }}" class="group flex items-center gap-3 px-4 py-3.5 border-b border-gray-50 hover:bg-amber-50 transition-all duration-200">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center shrink-0 group-hover:bg-amber-200 transition">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-amber-700 transition">Properties</span>
                            <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-amber-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('products.index') }}" class="group flex items-center gap-3 px-4 py-3.5 border-b border-gray-50 hover:bg-amber-50 transition-all duration-200">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0 group-hover:bg-blue-200 transition">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-amber-700 transition">Products</span>
                            <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-amber-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('services.index') }}" class="group flex items-center gap-3 px-4 py-3.5 hover:bg-amber-50 transition-all duration-200">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-amber-700 transition">Services</span>
                            <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-amber-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </nav>

                    <!-- Small Ad/Promo below navigation -->
                    @if($banners->count())
                        <a href="{{ $banners->first()->link_url ?? '#' }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl overflow-hidden shadow-sm border border-gray-100 flex-1">
                            @if($banners->first()->media_type === 'video')
                                <video src="{{ $banners->first()->media_url }}" class="w-full h-full object-cover" autoplay muted loop playsinline></video>
                            @else
                                <img src="{{ $banners->first()->media_url }}" class="w-full h-full object-cover" alt="{{ $banners->first()->title }}">
                            @endif
                        </a>
                    @else
                        <div class="rounded-xl overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900 flex-1 flex items-center justify-center p-4 shadow-sm">
                            <div class="text-center">
                                <div class="w-10 h-10 rounded-full bg-amber-500/20 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <p class="text-white text-xs font-bold">Quick Deals</p>
                                <p class="text-gray-400 text-[10px] mt-0.5">New listings daily</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Main Banner Carousel -->
                <div class="flex-1 min-w-0 animate-[fadeIn_0.5s_ease-out]"
                     x-data="{
                        current: 0,
                        total: {{ $banners->count() ?: 1 }},
                        interval: null,
                        next() { this.current = (this.current + 1) % this.total; },
                        prev() { this.current = (this.current - 1 + this.total) % this.total; },
                        goTo(i) { this.current = i; this.resetTimer(); },
                        resetTimer() {
                            if (this.interval) clearInterval(this.interval);
                            this.startTimer();
                        },
                        startTimer() {
                            if (this.total <= 1) return;
                            this.interval = setInterval(() => this.next(), 5000);
                        },
                        init() { this.startTimer(); }
                     }">
                    <div class="relative rounded-xl overflow-hidden bg-slate-900 shadow-lg aspect-[16/7] sm:aspect-[16/6]">
                        <!-- Brand Overlay -->
                        <div class="absolute top-0 left-0 right-0 z-20 bg-gradient-to-b from-black/60 via-black/30 to-transparent px-4 sm:px-6 pt-3 pb-8 pointer-events-none">
                            <div class="flex items-center gap-2">
                                <span class="text-white font-extrabold text-sm sm:text-base tracking-tight">Phantom 5</span>
                                <span class="hidden sm:inline text-white/50 text-xs">|</span>
                                <span class="hidden sm:inline text-white/70 text-xs font-medium">Your Marketplace for Properties, Products & Services</span>
                            </div>
                        </div>

                        @if($banners->count())
                            @foreach($banners as $index => $banner)
                            <div x-show="current === {{ $index }}"
                                 x-transition:enter="transition-all ease-out duration-500"
                                 x-transition:enter-start="opacity-0 scale-[1.02]"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition-all ease-in duration-300"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute inset-0">
                                @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" target="_blank" rel="noopener noreferrer" class="block w-full h-full">
                                @endif
                                    @if($banner->media_type === 'video')
                                        <video src="{{ $banner->media_url }}" class="w-full h-full object-cover" autoplay muted loop playsinline></video>
                                    @else
                                        <img src="{{ $banner->media_url }}" class="w-full h-full object-cover" alt="{{ $banner->title }}">
                                    @endif
                                @if($banner->link_url)
                                </a>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-amber-600 via-amber-500 to-orange-500">
                                <div class="text-center text-white px-6">
                                    <h2 class="text-2xl sm:text-4xl font-extrabold mb-2">Welcome to <span class="text-white">Phantom 5</span></h2>
                                    <p class="text-white/80 text-sm sm:text-base max-w-md mx-auto">Your one-stop marketplace for properties, products & services</p>
                                </div>
                            </div>
                        @endif

                        @if($banners->count() > 1)
                        <button @click="prev(); resetTimer();" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 hover:bg-black/60 text-white flex items-center justify-center backdrop-blur-sm transition z-10" style="opacity: 0.7;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="next(); resetTimer();" class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 hover:bg-black/60 text-white flex items-center justify-center backdrop-blur-sm transition z-10" style="opacity: 0.7;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-10">
                            @foreach($banners as $index => $banner)
                            <button @click="goTo({{ $index }})"
                                    class="h-2 rounded-full transition-all duration-300"
                                    :class="current === {{ $index }} ? 'w-6 bg-amber-500' : 'w-2 bg-white/60 hover:bg-white/90'">
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Category Strip -->
    <section class="lg:hidden bg-white border-b border-gray-100 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex gap-3 overflow-x-auto scrollbar-hide">
                <a href="{{ route('properties.index') }}" class="flex items-center gap-2 px-4 py-2 bg-amber-50 rounded-full border border-amber-100 shrink-0 hover:bg-amber-100 transition">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-sm font-medium text-slate-700">Properties</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-full border border-blue-100 shrink-0 hover:bg-blue-100 transition">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span class="text-sm font-medium text-slate-700">Products</span>
                </a>
                <a href="{{ route('services.index') }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 rounded-full border border-emerald-100 shrink-0 hover:bg-emerald-100 transition">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-sm font-medium text-slate-700">Services</span>
                </a>
            </div>
        </div>
    </section>

    <style>
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @php
        $rotationSeconds = (int) ($featuredSettings['rotation_seconds'] ?? 5);
        $propertiesPerPage = (int) ($featuredSettings['properties_per_page'] ?? 6);
        $propertiesPerRow = (int) ($featuredSettings['properties_per_row'] ?? 3);
        $productsPerPage = (int) ($featuredSettings['products_per_page'] ?? 8);
        $productsPerRow = (int) ($featuredSettings['products_per_row'] ?? 4);
        $servicesPerPage = (int) ($featuredSettings['services_per_page'] ?? 6);
        $servicesPerRow = (int) ($featuredSettings['services_per_row'] ?? 3);

        $displayProperties = $featuredProperties->count() ? $featuredProperties : $latestProperties;
        $displayProducts = $featuredProducts->count() ? $featuredProducts : $latestProducts;
        $displayServices = $featuredServices->count() ? $featuredServices : $latestServices;
    @endphp

    <style>
        .featured-grid-properties { grid-template-columns: repeat({{ $propertiesPerRow }}, minmax(0, 1fr)); }
        .featured-grid-products { grid-template-columns: repeat({{ $productsPerRow }}, minmax(0, 1fr)); }
        .featured-grid-services { grid-template-columns: repeat({{ $servicesPerRow }}, minmax(0, 1fr)); }
        @media (max-width: 1023px) {
            .featured-grid-properties, .featured-grid-products, .featured-grid-services { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 639px) {
            .featured-grid-properties, .featured-grid-products, .featured-grid-services { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        }
    </style>

    <script>
        function featuredCarousel(total, perPage, seconds) {
            return {
                currentPage: 0,
                totalPages: Math.max(1, Math.ceil(total / perPage)),
                perPage: perPage,
                interval: null,
                isVisible(index) {
                    var start = this.currentPage * this.perPage;
                    return index >= start && index < start + this.perPage;
                },
                goTo(page) {
                    this.currentPage = page;
                    if (this.interval) clearInterval(this.interval);
                    this.startTimer();
                },
                next() {
                    this.currentPage = (this.currentPage + 1) % this.totalPages;
                },
                startTimer() {
                    if (this.totalPages <= 1) return;
                    this.interval = setInterval(() => this.next(), seconds * 1000);
                },
                init() {
                    this.startTimer();
                },
                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            };
        }
    </script>

    <!-- Featured Properties -->
    @if($displayProperties->count())
    <section class="py-10 sm:py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6 sm:mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Featured Properties</h2>
                    <p class="text-gray-500 mt-1 sm:mt-2 text-sm sm:text-base">Discover our hand-picked properties</p>
                </div>
                <a href="{{ route('properties.index') }}" class="hidden sm:inline-flex items-center text-amber-600 font-semibold hover:text-amber-700 transition">
                    View All
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div x-data="featuredCarousel({{ $displayProperties->count() }}, {{ $propertiesPerPage }}, {{ $rotationSeconds }})">
                <div class="grid featured-grid-properties gap-8">
                    @foreach($displayProperties as $index => $property)
                    <a href="{{ route('properties.show', $property) }}"
                       x-show="isVisible({{ $index }})"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 translate-y-4"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $property->images->first()?->url ?? 'https://via.placeholder.com/400x300' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $property->title }}">
                            <span class="absolute top-3 left-3 bg-amber-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $property->type->label() }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-slate-900 group-hover:text-amber-600 transition">{{ $property->title }}</h3>
                            <p class="text-gray-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $property->city }}, {{ $property->state }}
                            </p>
                            <p class="text-amber-600 font-bold text-lg mt-3">{{ format_price($property->price, $property->currency) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Pagination Dots -->
                <div class="flex justify-center items-center mt-8 gap-2" x-show="totalPages > 1">
                    <template x-for="page in totalPages" :key="page">
                        <button @click="goTo(page - 1)"
                                class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                :class="currentPage === (page - 1) ? 'bg-amber-600 w-8' : 'bg-gray-300 hover:bg-gray-400'">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Products -->
    @if($displayProducts->count())
    <section class="py-10 sm:py-16 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6 sm:mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Featured Products</h2>
                    <p class="text-gray-500 mt-1 sm:mt-2 text-sm sm:text-base">Quality building and home products</p>
                </div>
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center text-amber-600 font-semibold hover:text-amber-700 transition">
                    View All
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div x-data="featuredCarousel({{ $displayProducts->count() }}, {{ $productsPerPage }}, {{ $rotationSeconds }})">
                <div class="grid featured-grid-products gap-6">
                    @foreach($displayProducts as $index => $product)
                    <a href="{{ route('products.show', $product) }}"
                       x-show="isVisible({{ $index }})"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 translate-y-4"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $product->images->first()?->url ?? 'https://via.placeholder.com/300x200' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $product->name }}">
                            <span class="absolute top-3 left-3 bg-slate-900 text-white text-xs font-medium px-2 py-1 rounded">{{ $product->category->label() }}</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-slate-900 group-hover:text-amber-600 transition">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-amber-600 font-bold">{{ format_price($product->price, $product->currency) }}</p>
                                @if($product->stock_quantity > 0)
                                    <span class="text-xs text-emerald-600 font-medium">{{ $product->stock_quantity }} left</span>
                                @else
                                    <span class="text-xs text-red-500 font-medium">Sold out</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Pagination Dots -->
                <div class="flex justify-center items-center mt-8 gap-2" x-show="totalPages > 1">
                    <template x-for="page in totalPages" :key="page">
                        <button @click="goTo(page - 1)"
                                class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                :class="currentPage === (page - 1) ? 'bg-amber-600 w-8' : 'bg-gray-300 hover:bg-gray-400'">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Services -->
    @if($displayServices->count())
    <section class="py-10 sm:py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6 sm:mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Featured Services</h2>
                    <p class="text-gray-500 mt-1 sm:mt-2 text-sm sm:text-base">Professional services for your home</p>
                </div>
                <a href="{{ route('services.index') }}" class="hidden sm:inline-flex items-center text-amber-600 font-semibold hover:text-amber-700 transition">
                    View All
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div x-data="featuredCarousel({{ $displayServices->count() }}, {{ $servicesPerPage }}, {{ $rotationSeconds }})">
                <div class="grid featured-grid-services gap-8">
                    @foreach($displayServices as $index => $service)
                    <a href="{{ route('services.show', $service) }}"
                       x-show="isVisible({{ $index }})"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 translate-y-4"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $service->images->first()?->url ?? 'https://via.placeholder.com/400x250' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $service->name }}">
                            <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $service->category->label() }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-slate-900 group-hover:text-amber-600 transition">{{ $service->name }}</h3>
                            <p class="text-amber-600 font-semibold mt-2">{{ $service->price_range }}</p>
                            @if($service->is_negotiable)
                                <span class="inline-block mt-2 text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded">Negotiable</span>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Pagination Dots -->
                <div class="flex justify-center items-center mt-8 gap-2" x-show="totalPages > 1">
                    <template x-for="page in totalPages" :key="page">
                        <button @click="goTo(page - 1)"
                                class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                :class="currentPage === (page - 1) ? 'bg-amber-600 w-8' : 'bg-gray-300 hover:bg-gray-400'">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Ad Banners Strip (above footer) -->
    @if($banners->count())
    <section class="py-6 sm:py-8 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
                @foreach($banners->take(5) as $banner)
                <a href="{{ $banner->link_url ?? '#' }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    @if($banner->media_type === 'video')
                        <video src="{{ $banner->media_url }}" class="w-full h-32 sm:h-36 object-cover group-hover:scale-105 transition duration-500" autoplay muted loop playsinline></video>
                    @else
                        <img src="{{ $banner->media_url }}" class="w-full h-32 sm:h-36 object-cover group-hover:scale-105 transition duration-500" alt="{{ $banner->title }}">
                    @endif
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-app-layout>
