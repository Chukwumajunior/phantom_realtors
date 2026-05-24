<x-app-layout>
    <div class="py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-4">Account Pending Approval</h1>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Your merchant account is currently being reviewed by our admin team. This usually takes 1-2 business days.
                    You will be notified once your account has been approved.
                </p>
                <p class="text-sm text-gray-500">
                    If you have any questions, please <a href="{{ route('contact') }}" class="text-amber-600 hover:text-amber-700 font-medium">contact us</a>.
                </p>
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-slate-900 text-white rounded-lg font-semibold hover:bg-slate-800 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
