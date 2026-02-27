<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GymManager') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-950" x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('darkMode') === '1' }" x-init="$watch('darkMode', value => { document.documentElement.classList.toggle('dark', value); localStorage.setItem('darkMode', value ? '1' : '0') }); document.documentElement.classList.toggle('dark', darkMode)">
    <div class="min-h-screen flex">
        <aside class="w-72 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 hidden lg:flex lg:flex-col">
            <div class="h-16 px-6 flex items-center border-b border-gray-200 dark:border-gray-800">
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-gray-900 dark:text-white">GymManager</a>
            </div>
            <nav class="p-4 space-y-1 text-sm">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">Dashboard</a>
                <a href="{{ route('members.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('members.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">Membres</a>
                <a href="{{ route('subscriptions.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('subscriptions.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">Abonnements</a>
                <a href="{{ route('payments.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">Paiements</a>
                @if(auth()->user()->hasRole('admin', 'manager'))
                    <a href="{{ route('reports.financial') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' }}">Rapports</a>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <button class="lg:hidden rounded-md p-2 text-gray-600 dark:text-gray-300" @click="sidebarOpen = !sidebarOpen">☰</button>
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
