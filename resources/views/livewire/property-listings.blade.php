<div>
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search properties..." class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
            </div>
            <div>
                <select wire:model.live="type" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                    <option value="">All Types</option>
                    @foreach($types as $t)
                        <option value="{{ $t->value }}">{{ $t->label() }}</option>
                    @endforeach
                </select>
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
                    <option value="oldest">Oldest</option>
                </select>
            </div>
        </div>

        <!-- Location, Price & Clear -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mt-4">
            <select wire:model.live="country" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                <option value="">All Countries</option>
                @foreach($countries as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
            <select wire:model.live="state" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500" {{ !$country ? 'disabled' : '' }}>
                <option value="">All States</option>
                @foreach($states as $s)
                    <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
            </select>
            <select wire:model.live="city" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500" {{ !$state ? 'disabled' : '' }}>
                <option value="">All Cities</option>
                @foreach($cities as $ci)
                    <option value="{{ $ci }}">{{ $ci }}</option>
                @endforeach
            </select>
            <input wire:model.live.debounce.500ms="minPrice" type="number" placeholder="Min Price" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
            <input wire:model.live.debounce.500ms="maxPrice" type="number" placeholder="Max Price" class="w-full border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
            <button wire:click="clearFilters" class="w-full px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Clear Filters
            </button>
        </div>
    </div>

    <!-- Results -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($properties as $property)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition group">
                <a href="{{ route('properties.show', $property) }}">
                    <div class="relative h-52 overflow-hidden" x-data="{ current: 0, total: {{ $property->images->count() ?: 1 }} }" x-init="setInterval(() => { current = (current + 1) % total }, 3000)">
                        @if($property->images->count() > 0)
                            @foreach($property->images->take(4) as $index => $image)
                                <img x-show="current === {{ $index }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ $image->url }}" alt="{{ $property->title }}" class="absolute inset-0 w-full h-full object-cover">
                            @endforeach
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 px-3 py-1 text-xs font-bold rounded-full bg-amber-500 text-white z-10">
                            {{ $property->type->label() }}
                        </span>
                        @if($property->is_featured)
                            <span class="absolute top-3 right-3 px-2 py-1 text-xs font-bold rounded-full bg-emerald-500 text-white z-10">Featured</span>
                        @endif
                    </div>
                </a>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 truncate">{{ $property->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $property->city }}, {{ $property->state }}</p>
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                        @if($property->bedrooms)
                            <span>{{ $property->bedrooms }} Beds</span>
                        @endif
                        @if($property->bathrooms)
                            <span>{{ $property->bathrooms }} Baths</span>
                        @endif
                        @if($property->area_sqft)
                            <span>{{ number_format($property->area_sqft) }} sqft</span>
                        @endif
                    </div>
                    <p class="text-lg font-bold text-amber-600 mt-3">{{ $property->formatted_price }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No properties found matching your criteria.</p>
                <button wire:click="clearFilters" class="mt-4 text-amber-600 hover:text-amber-700 font-medium">Clear all filters</button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $properties->links() }}
    </div>
</div>
