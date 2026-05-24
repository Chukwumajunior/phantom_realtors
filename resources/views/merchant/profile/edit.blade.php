<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Business Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('merchant.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Business Information</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="business_name" class="block text-sm font-medium text-gray-700 mb-2">Business Name</label>
                            <input type="text" id="business_name" name="business_name" value="{{ old('business_name', $profile->business_name ?? '') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('business_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="business_description" class="block text-sm font-medium text-gray-700 mb-2">Business Description</label>
                            <textarea id="business_description" name="business_description" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('business_description', $profile->business_description ?? '') }}</textarea>
                            @error('business_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="business_address" class="block text-sm font-medium text-gray-700 mb-2">Business Address</label>
                            <input type="text" id="business_address" name="business_address" value="{{ old('business_address', $profile->business_address ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('business_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="business_phone" class="block text-sm font-medium text-gray-700 mb-2">Business Phone</label>
                                <input type="tel" id="business_phone" name="business_phone" value="{{ old('business_phone', $profile->business_phone ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('business_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="business_email" class="block text-sm font-medium text-gray-700 mb-2">Business Email</label>
                                <input type="email" id="business_email" name="business_email" value="{{ old('business_email', $profile->business_email ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('business_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Current Logo -->
                        @if(isset($profile) && $profile->logo)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Logo</label>
                            <img src="{{ Storage::url($profile->logo) }}" class="w-24 h-24 rounded-lg object-cover" alt="Business Logo">
                        </div>
                        @endif

                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Business Logo</label>
                            <input type="file" id="logo" name="logo" accept="image/*" class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-700 file:font-medium hover:file:bg-amber-100">
                            <p class="mt-1 text-sm text-gray-500">Upload a square image for best results. Max 2MB.</p>
                            @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
