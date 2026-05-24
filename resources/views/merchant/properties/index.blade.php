<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-slate-900">My Properties</h2>
            <a href="{{ route('merchant.properties.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg font-semibold text-sm hover:bg-amber-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Property
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Property</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Price</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($properties as $property)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $property->images->first() ? $property->images->first()->url : 'https://via.placeholder.com/60x60' }}" class="w-12 h-12 rounded-lg object-cover" alt="{{ $property->title }}">
                                        <div>
                                            <p class="font-medium text-slate-900">{{ Str::limit($property->title, 40) }}</p>
                                            <p class="text-sm text-gray-500">{{ $property->city }}, {{ $property->state }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-1 rounded-full">{{ $property->type->label() }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ format_price($property->price, $property->currency) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('merchant.properties.edit', $property) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                        <form action="{{ route('merchant.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <p class="mb-2">No properties listed yet.</p>
                                    <a href="{{ route('merchant.properties.create') }}" class="text-amber-600 font-medium hover:text-amber-700">Add your first property</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($properties->hasPages())
            <div class="mt-6">
                {{ $properties->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
