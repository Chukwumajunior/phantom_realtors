<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Site Settings</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Notification --}}
            @if($notification)
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                <div class="flex items-center gap-3 p-4 rounded-xl border {{ $notificationType === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' }}">
                    @if($notificationType === 'success')
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                    <p class="text-sm font-medium">{{ $notification }}</p>
                    <button @click="show = false" class="ml-auto {{ $notificationType === 'success' ? 'text-green-500 hover:text-green-700' : 'text-red-500 hover:text-red-700' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            @endif

            {{-- Bank Account Details --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Bank Account Details</h3>
                            <p class="text-sm text-gray-500">Payment account shown to users during tier upgrades.</p>
                        </div>
                    </div>
                </div>
                <form wire:submit="saveBankDetails" class="p-6 sm:p-8 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="bank_name" :value="__('Bank Name')" />
                            <x-text-input id="bank_name" class="block mt-1.5 w-full" type="text" wire:model="bank_name" required placeholder="e.g. OPay" />
                            @error('bank_name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="account_name" :value="__('Account Name')" />
                            <x-text-input id="account_name" class="block mt-1.5 w-full" type="text" wire:model="account_name" required placeholder="e.g. PHANTOM 5 REALTORS CONCEPTS" />
                            @error('account_name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <x-input-label for="account_number" :value="__('Account Number')" />
                        <x-text-input id="account_number" class="block mt-1.5 w-full sm:max-w-xs" type="text" wire:model="account_number" required placeholder="e.g. 6142210881" />
                        @error('account_number') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-5 py-2.5 bg-amber-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition disabled:opacity-50">
                            <span wire:loading.remove wire:target="saveBankDetails">Save Bank Details</span>
                            <span wire:loading wire:target="saveBankDetails" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tier Configuration --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Tier Configuration</h3>
                            <p class="text-sm text-gray-500">Set pricing and capabilities for each poster tier.</p>
                        </div>
                    </div>
                </div>
                <form wire:submit="saveTierSettings" class="p-6 sm:p-8 space-y-6">
                    {{-- Tier Pricing --}}
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-4">Tier Pricing</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-1">Tier 1</p>
                                <p class="text-2xl font-bold text-green-600">FREE</p>
                            </div>
                            <div>
                                <x-input-label :value="__('Tier 2 Price (NGN)')" />
                                <x-text-input class="block mt-1.5 w-full" type="number" wire:model="tier2Price" min="0" step="100" required />
                                @error('tier2Price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('Tier 3 Price (NGN)')" />
                                <x-text-input class="block mt-1.5 w-full" type="number" wire:model="tier3Price" min="0" step="100" required />
                                @error('tier3Price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tier 1 Configuration --}}
                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-700">1</span>
                            <h4 class="text-sm font-bold text-slate-900">Tier 1 - Free</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <x-input-label :value="__('Display Name')" />
                                <x-text-input class="block mt-1.5 w-full" type="text" wire:model="tier1Name" required />
                                @error('tier1Name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('Max Posts')" />
                                <x-text-input class="block mt-1.5 w-full" type="number" wire:model="tier1Posts" min="1" max="100" required />
                                @error('tier1Posts') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('Max Categories')" />
                                <x-text-input class="block mt-1.5 w-full" type="number" wire:model="tier1Categories" min="1" max="100" required />
                                @error('tier1Categories') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2 lg:col-span-1">
                                <x-input-label :value="__('Description')" />
                                <x-text-input class="block mt-1.5 w-full" type="text" wire:model="tier1Description" required />
                                @error('tier1Description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tier 2 Configuration --}}
                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-700">2</span>
                            <h4 class="text-sm font-bold text-slate-900">Tier 2 - Paid</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <x-input-label :value="__('Display Name')" />
                                <x-text-input class="block mt-1.5 w-full" type="text" wire:model="tier2Name" required />
                                @error('tier2Name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('Max Posts')" />
                                <x-text-input class="block mt-1.5 w-full" type="number" wire:model="tier2Posts" min="1" max="100" required />
                                @error('tier2Posts') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('Max Categories')" />
                                <x-text-input class="block mt-1.5 w-full" type="number" wire:model="tier2Categories" min="1" max="100" required />
                                @error('tier2Categories') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2 lg:col-span-1">
                                <x-input-label :value="__('Description')" />
                                <x-text-input class="block mt-1.5 w-full" type="text" wire:model="tier2Description" required />
                                @error('tier2Description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tier 3 Configuration --}}
                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-6 h-6 rounded-full bg-purple-100 flex items-center justify-center text-xs font-bold text-purple-700">3</span>
                            <h4 class="text-sm font-bold text-slate-900">Tier 3 - Paid (Unlimited)</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label :value="__('Display Name')" />
                                <x-text-input class="block mt-1.5 w-full" type="text" wire:model="tier3Name" required />
                                @error('tier3Name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('Description')" />
                                <x-text-input class="block mt-1.5 w-full" type="text" wire:model="tier3Description" required />
                                @error('tier3Description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Tier 3 has unlimited posts and categories. Requires company name + CAC document.</p>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-5 py-2.5 bg-amber-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition disabled:opacity-50">
                            <span wire:loading.remove wire:target="saveTierSettings">Save Tier Settings</span>
                            <span wire:loading wire:target="saveTierSettings" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Featured Listings Settings --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Featured Listings Settings</h3>
                            <p class="text-sm text-gray-500">Configure how featured listings rotate on the home page.</p>
                        </div>
                    </div>
                </div>
                <form wire:submit="saveFeaturedSettings" class="p-6 sm:p-8 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="maxPerMerchant" :value="__('Max Listings Per Merchant')" />
                            <x-text-input id="maxPerMerchant" class="block mt-1.5 w-full" type="number" wire:model="maxPerMerchant" min="1" max="100" required />
                            <p class="mt-1 text-xs text-gray-400">Maximum number of listings pulled from each merchant.</p>
                            @error('maxPerMerchant') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="rotationSeconds" :value="__('Rotation Interval (seconds)')" />
                            <x-text-input id="rotationSeconds" class="block mt-1.5 w-full" type="number" wire:model="rotationSeconds" min="1" max="120" required />
                            <p class="mt-1 text-xs text-gray-400">How long each slide stays visible before rotating.</p>
                            @error('rotationSeconds') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-slate-700">Properties</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="propertiesPerPage" :value="__('Per Slide')" />
                                <x-text-input id="propertiesPerPage" class="block mt-1.5 w-full" type="number" wire:model="propertiesPerPage" min="1" max="24" required />
                                @error('propertiesPerPage') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label for="propertiesPerRow" :value="__('Per Row')" />
                                <x-text-input id="propertiesPerRow" class="block mt-1.5 w-full" type="number" wire:model="propertiesPerRow" min="1" max="12" required />
                                @error('propertiesPerRow') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-slate-700">Products</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="productsPerPage" :value="__('Per Slide')" />
                                <x-text-input id="productsPerPage" class="block mt-1.5 w-full" type="number" wire:model="productsPerPage" min="1" max="24" required />
                                @error('productsPerPage') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label for="productsPerRow" :value="__('Per Row')" />
                                <x-text-input id="productsPerRow" class="block mt-1.5 w-full" type="number" wire:model="productsPerRow" min="1" max="12" required />
                                @error('productsPerRow') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-slate-700">Services</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="servicesPerPage" :value="__('Per Slide')" />
                                <x-text-input id="servicesPerPage" class="block mt-1.5 w-full" type="number" wire:model="servicesPerPage" min="1" max="24" required />
                                @error('servicesPerPage') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label for="servicesPerRow" :value="__('Per Row')" />
                                <x-text-input id="servicesPerRow" class="block mt-1.5 w-full" type="number" wire:model="servicesPerRow" min="1" max="12" required />
                                @error('servicesPerRow') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-5 py-2.5 bg-amber-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition disabled:opacity-50">
                            <span wire:loading.remove wire:target="saveFeaturedSettings">Save Featured Settings</span>
                            <span wire:loading wire:target="saveFeaturedSettings" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
