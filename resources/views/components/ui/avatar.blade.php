@props([
    'src' => null,
    'alt' => 'Avatar',
    'size' => 'md',
    'initials' => null,
    'status' => null, // online, offline, away, busy
    'fallback' => null,
])

@php
    $sizeClasses = match ($size) {
        'xs' => 'size-6 text-xs',
        'sm' => 'size-8 text-sm',
        'md' => 'size-10 text-base',
        'lg' => 'size-12 text-lg',
        'xl' => 'size-16 text-xl',
        default => 'size-10 text-base',
    };

    $statusClasses = match ($status) {
        'online' => 'bg-success-500',
        'offline' => 'bg-neutral-400',
        'away' => 'bg-warning-500',
        'busy' => 'bg-danger-500',
        default => null,
    };

    $statusSizes = match ($size) {
        'xs' => 'size-1.5 ring-1',
        'sm' => 'size-2 ring-1',
        'md' => 'size-2.5 ring-2',
        'lg' => 'size-3 ring-2',
        'xl' => 'size-3.5 ring-2',
        default => 'size-2.5 ring-2',
    };

    $fallbackText = $fallback ?? $initials ?? '?';
@endphp

<div class="relative inline-flex shrink-0">
    @if ($src)
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            {{ $attributes->merge(['class' => "rounded-full object-cover {$sizeClasses}"]) }}
            loading="lazy"
        />
    @else
        <span
            {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-full bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300 font-medium {$sizeClasses}"]) }}
            aria-label="{{ $alt }}"
        >
            @if ($initials)
                {{ $initials }}
            @else
                <svg class="size-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            @endif
        </span>
    @endif

    {{-- Status indicator --}}
    @if ($status)
        <span
            class="absolute bottom-0 right-0 block {{ $statusSizes }} rounded-full {{ $statusClasses }} ring-surface"
            aria-label="{{ $status }}"
            role="status"
        ></span>
    @endif
</div>

