@props(['size' => 'md', 'color' => 'blue'])

@php
$sizeClasses = [
    'sm' => 'h-4 w-4',
    'md' => 'h-8 w-8',
    'lg' => 'h-12 w-12',
    'xl' => 'h-16 w-16',
];

$colorClasses = [
    'blue' => 'border-blue-600',
    'white' => 'border-white',
    'gray' => 'border-gray-600',
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
$colorClass = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div {{ $attributes->merge(['class' => 'inline-block']) }}>
    <div class="animate-spin rounded-full border-b-2 {{ $sizeClass }} {{ $colorClass }}"></div>
</div>
