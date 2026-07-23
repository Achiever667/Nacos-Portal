@props([
    'paginator' => null,
    'showInfo' => true,
    'simple' => false,
    'size' => 'sm',
])

@php
    if (!$paginator) {
        return;
    }

    $sizeClasses = match ($size) {
        'xs' => 'text-xs gap-0.5',
        'sm' => 'text-sm gap-1',
        'md' => 'text-base gap-1',
        default => 'text-sm gap-1',
    };

    $buttonSize = match ($size) {
        'xs' => 'px-1.5 py-0.5 text-xs',
        'sm' => 'px-2.5 py-1 text-sm',
        'md' => 'px-3 py-1.5 text-sm',
        default => 'px-2.5 py-1 text-sm',
    };

    $activeClasses = 'bg-primary-500 text-white hover:bg-primary-600 focus:ring-primary-500';
    $inactiveClasses = 'bg-surface text-text border border-border hover:bg-surface-secondary focus:ring-primary-500';
    $disabledClasses = 'opacity-40 cursor-not-allowed pointer-events-none';

    function pageButton($label, $page, $active, $disabled, $buttonSize, $activeClasses, $inactiveClasses, $disabledClasses) {
        $classes = "inline-flex items-center justify-center {$buttonSize} rounded-lg font-medium transition-colors duration-100 focus:outline-none focus:ring-2 focus:ring-offset-1 dark:focus:ring-offset-surface";
        if ($disabled) {
            $classes .= " {$disabledClasses} {$inactiveClasses}";
        } elseif ($active) {
            $classes .= " {$activeClasses}";
        } else {
            $classes .= " {$inactiveClasses}";
        }
        return "<a href=\"" . ($disabled ? '#' : url()->current() . '?page=' . $page) . "\" class=\"{$classes}\" " . ($active ? 'aria-current="page"' : '') . ">{$label}</a>";
    }
@endphp

@if ($paginator->hasPages())
    <nav
        role="navigation"
        aria-label="Pagination"
        {{ $attributes->merge(['class' => "flex items-center justify-between {$sizeClasses}"]) }}
    >
        {{-- Info --}}
        @if ($showInfo)
            <p class="text-sm text-text-secondary">
                Showing
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-medium">{{ $paginator->total() }}</span>
                results
            </p>
        @endif

        {{-- Buttons --}}
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center {{ $buttonSize }} rounded-lg border border-border bg-surface text-text-secondary opacity-40 cursor-not-allowed">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center {{ $buttonSize }} rounded-lg border border-border bg-surface text-text hover:bg-surface-secondary transition-colors duration-100 focus:outline-none focus:ring-2 focus:ring-primary-500" rel="prev" aria-label="Previous page">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                </a>
            @endif

            {{-- Pages --}}
            @if (!$simple)
                @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex items-center justify-center {{ $buttonSize }} rounded-lg bg-primary-500 text-white font-medium focus:outline-none focus:ring-2 focus:ring-primary-500" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center {{ $buttonSize }} rounded-lg border border-border bg-surface text-text hover:bg-surface-secondary transition-colors duration-100 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $page }}</a>
                    @endif
                @endforeach
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center {{ $buttonSize }} rounded-lg border border-border bg-surface text-text hover:bg-surface-secondary transition-colors duration-100 focus:outline-none focus:ring-2 focus:ring-primary-500" rel="next" aria-label="Next page">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </a>
            @else
                <span class="inline-flex items-center justify-center {{ $buttonSize }} rounded-lg border border-border bg-surface text-text-secondary opacity-40 cursor-not-allowed">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </span>
            @endif
        </div>
    </nav>
@endif

