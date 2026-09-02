<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Confirm your password</h2>
            <p class="mt-1 text-sm text-gray-500">This is a secure area. Please confirm your password before continuing.</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <div x-data="{ show: false }" class="relative mt-1.5">
                    <x-text-input id="password" class="block w-full pr-10" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <x-primary-button class="w-full justify-center">
                Confirm
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
