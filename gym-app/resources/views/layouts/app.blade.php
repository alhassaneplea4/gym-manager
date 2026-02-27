<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GymManager') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>[x-cloak]{display:none !important;}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-950" x-data="{ darkMode: localStorage.getItem('darkMode') === '1' }" x-init="$watch('darkMode', value => { document.documentElement.classList.toggle('dark', value); localStorage.setItem('darkMode', value ? '1' : '0') }); document.documentElement.classList.toggle('dark', darkMode)">
    <div class="min-h-screen flex flex-col">
        <header class="h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-gray-900 dark:text-white">GymManager</a>
            <div class="text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->name }} · {{ auth()->user()->role }}</div>
            <div class="flex items-center gap-3">
                <button @click="darkMode = !darkMode" class="px-3 py-1.5 text-xs rounded-md border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200">Mode</button>
                <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 dark:text-gray-300">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 dark:text-red-400">Déconnexion</button>
                </form>
            </div>
        </header>

        <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex flex-wrap items-center gap-2 text-sm">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('members.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 110-8 4 4 0 010 8M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    <span>Membres</span>
                </a>
                <a href="{{ route('subscriptions.index') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('subscriptions.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h13M8 12h13M8 17h13M3 7h.01M3 12h.01M3 17h.01"/></svg>
                    <span>Abonnements</span>
                </a>
                <a href="{{ route('payments.index') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2" ry="2" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2 10h20"/></svg>
                    <span>Paiements</span>
                </a>
                @if(auth()->user()->hasRole('admin', 'manager'))
                    <a href="{{ route('reports.financial') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3v18h18M7 14l3-3 3 2 4-5"/></svg>
                        <span>Rapports</span>
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    <span>Profil</span>
                </a>
            </div>
        </nav>

        <div class="flex-1 flex flex-col">
            @if (isset($header))
                <div class="px-4 sm:px-6 lg:px-8 pt-6">
                    {{ $header }}
                </div>
            @endif

            <main class="px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
