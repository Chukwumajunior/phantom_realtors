<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Merchants</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Search & Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name, email, or business name..." class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>
                    <select wire:model.live="status" class="border-gray-300 rounded-lg text-sm focus:border-amber-500 focus:ring-amber-500 sm:w-44">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s->value }}">{{ $s->label() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @if($merchants->count())

                <!-- Desktop Table -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Merchant</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Business</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Applied</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($merchants as $merchant)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($merchant->user->avatar)
                                            @if(str_starts_with($merchant->user->avatar, 'http'))
                                                <img src="{{ $merchant->user->avatar }}" alt="" class="w-9 h-9 rounded-lg object-cover">
                                            @else
                                                <img src="{{ asset('storage/' . $merchant->user->avatar) }}" alt="" class="w-9 h-9 rounded-lg object-cover">
                                            @endif
                                        @else
                                            <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                                                <span class="text-sm font-bold text-amber-700">{{ strtoupper(substr($merchant->user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ $merchant->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $merchant->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-slate-900">{{ $merchant->business_name }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-status-badge :status="$merchant->status->label()" :color="$merchant->status->color()" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $merchant->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.merchants.show', $merchant) }}" wire:navigate class="text-sm font-medium text-amber-600 hover:text-amber-700 transition">
                                        Review
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="sm:hidden divide-y divide-gray-100">
                    @foreach($merchants as $merchant)
                    <a href="{{ route('admin.merchants.show', $merchant) }}" wire:navigate class="block p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            @if($merchant->user->avatar)
                                @if(str_starts_with($merchant->user->avatar, 'http'))
                                    <img src="{{ $merchant->user->avatar }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <img src="{{ asset('storage/' . $merchant->user->avatar) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                @endif
                            @else
                                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <span class="text-sm font-bold text-amber-700">{{ strtoupper(substr($merchant->user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $merchant->user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $merchant->business_name }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <x-status-badge :status="$merchant->status->label()" :color="$merchant->status->color()" />
                                <p class="text-xs text-gray-400 mt-1">{{ $merchant->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                @if($merchants->hasPages())
                <div class="px-4 sm:px-6 py-4 border-t border-gray-100">
                    {{ $merchants->links() }}
                </div>
                @endif
                @else
                <div class="p-12 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    @if($search || $status)
                        <p class="text-sm font-medium text-slate-900">No merchants found</p>
                        <p class="text-sm text-gray-500 mt-1">Try adjusting your search or filter.</p>
                    @else
                        <p class="text-sm font-medium text-slate-900">No merchant applications</p>
                        <p class="text-sm text-gray-500 mt-1">Applications will appear here when users apply to become merchants.</p>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
