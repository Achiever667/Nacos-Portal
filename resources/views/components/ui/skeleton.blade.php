@props([
    'variant' => 'text', // text, avatar, card, table, list
    'lines' => 3,
    'width' => null,
    'height' => null,
    'rounded' => true,
])

@php
    $baseClass = 'animate-pulse bg-neutral-200 dark:bg-neutral-700';

    if ($rounded) {
        $roundedClass = 'rounded-md';
    } else {
        $roundedClass = '';
    }
@endphp

<div {{ $attributes->merge(['class' => 'space-y-3 w-full', 'aria-hidden' => 'true', 'role' => 'presentation']) }}>
    @switch($variant)
        @case('avatar')
            <div class="flex items-center gap-4">
                <div class="shrink-0 size-12 {{ $baseClass }} rounded-full"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-4 {{ $baseClass }} {{ $roundedClass }} w-1/3"></div>
                    <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-1/2"></div>
                </div>
            </div>
            @break

        @case('card')
            <div class="border border-border rounded-xl overflow-hidden">
                <div class="h-48 {{ $baseClass }} {{ $rounded ? '' : 'rounded-none' }}"></div>
                <div class="p-4 space-y-3">
                    <div class="h-4 {{ $baseClass }} {{ $roundedClass }} w-3/4"></div>
                    <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-full"></div>
                    <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-2/3"></div>
                    <div class="flex gap-2 pt-2">
                        <div class="h-8 {{ $baseClass }} {{ $roundedClass }} w-20"></div>
                        <div class="h-8 {{ $baseClass }} {{ $roundedClass }} w-20"></div>
                    </div>
                </div>
            </div>
            @break

        @case('table')
            <div class="space-y-2">
                <div class="flex gap-4">
                    <div class="h-4 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                    <div class="h-4 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                    <div class="h-4 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                    <div class="h-4 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                </div>
                @for ($i = 0; $i < $lines; $i++)
                    <div class="flex gap-4 pt-2 border-t border-border">
                        <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                        <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                        <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                        <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-1/4"></div>
                    </div>
                @endfor
            </div>
            @break

        @case('list')
            <div class="space-y-3">
                @for ($i = 0; $i < $lines; $i++)
                    <div class="flex items-center gap-3">
                        <div class="size-8 {{ $baseClass }} rounded-full shrink-0"></div>
                        <div class="flex-1 space-y-1.5">
                            <div class="h-3 {{ $baseClass }} {{ $roundedClass }} w-3/5"></div>
                            <div class="h-2.5 {{ $baseClass }} {{ $roundedClass }} w-2/5"></div>
                        </div>
                    </div>
                @endfor
            </div>
            @break

        @default
            {{-- Text skeleton --}}
            <div class="space-y-2.5">
                @for ($i = 0; $i < $lines; $i++)
                    <div
                        class="h-3 {{ $baseClass }} {{ $roundedClass }}"
                        style="width: {{ $width ?? (rand(60, 100) . '%') }}"
                    ></div>
                @endfor
            </div>
    @endswitch
</div>

