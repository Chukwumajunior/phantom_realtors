<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Subscription</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Current Subscription Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Current Subscription</h3>

                @if($subscription)
                    <div class="flex items-center gap-4 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($subscription->status->color() === 'green') bg-green-100 text-green-800
                            @elseif($subscription->status->color() === 'blue') bg-blue-100 text-blue-800
                            @elseif($subscription->status->color() === 'red') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $subscription->status->label() }}
                        </span>
                        @if($subscription->plan)
                            <span class="text-sm text-gray-600">{{ $subscription->plan->name }}</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Started</p>
                            <p class="font-medium text-slate-900">{{ $subscription->starts_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Expires</p>
                            <p class="font-medium text-slate-900">{{ $subscription->expires_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Days Remaining</p>
                            <p class="font-medium text-slate-900">{{ $subscription->daysRemaining() }} day(s)</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600">You do not have an active subscription. Contact admin to activate one.</p>
                @endif
            </div>

            <!-- Available Plans -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Available Plans</h3>
                <p class="text-sm text-gray-600 mb-6">To subscribe or renew, make payment to the bank details below and contact the admin for activation.</p>

                @if($plans->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($plans as $plan)
                            <div class="border border-gray-200 rounded-xl p-6 hover:border-amber-300 transition">
                                <h4 class="text-lg font-bold text-slate-900">{{ $plan->name }}</h4>
                                @if($plan->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $plan->description }}</p>
                                @endif
                                <p class="text-3xl font-bold text-amber-600 mt-4">{{ $plan->formatted_price }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $plan->duration_days }} days</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No plans available at the moment.</p>
                @endif
            </div>

            <!-- Payment Instructions -->
            @php $bankDetails = \App\Models\SiteConfig::getBankDetails(); @endphp
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
                <h3 class="text-lg font-bold text-amber-900 mb-2">How to Subscribe</h3>
                <ol class="list-decimal list-inside text-sm text-amber-800 space-y-2">
                    <li>Choose a plan from above</li>
                    <li>Make payment via bank transfer to the account below</li>
                    <li>Contact the admin with your proof of payment</li>
                    <li>Admin will activate your subscription once payment is confirmed</li>
                </ol>
                @if($bankDetails['bank_name'] && $bankDetails['account_number'])
                <div class="mt-4 pt-4 border-t border-amber-200">
                    <p class="text-sm font-medium text-amber-900 mb-1">Bank Transfer Details:</p>
                    <div class="text-sm text-amber-800">
                        <p><span class="font-medium">Bank:</span> {{ $bankDetails['bank_name'] }}</p>
                        <p><span class="font-medium">Account Name:</span> {{ $bankDetails['account_name'] }}</p>
                        <p><span class="font-medium">Account Number:</span> {{ $bankDetails['account_number'] }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Subscription History -->
            @if($allSubscriptions->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-slate-900">Subscription History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Plan</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Started</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Expired</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($allSubscriptions as $sub)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-slate-900">{{ $sub->plan?->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($sub->status->color() === 'green') bg-green-100 text-green-800
                                        @elseif($sub->status->color() === 'blue') bg-blue-100 text-blue-800
                                        @elseif($sub->status->color() === 'red') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $sub->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $sub->starts_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $sub->expires_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
