<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">Add student</h1>
                <p class="mt-1 text-sm text-text-secondary">Create a new student profile in the NACOS portal.</p>
            </div>
            <a href="{{ route('students.index') }}" class="inline-flex items-center rounded-2xl border border-border bg-surface px-4 py-2 text-sm text-text transition hover:border-primary-300 hover:bg-surface-secondary">Back to students</a>
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
            <p class="text-base font-semibold text-text">Student details</p>
        </x-slot>

        <form method="POST" action="{{ route('students.store') }}" class="space-y-6">
            @csrf

            <div class="grid gap-6 lg:grid-cols-2">
                <x-ui.input label="First name" name="first_name" value="{{ old('first_name') }}" required />
                <x-ui.input label="Last name" name="last_name" value="{{ old('last_name') }}" required />
                <x-ui.input label="Email address" name="email" type="email" value="{{ old('email') }}" required />
                <x-ui.input label="Phone number" name="phone" value="{{ old('phone') }}" />
                <x-ui.input label="Registration number" name="registration_number" value="{{ old('registration_number') }}" required helper="Unique student ID for campus records." />
                <x-ui.select
                    label="Department"
                    name="department"
                    :options="array_combine($departments, $departments)"
                    selected="{{ old('department') }}"
                    placeholder="Choose a department"
                    required
                />
                <x-ui.select
                    label="Level"
                    name="level"
                    :options="['100' => '100', '200' => '200', '300' => '300', '400' => '400', '500' => '500']"
                    selected="{{ old('level') }}"
                    placeholder="Choose a level"
                    required
                />
                <x-ui.select
                    label="Status"
                    name="status"
                    :options="['active' => 'Active', 'inactive' => 'Inactive', 'alumni' => 'Alumni']"
                    selected="{{ old('status', 'active') }}"
                    required
                />
                <x-ui.input label="Date of birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" />
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-text-secondary">Student profiles are used for enrollment and reporting across NACOS services.</p>
                <div class="flex flex-wrap gap-3">
                    <x-ui.button type="submit" variant="primary">Save student</x-ui.button>
                    <a href="{{ route('students.index') }}" class="inline-flex items-center rounded-2xl border border-border bg-surface px-4 py-2 text-sm text-text transition hover:border-primary-300 hover:bg-surface-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
