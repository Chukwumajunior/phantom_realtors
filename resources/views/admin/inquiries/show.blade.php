<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">Inquiry Details</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Name</label>
                            <p class="text-slate-900 font-medium">{{ $inquiry->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-slate-900">{{ $inquiry->email }}</p>
                        </div>
                        @if($inquiry->phone)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Phone</label>
                            <p class="text-slate-900">{{ $inquiry->phone }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="text-sm font-medium text-gray-500">Date</label>
                            <p class="text-slate-900">{{ $inquiry->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Message</label>
                        <p class="text-slate-900 mt-1 whitespace-pre-wrap">{{ $inquiry->message }}</p>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 flex items-center gap-3">
                    <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="read">
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">Mark as Read</button>
                    </form>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Inquiries</a>
            </div>
        </div>
    </div>
</x-app-layout>
