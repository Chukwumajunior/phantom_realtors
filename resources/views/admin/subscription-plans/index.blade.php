<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-slate-900">Subscription Plans</h2>
            <a wire:navigate href="{{ route('admin.subscription-plans.create') }}" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">Create Plan</a>
        </div>
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
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Price</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Duration</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Subscribers</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($plans as $plan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-900">{{ $plan->name }}</p>
                                    @if($plan->description)
                                        <p class="text-sm text-gray-500 mt-0.5">{{ Str::limit($plan->description, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $plan->formatted_price }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->duration_days }} days</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->subscriptions_count }}</td>
                                <td class="px-6 py-4">
                                    @if($plan->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a wire:navigate href="{{ route('admin.subscription-plans.edit', $plan) }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">Edit</a>
                                        <form action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No subscription plans yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $plans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
