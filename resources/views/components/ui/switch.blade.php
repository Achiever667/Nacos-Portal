@props([
    'label' => null,
    'description' => null,
    'name' => null,
    'id' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'model' => null,
    'error' => null,
])

@php
    $inputId = $id ?? $name ?? 'switch-' . md5($attributes->get('name', uniqid()));
    $hasError = $error || ($name && $errors->has($name));
@endphp

<label
    for="{{ $inputId }}"
    class="inline-flex items-center justify-between w-full gap-4 {{ $disabled ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
    @if ($model)
        x-data="{ on: {{ old($name, $checked) ? 'true' : 'false' }} }"
    @endif
>
    {{-- Label side --}}
    <div class="flex-1 space-y-0.5">
        @if ($label)
            <span class="text-sm font-medium text-text">{{ $label }}</span>
        @endif
        @if ($description)
            <p class="text-sm text-text-secondary">{{ $description }}</p>
        @endif
    </div>

    {{-- Toggle switch --}}
    <button
        type="button"
        role="switch"
        id="{{ $inputId }}"
        @if ($model) x-model="{{ $model }}" @endif
        @disabled($disabled)
        aria-checked="{{ old($name, $checked) ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => 'relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface ' . (old($name, $checked) ? 'bg-primary-500' : 'bg-neutral-300 dark:bg-neutral-600')])->exceptProps([
            'label', 'description', 'name', 'id', 'value', 'checked', 'disabled', 'model', 'error'
        ]) }}
        @if ($model)
            @click="on = !on"
            :class="{ 'bg-primary-500': on, 'bg-neutral-300 dark:bg-neutral-600': !on }"
        @endif
    >
        <span
            class="inline-block size-5 rounded-full bg-white shadow-sm ring-0 transition-transform duration-200 ease-in-out {{ old($name, $checked) ? 'translate-x-5' : 'translate-x-0.5' }}"
            @if ($model)
                :class="{ 'translate-x-5': on, 'translate-x-0.5': !on }"
            @endif
            aria-hidden="true"
        ></span>
    </button>

    {{-- Hidden input for form submission --}}
    <input type="hidden" name="{{ $name }}" value="0">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
        @disabled($disabled)
        class="sr-only"
        tabindex="-1"
        aria-hidden="true"
        @if ($model) :checked="on" @endif
    />
</label>

@if ($hasError && $name)
    <p id="{{ $inputId }}-error" class="mt-1 text-sm text-danger-500" role="alert">
        {{ $error ?? $errors->first($name) }}
    </p>
@endif

