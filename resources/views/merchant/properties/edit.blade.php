<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Edit Property</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('merchant.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Basic Information</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $property->title) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="5" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $property->description) }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                                <div class="flex gap-2">
                                    <select name="currency" class="rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 w-28">
                                        @foreach(\App\Enums\Currency::cases() as $curr)
                                            <option value="{{ $curr->value }}" {{ old('currency', $property->currency?->value ?? config('app.currency')) === $curr->value ? 'selected' : '' }}>{{ $curr->value }} ({{ $curr->symbol() }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" id="price" name="price" value="{{ old('price', $property->price) }}" step="0.01" required class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                </div>
                                @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @error('currency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                                <select id="type" name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                    <option value="">Select Type</option>
                                    @foreach(\App\Enums\PropertyType::cases() as $type)
                                        <option value="{{ $type->value }}" {{ old('type', $property->type->value) === $type->value ? 'selected' : '' }}>{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                                @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="category" name="category" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                <option value="">Select Category</option>
                                @foreach(\App\Enums\PropertyCategory::cases() as $category)
                                    <option value="{{ $category->value }}" {{ old('category', $property->category->value) === $category->value ? 'selected' : '' }}>{{ $category->label() }}</option>
                                @endforeach
                            </select>
                            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Location</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $property->address) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                <input type="text" id="country" name="country" value="{{ old('country', $property->country ?? 'Nigeria') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('country') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                <input type="text" id="state" name="state" value="{{ old('state', $property->state) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('state') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $property->city) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="lga" class="block text-sm font-medium text-gray-700 mb-2">LGA</label>
                                <input type="text" id="lga" name="lga" value="{{ old('lga', $property->lga) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('lga') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Property Details</h3>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                            <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('bedrooms') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                            <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('bathrooms') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="toilets" class="block text-sm font-medium text-gray-700 mb-2">Toilets</label>
                            <input type="number" id="toilets" name="toilets" value="{{ old('toilets', $property->toilets) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('toilets') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="area_sqft" class="block text-sm font-medium text-gray-700 mb-2">Area (sqft)</label>
                            <input type="number" id="area_sqft" name="area_sqft" value="{{ old('area_sqft', $property->area_sqft) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('area_sqft') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Features & Images</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="features" class="block text-sm font-medium text-gray-700 mb-2">Features (one per line)</label>
                            <textarea id="features" name="features" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('features', $property->features ? implode("\n", $property->features) : '') }}</textarea>
                            @error('features') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Current Images -->
                        @if($property->images && count($property->images) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($property->images as $image)
                                <div class="relative">
                                    <img src="{{ Storage::url($image) }}" class="w-full h-24 object-cover rounded-lg" alt="Property image">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload New Images (replaces current)</label>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-700 file:font-medium hover:file:bg-amber-100">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to keep current images. Upload new ones to replace.</p>
                            @error('images') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            @error('images.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a wire:navigate href="{{ route('merchant.properties.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition">Update Property</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
