<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">My Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Profile Header Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="relative h-36 bg-gradient-to-br from-slate-900 via-slate-800 to-amber-900/40">
                    {{-- Pattern overlay --}}
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="profile-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                                    <circle cx="16" cy="16" r="1" fill="white"/>
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#profile-grid)" />
                        </svg>
                    </div>
                </div>
                <div class="relative z-10 px-6 sm:px-8 pb-6 -mt-12">
                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <div class="shrink-0">
                            @if($currentAvatar)
                                <img src="{{ asset('storage/' . $currentAvatar) }}" alt="{{ $name }}" class="w-24 h-24 rounded-2xl border-4 border-white shadow-lg object-cover ring-1 ring-gray-100">
                            @else
                                <div class="w-24 h-24 rounded-2xl border-4 border-white shadow-lg bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center ring-1 ring-gray-100">
                                    <span class="text-3xl font-bold text-white">{{ strtoupper(substr($name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 pt-14">
                            <h3 class="text-xl font-bold text-slate-900">{{ $name }}</h3>
                            <p class="text-sm text-gray-500">{{ $email }}</p>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ auth()->user()->role->label() }}
                                </span>
                                @if(auth()->user()->email_verified_at)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Forms --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Personal Information --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">Personal Information</h3>
                                    <p class="text-sm text-gray-500">Update your personal details and contact information.</p>
                                </div>
                            </div>
                        </div>

                        <form wire:submit="updateProfile" class="p-6 sm:p-8 space-y-5">
                            @if($profileMessage)
                            <div x-data="{ show: true }" x-init="setTimeout(() => { show = false; $wire.set('profileMessage', '') }, 4000)" x-show="show" x-transition
                                class="flex items-center gap-2 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $profileMessage }}
                            </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                                    <input wire:model="name" type="text" id="name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" required placeholder="Your full name">
                                    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                                    <input wire:model="email" type="email" id="email" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" required placeholder="you@example.com">
                                    @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                                    <input wire:model="phone" type="tel" id="phone" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="+234 ...">
                                    @error('phone') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1.5">State</label>
                                    <input wire:model="state" type="text" id="state" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="e.g. Lagos">
                                    @error('state') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
                                    <input wire:model="city" type="text" id="city" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="e.g. Ikeja">
                                    @error('city') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                                    <input wire:model="address" type="text" id="address" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="Street address">
                                    @error('address') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1.5">Bio</label>
                                <textarea wire:model="bio" id="bio" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="Tell us a little about yourself..."></textarea>
                                @error('bio') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1.5">Profile Photo</label>
                                <div class="flex items-center gap-4">
                                    @if($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-14 h-14 rounded-xl object-cover border border-gray-200 shadow-sm">
                                    @elseif($currentAvatar)
                                        <img src="{{ asset('storage/' . $currentAvatar) }}" alt="Current" class="w-14 h-14 rounded-xl object-cover border border-gray-200 shadow-sm">
                                    @else
                                        <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center border border-gray-200">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <input wire:model="avatar" type="file" id="avatar" accept="image/*"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 file:cursor-pointer cursor-pointer">
                                        <div wire:loading wire:target="avatar" class="text-xs text-amber-600 mt-1 font-medium">Uploading...</div>
                                    </div>
                                </div>
                                @error('avatar') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white text-sm font-semibold rounded-lg hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition flex items-center gap-2">
                                    <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                                    <span wire:loading wire:target="updateProfile" class="flex items-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                        Saving...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Change Password --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">Change Password</h3>
                                    <p class="text-sm text-gray-500">Use a strong password with at least 8 characters.</p>
                                </div>
                            </div>
                        </div>

                        <form wire:submit="updatePassword" class="p-6 sm:p-8 space-y-5">
                            @if($passwordMessage)
                            <div x-data="{ show: true }" x-init="setTimeout(() => { show = false; $wire.set('passwordMessage', '') }, 4000)" x-show="show" x-transition
                                class="flex items-center gap-2 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $passwordMessage }}
                            </div>
                            @endif

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
                                <input wire:model="current_password" type="password" id="current_password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="Enter current password">
                                @error('current_password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                                    <input wire:model="password" type="password" id="password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="Min. 8 characters">
                                    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                                    <input wire:model="password_confirmation" type="password" id="password_confirmation" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm placeholder-gray-400" placeholder="Repeat new password">
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-900 focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition flex items-center gap-2">
                                    <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                                    <span wire:loading wire:target="updatePassword" class="flex items-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                        Updating...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right Column: Sidebar --}}
                <div class="space-y-6">
                    {{-- Account Details --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Account Details</h4>
                        </div>
                        <div class="space-y-3.5">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Member since</span>
                                <span class="font-medium text-slate-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Role</span>
                                <span class="font-medium text-slate-900">{{ auth()->user()->role->label() }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Email verified</span>
                                @if(auth()->user()->email_verified_at)
                                    <span class="inline-flex items-center gap-1 font-medium text-green-600">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Yes
                                    </span>
                                @else
                                    <span class="font-medium text-red-600">No</span>
                                @endif
                            </div>
                            @if(auth()->user()->phone)
                            <div class="border-t border-gray-50"></div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Phone</span>
                                <span class="font-medium text-slate-900">{{ auth()->user()->phone }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Merchant Status --}}
                    @if(auth()->user()->merchantProfile)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Merchant Status</h4>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <x-status-badge :status="auth()->user()->merchantProfile->status->label()" :color="auth()->user()->merchantProfile->status->color()" />
                            </div>
                            <p class="text-sm font-medium text-slate-700">{{ auth()->user()->merchantProfile->business_name }}</p>
                            @if(auth()->user()->merchantProfile->approved_at)
                                <p class="text-xs text-gray-500">Approved {{ auth()->user()->merchantProfile->approved_at->format('M d, Y') }}</p>
                            @endif
                            @if(auth()->user()->merchantProfile->status->value === 'rejected')
                                <div class="mt-2 p-3 bg-red-50 border border-red-100 rounded-lg">
                                    <p class="text-xs text-red-700">{{ auth()->user()->merchantProfile->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Danger Zone (non-admin only) --}}
                    @unless(auth()->user()->isAdmin())
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6" x-data="{ showDelete: false }">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            <h4 class="text-sm font-bold text-red-600 uppercase tracking-wide">Danger Zone</h4>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Permanently delete your account and all associated data. This action cannot be undone.</p>
                        <button @click="showDelete = true" class="w-full px-4 py-2.5 bg-red-50 text-red-700 text-sm font-semibold rounded-lg border border-red-200 hover:bg-red-100 hover:border-red-300 transition">
                            Delete Account
                        </button>

                        {{-- Delete Confirmation Modal --}}
                        <div x-show="showDelete" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showDelete = false"></div>
                            <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 mb-1">Delete your account</h3>
                                <p class="text-sm text-gray-500 mb-5">This is permanent and cannot be reversed. All your data will be removed.</p>
                                <form wire:submit="deleteAccount">
                                    <div class="mb-5">
                                        <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm your password</label>
                                        <input wire:model="delete_password" type="password" id="delete_password" placeholder="Enter your password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                                        @error('delete_password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="flex items-center justify-end gap-3">
                                        <button type="button" @click="showDelete = false" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                                        <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition flex items-center gap-2">
                                            <span wire:loading.remove wire:target="deleteAccount">Delete Permanently</span>
                                            <span wire:loading wire:target="deleteAccount" class="flex items-center gap-2">
                                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                                Deleting...
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endunless
                </div>
            </div>

        </div>
    </div>
</div>
