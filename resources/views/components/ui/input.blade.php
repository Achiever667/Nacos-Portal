@props([
    'label' => null,
    'placeholder' => null,
    'hint' => null,
    'helper' => null,
    'prefix' => null,
    'suffix' => null,
    'leadingIcon' => null,
    'trailingIcon' => null,
    'error' => null,
    'success' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'autofocus' => false,
    'name' => null,
    'id' => null,
    'type' => 'text',
    'value' => null,
    'model' => null,
])

@php
    $inputId = $id ?? $name ?? 'input-' . md5($attributes->get('name', uniqid()));
    $hasError = $error || $errors->has($name);
    $hasSuccess = $success && !$hasError;

    // Base input classes
    $inputClasses = [
        'block w-full rounded-lg border px-3 py-2 text-sm transition-all duration-150',
        'bg-surface text-text placeholder:text-neutral-400 dark:placeholder:text-neutral-500',
        'focus:outline-none focus:ring-2 focus:ring-offset-0',
        'disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-neutral-100 dark:disabled:bg-neutral-800',
        'readonly:cursor-default readonly:bg-neutral-50 dark:readonly:bg-neutral-800',
    ];

    if ($hasError) {
        $inputClasses[] = 'border-danger-500 focus:border-danger-500 focus:ring-danger-500/30';
    } elseif ($hasSuccess) {
        $inputClasses[] = 'border-success-500 focus:border-success-500 focus:ring-success-500/30';
    } else {
        $inputClasses[] = 'border-border focus:border-primary-500 focus:ring-primary-500/30 hover:border-neutral-300 dark:hover:border-neutral-600';
    }

    if ($leadingIcon || $prefix) {
        $inputClasses[] = 'ps-10';
    }

    if ($trailingIcon || $suffix) {
        $inputClasses[] = 'pe-10';
    }

    $inputClassString = implode(' ', $inputClasses);
@endphp

<div class="w-full">
    {{-- Label --}}
    @if ($label)
        <label for="{{ $inputId }}" class="block mb-1.5 text-sm font-medium text-text">
            {{ $label }}
            @if ($required)
                <span class="text-danger-500 ms-0.5" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    {{-- Input wrapper --}}
    <div class="relative">
        {{-- Leading icon --}}
        @if ($leadingIcon)
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-neutral-400 peer-disabled:opacity-50" aria-hidden="true">
                <span class="size-4">{!! $leadingIcon !!}</span>
            </div>
        @endif

        {{-- Prefix text --}}
        @if ($prefix)
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-neutral-500 text-sm" aria-hidden="true">
                <span class="text-neutral-400">{{ $prefix }}</span>
            </div>
        @endif

        {{-- The input --}}
        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @disabled($disabled)
            @readonly($readonly)
            @required($required)
            @if ($autofocus) autofocus @endif
            @if ($model) x-model="{{ $model }}" @endif
            {{ $attributes->merge(['class' => $inputClassString])->exceptProps([
                'label', 'placeholder', 'hint', 'helper', 'prefix', 'suffix',
                'leadingIcon', 'trailingIcon', 'error', 'success', 'disabled',
                'readonly', 'required', 'autofocus', 'name', 'id', 'type', 'value', 'model'
            ]) }}
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            aria-describedby="{{ $hasError ? $inputId . '-error' : ($helper ? $inputId . '-helper' : '') }}"
        />

        {{-- Trailing icon --}}
        @if ($trailingIcon)
            <div class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-neutral-400" aria-hidden="true">
                <span class="size-4">{!! $trailingIcon !!}</span>
            </div>
        @endif

        {{-- Suffix text --}}
        @if ($suffix)
            <div class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-neutral-500 text-sm" aria-hidden="true">
                <span class="text-neutral-400">{{ $suffix }}</span>
            </div>
        @endif
    </div>

    {{-- Error message --}}
    @if ($hasError)
        <p id="{{ $inputId }}-error" class="mt-1.5 text-sm text-danger-500" role="alert">
            {{ $error ?? $errors->first($name) }}
        </p>
    @endif

    {{-- Helper text --}}
    @if ($helper && !$hasError)
        <p id="{{ $inputId }}-helper" class="mt-1.5 text-sm text-text-secondary">
            {{ $helper }}
        </p>
    @endif

    {{-- Hint (legacy support) --}}
    @if ($hint && !$hasError && !$helper)
        <p class="mt-1.5 text-sm text-text-secondary">
            {{ $hint }}
        </p>
    @endif
</div>

