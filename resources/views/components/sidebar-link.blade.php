@props(['active'])

@php
$classes = $active ?? false
            ? 'bg-blue-800 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md'
            : 'text-blue-100 hover:bg-blue-600 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

