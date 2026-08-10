@props([
    'title' => null,
    'value' => null,
    'description' => null,
    'icon' => null,
    'iconBg' => 'bg-primary-50 text-primary-700',
    'shadow' => true,
    'hover' => false,
])

<x-ui.card :shadow="$shadow" :hover="$hover" {{ $attributes }}>
    <div class="flex items-start justify-between gap-4">
        <div>
            @if ($title)
                <p class="text-sm font-medium text-text-secondary">{{ $title }}</p>
            @endif
            @if ($value !== null)
                <p class="mt-3 text-3xl font-semibold text-text">{{ $value }}</p>
            @endif
        </div>
        @if ($icon)
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-3xl {{ $iconBg }}">
                {!! $icon !!}
            </span>
        @endif
    </div>
    @if ($description)
        <p class="mt-4 text-sm text-text-secondary">{{ $description }}</p>
    @endif
</x-ui.card>
