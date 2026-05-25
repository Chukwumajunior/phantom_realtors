<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Merchant Subscriptions</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Inline Flash Message -->
            @if($message)
            <div class="mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                <div class="flex items-center gap-3 p-4 rounded-lg border {{ $messageType === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800' }}">
                    @if($messageType === 'success')
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                    <p class="text-sm font-medium">{{ $message }}</p>
                    <button @click="show = false" class="ml-auto {{ $messageType === 'success' ? 'text-green-500 hover:text-green-700' : 'text-red-500 hover:text-red-700' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Merchant</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Business</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Current Plan</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Expires</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($merchants as $merchant)
                            @php
                                $latestSub = $merchant->subscriptions->first();
                                $isActive = $latestSub && $latestSub->isActive();
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-900">{{ $merchant->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $merchant->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $merchant->merchantProfile?->business_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $latestSub?->plan?->name ?? 'None' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($isActive)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $latestSub->status->label() }}
                                        </span>
                                    @elseif($latestSub)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Expired
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            No Subscription
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $latestSub?->expires_at?->format('M d, Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2" x-data="{ showForm: false, selectedPlan: '' }">
                                        <!-- Activate Action -->
                                        <button type="button" @click="showForm = !showForm" class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                            Activate
                                        </button>
                                        <div x-show="showForm" x-transition class="flex items-center gap-2">
                                            <select x-model="selectedPlan" class="text-sm rounded-lg border-gray-300 py-1">
                                                <option value="">Select plan</option>
                                                @foreach($plans as $plan)
                                                    <option value="{{ $plan->id }}">{{ $plan->name }} ({{ $plan->formatted_price }})</option>
                                                @endforeach
                                            </select>
                                            <button
                                                type="button"
                                                @click="if(selectedPlan) $wire.activate({{ $merchant->id }}, parseInt(selectedPlan))"
                                                class="px-3 py-1 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 disabled:opacity-50"
                                            >
                                                Go
                                            </button>
                                        </div>

                                        @if($isActive)
                                        <button
                                            type="button"
                                            wire:click="cancel({{ $merchant->id }})"
                                            wire:confirm="Cancel this subscription?"
                                            wire:loading.attr="disabled"
                                            class="text-red-600 hover:text-red-700 text-sm font-medium disabled:opacity-50"
                                        >
                                            Cancel
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No merchants found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $merchants->links() }}
            </div>
        </div>
    </div>
</div>
