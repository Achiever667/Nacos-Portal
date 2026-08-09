@php
    // $unreadCount = auth()->user()->unreadNotifications()->count();
    $searchIcon = '<svg class="size-4 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>';
@endphp

<header class="border-b border-border/80 bg-background/95 backdrop-blur-sm px-4 py-3 shadow-sm sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = true" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-border bg-surface text-text transition hover:border-primary-300 hover:bg-surface-secondary focus:outline-none focus:ring-2 focus:ring-primary-500/30 lg:hidden">
            <span class="sr-only">Open sidebar</span>
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/></svg>
        </button>

        <div class="hidden lg:flex items-center gap-3 rounded-3xl border border-border bg-surface px-4 py-2 shadow-sm">
            <span class="text-sm font-semibold text-text">NACOS Portal</span>
            <span class="rounded-full bg-primary-50 px-2.5 py-1 text-xs font-medium text-primary-700">Enterprise</span>
        </div>

<div class="flex-1">
                <x-ui.input
                    name="search"
                    placeholder="Search portal"
                    :leading-icon="$searchIcon"
                    class="bg-surface"
                    readonly
                    disabled
                />
            </form>
        </div>

        <div class="flex items-center gap-2">
            {{-- <button type="button" class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-border bg-surface text-text transition hover:border-primary-300 hover:bg-surface-secondary focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                <span class="sr-only">View notifications</span>
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 8-3 8h18s-3-1-3-8"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                @if ($unreadCount > 0)
                    <span class="absolute -end-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-danger-500 px-1.5 text-[10px] font-semibold text-white">{{ $unreadCount }}</span>
                @endif
            </button> --}}

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex h-11 items-center gap-3 rounded-2xl border border-border bg-surface px-4 text-sm font-medium text-text transition hover:border-primary-300 hover:bg-surface-secondary focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="text-sm text-text">{{ auth()->user()->name }}</span>
                        <svg class="size-4 text-neutral-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-3">
                        <p class="text-sm font-semibold text-text">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-text-secondary">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="border-t border-border"></div>
                    <x-ui.dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-ui.dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-ui.dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-ui.dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
