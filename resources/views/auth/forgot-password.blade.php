<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Forgot your password?</h2>
            <p class="mt-1 text-sm text-gray-500">No worries. Enter your email and we'll send you a reset link.</p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>

            <x-primary-button class="w-full justify-center">
                Send reset link
            </x-primary-button>
        </form>

        <p class="text-center text-sm text-gray-500">
            Remember your password?
            <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 font-semibold">Back to sign in</a>
        </p>
    </div>
</x-guest-layout>
