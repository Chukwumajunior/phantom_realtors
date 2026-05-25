<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">{{ $product->name }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Full-width Image Gallery -->
            <div class="mb-8" x-data="{ activeImage: 0, total: {{ $product->images->count() ?: 1 }} }">
                @if($product->images->count() > 0)
                <div class="relative w-full rounded-2xl overflow-hidden bg-gray-100">
                    @foreach($product->images->take(4) as $index => $image)
                        <img x-show="activeImage === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ $image->url }}" class="w-full h-[300px] sm:h-[400px] lg:h-[500px] object-cover" alt="{{ $product->name }}">
                    @endforeach

                    @if($product->images->count() > 1)
                    <!-- Left/Right Navigation -->
                    <button @click="activeImage = (activeImage - 1 + total) % total" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="activeImage = (activeImage + 1) % total" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    <!-- Dots Indicator -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                        @foreach($product->images->take(4) as $index => $image)
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

                <!-- Product Info (Left) -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <span class="inline-block bg-slate-900 text-white text-xs font-medium px-3 py-1 rounded-full mb-3">{{ $product->category->label() }}</span>
                        <h1 class="text-3xl font-bold text-slate-900">{{ $product->name }}</h1>
                        <p class="text-3xl font-bold text-amber-600 mt-4">{{ format_price($product->price, $product->currency) }}</p>
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center gap-3">
                        @if($product->stock_quantity > 0)
                            <span class="inline-flex items-center gap-1 text-green-700 bg-green-50 px-3 py-1.5 rounded-lg text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                In Stock ({{ $product->stock_quantity }} available)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-red-700 bg-red-50 px-3 py-1.5 rounded-lg text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Order Button -->
                    @if($product->stock_quantity > 0)
                    <div x-data="{ quantity: 1 }" class="bg-gray-50 rounded-xl p-5 space-y-4">
                        <div class="flex items-center gap-4">
                            <label class="text-sm font-medium text-gray-700">Quantity:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button @click="quantity = Math.max(1, quantity - 1)" type="button" class="px-3 py-2 text-gray-600 hover:text-gray-800">-</button>
                                <span x-text="quantity" class="px-4 py-2 text-sm font-medium border-x border-gray-300"></span>
                                <button @click="quantity = Math.min({{ $product->stock_quantity }}, quantity + 1)" type="button" class="px-3 py-2 text-gray-600 hover:text-gray-800">+</button>
                            </div>
                        </div>

                        @auth
                            <form action="{{ route('customer.orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="merchant_id" value="{{ $product->user_id }}">
                                <input type="hidden" name="items[0][itemable_type]" value="product">
                                <input type="hidden" name="items[0][itemable_id]" value="{{ $product->id }}">
                                <input type="hidden" name="items[0][quantity]" :value="quantity">
                                <button type="submit" class="w-full px-6 py-3 bg-amber-600 text-white font-bold rounded-lg hover:bg-amber-700 transition flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                    Order Now
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="w-full px-6 py-3 bg-amber-600 text-white font-bold rounded-lg hover:bg-amber-700 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                Sign in to Order
                            </a>
                        @endauth
                    </div>
                    @endif

                    <!-- Brand & Condition -->
                    @if($product->brand || $product->condition)
                    <div class="grid grid-cols-2 gap-4">
                        @if($product->brand)
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <p class="text-sm text-gray-500">Brand</p>
                            <p class="font-semibold text-slate-900">{{ $product->brand }}</p>
                        </div>
                        @endif
                        @if($product->condition)
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <p class="text-sm text-gray-500">Condition</p>
                            <p class="font-semibold text-slate-900">{{ ucfirst($product->condition) }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Description -->
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-3">Description</h2>
                        <div class="text-gray-600 leading-relaxed prose prose-sm max-w-none">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <!-- Specifications -->
                    @if($product->specifications && count($product->specifications) > 0)
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-3">Specifications</h2>
                        <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                            @foreach($product->specifications as $key => $value)
                            <div class="flex justify-between py-2 border-b border-gray-200 last:border-0">
                                <span class="text-gray-600 text-sm">{{ $key }}</span>
                                <span class="font-medium text-slate-900 text-sm">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Merchant Info -->
                    @if($product->merchant)
                    <div class="bg-white border border-gray-200 rounded-2xl p-5">
                        <h3 class="text-lg font-bold text-slate-900 mb-3">Sold By</h3>
                        <div class="flex items-center gap-3">
                            @if($product->merchant->merchantProfile && $product->merchant->merchantProfile->logo)
                                <img src="{{ asset('storage/' . $product->merchant->merchantProfile->logo) }}" class="w-12 h-12 rounded-full object-cover" alt="Merchant">
                            @else
                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <span class="text-amber-600 font-bold text-lg">{{ substr($product->merchant->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $product->merchant->merchantProfile->business_name ?? $product->merchant->name }}</p>
                                <p class="text-sm text-gray-500">Verified Merchant</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar (Right) -->
                <div class="space-y-6">
                    <!-- Related Products -->
                    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Related Products</h3>
                        <div class="space-y-4">
                            @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related) }}" class="group flex gap-3 hover:bg-gray-50 rounded-lg p-2 -mx-2 transition">
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    <img src="{{ $related->images->first() ? $related->images->first()->url : 'https://via.placeholder.com/200x200' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $related->name }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-slate-900 group-hover:text-amber-600 transition truncate">{{ $related->name }}</h4>
                                    <p class="text-amber-600 font-bold text-sm mt-1">{{ format_price($related->price, $related->currency) }}</p>
                                    @if($related->stock_quantity > 0)
                                        <span class="text-xs text-emerald-600">{{ $related->stock_quantity }} left</span>
                                    @else
                                        <span class="text-xs text-red-500">Sold out</span>
                                    @endif
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
