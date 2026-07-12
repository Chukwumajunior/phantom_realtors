<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Set Up Your Posting Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-posting-policy />

            <!-- Tier Selection & Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ selectedTier: '{{ old('tier', 'tier_1') }}' }">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Choose Your Tier</h3>

                <!-- Tier Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    @foreach($tiers as $tier)
                    <label class="cursor-pointer">
                        <input type="radio" name="tier_select" value="{{ $tier->value }}" x-model="selectedTier" class="sr-only peer">
                        <div class="border-2 rounded-xl p-4 transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-gray-300"
                            :class="selectedTier === '{{ $tier->value }}' ? 'border-amber-500 bg-amber-50' : 'border-gray-200'">
                            <div class="font-semibold text-slate-800">{{ $tier->label() }}</div>
                            <p class="text-xs text-gray-500 mt-1">{{ $tier->description() }}</p>
                            <div class="mt-2 text-xs font-medium {{ $tier->isFree() ? 'text-green-600' : 'text-amber-600' }}">
                                @if($tier->isFree())
                                    FREE
                                @else
                                    {{ format_price(\App\Models\SiteConfig::getTierPrice($tier->value)) }}
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Payment Info for Paid Tiers -->
                <div x-show="selectedTier !== 'tier_1'" x-transition class="mb-6">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                        <h4 class="text-sm font-bold text-amber-800 mb-2">Payment Required</h4>
                        <p class="text-sm text-amber-700 mb-3">Transfer the tier fee to the account below. Upload proof of payment with your application.</p>
                        <div class="bg-white rounded-lg p-4 border border-amber-100">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-500 block text-xs">Bank</span>
                                    <strong class="text-slate-900">{{ $bankDetails['bank_name'] }}</strong>
                                </div>
                                <div>
                                    <span class="text-gray-500 block text-xs">Account Name</span>
                                    <strong class="text-slate-900">{{ $bankDetails['account_name'] }}</strong>
                                </div>
                                <div>
                                    <span class="text-gray-500 block text-xs">Account Number</span>
                                    <strong class="text-slate-900">{{ $bankDetails['account_number'] }}</strong>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-amber-600 mt-3">Your profile will be activated once admin confirms your payment.</p>
                    </div>
                </div>

                <!-- Registration Form -->
                <form action="{{ route('merchant.setup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tier" :value="selectedTier">

                    <div class="space-y-6">
                        <!-- Basic Info (All Tiers) -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-slate-700 border-b pb-2">Personal Information</h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="business_name" id="business_name" value="{{ old('business_name') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500" required>
                                    @error('business_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500" required>
                                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="passport_photo" class="block text-sm font-medium text-gray-700 mb-1">
                                    Passport Photo <span class="text-red-500">*</span>
                                </label>
                                @if(auth()->user()->avatar)
                                    <p class="text-xs text-green-600 mb-1">You already have a photo on file. Upload a new one to replace it.</p>
                                @endif
                                <input type="file" name="passport_photo" id="passport_photo" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                                    {{ auth()->user()->avatar ? '' : 'required' }}>
                                @error('passport_photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Location (All Tiers) -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-slate-700 border-b pb-2">Business Location</h4>
                            <x-location-fields prefix="" />
                        </div>

                        <!-- Payment Proof (Paid Tiers) -->
                        <div x-show="selectedTier !== 'tier_1'" x-transition class="space-y-4">
                            <h4 class="font-medium text-slate-700 border-b pb-2">Payment Proof</h4>

                            <div>
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-1">Upload Proof of Payment <span class="text-red-500">*</span></label>
                                <p class="text-xs text-gray-500 mb-1">Screenshot or photo of your transfer receipt (max 5MB)</p>
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                @error('payment_proof') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="payment_reference" class="block text-sm font-medium text-gray-700 mb-1">Payment Reference (optional)</label>
                                <input type="text" name="payment_reference" id="payment_reference" value="{{ old('payment_reference') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="e.g. Transfer reference number">
                                @error('payment_reference') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Tier 3 Only Fields -->
                        <div x-show="selectedTier === 'tier_3'" x-transition class="space-y-4">
                            <h4 class="font-medium text-slate-700 border-b pb-2">Tier 3 Requirements</h4>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Registered Company Name <span class="text-red-500">*</span></label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="cac_document" class="block text-sm font-medium text-gray-700 mb-1">CAC Document <span class="text-red-500">*</span></label>
                                <p class="text-xs text-gray-500 mb-1">Upload your Corporate Affairs Commission registration document (PDF, JPG, PNG - max 5MB)</p>
                                <input type="file" name="cac_document" id="cac_document" accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                @error('cac_document') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <button type="submit" class="w-full px-6 py-3 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-700 transition shadow-sm">
                                <span x-text="selectedTier === 'tier_1' ? 'Create Posting Profile' : 'Submit Application'"></span>
                            </button>
                            <p x-show="selectedTier !== 'tier_1'" class="text-xs text-gray-500 text-center mt-2">Your profile will be activated after payment confirmation.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
