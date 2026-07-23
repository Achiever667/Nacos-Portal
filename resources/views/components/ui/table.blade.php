@props([
    'headers' => [],
    'rows' => [],
    'striped' => false,
    'hover' => false,
    'loading' => false,
    'selectable' => false,
    'selected' => [],
    'variant' => 'simple', // simple, bordered, compact
    'responsive' => true,
])

@php
    $tableClasses = 'w-full text-sm text-left rtl:text-right text-text';

    $headerClasses = 'text-xs font-medium uppercase tracking-wider text-text-secondary';

    $variantClasses = match ($variant) {
        'bordered' => 'border border-border',
        'compact' => 'text-xs',
        default => '',
    };

    $rowClasses = 'border-b border-border transition-colors duration-100';

    if ($striped) {
        $stripedClass = 'even:bg-surface-secondary';
    } else {
        $stripedClass = '';
    }

    if ($hover) {
        $hoverClass = 'hover:bg-surface-secondary';
    } else {
        $hoverClass = '';
    }

    $cellClasses = match ($variant) {
        'compact' => 'px-3 py-2',
        default => 'px-4 py-3',
    };
@endphp

<div @if ($responsive) class="overflow-x-auto" @endif>
    <table {{ $attributes->merge(['class' => "{$tableClasses} {$variantClasses}"]) }}>
        {{-- Header --}}
        @if (count($headers) > 0)
            <thead class="{{ $headerClasses }}">
                <tr class="border-b border-border">
                    @if ($selectable)
                        <th scope="col" class="{{ $cellClasses }}">
                            <input
                                type="checkbox"
                                class="size-4 rounded border-border text-primary-500 focus:ring-primary-500"
                                x-data
                                @change="$el.closest('table').querySelectorAll('tbody input[type=checkbox]').forEach(cb => cb.checked = $el.checked)"
                                aria-label="Select all rows"
                            />
                        </th>
                    @endif
                    @foreach ($headers as $header)
                        <th scope="col" class="{{ $cellClasses }}">
                            {{ $header }}
                        </th>
                    @endforeach
                    @isset($actions)
                        <th scope="col" class="{{ $cellClasses }}">
                            <span class="sr-only">Actions</span>
                        </th>
                    @endisset
                </tr>
            </thead>
        @endif

        {{-- Body --}}
        <tbody>
            {{-- Loading state --}}
            @if ($loading)
                <tr>
                    <td colspan="{{ count($headers) + ($selectable ? 1 : 0) + (isset($actions) ? 1 : 0) }}" class="text-center py-12">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="animate-spin size-6 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" role="status" aria-label="Loading table data">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-text-secondary">Loading data...</span>
                        </div>
                    </td>
                </tr>
            @elseif (count($rows) > 0)
                @foreach ($rows as $index => $row)
                    <tr class="{{ $rowClasses }} {{ $stripedClass }} {{ $hoverClass }}">
                        @if ($selectable)
                            <td class="{{ $cellClasses }}">
                                <input
                                    type="checkbox"
                                    class="size-4 rounded border-border text-primary-500 focus:ring-primary-500"
                                    value="{{ $row['id'] ?? $index }}"
                                    @if (in_array($row['id'] ?? $index, $selected)) checked @endif
                                    aria-label="Select row {{ $index + 1 }}"
                                />
                            </td>
                        @endif
                        @foreach ($headers as $key => $header)
                            <td class="{{ $cellClasses }}">
                                {{ $row[$key] ?? $row[Str::slug($header, '_')] ?? '' }}
                            </td>
                        @endforeach
                        @isset($actions)
                            <td class="{{ $cellClasses }}">
                                {{ $actions($row, $index) }}
                            </td>
                        @endisset
                    </tr>
                @endforeach
            @else
                {{-- Empty state via slot --}}
                @if (trim($slot ?? ''))
                    <tr>
                        <td colspan="99" class="text-center py-12 text-text-secondary">
                            {{ $slot }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="99" class="text-center py-12">
                            <div class="flex flex-col items-center gap-2 text-text-secondary">
                                <svg class="size-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25m-2.25-2.25l-2.25-2.25m2.25 2.25l2.25 2.25" />
                                </svg>
                                <p class="text-sm">No data available</p>
                            </div>
                        </td>
                    </tr>
                @endif
            @endif
        </tbody>
    </table>
</div>

