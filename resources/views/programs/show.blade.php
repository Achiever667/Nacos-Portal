<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">{{ $program->name }}</h1>
                <p class="mt-1 text-sm text-text-secondary">Program details, outcomes, and career focus.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('programs.index') }}" class="inline-flex items-center rounded-2xl border border-border bg-surface px-4 py-2 text-sm text-text transition hover:border-primary-300 hover:bg-surface-secondary">Back to programs</a>
                @can('edit programs')
                    <x-ui.button href="{{ route('programs.edit', $program) }}" variant="primary">Edit program</x-ui.button>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[1.4fr_0.8fr]">
        <x-ui.card shadow>
            <x-slot name="header">
                <div>
                    <p class="text-base font-semibold text-text">Program summary</p>
                    <p class="mt-1 text-sm text-text-secondary">A clean view of the program's description, department, and career support.</p>
                </div>
            </x-slot>

            <div class="space-y-6">
                <div>
                    <p class="text-sm font-semibold text-text-secondary">Program code</p>
                    <p class="mt-2 text-text">{{ $program->code }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-text-secondary">Department</p>
                    <p class="mt-2 text-text">{{ $program->department }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-text-secondary">Overview</p>
                    <p class="mt-3 text-text leading-7">{{ $program->overview }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-text-secondary">Career opportunities</p>
                    <p class="mt-3 text-text leading-7">{{ $program->career_opportunities }}</p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card shadow>
            <x-slot name="header">
                <p class="text-base font-semibold text-text">Program status</p>
            </x-slot>

            <div class="space-y-4">
                <div class="rounded-3xl border border-border bg-surface p-4">
                    <p class="text-sm font-semibold text-text-secondary">Availability</p>
                    <div class="mt-3">
                        <x-ui.badge :variant="$program->is_active ? 'success' : 'neutral'" size="md">{{ $program->is_active ? 'Active' : 'Inactive' }}</x-ui.badge>
                    </div>
                </div>

                <div class="rounded-3xl border border-border bg-surface p-4">
                    <p class="text-sm font-semibold text-text-secondary">Accessible link</p>
                    <p class="mt-2 text-text">{{ route('programs.show', $program) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-app-layout>
