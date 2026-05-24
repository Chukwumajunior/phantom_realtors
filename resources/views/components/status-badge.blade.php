@props(['status', 'color' => 'gray'])

@php
$classes = match($color) {
    'green' => 'bg-green-100 text-green-800',
    'red' => 'bg-red-100 text-red-800',
    'yellow' => 'bg-yellow-100 text-yellow-800',
    'blue' => 'bg-blue-100 text-blue-800',
    'amber' => 'bg-amber-100 text-amber-800',
    'purple' => 'bg-purple-100 text-purple-800',
    'orange' => 'bg-orange-100 text-orange-800',
    default => 'bg-gray-100 text-gray-800',
};
@endphp

<span class="px-2 py-1 text-xs font-medium rounded-full {{ $classes }}">
    {{ $status }}
</span>
