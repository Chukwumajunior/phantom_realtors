<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Become a Seller</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-slate-900">Start Selling on Phantom 5 Realtors</h3>
                    <p class="text-sm text-gray-500 mt-1">List your properties, products, or services and reach thousands of buyers.</p>
                </div>

                <form action="{{ route('become-seller.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="business_name" :value="__('Business Name')" />
                        <x-text-input id="business_name" class="block mt-1 w-full" type="text" name="business_name" :value="old('business_name')" required />
                        <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="business_phone" :value="__('Business Phone')" />
                        <x-text-input id="business_phone" class="block mt-1 w-full" type="tel" name="business_phone" :value="old('business_phone', auth()->user()->phone)" />
                        <x-input-error :messages="$errors->get('business_phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="business_address" :value="__('Business Address')" />
                        <x-text-input id="business_address" class="block mt-1 w-full" type="text" name="business_address" :value="old('business_address')" />
                        <x-input-error :messages="$errors->get('business_address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="business_description" :value="__('Tell us about your business')" />
                        <textarea id="business_description" name="business_description" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('business_description') }}</textarea>
                        <x-input-error :messages="$errors->get('business_description')" class="mt-2" />
                    </div>

                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-sm text-amber-800">After submitting, your application will be reviewed by our admin team. You'll be notified once approved.</p>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Submit Application</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
