@props([
    'tabs' => [],
    'default' => null,
    'variant' => 'underline', // underline, pills, segmented
    'full' => false,
    'name' => 'tabs-' . md5(uniqid()),
])

@php
    $variantClasses = match ($variant) {
        'pills' => 'gap-1',
        'segmented' => 'bg-surface-secondary p-1 rounded-lg gap-0',
        default => 'border-b border-border gap-0',
    };

    $tabClasses = match ($variant) {
        'pills' => 'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-150 cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500',
        'segmented' => 'px-4 py-2 rounded-md text-sm font-medium transition-all duration-150 cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500',
        default => 'px-4 py-2.5 text-sm font-medium border-b-2 border-transparent -mb-px transition-all duration-150 cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-t-lg',
    };

    $activeTabClasses = match ($variant) {
        'pills' => 'bg-primary-500 text-white',
        'segmented' => 'bg-surface text-text shadow-sm',
        default => 'text-primary-500 border-primary-500',
    };

    $inactiveTabClasses = match ($variant) {
        'pills' => 'text-text-secondary hover:text-text hover:bg-surface-secondary',
        'segmented' => 'text-text-secondary hover:text-text',
        default => 'text-text-secondary hover:text-text hover:border-neutral-300 dark:hover:border-neutral-600',
    };
@endphp

<div x-data="{ activeTab: '{{ $default ?? ($tabs[0]['id'] ?? $tabs[0]['label'] ?? 'tab-0') }}' }" {{ $attributes->merge(['class' => 'w-full']) }}>
    {{-- Tab list --}}
    <div
        class="flex {{ $full ? 'w-full' : '' }} {{ $variantClasses }}"
        role="tablist"
        aria-orientation="horizontal"
    >
        @foreach ($tabs as $index => $tab)
            @php
                $tabId = $tab['id'] ?? 'tab-' . $index;
                $tabLabel = $tab['label'] ?? $tab;
                $tabDisabled = $tab['disabled'] ?? false;
            @endphp
            <button
                type="button"
                role="tab"
                :aria-selected="activeTab === '{{ $tabId }}'"
                aria-controls="tabpanel-{{ $tabId }}"
                id="tab-{{ $tabId }}"
                @click="activeTab = '{{ $tabId }}'"
                @keydown.home.prevent="$el.closest('[role=tablist]').firstElementChild.focus()"
                @keydown.end.prevent="$el.closest('[role=tablist]').lastElementChild.focus()"
                @keydown.left.prevent="$el.previousElementSibling?.focus()"
                @keydown.right.prevent="$el.nextElementSibling?.focus()"
                :tabindex="activeTab === '{{ $tabId }}' ? '0' : '-1'"
                @disabled($tabDisabled)
                class="{{ $tabClasses }} {{ $full ? 'flex-1 text-center' : '' }}"
                :class="{ '{{ $activeTabClasses }}': activeTab === '{{ $tabId }}', '{{ $inactiveTabClasses }}': activeTab !== '{{ $tabId }}' }"
            >
                @if (isset($tab['icon']))
                    <span class="inline-flex items-center gap-2">
                        <span class="size-4">{!! $tab['icon'] !!}</span>
                        {{ $tabLabel }}
                    </span>
                @else
                    {{ $tabLabel }}
                @endif
            </button>
        @endforeach
    </div>

    {{-- Tab panels --}}
    @foreach ($tabs as $index => $tab)
        @php
            $tabId = $tab['id'] ?? 'tab-' . $index;
            $tabContent = $tab['content'] ?? '';
        @endphp
        <div
            x-show="activeTab === '{{ $tabId }}'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            role="tabpanel"
            id="tabpanel-{{ $tabId }}"
            aria-labelledby="tab-{{ $tabId }}"
            class="py-4 focus:outline-none"
        >
            {{ $tabContent }}
            {{-- Allow panel slot override --}}
            @isset(${"panel-" . $tabId})
                {{ ${"panel-" . $tabId} }}
            @endisset
        </div>
    @endforeach

    {{-- Slot fallback for custom panel usage --}}
    {{ $slot }}
</div>

