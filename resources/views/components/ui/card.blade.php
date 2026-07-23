@props([
    'title' => null,
    'description' => null,
    'header' => null,
    'footer' => null,
    'padding' => true,
    'shadow' => true,
    'hover' => false,
])

@php
    $classes = [
        'bg-surface border border-border rounded-xl',
    ];

    if ($shadow) {
        $classes[] = 'shadow-sm';
    }

    if ($hover) {
        $classes[] = 'hover:shadow-md hover:border-neutral-300 dark:hover:border-neutral-600 transition-all duration-200';
    }

    $classString = implode(' ', $classes);
@endphp

<div {{ $attributes->merge(['class' => $classString]) }}>
    {{-- Header --}}
    @if ($header)
        <div class="px-6 py-4 border-b border-border">
            {{ $header }}
        </div>
    @elseif ($title || $description)
        <div class="px-6 py-4 border-b border-border">
            @if ($title)
                <h3 class="text-base font-semibold text-text">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="mt-1 text-sm text-text-secondary">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{-- Body --}}
    @if ($padding)
        <div class="px-6 py-4">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif

    {{-- Footer --}}
    @if ($footer)
        <div class="px-6 py-4 border-t border-border">
            {{ $footer }}
        </div>
    @endif
</div>

