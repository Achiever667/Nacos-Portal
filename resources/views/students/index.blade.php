<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">Students</h1>
                <p class="mt-1 text-sm text-text-secondary">Browse and manage student profiles for the NACOS community.</p>
            </div>
            @can('create students')
                <x-ui-button href="{{ route('students.create') }}" variant="primary">
                    Add student
                </x-ui-button>
            @endcan
        </div>
    </x-slot>

    @if (session('success'))
        <x-ui-alert variant="success" title="Success" description="{{ session('success') }}" class="mb-6" />
    @endif

    <x-ui-card shadow>
        <x-slot name="header">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-base font-semibold text-text">Student directory</p>
                    <p class="mt-1 text-sm text-text-secondary">Search, review, and update student records.</p>
                </div>

                <form method="GET" action="{{ route('students.index') }}" class="w-full sm:w-auto">
                    <x-ui-input
                        name="search"
                        placeholder="Search students, registration, email"
                        value="{{ $search ?? '' }}"
                        type="search"
                        helper="Search by name, email, registration number, or department."
                        class="max-w-md"
                    />
                </form>
            </div>
        </x-slot>

        @if ($students->isEmpty())
            <x-ui-empty-state
                title="No students found"
                description="Try refining your search or add a new student to begin building your directory."
                actionUrl="{{ route('students.create') }}"
                actionText="Add student"
                class="px-6 py-12"
            />
        @else
            <div class="overflow-hidden rounded-3xl border border-border bg-surface">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border text-left text-sm">
                        <thead class="bg-surface-secondary text-text-secondary">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Student</th>
                                <th class="px-6 py-4 font-semibold">Registration</th>
                                <th class="px-6 py-4 font-semibold">Program</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border bg-surface">
                            @foreach ($students as $student)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-text">{{ $student->first_name }} {{ $student->last_name }}</div>
                                        <div class="mt-1 text-sm text-text-secondary">{{ $student->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-text-secondary">{{ $student->registration_number }}</td>
                                    <td class="px-6 py-4 text-text-secondary">{{ $student->department }}, Level {{ $student->level }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusVariant = match ($student->status) {
                                                'active' => 'success',
                                                'inactive' => 'warning',
                                                'alumni' => 'info',
                                                default => 'neutral',
                                            };
                                        @endphp
                                        <x-ui-badge :variant="$statusVariant" size="sm">{{ ucfirst($student->status) }}</x-ui-badge>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <x-ui-button href="{{ route('students.show', $student) }}" variant="outline" size="sm">View</x-ui-button>
                                            @can('edit students')
                                                <x-ui-button href="{{ route('students.edit', $student) }}" variant="secondary" size="sm">Edit</x-ui-button>
                                            @endcan
                                            @can('delete students')
                                                <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-ui-button type="submit" variant="danger" size="sm" onclick="return confirm('Remove this student?')">Delete</x-ui-button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-border bg-surface-secondary px-6 py-4">
                    {{ $students->links() }}
                </div>
            </div>
        @endif
    </x-ui-card>
</x-app-layout>
