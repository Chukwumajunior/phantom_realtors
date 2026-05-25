<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Add New Service</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('merchant.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Service Information</h3>

                    <div class="space-y-6" x-data="{
                        hierarchy: @js(\App\Enums\ServiceGroup::hierarchy()),
                        selectedGroup: '',
                        selectedCategory: '{{ old('category', '') }}',
                        description: '{{ old('description', '') }}',
                        descriptionModified: {{ old('description') ? 'true' : 'false' }},
                        get filteredCategories() {
                            if (!this.selectedGroup) return [];
                            const found = this.hierarchy.find(g => g.value === this.selectedGroup);
                            return found ? found.categories : [];
                        },
                        getDefaultDescription(value) {
                            for (const g of this.hierarchy) {
                                const cat = g.categories.find(c => c.value === value);
                                if (cat) return cat.description;
                            }
                            return '';
                        },
                        init() {
                            if (this.selectedCategory) {
                                for (const g of this.hierarchy) {
                                    if (g.categories.some(c => c.value === this.selectedCategory)) {
                                        this.selectedGroup = g.value;
                                        break;
                                    }
                                }
                            }
                            this.$watch('selectedCategory', (value) => {
                                if (value) {
                                    this.description = this.getDefaultDescription(value);
                                    this.descriptionModified = false;
                                }
                            });
                        }
                    }">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Service Group</label>
                                <select x-model="selectedGroup" @change="selectedCategory = ''" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                    <option value="">Select Group</option>
                                    <template x-for="g in hierarchy" :key="g.value">
                                        <option :value="g.value" x-text="g.label"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Service Name</label>
                                <select x-model="selectedCategory" name="category" required :disabled="!selectedGroup" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 disabled:opacity-50 disabled:bg-gray-50">
                                    <option value="">Select Service</option>
                                    <template x-for="c in filteredCategories" :key="c.value">
                                        <option :value="c.value" x-text="c.label"></option>
                                    </template>
                                </select>
                                @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="5" required x-model="description" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">A default description is provided when you select a service name. You can modify it.</p>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                <select name="currency" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                    @foreach(\App\Enums\Currency::cases() as $curr)
                                        <option value="{{ $curr->value }}" {{ old('currency', config('app.currency')) === $curr->value ? 'selected' : '' }}>{{ $curr->value }} ({{ $curr->symbol() }})</option>
                                    @endforeach
                                </select>
                                @error('currency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="price_from" class="block text-sm font-medium text-gray-700 mb-2">Price From</label>
                                <input type="number" id="price_from" name="price_from" value="{{ old('price_from') }}" step="0.01" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('price_from') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="price_to" class="block text-sm font-medium text-gray-700 mb-2">Price To</label>
                                <input type="number" id="price_to" name="price_to" value="{{ old('price_to') }}" step="0.01" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('price_to') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="is_negotiable" name="is_negotiable" value="1" {{ old('is_negotiable') ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                            <label for="is_negotiable" class="text-sm font-medium text-gray-700">Price is negotiable</label>
                        </div>

                        <div>
                            <label for="service_area" class="block text-sm font-medium text-gray-700 mb-2">Service Area</label>
                            <input type="text" id="service_area" name="service_area" value="{{ old('service_area') }}" placeholder="e.g., Lagos, Abuja, Nationwide" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('service_area') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Highlights & Images</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="highlights" class="block text-sm font-medium text-gray-700 mb-2">Service Highlights (one per line)</label>
                            <textarea id="highlights" name="highlights" rows="4" placeholder="Fast turnaround time&#10;Experienced team&#10;Quality materials used" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('highlights') }}</textarea>
                            @error('highlights') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Service Images</label>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-700 file:font-medium hover:file:bg-amber-100">
                            <p class="mt-1 text-sm text-gray-500">Upload images showcasing your work. Max 5MB each.</p>
                            @error('images') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            @error('images.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a wire:navigate href="{{ route('merchant.services.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition">Create Service</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
