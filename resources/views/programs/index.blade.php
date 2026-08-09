<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">Programs</h1>
                <p class="mt-1 text-sm text-text-secondary">Manage academic programs and their institutional descriptions.</p>
            </div>
            @can('create programs')
                <x-ui.button href="{{ route('programs.create') }}" variant="primary">Add program</x-ui.button>
            @endcan
        </div>
    </x-slot>

    @if (session('success'))
        <x-ui.alert variant="success" title="Success" description="{{ session('success') }}" class="mb-6" />
    @endif

    <x-ui.card shadow>
        <x-slot name="header">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-base font-semibold text-text">Program catalog</p>
                    <p class="mt-1 text-sm text-text-secondary">Search available programs and review objectives, departments, and status.</p>
                </div>
                <form method="GET" action="{{ route('programs.index') }}" class="w-full sm:w-auto">
                    <x-ui.input
                        name="search"
                        placeholder="Search programs, codes, department"
                        value="{{ $search ?? '' }}"
                        type="search"
                        helper="Search by program name, code, or department."
                        class="max-w-md"
                    />
                </form>
            </div>
        </x-slot>

        @if ($programs->isEmpty())
            <x-ui.empty-state
                title="No programs found"
                description="There are no programs matching your current filters. Add a new program to begin onboarding students."
                actionUrl="{{ route('programs.create') }}"
                actionText="Add program"
                class="px-6 py-12"
            />
        @else
            <div class="overflow-hidden rounded-3xl border border-border bg-surface">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border text-left text-sm">
                        <thead class="bg-surface-secondary text-text-secondary">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Program</th>
                                <th class="px-6 py-4 font-semibold">Code</th>
                                <th class="px-6 py-4 font-semibold">Department</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border bg-surface">
                            @foreach ($programs as $program)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-text">{{ $program->name }}</div>
                                        <div class="mt-1 text-sm text-text-secondary">{{ \Illuminate\Support\Str::limit($program->overview, 75) }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-text-secondary">{{ $program->code }}</td>
                                    <td class="px-6 py-4 text-text-secondary">{{ $program->department }}</td>
                                    <td class="px-6 py-4">
                                        <x-ui.badge :variant="$program->is_active ? 'success' : 'neutral'" size="sm">{{ $program->is_active ? 'Active' : 'Inactive' }}</x-ui.badge>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <x-ui.button href="{{ route('programs.show', $program) }}" variant="outline" size="sm">View</x-ui.button>
                                            @can('edit programs')
                                                <x-ui.button href="{{ route('programs.edit', $program) }}" variant="secondary" size="sm">Edit</x-ui.button>
                                            @endcan
                                            @can('delete programs')
                                                <form method="POST" action="{{ route('programs.destroy', $program) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-ui.button type="submit" variant="danger" size="sm" onclick="return confirm('Delete this program?')">Delete</x-ui.button>
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
                    {{ $programs->links() }}
                </div>
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
