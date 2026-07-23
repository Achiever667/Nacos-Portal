@props([
    'title' => 'No data found',
    'description' => null,
    'action' => null,
    'actionUrl' => '#',
    'actionText' => null,
    'icon' => null,
])

<div
    {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center py-12 px-4']) }}
    role="status"
>
    {{-- Icon / Illustration --}}
    @if ($icon)
        <div class="mb-4 text-neutral-300 dark:text-neutral-600">
            <span class="size-16">{!! $icon !!}</span>
        </div>
    @else
        <div class="mb-4 text-neutral-300 dark:text-neutral-600">
            <svg class="size-16 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
        </div>
    @endif

    {{-- Custom illustration slot --}}
    {{ $illustration ?? '' }}

    {{-- Title --}}
    @if ($title)
        <h3 class="text-lg font-semibold text-text">{{ $title }}</h3>
    @endif

    {{-- Description --}}
    @if ($description)
        <p class="mt-2 text-sm text-text-secondary max-w-sm">{{ $description }}</p>
    @endif

    {{-- Action button --}}
    @if ($actionText)
        <div class="mt-6">
            @if ($actionUrl !== '#')
                <a
                    href="{{ $actionUrl }}"
                    {{ $action->attributes ?? '' }}
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface transition-colors duration-150"
                >
                    {{ $actionText }}
                </a>
            @else
                <button
                    type="button"
                    {{ $action->attributes ?? '' }}
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface transition-colors duration-150"
                >
                    {{ $actionText }}
                </button>
            @endif
        </div>
    @endif

    {{-- Custom action slot --}}
    {{ $action ?? '' }}

    {{-- Additional content --}}
    {{ $slot }}
</div>

