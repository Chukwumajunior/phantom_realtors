@props(['prefix' => 'location_', 'old' => null])

<div class="space-y-4">
    <h3 class="text-lg font-semibold text-slate-800">Location</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- House Number -->
        <div>
            <label for="{{ $prefix }}house_number" class="block text-sm font-medium text-gray-700 mb-1">House Number <span class="text-red-500">*</span></label>
            <input type="text" name="{{ $prefix }}house_number" id="{{ $prefix }}house_number"
                value="{{ old($prefix.'house_number', $old?->{$prefix.'house_number'} ?? '') }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                placeholder="e.g. 12" required>
            @error($prefix.'house_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Street Name -->
        <div>
            <label for="{{ $prefix }}street_name" class="block text-sm font-medium text-gray-700 mb-1">Street Name <span class="text-red-500">*</span></label>
            <input type="text" name="{{ $prefix }}street_name" id="{{ $prefix }}street_name"
                value="{{ old($prefix.'street_name', $old?->{$prefix.'street_name'} ?? '') }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                placeholder="e.g. Akinola Street" required>
            @error($prefix.'street_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Area -->
        <div>
            <label for="{{ $prefix }}area" class="block text-sm font-medium text-gray-700 mb-1">Area <span class="text-red-500">*</span></label>
            <input type="text" name="{{ $prefix }}area" id="{{ $prefix }}area"
                value="{{ old($prefix.'area', $old?->{$prefix.'area'} ?? '') }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                placeholder="e.g. Bariga" required>
            @error($prefix.'area') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- LGA -->
        <div>
            <label for="{{ $prefix }}lga" class="block text-sm font-medium text-gray-700 mb-1">Local Government Area <span class="text-red-500">*</span></label>
            <input type="text" name="{{ $prefix }}lga" id="{{ $prefix }}lga"
                value="{{ old($prefix.'lga', $old?->{$prefix.'lga'} ?? '') }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                placeholder="e.g. Somolu" required>
            @error($prefix.'lga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- State -->
        <div>
            <label for="{{ $prefix }}state" class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
            <input type="text" name="{{ $prefix }}state" id="{{ $prefix }}state"
                value="{{ old($prefix.'state', $old?->{$prefix.'state'} ?? '') }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                placeholder="e.g. Lagos" required>
            @error($prefix.'state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Zip Code -->
        <div>
            <label for="{{ $prefix }}zip_code" class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
            <input type="text" name="{{ $prefix }}zip_code" id="{{ $prefix }}zip_code"
                value="{{ old($prefix.'zip_code', $old?->{$prefix.'zip_code'} ?? '') }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                placeholder="e.g. 100001">
            @error($prefix.'zip_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Country -->
        <div>
            <label for="{{ $prefix }}country" class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
            <input type="text" name="{{ $prefix }}country" id="{{ $prefix }}country"
                value="{{ old($prefix.'country', $old?->{$prefix.'country'} ?? 'Nigeria') }}"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                placeholder="e.g. Nigeria" required>
            @error($prefix.'country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
