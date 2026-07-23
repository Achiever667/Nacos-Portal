@props([
    'href' => '#',
    'icon' => null,
    'divider' => false,
])

@if ($divider)
    <div class="border-t border-border my-1" role="separator"></div>
@else
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => 'flex items-center gap-3 px-4 py-2.5 text-sm text-text hover:bg-surface-secondary transition-colors duration-100 focus:outline-none focus:bg-surface-secondary cursor-pointer']) }}
        role="menuitem"
    >
        @if ($icon)
            <span class="shrink-0 size-4 text-text-secondary">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </a>
@endif

