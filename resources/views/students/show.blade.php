<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">{{ $student->first_name }} {{ $student->last_name }}</h1>
                <p class="mt-1 text-sm text-text-secondary">Student profile details and academic status.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('students.index') }}" class="inline-flex items-center rounded-2xl border border-border bg-surface px-4 py-2 text-sm text-text transition hover:border-primary-300 hover:bg-surface-secondary">Back to students</a>
                @can('edit students')
                    <x-ui.button href="{{ route('students.edit', $student) }}" variant="primary">Edit profile</x-ui.button>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
        <x-ui.card shadow>
            <x-slot name="header">
                <div>
                    <p class="text-base font-semibold text-text">Profile overview</p>
                    <p class="mt-1 text-sm text-text-secondary">Review the student's registration data and status.</p>
                </div>
            </x-slot>

            <div class="space-y-6">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Full name</p>
                        <p class="mt-2 text-text">{{ $student->first_name }} {{ $student->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Registration number</p>
                        <p class="mt-2 text-text">{{ $student->registration_number }}</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Email</p>
                        <p class="mt-2 text-text">{{ $student->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Phone</p>
                        <p class="mt-2 text-text">{{ $student->phone ?? 'Not provided' }}</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Department</p>
                        <p class="mt-2 text-text">{{ $student->department }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Level</p>
                        <p class="mt-2 text-text">{{ $student->level }}</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Status</p>
                        <div class="mt-2">
                            <x-ui.badge :variant="$student->status === 'active' ? 'success' : ($student->status === 'inactive' ? 'warning' : 'info')" size="sm">{{ ucfirst($student->status) }}</x-ui.badge>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text-secondary">Date of birth</p>
                        <p class="mt-2 text-text">{{ optional($student->date_of_birth)->format('F j, Y') ?? 'Unknown' }}</p>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card shadow>
            <x-slot name="header">
                <p class="text-base font-semibold text-text">Quick actions</p>
            </x-slot>

            <div class="space-y-3">
                @can('edit students')
                    <x-ui.button href="{{ route('students.edit', $student) }}" variant="secondary" full>Edit student</x-ui.button>
                @endcan
                <x-ui.button href="{{ route('students.index') }}" variant="ghost" full>Return to directory</x-ui.button>
            </div>
        </x-ui.card>
    </div>
</x-app-layout>
