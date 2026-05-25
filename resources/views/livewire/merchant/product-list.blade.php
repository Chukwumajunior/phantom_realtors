<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-slate-900">My Products</h2>
            <a wire:navigate href="{{ route('merchant.products.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg font-semibold text-sm hover:bg-amber-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($notification)
            <div x-data="{ show: true }" x-init="setTimeout(() => { show = false; $wire.set('notification', '') }, 4000)" x-show="show" x-transition
                class="{{ $notificationType === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800' }} border rounded-lg p-4 text-sm mb-4">
                {{ $notification }}
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Product</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Category</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Price</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Stock</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50" wire:key="product-{{ $product->id }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $product->images->first() ? $product->images->first()->url : 'https://via.placeholder.com/60x60' }}" class="w-12 h-12 rounded-lg object-cover" alt="{{ $product->name }}">
                                        <p class="font-medium text-slate-900">{{ Str::limit($product->name, 40) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-slate-100 text-slate-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $product->category->label() }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ format_price($product->price, $product->currency) }}</td>
                                <td class="px-6 py-4">
                                    @if($product->stock_quantity > 0)
                                        <span class="text-green-600 text-sm font-medium">{{ $product->stock_quantity }} in stock</span>
                                    @else
                                        <span class="text-red-600 text-sm font-medium">Out of stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a wire:navigate href="{{ route('merchant.products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                        <button wire:click="deleteProduct({{ $product->id }})" wire:confirm="Are you sure you want to delete this product?" class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <p class="mb-2">No products listed yet.</p>
                                    <a wire:navigate href="{{ route('merchant.products.create') }}" class="text-amber-600 font-medium hover:text-amber-700">Add your first product</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
