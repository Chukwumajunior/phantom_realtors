<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Site Settings</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Bank Account Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-slate-900">Bank Account Details</h3>
                    <p class="text-sm text-gray-500 mt-1">Payment account shown to merchants during application and subscription renewal.</p>
                </div>
                <form action="{{ route('admin.settings.bank-details') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="bank_name" :value="__('Bank Name')" />
                        <x-text-input id="bank_name" class="block mt-1 w-full" type="text" name="bank_name" :value="old('bank_name', $bankDetails['bank_name'] ?? '')" required placeholder="e.g. First Bank Nigeria" />
                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="account_name" :value="__('Account Name')" />
                        <x-text-input id="account_name" class="block mt-1 w-full" type="text" name="account_name" :value="old('account_name', $bankDetails['account_name'] ?? '')" required placeholder="e.g. Phantom 5 Ltd" />
                        <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="account_number" :value="__('Account Number')" />
                        <x-text-input id="account_number" class="block mt-1 w-full" type="text" name="account_number" :value="old('account_number', $bankDetails['account_number'] ?? '')" required placeholder="e.g. 0123456789" />
                        <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-primary-button>Save Bank Details</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Subscription Plans -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-slate-900">Subscription Plans</h3>
                    <p class="text-sm text-gray-500 mt-1">Set pricing and duration for merchant subscription plans.</p>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($plans as $plan)
                    <form action="{{ route('admin.settings.plans.update', $plan) }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                            <div>
                                <x-input-label :value="__('Plan Name')" />
                                <x-text-input class="block mt-1 w-full" type="text" name="name" :value="$plan->name" required />
                            </div>
                            <div>
                                <x-input-label :value="__('Price (₦)')" />
                                <x-text-input class="block mt-1 w-full" type="number" name="price" :value="$plan->price" step="0.01" min="0" required />
                            </div>
                            <div>
                                <x-input-label :value="__('Duration (days)')" />
                                <x-text-input class="block mt-1 w-full" type="number" name="duration_days" :value="$plan->duration_days" min="1" required />
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="flex items-center gap-2">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" {{ $plan->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">Active</span>
                                </label>
                                <x-primary-button class="text-xs">Save</x-primary-button>
                                <button type="button" onclick="if(confirm('Delete this plan?')) document.getElementById('delete-plan-{{ $plan->id }}').submit()" class="text-red-600 hover:text-red-700 text-xs font-medium">Delete</button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <x-input-label :value="__('Description (optional)')" />
                            <x-text-input class="block mt-1 w-full" type="text" name="description" :value="$plan->description" placeholder="Brief description of this plan" />
                        </div>
                    </form>
                    @endforeach
                </div>

                <!-- Add New Plan -->
                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    <h4 class="text-sm font-bold text-slate-900 mb-3">Add New Plan</h4>
                    <form action="{{ route('admin.settings.plans.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                            <div>
                                <x-input-label :value="__('Plan Name')" />
                                <x-text-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="e.g. Quarterly Plan" />
                            </div>
                            <div>
                                <x-input-label :value="__('Price (₦)')" />
                                <x-text-input class="block mt-1 w-full" type="number" name="price" :value="old('price')" step="0.01" min="0" required placeholder="e.g. 15000" />
                            </div>
                            <div>
                                <x-input-label :value="__('Duration (days)')" />
                                <x-text-input class="block mt-1 w-full" type="number" name="duration_days" :value="old('duration_days')" min="1" required placeholder="e.g. 90" />
                            </div>
                            <div>
                                <x-primary-button class="w-full justify-center">Add Plan</x-primary-button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <x-text-input class="block w-full" type="text" name="description" :value="old('description')" placeholder="Description (optional)" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Plan Hidden Forms -->
            @foreach($plans as $plan)
            <form id="delete-plan-{{ $plan->id }}" action="{{ route('admin.settings.plans.destroy', $plan) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            @endforeach

        </div>
    </div>
</x-app-layout>
