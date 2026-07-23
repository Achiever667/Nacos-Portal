@props([
    'align' => 'left',
    'width' => '48',
    'contentClasses' => '',
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'start-0',
        'right' => 'end-0',
        'top' => 'bottom-full mb-2 start-0',
        default => 'start-0',
    };

    $widthClass = match ($width) {
        '48' => 'w-48',
        '56' => 'w-56',
        '64' => 'w-64',
        '72' => 'w-72',
        'full' => 'w-full',
        default => $width,
    };
@endphp

<div
    x-data="{ open: false }"
    @click.outside="open = false"
    @close.stop="open = false"
    {{ $attributes->merge(['class' => 'relative inline-block text-left']) }}
>
    {{-- Trigger --}}
    <div
        @click="open = !open"
        @keydown.space.prevent="open = !open"
        @keydown.enter.prevent="open = !open"
        role="button"
        tabindex="0"
        aria-haspopup="true"
        :aria-expanded="open"
    >
        {{ $trigger }}
    </div>

    {{-- Dropdown menu --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $widthClass }} {{ $alignmentClasses }}"
        style="display: none;"
        @click="open = false"
        role="menu"
        aria-orientation="vertical"
    >
        <div class="rounded-lg border border-border bg-surface shadow-lg ring-1 ring-black/5 dark:ring-white/10 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

