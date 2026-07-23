@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'trailingIcon' => null,
    'loading' => false,
    'disabled' => false,
    'full' => false,
    'rounded' => false,
    'type' => 'button',
    'href' => null,
    'target' => null,
    'rel' => null,
])

@php
    // Determine if icon-only mode
    $isIconOnly = $icon && !$trailingIcon && !trim((string) $slot ?? '');

    // Variant classes
    $variantClasses = match ($variant) {
        'primary' => 'bg-primary-500 text-white hover:bg-primary-600 focus:ring-primary-500 active:bg-primary-700 disabled:bg-primary-300 dark:disabled:bg-primary-800',
        'secondary' => 'bg-surface text-text border border-border hover:bg-surface-secondary focus:ring-primary-500 active:bg-neutral-200 dark:active:bg-neutral-700 disabled:opacity-50',
        'outline' => 'bg-transparent text-text border border-border hover:bg-surface-secondary focus:ring-primary-500 active:bg-neutral-200 dark:active:bg-neutral-700 disabled:opacity-50',
        'ghost' => 'bg-transparent text-text hover:bg-surface-secondary focus:ring-primary-500 active:bg-neutral-200 dark:active:bg-neutral-700 disabled:opacity-50',
        'danger' => 'bg-danger-500 text-white hover:bg-danger-600 focus:ring-danger-500 active:bg-danger-700 disabled:bg-danger-300 dark:disabled:bg-danger-800',
        'success' => 'bg-success-500 text-white hover:bg-success-600 focus:ring-success-500 active:bg-success-700 disabled:bg-success-300 dark:disabled:bg-success-800',
        'warning' => 'bg-warning-500 text-white hover:bg-warning-600 focus:ring-warning-500 active:bg-warning-700 disabled:bg-warning-300 dark:disabled:bg-warning-800',
        'info' => 'bg-info-500 text-white hover:bg-info-600 focus:ring-info-500 active:bg-info-700 disabled:bg-info-300 dark:disabled:bg-info-800',
        'link' => 'bg-transparent text-primary-500 hover:text-primary-600 underline underline-offset-2 focus:ring-primary-500 disabled:text-neutral-400 dark:disabled:text-neutral-600 disabled:no-underline',
        default => 'bg-primary-500 text-white hover:bg-primary-600 focus:ring-primary-500 active:bg-primary-700',
    };

    // Size classes
    $sizeClasses = match ($size) {
        'xs' => 'px-2 py-1 text-xs gap-1',
        'sm' => 'px-3 py-1.5 text-sm gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-5 py-2.5 text-base gap-2',
        'xl' => 'px-6 py-3 text-lg gap-2.5',
        default => 'px-4 py-2 text-sm gap-2',
    };

    // Icon-only size
    $iconSizeClasses = match ($size) {
        'xs' => 'p-1',
        'sm' => 'p-1.5',
        'md' => 'p-2',
        'lg' => 'p-2.5',
        'xl' => 'p-3',
        default => 'p-2',
    };

    // Icon dimensions
    $iconDimensions = match ($size) {
        'xs' => 'size-3.5',
        'sm' => 'size-4',
        'md' => 'size-4',
        'lg' => 'size-5',
        'xl' => 'size-5',
        default => 'size-4',
    };

    // Final size
    $appliedSizeClasses = $isIconOnly ? $iconSizeClasses : $sizeClasses;

    // Build base classes
    $classes = [
        'inline-flex items-center justify-center font-medium',
        'focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-surface',
        'transition-all duration-150 ease-in-out',
        'cursor-pointer select-none',
        'disabled:cursor-not-allowed disabled:pointer-events-none',
        $variantClasses,
        $appliedSizeClasses,
    ];

    if ($full) {
        $classes[] = 'w-full';
    }

    $classes[] = $rounded ? 'rounded-full' : 'rounded-lg';

    if ($loading) {
        $classes[] = 'relative';
    }

    $classString = implode(' ', $classes);

    // Attributes to exclude from merging
    $exclude = ['variant', 'size', 'icon', 'trailingIcon', 'loading', 'disabled', 'full', 'rounded', 'type', 'href', 'target', 'rel'];

    // Spinner SVG
    $spinner = '<svg class="animate-spin ' . $iconDimensions . '" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
@endphp

{{-- Icon-only button --}}
@if ($isIconOnly)
    @if ($href)
        <a
            href="{{ $href }}"
            target="{{ $target ?? '' }}"
            rel="{{ $rel ?? '' }}"
            {{ $attributes->merge(['class' => $classString])->exceptProps($exclude) }}
            aria-label="{{ $attributes->get('aria-label', $attributes->get('title', 'Icon button')) }}"
        >{!! $loading ? $spinner : $icon !!}</a>
    @else
        <button
            type="{{ $type }}"
            @disabled($disabled || $loading)
            {{ $attributes->merge(['class' => $classString])->exceptProps($exclude) }}
            aria-label="{{ $attributes->get('aria-label', $attributes->get('title', 'Icon button')) }}"
        >{!! $loading ? $spinner : $icon !!}</button>
    @endif
@else
    {{-- Standard button with content --}}
    @if ($href)
        <a
            href="{{ $href }}"
            target="{{ $target ?? '' }}"
            rel="{{ $rel ?? '' }}"
            {{ $attributes->merge(['class' => $classString])->exceptProps($exclude) }}
        >
            @if ($loading)
                {!! $spinner !!}
                <span class="opacity-0 inline-flex items-center gap-2">{{ $slot }}</span>
            @else
                @if ($icon)
                    <span class="shrink-0 {{ $iconDimensions }}">{!! $icon !!}</span>
                @endif
                <span>{{ $slot }}</span>
                @if ($trailingIcon)
                    <span class="shrink-0 {{ $iconDimensions }}">{!! $trailingIcon !!}</span>
                @endif
            @endif
        </a>
    @else
        <button
            type="{{ $type }}"
            @disabled($disabled || $loading)
            {{ $attributes->merge(['class' => $classString])->exceptProps($exclude) }}
        >
            @if ($loading)
                {!! $spinner !!}
                <span class="opacity-0 inline-flex items-center gap-2">{{ $slot }}</span>
            @else
                @if ($icon)
                    <span class="shrink-0 {{ $iconDimensions }}">{!! $icon !!}</span>
                @endif
                <span>{{ $slot }}</span>
                @if ($trailingIcon)
                    <span class="shrink-0 {{ $iconDimensions }}">{!! $trailingIcon !!}</span>
                @endif
            @endif
        </button>
    @endif
@endif

