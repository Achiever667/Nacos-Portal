@props([
    'label' => null,
    'description' => null,
    'name' => null,
    'id' => null,
    'value' => '1',
    'checked' => false,
    'indeterminate' => false,
    'disabled' => false,
    'required' => false,
    'error' => null,
])

@php
    $inputId = $id ?? $name ?? 'checkbox-' . md5($attributes->get('name', uniqid()));
    $hasError = $error || ($name && $errors->has($name));

    $checkboxClasses = [
        'size-4 rounded border transition-all duration-150',
        'text-primary-500 focus:ring-2 focus:ring-primary-500/30 focus:ring-offset-0',
        'disabled:cursor-not-allowed disabled:opacity-50',
    ];

    if ($hasError) {
        $checkboxClasses[] = 'border-danger-500';
    } else {
        $checkboxClasses[] = 'border-border hover:border-neutral-400 dark:hover:border-neutral-500';
    }

    $checkboxClassString = implode(' ', $checkboxClasses);
@endphp

<label
    for="{{ $inputId }}"
    class="inline-flex items-start gap-3 {{ $disabled ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
    @if ($indeterminate)
        x-data
        x-init="$el.querySelector('input').indeterminate = true"
    @endif
>
    {{-- Checkbox input --}}
    <input
        type="checkbox"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
        @disabled($disabled)
        @required($required)
        {{ $attributes->merge(['class' => $checkboxClassString])->exceptProps([
            'label', 'description', 'name', 'id', 'value', 'checked',
            'indeterminate', 'disabled', 'required', 'error'
        ]) }}
        aria-invalid="{{ $hasError ? 'true' : 'false' }}"
        aria-describedby="{{ $hasError && $name ? $inputId . '-error' : '' }}"
    />

    {{-- Label content --}}
    <div class="space-y-0.5">
        @if ($label)
            <span class="text-sm font-medium text-text">{{ $label }}</span>
        @endif
        @if ($description)
            <p class="text-sm text-text-secondary">{{ $description }}</p>
        @endif
    </div>
</label>

{{-- Error --}}
@if ($hasError && $name)
    <p id="{{ $inputId }}-error" class="mt-1 text-sm text-danger-500" role="alert">
        {{ $error ?? $errors->first($name) }}
    </p>
@endif

