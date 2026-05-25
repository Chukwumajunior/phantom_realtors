<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Edit Product</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('merchant.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Product Information</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="5" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select id="category" name="category" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                    <option value="">Select Category</option>
                                    @foreach(\App\Enums\ProductCategory::cases() as $category)
                                        <option value="{{ $category->value }}" {{ old('category', $product->category->value) === $category->value ? 'selected' : '' }}>{{ $category->label() }}</option>
                                    @endforeach
                                </select>
                                @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                                <div class="flex gap-2">
                                    <select name="currency" class="rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 w-28">
                                        @foreach(\App\Enums\Currency::cases() as $curr)
                                            <option value="{{ $curr->value }}" {{ old('currency', $product->currency?->value ?? config('app.currency')) === $curr->value ? 'selected' : '' }}>{{ $curr->value }} ({{ $curr->symbol() }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                </div>
                                @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @error('currency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                                <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('stock_quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                                <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('brand') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                                <select id="condition" name="condition" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                    <option value="">Select Condition</option>
                                    <option value="new" {{ old('condition', $product->condition) === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ old('condition', $product->condition) === 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="refurbished" {{ old('condition', $product->condition) === 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                </select>
                                @error('condition') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Specifications & Images</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="specifications" class="block text-sm font-medium text-gray-700 mb-2">Specifications (key:value, one per line)</label>
                            <textarea id="specifications" name="specifications" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('specifications', $product->specifications ? collect($product->specifications)->map(fn($v, $k) => "$k:$v")->implode("\n") : '') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Format: Key:Value (one per line)</p>
                            @error('specifications') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Current Images -->
                        @if($product->images && count($product->images) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($product->images as $image)
                                <div class="relative">
                                    <img src="{{ Storage::url($image) }}" class="w-full h-24 object-cover rounded-lg" alt="Product image">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload New Images (replaces current)</label>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-700 file:font-medium hover:file:bg-amber-100">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to keep current images.</p>
                            @error('images') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            @error('images.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a wire:navigate href="{{ route('merchant.products.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
