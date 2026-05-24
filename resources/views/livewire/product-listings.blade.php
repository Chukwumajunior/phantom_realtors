<div>
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search products..." class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
            </div>
            <div>
                <select wire:model.live="category" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->value }}">{{ $cat->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="sortBy" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                    <option value="latest">Latest</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                </select>
            </div>
            <div>
                <button wire:click="clearFilters" class="w-full px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Clear Filters</button>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition group">
                <a href="{{ route('products.show', $product) }}">
                    <div class="relative h-48 overflow-hidden" x-data="{ current: 0, total: {{ $product->images->count() ?: 1 }} }" x-init="setInterval(() => { current = (current + 1) % total }, 3000)">
                        @if($product->images->count() > 0)
                            @foreach($product->images->take(4) as $index => $image)
                                <img x-show="current === {{ $index }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ $image->url }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                            @endforeach
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 px-2 py-1 text-xs font-medium rounded-full bg-slate-800 text-white z-10">
                            {{ $product->category->label() }}
                        </span>
                    </div>
                </a>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $product->name }}</h3>
                    @if($product->brand)
                        <p class="text-xs text-gray-500 mt-1">{{ $product->brand }}</p>
                    @endif
                    <div class="flex items-center justify-between mt-3">
                        <p class="text-lg font-bold text-amber-600">{{ $product->formatted_price }}</p>
                        @if($product->isInStock())
                            <span class="text-xs text-emerald-600 font-medium">{{ $product->stock_quantity }} left</span>
                        @else
                            <span class="text-xs text-red-500 font-medium">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No products found.</p>
                <button wire:click="clearFilters" class="mt-4 text-amber-600 hover:text-amber-700 font-medium">Clear all filters</button>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
