<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">User Details</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                <!-- User Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center">
                                <span class="text-amber-600 font-bold text-xl">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">{{ $user->name }}</h3>
                                <p class="text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        @if($user->status ?? null)
                            <x-status-badge :status="$user->status->label()" :color="$user->status->color()" />
                        @else
                            <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Role</p>
                            <p class="font-medium text-slate-900 capitalize">{{ $user->role->value ?? $user->role }}</p>
                        </div>
                        @if($user->phone)
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium text-slate-900">{{ $user->phone }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500">Joined</p>
                            <p class="font-medium text-slate-900">{{ $user->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email Verified</p>
                            <p class="font-medium text-slate-900">{{ $user->email_verified_at ? $user->email_verified_at->format('F d, Y') : 'Not verified' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Update -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Account Actions</h3>
                    <form action="{{ route('admin.users.update-status', $user) }}" method="POST" class="flex items-end gap-4">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                            <select id="status" name="status" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                <option value="active" {{ ($user->status->value ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ ($user->status->value ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition">Update Status</button>
                    </form>
                </div>
            </div>

            <div class="mt-6">
                <a wire:navigate href="{{ route('admin.users.index') }}" class="text-amber-600 hover:text-amber-700 font-medium text-sm">&larr; Back to Users</a>
            </div>
        </div>
    </div>
</x-app-layout>
