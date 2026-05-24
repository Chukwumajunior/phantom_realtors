<x-app-layout>
    <!-- Hero Section -->
    <section class="relative min-h-[80vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070" class="w-full h-full object-cover" alt="Luxury Home">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-900/40"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-white py-24">
            <div class="max-w-3xl">
                <span class="inline-block px-4 py-2 rounded-full bg-amber-600/20 border border-amber-500/30 text-amber-500 text-xs font-bold uppercase tracking-widest mb-6">Premium Real Estate & Building Solutions</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Welcome to <span class="text-amber-500">Phantom Realtors</span>
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-10 leading-relaxed max-w-xl">
                    Quality homes, building solutions, and modern living. We connect you with the best properties, products, and services to create your dream space.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('properties.index') }}" class="bg-amber-600 text-white px-8 py-4 rounded-lg font-bold text-center hover:bg-amber-700 transition duration-300 shadow-xl">Browse Properties</a>
                    <a href="{{ route('products.index') }}" class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-8 py-4 rounded-lg font-bold text-center hover:bg-white/20 transition duration-300">Shop Products</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Properties -->
    @if($featuredProperties->count())
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Featured Properties</h2>
                    <p class="text-gray-500 mt-2">Discover our hand-picked properties</p>
                </div>
                <a href="{{ route('properties.index') }}" class="hidden sm:inline-flex items-center text-amber-600 font-semibold hover:text-amber-700 transition">
                    View All
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProperties as $property)
                <a href="{{ route('properties.show', $property) }}" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $property->images->first() ? $property->images->first()->url : 'https://via.placeholder.com/400x300' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $property->title }}">
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
        </div>
    </section>
    @endif

    <!-- Featured Products -->
    @if($featuredProducts->count())
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Featured Products</h2>
                    <p class="text-gray-500 mt-2">Quality building and home products</p>
                </div>
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center text-amber-600 font-semibold hover:text-amber-700 transition">
                    View All
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $product->images->first() ? $product->images->first()->url : 'https://via.placeholder.com/300x200' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $product->name }}">
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
        </div>
    </section>
    @endif

    <!-- Featured Services -->
    @if($featuredServices->count())
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Featured Services</h2>
                    <p class="text-gray-500 mt-2">Professional services for your home</p>
                </div>
                <a href="{{ route('services.index') }}" class="hidden sm:inline-flex items-center text-amber-600 font-semibold hover:text-amber-700 transition">
                    View All
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredServices as $service)
                <a href="{{ route('services.show', $service) }}" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $service->images->first() ? $service->images->first()->url : 'https://via.placeholder.com/400x250' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $service->name }}">
                        <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $service->category->label() }}</span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-slate-900 group-hover:text-amber-600 transition">{{ $service->name }}</h3>
                        <p class="text-amber-600 font-semibold mt-2">
                            {{ format_price($service->price_from, $service->currency, 0) }} - {{ format_price($service->price_to, $service->currency, 0) }}
                        </p>
                        @if($service->is_negotiable)
                            <span class="inline-block mt-2 text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded">Negotiable</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-app-layout>
