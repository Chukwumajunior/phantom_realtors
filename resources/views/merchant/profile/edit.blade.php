<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Posting Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-700">{{ session('info') }}</p>
            </div>
            @endif

            <!-- Current Tier Display -->
            @if(\App\Models\SiteConfig::isFreeMode())
            <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-5">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <h4 class="font-semibold text-green-800">Free Mode Active</h4>
                        <p class="text-sm text-green-700 mt-0.5">All tier restrictions are currently disabled. You can upload unlimited products, properties, and services for free.</p>
                    </div>
                </div>
            </div>
            @else
            <div class="mb-6 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-slate-800">Current Tier</h3>
                        <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-sm font-medium
                            @if($profile->tier === \App\Enums\PosterTier::Tier1) bg-gray-100 text-gray-800
                            @elseif($profile->tier === \App\Enums\PosterTier::Tier2) bg-blue-100 text-blue-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ $profile->tier->label() }}
                        </span>
                        <p class="text-sm text-gray-500 mt-1">{{ $profile->tier->description() }}</p>
                    </div>
                    @if($profile->isPending())
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Pending Approval
                        </span>
                    @endif
                </div>
            </div>
            @endif

            <form action="{{ route('merchant.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8"
                x-data="{ selectedTier: '{{ old('tier', $profile->tier->value) }}' }">
                @csrf
                @method('PATCH')

                <!-- Tier Upgrade Section -->
                @if(!(\App\Models\SiteConfig::isFreeMode()) && $profile->tier !== \App\Enums\PosterTier::Tier3 && $profile->isApproved())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Upgrade Tier</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach($tiers as $tier)
                        @php
                            $isLowerTier = array_search($tier->value, array_column(\App\Enums\PosterTier::cases(), 'value')) < array_search($profile->tier->value, array_column(\App\Enums\PosterTier::cases(), 'value'));
                        @endphp
                        <label class="cursor-pointer {{ $isLowerTier ? 'pointer-events-none' : '' }}">
                            <input type="radio" name="tier" value="{{ $tier->value }}" x-model="selectedTier" class="sr-only peer"
                                {{ $isLowerTier ? 'disabled' : '' }}>
                            <div class="h-full flex flex-col border-2 rounded-xl p-4 transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-gray-300
                                {{ $isLowerTier ? 'opacity-50' : '' }}"
                                :class="selectedTier === '{{ $tier->value }}' ? 'border-amber-500 bg-amber-50' : 'border-gray-200'">
                                <div class="font-semibold text-slate-800">{{ $tier->label() }}</div>
                                <p class="text-xs text-gray-500 mt-1 flex-1">{{ $tier->description() }}</p>
                                <div class="mt-3 text-xs font-medium {{ $tier->isFree() ? 'text-green-600' : 'text-amber-600' }}">
                                    @if($tier->isFree())
                                        FREE
                                    @else
                                        {{ format_price(\App\Models\SiteConfig::getTierPrice($tier->value)) }}
                                    @endif
                                </div>
                                @if($tier === $profile->tier)
                                    <div class="mt-1 text-xs font-medium text-amber-600">Current</div>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <!-- Payment info for upgrades -->
                    <div x-show="selectedTier !== '{{ $profile->tier->value }}' && selectedTier !== 'tier_1'" x-transition class="mt-6">
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                            <h4 class="text-sm font-bold text-amber-800 mb-2">Payment Required for Upgrade</h4>
                            <p class="text-sm text-amber-700 mb-3">Transfer the tier fee to the account below and upload proof of payment.</p>
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

                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-1">Proof of Payment <span class="text-red-500">*</span></label>
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
                        </div>
                    </div>
                </div>
                @else
                    <input type="hidden" name="tier" value="{{ $profile->tier->value }}">
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Business Information</h3>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-2">Business Name <span class="text-red-500">*</span></label>
                                <input type="text" id="business_name" name="business_name" value="{{ old('business_name', $profile->business_name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('business_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Passport Photo -->
                        <div>
                            <label for="passport_photo" class="block text-sm font-medium text-gray-700 mb-2">Passport Photo</label>
                            @if(auth()->user()->avatar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-20 h-20 rounded-lg object-cover" alt="Current Photo">
                                </div>
                            @endif
                            <input type="file" name="passport_photo" id="passport_photo" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            @error('passport_photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tier 3 Only Fields -->
                        <div x-show="!{{ \App\Models\SiteConfig::isFreeMode() ? 'true' : 'false' }} && selectedTier === 'tier_3'" x-transition class="space-y-4 border-t pt-4">
                            <h4 class="font-medium text-slate-700">Tier 3 Requirements</h4>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Registered Company Name <span class="text-red-500">*</span></label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $profile->company_name) }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="cac_document" class="block text-sm font-medium text-gray-700 mb-2">CAC Document</label>
                                @if($profile->cac_document)
                                    <p class="text-xs text-green-600 mb-1">CAC document already uploaded. Upload a new one to replace it.</p>
                                @endif
                                <input type="file" name="cac_document" id="cac_document" accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                @error('cac_document') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Business Location</h3>
                    <x-location-fields prefix="" :old="$profile" />
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
