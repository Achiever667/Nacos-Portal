@props([
    'label' => null,
    'description' => null,
    'name' => null,
    'id' => null,
    'value' => null,
    'checked' => false,
    'disabled' => false,
    'required' => false,
    'inline' => false,
    'error' => null,
])

@php
    $inputId = $id ?? $name . '-' . $value ?? 'radio-' . md5(uniqid());
    $hasError = $error || ($name && $errors->has($name));

    $radioClasses = [
        'size-4 border-2 transition-all duration-150',
        'text-primary-500 focus:ring-2 focus:ring-primary-500/30 focus:ring-offset-0',
        'disabled:cursor-not-allowed disabled:opacity-50',
    ];

    if ($hasError) {
        $radioClasses[] = 'border-danger-500';
    } else {
        $radioClasses[] = 'border-border hover:border-neutral-400 dark:hover:border-neutral-500';
    }

    $radioClassString = implode(' ', $radioClasses);
@endphp

<label
    for="{{ $inputId }}"
    class="inline-flex items-start gap-3 {{ $disabled ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
>
    <input
        type="radio"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
        @disabled($disabled)
        @required($required)
        {{ $attributes->merge(['class' => $radioClassString])->exceptProps([
            'label', 'description', 'name', 'id', 'value', 'checked',
            'disabled', 'required', 'inline', 'error'
        ]) }}
        aria-invalid="{{ $hasError ? 'true' : 'false' }}"
        aria-describedby="{{ $hasError && $name ? $inputId . '-error' : '' }}"
    />

    <div class="space-y-0.5">
        @if ($label)
            <span class="text-sm font-medium text-text">{{ $label }}</span>
        @endif
        @if ($description)
            <p class="text-sm text-text-secondary">{{ $description }}</p>
        @endif
    </div>
</label>

@if ($hasError && $name)
    <p id="{{ $inputId }}-error" class="mt-1 text-sm text-danger-500" role="alert">
        {{ $error ?? $errors->first($name) }}
    </p>
@endif

