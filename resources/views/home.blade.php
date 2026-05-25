<x-app-layout>
    <!-- Hero Section -->
    <section class="relative min-h-[60vh] sm:min-h-[80vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070" class="w-full h-full object-cover" alt="Luxury Home">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-900/40"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-white py-12 sm:py-24">
            <div class="max-w-3xl">
                <span class="inline-block px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-amber-600/20 border border-amber-500/30 text-amber-500 text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-4 sm:mb-6">Premium Real Estate & Building Solutions</span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 sm:mb-6">
                    Welcome to <span class="text-amber-500 whitespace-nowrap">Phantom 5</span>
                </h1>
                <p class="text-base sm:text-lg md:text-xl text-white/80 mb-6 sm:mb-10 leading-relaxed max-w-xl">
                    Quality homes, building solutions, and modern living. We connect you with the best properties, products, and services to create your dream space.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="{{ route('properties.index') }}" class="bg-amber-600 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold text-center text-sm sm:text-base hover:bg-amber-700 transition duration-300 shadow-xl">Browse Properties</a>
                    <a href="{{ route('products.index') }}" class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold text-center text-sm sm:text-base hover:bg-white/20 transition duration-300">Shop Products</a>
                </div>
            </div>
        </div>
    </section>

    @php
        $rotationSeconds = (int) ($featuredSettings['rotation_seconds'] ?? 5);
        $propertiesPerPage = (int) ($featuredSettings['properties_per_page'] ?? 6);
        $propertiesPerRow = (int) ($featuredSettings['properties_per_row'] ?? 3);
        $productsPerPage = (int) ($featuredSettings['products_per_page'] ?? 8);
        $productsPerRow = (int) ($featuredSettings['products_per_row'] ?? 4);
        $servicesPerPage = (int) ($featuredSettings['services_per_page'] ?? 6);
        $servicesPerRow = (int) ($featuredSettings['services_per_row'] ?? 3);

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
    @if($featuredProperties->count())
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

            <div x-data="featuredCarousel({{ $featuredProperties->count() }}, {{ $propertiesPerPage }}, {{ $rotationSeconds }})">
                <div class="grid featured-grid-properties gap-8">
                    @foreach($featuredProperties as $index => $property)
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
    @if($featuredProducts->count())
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

            <div x-data="featuredCarousel({{ $featuredProducts->count() }}, {{ $productsPerPage }}, {{ $rotationSeconds }})">
                <div class="grid featured-grid-products gap-6">
                    @foreach($featuredProducts as $index => $product)
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
    @if($featuredServices->count())
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

            <div x-data="featuredCarousel({{ $featuredServices->count() }}, {{ $servicesPerPage }}, {{ $rotationSeconds }})">
                <div class="grid featured-grid-services gap-8">
                    @foreach($featuredServices as $index => $service)
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
</x-app-layout>
