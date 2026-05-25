<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Merchant Subscriptions</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-800 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 text-red-800 text-sm">{{ session('error') }}</div>
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
                                    <div class="flex items-center gap-2">
                                        <!-- Activate Form -->
                                        <form action="{{ route('admin.subscriptions.activate', $merchant) }}" method="POST" class="inline-flex items-center gap-2"
                                            x-data="{ showForm: false }">
                                            @csrf
                                            <button type="button" @click="showForm = !showForm" class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                                Activate
                                            </button>
                                            <div x-show="showForm" x-transition class="flex items-center gap-2">
                                                <select name="subscription_plan_id" required class="text-sm rounded-lg border-gray-300 py-1">
                                                    <option value="">Select plan</option>
                                                    @foreach($plans as $plan)
                                                        <option value="{{ $plan->id }}">{{ $plan->name }} ({{ $plan->formatted_price }})</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700">Go</button>
                                            </div>
                                        </form>

                                        @if($isActive)
                                        <form action="{{ route('admin.subscriptions.cancel', $merchant) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Cancel this subscription?')">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Cancel</button>
                                        </form>
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
</x-app-layout>
