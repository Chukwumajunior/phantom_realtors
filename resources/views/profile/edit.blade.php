<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(auth()->user()->merchantProfile)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Merchant Application</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Status of your seller application.</p>

                    <div class="mt-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-3">
                            <x-status-badge :status="auth()->user()->merchantProfile->status->label()" :color="auth()->user()->merchantProfile->status->color()" />
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->merchantProfile->business_name }}</span>
                        </div>
                        @if(auth()->user()->merchantProfile->status->value === 'pending')
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Your application is being reviewed by our team.</p>
                        @elseif(auth()->user()->merchantProfile->status->value === 'approved')
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Approved on {{ auth()->user()->merchantProfile->approved_at?->format('M d, Y') }}.</p>
                        @elseif(auth()->user()->merchantProfile->status->value === 'rejected')
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Reason: {{ auth()->user()->merchantProfile->rejection_reason }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
