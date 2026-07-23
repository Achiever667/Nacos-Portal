@props([
    'label' => null,
    'placeholder' => null,
    'helper' => null,
    'error' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'autofocus' => false,
    'name' => null,
    'id' => null,
    'value' => null,
    'maxLength' => null,
    'rows' => 3,
    'autoResize' => false,
    'showCounter' => false,
    'resize' => 'vertical', // none, vertical, horizontal, both
])

@php
    $inputId = $id ?? $name ?? 'textarea-' . md5($attributes->get('name', uniqid()));
    $hasError = $error || $errors->has($name);

    $resizeClass = match ($resize) {
        'none' => 'resize-none',
        'horizontal' => 'resize-x',
        'both' => 'resize',
        default => 'resize-y',
    };

    $inputClasses = [
        'block w-full rounded-lg border px-3 py-2 text-sm transition-all duration-150',
        'bg-surface text-text placeholder:text-neutral-400 dark:placeholder:text-neutral-500',
        'focus:outline-none focus:ring-2 focus:ring-offset-0',
        'disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-neutral-100 dark:disabled:bg-neutral-800',
        'readonly:cursor-default readonly:bg-neutral-50 dark:readonly:bg-neutral-800',
        $resizeClass,
    ];

    if ($hasError) {
        $inputClasses[] = 'border-danger-500 focus:border-danger-500 focus:ring-danger-500/30';
    } else {
        $inputClasses[] = 'border-border focus:border-primary-500 focus:ring-primary-500/30 hover:border-neutral-300 dark:hover:border-neutral-600';
    }

    $inputClassString = implode(' ', $inputClasses);
@endphp

<div class="w-full">
    {{-- Label + counter --}}
    <div class="flex items-center justify-between mb-1.5">
        @if ($label)
            <label for="{{ $inputId }}" class="text-sm font-medium text-text">
                {{ $label }}
                @if ($required)
                    <span class="text-danger-500 ms-0.5" aria-hidden="true">*</span>
                @endif
            </label>
        @endif
        @if ($showCounter && $maxLength)
            <span class="text-xs text-text-secondary" x-data="{ count: 0 }" x-text="count + ' / {{ $maxLength }}'"></span>
        @endif
    </div>

    {{-- Textarea --}}
    <textarea
        id="{{ $inputId }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @disabled($disabled)
        @readonly($readonly)
        @required($required)
        @if ($autofocus) autofocus @endif
        @if ($maxLength) maxlength="{{ $maxLength }}" @endif
        @if ($showCounter)
            x-data
            x-init="$watch('$el.value.length', val => count = val)"
            @input="count = $el.value.length"
        @endif
        @if ($autoResize)
            x-data="{ resize() { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px' } }"
            x-init="resize()"
            @input="resize()"
        @endif
        {{ $attributes->merge(['class' => $inputClassString])->exceptProps([
            'label', 'placeholder', 'helper', 'error', 'disabled', 'readonly',
            'required', 'autofocus', 'name', 'id', 'value', 'maxLength', 'rows',
            'autoResize', 'showCounter', 'resize'
        ]) }}
        aria-invalid="{{ $hasError ? 'true' : 'false' }}"
        aria-describedby="{{ $hasError ? $inputId . '-error' : ($helper ? $inputId . '-helper' : '') }}"
    >{{ old($name, $value) }}</textarea>

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
</div>

