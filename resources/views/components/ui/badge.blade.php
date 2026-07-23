@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
])

@php
    $variantClasses = match ($variant) {
        'primary' => 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300',
        'success' => 'bg-success-100 text-success-700 dark:bg-success-900/30 dark:text-success-300',
        'warning' => 'bg-warning-100 text-warning-700 dark:bg-warning-900/30 dark:text-warning-300',
        'danger' => 'bg-danger-100 text-danger-700 dark:bg-danger-900/30 dark:text-danger-300',
        'info' => 'bg-info-100 text-info-700 dark:bg-info-900/30 dark:text-info-300',
        'neutral' => 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300',
        default => 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300',
    };

    $sizeClasses = match ($size) {
        'sm' => 'px-1.5 py-0.5 text-xs gap-1',
        'md' => 'px-2.5 py-1 text-xs gap-1.5',
        'lg' => 'px-3 py-1.5 text-sm gap-1.5',
        default => 'px-2.5 py-1 text-xs gap-1.5',
    };

    $iconDimensions = match ($size) {
        'sm' => 'size-3',
        'md' => 'size-3.5',
        'lg' => 'size-4',
        default => 'size-3.5',
    };
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-full {$variantClasses} {$sizeClasses}"]) }}
    role="status"
>
    @if ($icon)
        <span class="shrink-0 {{ $iconDimensions }}">{!! $icon !!}</span>
    @endif
    {{ $slot }}
</span>

