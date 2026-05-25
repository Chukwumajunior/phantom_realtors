<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Set a new password</h2>
            <p class="mt-1 text-sm text-gray-500">Choose a strong password with at least 8 characters.</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="password" :value="__('New password')" />
                <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm new password')" />
                <x-text-input id="password_confirmation" class="block mt-1.5 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
            </div>

            <x-primary-button class="w-full justify-center">
                Reset password
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
