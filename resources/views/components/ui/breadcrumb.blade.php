@props([
    'items' => [],
    'home' => true,
    'homeIcon' => null,
])

@php
    $defaultHomeIcon = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>';
@endphp

<nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'flex items-center text-sm text-text-secondary']) }}>
    <ol class="flex items-center flex-wrap gap-1.5">
        {{-- Home --}}
        @if ($home)
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 hover:text-text transition-colors duration-100 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded" aria-label="Home">
                    @if ($homeIcon)
                        {!! $homeIcon !!}
                    @else
                        {!! $defaultHomeIcon !!}
                    @endif
                </a>
            </li>
            @if (count($items) > 0)
                <li class="inline-flex items-center" aria-hidden="true">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </li>
            @endif
        @endif

        {{-- Items --}}
        @foreach ($items as $index => $item)
            @php
                $isLast = $loop->last;
                $label = is_string($item) ? $item : ($item['label'] ?? '');
                $url = is_string($item) ? '#' : ($item['url'] ?? '#');
            @endphp
            <li class="inline-flex items-center gap-1.5">
                @if ($isLast || $url === '#')
                    <span class="{{ $isLast ? 'text-text font-medium' : '' }}" {{ $isLast ? 'aria-current="page"' : '' }}>
                        {{ $label }}
                    </span>
                @else
                    <a href="{{ $url }}" class="hover:text-text transition-colors duration-100 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded">
                        {{ $label }}
                    </a>
                @endif
                @if (!$isLast)
                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                @endif
            </li>
        @endforeach

        {{-- Slot for additional items --}}
        {{ $slot }}
    </ol>
</nav>

