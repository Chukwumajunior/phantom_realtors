<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Banner Management</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

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
                    <button @click="show = false" class="ml-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            @endif

            {{-- Add New Banner --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Add New Banner</h3>
                            <p class="text-sm text-gray-500">Upload images, GIFs, or short videos for the homepage carousel.</p>
                        </div>
                    </div>
                </div>
                <form wire:submit="addBanner" class="p-6 sm:p-8 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="title" :value="__('Banner Title')" />
                            <x-text-input id="title" class="block mt-1.5 w-full" type="text" wire:model="title" required placeholder="e.g. Summer Sale" />
                            @error('title') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <x-input-label for="link_url" :value="__('Link URL (optional)')" />
                            <x-text-input id="link_url" class="block mt-1.5 w-full" type="url" wire:model="link_url" placeholder="https://example.com" />
                            @error('link_url') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="media" :value="__('Media File')" />
                            <input id="media" type="file" wire:model="media" accept="image/*,video/mp4,video/webm,.gif" class="block mt-1.5 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                            <p class="mt-1 text-xs text-gray-400">Accepted: JPG, PNG, WebP, GIF, MP4, WebM (max 50MB)</p>
                            @error('media') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <x-input-label for="sort_order" :value="__('Sort Order')" />
                            <x-text-input id="sort_order" class="block mt-1.5 w-full" type="number" wire:model="sort_order" min="0" required />
                            <p class="mt-1 text-xs text-gray-400">Lower numbers appear first.</p>
                            @error('sort_order') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Upload preview --}}
                    @if($media)
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 mb-2">Preview:</p>
                        @if(str_starts_with($media->getMimeType(), 'video'))
                            <video src="{{ $media->temporaryUrl() }}" class="h-32 rounded-lg object-cover" muted autoplay loop></video>
                        @else
                            <img src="{{ $media->temporaryUrl() }}" class="h-32 rounded-lg object-cover" alt="Preview">
                        @endif
                    </div>
                    @endif

                    <div class="flex justify-end pt-2">
                        <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-5 py-2.5 bg-amber-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition disabled:opacity-50">
                            <span wire:loading.remove wire:target="addBanner">Add Banner</span>
                            <span wire:loading wire:target="addBanner" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Uploading...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Existing Banners --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Active Banners</h3>
                            <p class="text-sm text-gray-500">{{ $banners->count() }} banner(s) configured.</p>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($banners as $banner)
                    <div class="p-6 sm:p-8 hover:bg-gray-50/50 transition-colors" wire:key="banner-{{ $banner->id }}">
                        @if($editingId === $banner->id)
                            {{-- Edit Mode --}}
                            <form wire:submit="updateBanner" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label :value="__('Title')" />
                                        <x-text-input class="block mt-1.5 w-full" type="text" wire:model="editTitle" required />
                                        @error('editTitle') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Link URL')" />
                                        <x-text-input class="block mt-1.5 w-full" type="url" wire:model="editLinkUrl" placeholder="https://" />
                                        @error('editLinkUrl') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Sort Order')" />
                                        <x-text-input class="block mt-1.5 w-full" type="number" wire:model="editSortOrder" min="0" required />
                                        @error('editSortOrder') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div>
                                    <x-input-label :value="__('Replace Media (optional)')" />
                                    <input type="file" wire:model="editMedia" accept="image/*,video/mp4,video/webm,.gif" class="block mt-1.5 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                                    @error('editMedia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="submit" class="px-4 py-2 bg-amber-600 rounded-lg text-sm font-semibold text-white hover:bg-amber-700 transition">Save</button>
                                    <button type="button" wire:click="cancelEdit" class="px-4 py-2 bg-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-300 transition">Cancel</button>
                                </div>
                            </form>
                        @else
                            {{-- Display Mode --}}
                            <div class="flex items-center gap-5">
                                {{-- Media Preview --}}
                                <div class="shrink-0 w-32 h-20 rounded-lg overflow-hidden bg-gray-100">
                                    @if($banner->media_type === 'video')
                                        <video src="{{ $banner->media_url }}" class="w-full h-full object-cover" muted></video>
                                    @else
                                        <img src="{{ $banner->media_url }}" class="w-full h-full object-cover" alt="{{ $banner->title }}">
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-semibold text-slate-900 truncate">{{ $banner->title }}</h4>
                                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $banner->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                            {{ ucfirst($banner->media_type) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Order: {{ $banner->sort_order }} {{ $banner->link_url ? '| Link: ' . Str::limit($banner->link_url, 40) : '' }}</p>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2 shrink-0">
                                    <button wire:click="toggleActive({{ $banner->id }})" class="p-2 rounded-lg hover:bg-gray-100 transition" title="{{ $banner->is_active ? 'Deactivate' : 'Activate' }}">
                                        @if($banner->is_active)
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        @endif
                                    </button>
                                    <button wire:click="startEdit({{ $banner->id }})" class="p-2 rounded-lg hover:bg-gray-100 transition" title="Edit">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="deleteBanner({{ $banner->id }})" wire:confirm="Are you sure you want to delete this banner?" class="p-2 rounded-lg hover:bg-red-50 transition" title="Delete">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm text-gray-500">No banners yet. Add one above to get started.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
