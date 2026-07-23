@props([
    'variant' => 'info',
    'icon' => null,
    'dismissible' => false,
    'title' => null,
    'description' => null,
])

@php
    $variantClasses = match ($variant) {
        'success' => 'bg-success-50 border-success-200 text-success-800 dark:bg-success-950/20 dark:border-success-900 dark:text-success-300',
        'warning' => 'bg-warning-50 border-warning-200 text-warning-800 dark:bg-warning-950/20 dark:border-warning-900 dark:text-warning-300',
        'danger' => 'bg-danger-50 border-danger-200 text-danger-800 dark:bg-danger-950/20 dark:border-danger-900 dark:text-danger-300',
        'info' => 'bg-info-50 border-info-200 text-info-800 dark:bg-info-950/20 dark:border-info-900 dark:text-info-300',
        default => 'bg-info-50 border-info-200 text-info-800 dark:bg-info-950/20 dark:border-info-900 dark:text-info-300',
    };

    $defaultIcons = [
        'success' => '<svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'warning' => '<svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>',
        'danger' => '<svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>',
        'info' => '<svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>',
    ];

    $iconSvg = $icon ?? $defaultIcons[$variant] ?? $defaultIcons['info'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    {{ $attributes->merge(['class' => "relative border rounded-lg p-4 {$variantClasses}"]) }}
    role="alert"
>
    <div class="flex gap-3">
        {{-- Icon --}}
        @if ($iconSvg)
            <div class="shrink-0 mt-0.5" aria-hidden="true">
                {!! $iconSvg !!}
            </div>
        @endif

        {{-- Content --}}
        <div class="flex-1">
            @if ($title)
                <h3 class="text-sm font-semibold">{{ $title }}</h3>
            @endif
            @if ($description)
                <div class="mt-1 text-sm opacity-90">{{ $description }}</div>
            @endif
            {{ $slot }}
        </div>

        {{-- Dismiss button --}}
        @if ($dismissible)
            <button
                type="button"
                @click="show = false"
                class="shrink-0 p-1 rounded-md transition-colors hover:bg-black/5 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-current"
                aria-label="Dismiss alert"
            >
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
</div>

