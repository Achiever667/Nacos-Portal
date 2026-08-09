<x-app-layout>
    <x-slot name="header">
        <div class="space-y-3">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-text">Dashboard</h1>
                    <p class="mt-2 text-sm text-text-secondary max-w-2xl">Welcome to the NACOS administrative portal. Manage student services, billing, verification, and events from a unified interface.</p>
                </div>
                <div class="inline-flex items-center gap-2 rounded-2xl border border-border bg-surface px-4 py-3 text-sm text-text shadow-sm">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <div>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-text-secondary">{{ ucwords(str_replace('-', ' ', auth()->user()->getRoleNames()->first() ?? 'member')) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        // Dummy notifications array.
        $notifications = [
            [
                'icon' => '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'iconBg' => 'bg-primary-50 text-primary-700',
                'title' => 'New student registered',
                'description' => 'A new student account was created and is awaiting verification.',
                'time' => '2 minutes ago',
            ],
            [
                'icon' => '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                'iconBg' => 'bg-info-50 text-info-700',
                'title' => 'Meeting scheduled',
                'description' => 'The weekly executive meeting has been scheduled for Friday.',
                'time' => '1 hour ago',
            ],
            [
                'icon' => '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10Z"/><path d="M8 11h8"/><path d="M8 15h6"/></svg>',
                'iconBg' => 'bg-warning-50 text-warning-700',
                'title' => 'Support ticket received',
                'description' => 'A new support ticket has been submitted and requires attention.',
                'time' => '3 hours ago',
            ],
            [
                'icon' => '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M4 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg>',
                'iconBg' => 'bg-danger-50 text-danger-700',
                'title' => 'New executive on board',
                'description' => 'A new executive member has been added to the portal.',
                'time' => 'Yesterday',
            ],
        ];

        // Dummy stats for the global stat-card component.
        $stats = [
            [
                'title' => 'Registered members',
                'value' => number_format(\App\Models\User::count()),
                'description' => 'Total registered portal users and participants.',
                'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M4 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg>',
                'iconBg' => 'bg-primary-50 text-primary-700',
            ],
            [
                'title' => 'Assigned roles',
                'value' => number_format(\Spatie\Permission\Models\Role::count()),
                'description' => 'Roles are used to control who can access each area of the portal.',
                'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>',
                'iconBg' => 'bg-surface-secondary text-primary-700',
            ],
            [
                'title' => 'Permission policies',
                'value' => number_format(\Spatie\Permission\Models\Permission::count()),
                'description' => 'Granular permissions keep NACOS services secure and organized.',
                'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15v2"/><path d="M9 11h6"/><path d="M12 21a9 9 0 1 0-9-9 9 9 0 0 0 9 9Z"/></svg>',
                'iconBg' => 'bg-surface-secondary text-primary-700',
            ],
            [
                'title' => 'Unread alerts',
                'value' => number_format(count($notifications)),
                'description' => 'Notifications and requests waiting for your review.',
                'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 8-3 8h18s-3-1-3-8"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
                'iconBg' => 'bg-surface-secondary text-primary-700',
            ],
        ];
    @endphp

    {{-- Stat cards --}}
    <div class="grid gap-6 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <x-stat-card
                :title="$stat['title']"
                :value="$stat['value']"
                :description="$stat['description']"
                :icon="$stat['icon']"
                :icon-bg="$stat['iconBg']"
                shadow
                hover
            />
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.45fr_0.9fr]">
        {{-- Portal overview --}}
        <x-ui.card shadow>
            <x-slot name="header">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <p class="text-base font-semibold text-text">Portal overview</p>
                        <p class="mt-1 text-sm text-text-secondary">A clean, centralized view of NACOS student and admin operations.</p>
                    </div>
                    <x-ui.badge variant="primary" size="md">Live</x-ui.badge>
                </div>
            </x-slot>

            <div class="mt-6 space-y-6 text-sm text-text-secondary">
                <p>Use the left navigation to reach modules when they are available. The portal is built with permission-aware routing and a premium NACOS visual identity.</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-border bg-surface p-4">
                        <p class="text-sm font-semibold text-text">Secure by design</p>
                        <p class="mt-2">Role-based access control keeps sensitive data protected.</p>
                    </div>
                    <div class="rounded-3xl border border-border bg-surface p-4">
                        <p class="text-sm font-semibold text-text">Institutional trust</p>
                        <p class="mt-2">Designed for education and administrative workflows rooted in NACOS identity.</p>
                    </div>
                </div>
            </div>
        </x-ui.card>

        {{-- Notifications card using the dummy array --}}
        <x-ui.card shadow>
            <x-slot name="header">
                <div class="flex items-center justify-between gap-2">
                    <p class="text-base font-semibold text-text">Notifications</p>
                    <x-ui.badge variant="neutral" size="sm">{{ count($notifications) }} new</x-ui.badge>
                </div>
            </x-slot>

            <div class="mt-2 space-y-1">
                @forelse ($notifications as $notification)
                    <div class="flex items-start gap-3 rounded-2xl p-3 transition hover:bg-surface-secondary">
                        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl {{ $notification['iconBg'] }}">
                            {!! $notification['icon'] !!}
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-medium text-text">{{ $notification['title'] }}</p>
                                <span class="shrink-0 text-xs text-text-secondary">{{ $notification['time'] }}</span>
                            </div>
                            <p class="mt-1 text-sm text-text-secondary">{{ $notification['description'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="py-8 text-center text-sm text-text-secondary">You're all caught up.</p>
                @endforelse
            </div>
        </x-ui.card>
    </div>
</x-app-layout>
