@props([
    'text' => null,
    'position' => 'top', // top, bottom, left, right
    'delay' => 200,
])

@php
    $positionClasses = match ($position) {
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
        default => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
    };

    $arrowClasses = match ($position) {
        'top' => 'top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-neutral-900 dark:border-t-neutral-100',
        'bottom' => 'bottom-full left-1/2 -translate-x-1/2 border-4 border-transparent border-b-neutral-900 dark:border-b-neutral-100',
        'left' => 'left-full top-1/2 -translate-y-1/2 border-4 border-transparent border-l-neutral-900 dark:border-l-neutral-100',
        'right' => 'right-full top-1/2 -translate-y-1/2 border-4 border-transparent border-r-neutral-900 dark:border-r-neutral-100',
        default => 'top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-neutral-900 dark:border-t-neutral-100',
    };
@endphp

<div
    x-data="{ show: false }"
    @mouseenter="setTimeout(() => show = true, {{ $delay }})"
    @mouseleave="show = false"
    @focusin="show = true"
    @focusout="show = false"
    class="relative inline-flex"
    {{ $attributes }}
>
    {{-- Trigger element --}}
    {{ $slot }}

    {{-- Tooltip --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="absolute z-[200] px-2.5 py-1.5 text-xs font-medium text-white bg-neutral-900 dark:text-neutral-900 dark:bg-neutral-100 rounded-md shadow-lg whitespace-nowrap pointer-events-none {{ $positionClasses }}"
        style="display: none;"
        role="tooltip"
    >
        {{ $text }}
        <div class="absolute {{ $arrowClasses }}"></div>
    </div>
</div>

