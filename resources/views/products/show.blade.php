<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">{{ $product->name }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Full-width Image Gallery -->
            <div class="mb-8" x-data="{ activeImage: 0, total: {{ $product->images->count() ?: 1 }} }">
                @if($product->images->count() > 0)
                <div class="relative w-full h-[300px] sm:h-[400px] lg:h-[500px] rounded-2xl overflow-hidden bg-gray-100">
                    @foreach($product->images->take(4) as $index => $image)
                        <img x-show="activeImage === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ $image->url }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $product->name }}">
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
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $product->name }}</h1>
                        <p class="text-2xl sm:text-3xl font-bold text-amber-600 mt-4">{{ format_price($product->price, $product->currency) }}</p>
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

                    <!-- Action Buttons -->
                    @if($product->merchant?->isAdmin() && $product->stock_quantity > 0)
                        {{-- Admin-owned product: Order flow --}}
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
                        <div class="flex items-center gap-3 mb-4">
                            @if($product->merchant->isAdmin())
                                <img src="{{ asset('img/logo.png') }}" class="w-12 h-12 rounded-full object-cover" alt="Phantom 5">
                            @elseif($product->merchant->avatar)
                                <img src="{{ str_starts_with($product->merchant->avatar, 'http') ? $product->merchant->avatar : asset('storage/' . $product->merchant->avatar) }}" class="w-12 h-12 rounded-full object-cover" alt="{{ $product->merchant->name }}">
                            @else
                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <span class="text-amber-600 font-bold text-lg">{{ substr($product->merchant->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $product->merchant->isAdmin() ? 'Phantom 5 Merchant' : ($product->merchant->merchantProfile->business_name ?? $product->merchant->name) }}</p>
                                <p class="text-sm text-gray-500">{{ $product->merchant->isAdmin() ? 'Official Store' : 'Verified Merchant' }}</p>
                            </div>
                        </div>
                        @php $productPhone = $product->merchant->merchantProfile->business_phone ?? $product->merchant->phone ?? null; @endphp
                        @if($productPhone)
                        <a href="tel:{{ $productPhone }}" class="flex items-center justify-center gap-2 w-full bg-slate-800 text-white py-3 rounded-lg font-semibold hover:bg-slate-900 transition mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Call Merchant
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $productPhone) }}?text={{ urlencode('Hi, I am interested in your product: ' . $product->name) }}" target="_blank" class="flex items-center justify-center gap-2 w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition mb-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Chat on WhatsApp
                        </a>
                        @endif
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
