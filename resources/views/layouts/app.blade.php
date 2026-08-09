<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NACOS Portal') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-background text-text antialiased">
        <div x-data="{ sidebarOpen: false }" x-cloak class="min-h-screen flex">
            <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-black/25 lg:hidden" @click="sidebarOpen = false"></div>

            <aside class="fixed inset-y-0 start-0 z-50 w-72 overflow-y-auto border-r border-border/70 bg-surface p-5 shadow-xl shadow-black/5 lg:hidden" x-show="sidebarOpen" @click.away="sidebarOpen = false" x-cloak x-transition:enter="transition-transform duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                @include('layouts.sidebar')
            </aside>

            <aside class="hidden lg:block lg:fixed lg:inset-y-0 lg:start-0 lg:z-20 lg:w-72 lg:overflow-y-auto lg:border-r lg:border-border/70 lg:bg-surface lg:p-6">
                @include('layouts.sidebar')
            </aside>

            <div class="flex min-h-screen flex-1 flex-col lg:ps-72">
                @include('layouts.topbar')

                <main class="flex-1">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        @isset($header)
                            <div class="mb-8 rounded-3xl border border-border bg-surface p-6 shadow-sm">
                                {{ $header }}
                            </div>
                        @endisset

                        <div class="space-y-6">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
