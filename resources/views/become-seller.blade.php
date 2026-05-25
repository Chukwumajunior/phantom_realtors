<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Become a Seller</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    @if(isset($profile) && $profile && $profile->status->value === 'rejected')
                        <h3 class="text-lg font-bold text-slate-900">Resubmit Your Application</h3>
                        <p class="text-sm text-gray-500 mt-1">Please correct the issues mentioned below and resubmit.</p>
                        <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-sm font-medium text-red-800">Previous rejection reason:</p>
                            <p class="text-sm text-red-700 mt-1">{{ $profile->rejection_reason }}</p>
                        </div>
                    @else
                        <h3 class="text-lg font-bold text-slate-900">Start Selling on Phantom 5</h3>
                        <p class="text-sm text-gray-500 mt-1">List your properties, products, or services and reach thousands of buyers.</p>
                    @endif
                </div>

                <form action="{{ route('become-seller.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf

                    @php $isResubmission = isset($profile) && $profile && $profile->status->value === 'rejected'; @endphp

                    <div>
                        <x-input-label for="business_name" :value="__('Business Name')" />
                        <x-text-input id="business_name" class="block mt-1 w-full" type="text" name="business_name" :value="old('business_name', $profile->business_name ?? '')" required />
                        <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="business_phone" :value="__('Business Phone')" />
                        <x-text-input id="business_phone" class="block mt-1 w-full" type="tel" name="business_phone" :value="old('business_phone', $profile->business_phone ?? auth()->user()->phone)" />
                        <x-input-error :messages="$errors->get('business_phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="business_address" :value="__('Business Address')" />
                        <x-text-input id="business_address" class="block mt-1 w-full" type="text" name="business_address" :value="old('business_address', $profile->business_address ?? '')" />
                        <x-input-error :messages="$errors->get('business_address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="business_description" :value="__('Tell us about your business')" />
                        <textarea id="business_description" name="business_description" rows="4" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">{{ old('business_description', $profile->business_description ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('business_description')" class="mt-2" />
                    </div>

                    {{-- Passport Photo --}}
                    <div>
                        <x-input-label for="passport_photo" :value="__('Passport Photograph')" />
                        <p class="text-xs text-gray-500 mb-2">A clear passport-style photo is required for identity verification.</p>
                        <div class="flex items-start gap-4">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Current photo" class="w-16 h-16 rounded-xl object-cover border border-gray-200 shadow-sm shrink-0">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center border border-gray-200 shrink-0">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="passport_photo" id="passport_photo" accept="image/*" {{ auth()->user()->avatar ? '' : 'required' }}
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 file:cursor-pointer cursor-pointer">
                                @if(auth()->user()->avatar)
                                    <p class="text-xs text-gray-500 mt-1">You already have a photo on file. Upload a new one only if you want to replace it.</p>
                                @else
                                    <p class="text-xs text-gray-500 mt-1">Upload a clear photo of yourself (max 2MB).</p>
                                @endif
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('passport_photo')" class="mt-2" />
                    </div>

                    @if(!$isResubmission)
                    <!-- Subscription Plan Selection (only for first-time applications) -->
                    <div class="border-t border-gray-100 pt-5">
                        <h4 class="text-base font-bold text-slate-900 mb-3">Choose a Subscription Plan</h4>
                        <p class="text-sm text-gray-500 mb-4">Select a plan and upload your proof of payment to complete your application.</p>

                        @if($plans->count())
                            <div class="space-y-3">
                                @foreach($plans as $plan)
                                    <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-300 transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                        <input type="radio" name="subscription_plan_id" value="{{ $plan->id }}" {{ old('subscription_plan_id') == $plan->id ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500" required>
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-900">{{ $plan->name }}</p>
                                            @if($plan->description)
                                                <p class="text-sm text-gray-500">{{ $plan->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-amber-600">{{ $plan->formatted_price }}</p>
                                            <p class="text-xs text-gray-500">{{ $plan->duration_days }} days</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('subscription_plan_id') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                        @else
                            <p class="text-gray-500 text-sm">No subscription plans available at the moment. Please try again later.</p>
                        @endif
                    </div>

                    <!-- Payment Proof -->
                    <div class="border-t border-gray-100 pt-5">
                        <h4 class="text-base font-bold text-slate-900 mb-3">Payment Details</h4>

                        @php $bankDetails = \App\Models\SiteConfig::getBankDetails(); @endphp
                        @if($bankDetails['bank_name'] && $bankDetails['account_number'])
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                            <p class="text-sm font-medium text-amber-900 mb-1">Bank Transfer Details:</p>
                            <p class="text-sm text-amber-800">Make payment to the account below and upload proof of payment.</p>
                            <div class="mt-2 text-sm text-amber-800">
                                <p><span class="font-medium">Bank:</span> {{ $bankDetails['bank_name'] }}</p>
                                <p><span class="font-medium">Account Name:</span> {{ $bankDetails['account_name'] }}</p>
                                <p><span class="font-medium">Account Number:</span> {{ $bankDetails['account_number'] }}</p>
                            </div>
                        </div>
                        @endif

                        <div>
                            <x-input-label for="payment_proof" :value="__('Upload Proof of Payment')" />
                            <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required
                                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            <p class="text-xs text-gray-500 mt-1">Upload a screenshot or photo of your payment receipt (max 5MB)</p>
                            <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="payment_reference" :value="__('Payment Reference / Transaction ID (optional)')" />
                            <x-text-input id="payment_reference" class="block mt-1 w-full" type="text" name="payment_reference" :value="old('payment_reference')" placeholder="e.g. TRF/2026/05/12345" />
                            <x-input-error :messages="$errors->get('payment_reference')" class="mt-2" />
                        </div>
                    </div>
                    @else
                    <!-- Resubmission notice -->
                    <div class="border-t border-gray-100 pt-5">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-sm text-green-800">Your previous payment has been recorded. You only need to correct the information above and resubmit.</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-end pt-4">
                        <x-primary-button>Submit Application</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
