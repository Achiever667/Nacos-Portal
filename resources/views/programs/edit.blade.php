<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">Edit program</h1>
                <p class="mt-1 text-sm text-text-secondary">Update the program overview, status, or department.</p>
            </div>
            <a href="{{ route('programs.show', $program) }}" class="inline-flex items-center rounded-2xl border border-border bg-surface px-4 py-2 text-sm text-text transition hover:border-primary-300 hover:bg-surface-secondary">Back to program</a>
        </div>
    </x-slot>

    @if ($errors->any())
        <x-ui.alert variant="danger" title="Validation error" class="mb-6">
            <ul class="mt-2 text-sm text-text-secondary space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ui.alert>
    @endif

    <x-ui.card shadow>
        <x-slot name="header">
            <p class="text-base font-semibold text-text">Program details</p>
        </x-slot>

        <form method="POST" action="{{ route('programs.update', $program) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <x-ui.input label="Program name" name="name" value="{{ old('name', $program->name) }}" required />
                <x-ui.input label="Program code" name="code" value="{{ old('code', $program->code) }}" required helper="A short, unique program identifier." />
                <x-ui.select
                    label="Department"
                    name="department"
                    :options="array_combine($departments, $departments)"
                    selected="{{ old('department', $program->department) }}"
                    placeholder="Choose a department"
                    required
                />
                <x-ui.select
                    label="Status"
                    name="is_active"
                    :options="['1' => 'Active', '0' => 'Inactive']"
                    selected="{{ old('is_active', $program->is_active ? '1' : '0') }}"
                    required
                />
                <x-ui.textarea label="Program overview" name="overview" required>{{ old('overview', $program->overview) }}</x-ui.textarea>
                <x-ui.textarea label="Career opportunities" name="career_opportunities">{{ old('career_opportunities', $program->career_opportunities) }}</x-ui.textarea>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-text-secondary">Changes to this program will be reflected in student-facing content and administrative reports.</p>
                <div class="flex flex-wrap gap-3">
                    <x-ui.button type="submit" variant="primary">Save changes</x-ui.button>
                    <a href="{{ route('programs.show', $program) }}" class="inline-flex items-center rounded-2xl border border-border bg-surface px-4 py-2 text-sm text-text transition hover:border-primary-300 hover:bg-surface-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
