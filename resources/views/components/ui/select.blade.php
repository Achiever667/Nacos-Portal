@props([
    'label' => null,
    'placeholder' => null,
    'helper' => null,
    'error' => null,
    'disabled' => false,
    'required' => false,
    'name' => null,
    'id' => null,
    'options' => [],
    'selected' => null,
    'searchable' => false,
    'grouped' => false,
    'multiple' => false,
    'placeholder' => null,
])

@php
    $inputId = $id ?? $name ?? 'select-' . md5($attributes->get('name', uniqid()));
    $hasError = $error || $errors->has($name);

    $selectClasses = [
        'block w-full rounded-lg border px-3 py-2 text-sm transition-all duration-150 appearance-none',
        'bg-surface text-text',
        'focus:outline-none focus:ring-2 focus:ring-offset-0',
        'disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-neutral-100 dark:disabled:bg-neutral-800',
        'pr-10', // space for chevron
    ];

    if ($hasError) {
        $selectClasses[] = 'border-danger-500 focus:border-danger-500 focus:ring-danger-500/30';
    } else {
        $selectClasses[] = 'border-border focus:border-primary-500 focus:ring-primary-500/30 hover:border-neutral-300 dark:hover:border-neutral-600';
    }

    $selectClassString = implode(' ', $selectClasses);
@endphp

<div class="w-full" x-data="{ 
    open: false, 
    selected: '{{ old($name, $selected) }}',
    search: ''
}" @if ($searchable) x-init="$watch('selected', val => { if(val) { let opt = $el.querySelector(`option[value=\"${val}\"]`); if(opt) search = opt.textContent } })" @endif>
    {{-- Label --}}
    @if ($label)
        <label for="{{ $inputId }}" class="block mb-1.5 text-sm font-medium text-text">
            {{ $label }}
            @if ($required)
                <span class="text-danger-500 ms-0.5" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    {{-- Native select (fallback and form submission) --}}
    <div class="relative">
        <select
            id="{{ $inputId }}"
            name="{{ $name }}"
            @disabled($disabled)
            @required($required)
            @if ($multiple) multiple @endif
            {{ $attributes->merge(['class' => $selectClassString])->exceptProps([
                'label', 'placeholder', 'helper', 'error', 'disabled', 'required',
                'name', 'id', 'options', 'selected', 'searchable', 'grouped', 'multiple'
            ]) }}
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            aria-describedby="{{ $hasError ? $inputId . '-error' : ($helper ? $inputId . '-helper' : '') }}"
        >
            @if ($placeholder)
                <option value="" disabled {{ old($name, $selected) ? '' : 'selected' }}>{{ $placeholder }}</option>
            @endif

            @if ($grouped)
                @foreach ($options as $groupLabel => $groupOptions)
                    <optgroup label="{{ $groupLabel }}">
                        @foreach ($groupOptions as $value => $text)
                            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>{{ $text }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            @else
                @foreach ($options as $value => $text)
                    <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            @endif
        </select>

        {{-- Chevron icon --}}
        <div class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-neutral-400" aria-hidden="true">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>

    {{-- Error --}}
    @if ($hasError)
        <p id="{{ $inputId }}-error" class="mt-1.5 text-sm text-danger-500" role="alert">
            {{ $error ?? $errors->first($name) }}
        </p>
    @endif

    {{-- Helper --}}
    @if ($helper && !$hasError)
        <p id="{{ $inputId }}-helper" class="mt-1.5 text-sm text-text-secondary">
            {{ $helper }}
        </p>
    @endif
</div>

