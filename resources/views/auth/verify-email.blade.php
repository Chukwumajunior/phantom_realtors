<x-guest-layout>
    <div class="space-y-6">
        {{-- Heading --}}
        <div class="text-center">
            <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Check your email</h2>
            <p class="mt-2 text-sm text-gray-500 max-w-sm mx-auto">
                We've sent a verification link to your email address. Click the link to verify your account.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="flex items-center gap-2 p-3 bg-green-50 border border-green-200 rounded-lg text-sm font-medium text-green-700">
                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    Resend verification email
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                    Sign out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
