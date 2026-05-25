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
                <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <x-primary-button class="w-full justify-center">
                Confirm
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
