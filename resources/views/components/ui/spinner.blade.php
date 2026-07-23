@props([
    'size' => 'md',
    'color' => 'primary', // primary, white, current
])

@php
    $sizeClasses = match ($size) {
        'xs' => 'size-3',
        'sm' => 'size-4',
        'md' => 'size-6',
        'lg' => 'size-8',
        'xl' => 'size-10',
        default => 'size-6',
    };

    $colorClasses = match ($color) {
        'primary' => 'text-primary-500',
        'white' => 'text-white',
        'current' => 'text-current',
        default => 'text-primary-500',
    };
@endphp

<svg
    {{ $attributes->merge(['class' => "animate-spin {$sizeClasses} {$colorClasses}"]) }}
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    role="status"
    aria-label="Loading"
>
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>

