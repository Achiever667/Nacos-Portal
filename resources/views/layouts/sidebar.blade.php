@php
    $navSections = [
        [
            'label' => 'Workspace',
            'items' => [
                [
                    'name' => 'Dashboard',
                    'route' => 'dashboard',
                    'permission' => null,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-9 9 9"/><path d="M9 21V9h6v12"/></svg>',
                ],
            ],
        ],
        [
            'label' => 'Management',
            'items' => [
                [
                    'name' => 'Students',
                    'route' => 'students.index',
                    'permission' => App\Enums\Permission::ViewStudents->value,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                ],
                [
                    'name' => 'Programs',
                    'route' => 'programs.index',
                    'permission' => App\Enums\Permission::ViewPrograms->value,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5V4.5l8 4.5 8-4.5v15"/><path d="M4 4.5l8 4.5 8-4.5"/><path d="M4 14.5l8 4.5 8-4.5"/></svg>',
                ],
                [
                    'name' => 'Executives',
                    'route' => 'executives.index',
                    'permission' => App\Enums\Permission::ViewExecutives->value,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M4 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg>',
                ],
                [
                    'name' => 'Billing',
                    'route' => 'billing.index',
                    'permission' => App\Enums\Permission::ViewBills->value,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3"/><path d="M7 10v10h10V10"/><path d="M11 16h2"/><path d="M12 16v-6"/></svg>',
                ],
                [
                    'name' => 'Events',
                    'route' => 'events.index',
                    'permission' => App\Enums\Permission::ViewEvents->value,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16"/><path d="M5 6v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6"/><path d="M8 6V4a2 2 0 1 1 4 0v2"/><path d="M16 6V4a2 2 0 1 1 4 0v2"/></svg>',
                ],
                [
                    'name' => 'Support',
                    'route' => 'tickets.index',
                    'permission' => App\Enums\Permission::ViewTickets->value,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10Z"/><path d="M8 11h8"/><path d="M8 15h6"/></svg>',
                ],
            ],
        ],
        [
            'label' => 'Insights',
            'items' => [
                [
                    'name' => 'Reports',
                    'route' => 'reports.index',
                    'permission' => App\Enums\Permission::ViewReports->value,
                    'icon' => '<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5V4.5l8 4.5 8-4.5v15"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>',
                ],
            ],
        ],
    ];
@endphp

<div class="space-y-8">
    <div class="rounded-3xl border border-border bg-surface p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <x-application-logo class="h-10 w-10 text-primary-700" />
            <div>
                <p class="text-sm font-semibold text-text">NACOS Portal</p>
                <p class="text-xs text-text-secondary">Student & administration workspace</p>
            </div>
        </div>
    </div>

    <nav class="space-y-1" aria-label="Primary">
        @foreach ($navSections as $section)
            <div>
                <p class="px-3 text-xs font-semibold uppercase tracking-[0.12em] text-text-secondary">
                    {{ $section['label'] }}
                </p>
                <div class="mt-2 space-y-1">
                    @foreach ($section['items'] as $item)
                        @if (!$item['permission'] || auth()->user()->can($item['permission']))
                            @php
                                $routeExists = $item['route'] && Route::has($item['route']);
                                $isActive = $routeExists && request()->routeIs($item['route']);
                                $href = $routeExists ? route($item['route']) : '#';
                                $disabled = ! $routeExists;
                            @endphp

                            <a
                                href="{{ $href }}"
                                @if ($disabled) aria-disabled="true" @endif
                                class="group flex items-center gap-3 rounded-2xl px-3 py-2 text-sm font-medium transition duration-150 ease-in-out {{ $isActive ? 'bg-primary-50 text-primary-700 border border-primary-200 shadow-sm' : 'text-text hover:bg-surface-secondary' }} {{ $disabled ? 'pointer-events-none opacity-60' : '' }}"
                            >
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-border bg-surface text-text transition duration-150 ease-in-out group-hover:border-primary-200">
                                    {!! $item['icon'] !!}
                                </span>
                                <span>{{ $item['name'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="rounded-3xl border border-border bg-surface p-5 shadow-sm">
        <p class="text-sm font-semibold text-text">Profile</p>
        <p class="mt-2 text-sm text-text-secondary">Manage your account, security, and portal preferences.</p>
        <div class="mt-4 flex flex-col gap-3">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-between rounded-2xl border border-border bg-surface px-4 py-3 text-sm text-text transition hover:border-primary-200 hover:bg-surface-secondary">
                <span>Profile settings</span>
                <span class="rounded-full bg-neutral-100 px-2 py-0.5 text-xs text-text-secondary">Go</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center justify-between rounded-2xl border border-border bg-surface px-4 py-3 text-sm text-text transition hover:border-danger-300 hover:bg-danger-50">
                    <span>Sign out</span>
                    <svg class="size-4 text-danger-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>
