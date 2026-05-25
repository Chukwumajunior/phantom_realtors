<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Edit Subscription Plan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.subscription-plans.update', $subscriptionPlan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $subscriptionPlan->name) }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $subscriptionPlan->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (NGN)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $subscriptionPlan->price) }}" required min="0" step="0.01"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-1">Duration (days)</label>
                                <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $subscriptionPlan->duration_days) }}" required min="1"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('duration_days') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500">
                            <label for="is_active" class="text-sm text-gray-700">Active (visible to merchants)</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a wire:navigate href="{{ route('admin.subscription-plans.index') }}" class="px-4 py-2 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-100 transition">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">Update Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
