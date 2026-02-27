<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Badge membre</h2>
            <a href="{{ route('members.show', $member) }}" class="text-sm text-gray-600 dark:text-gray-300">Retour</a>
        </div>
    </x-slot>

    <div class="max-w-md rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <div class="text-center">
            <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">GymManager Member Card</p>
            <h3 class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $member->first_name }} {{ $member->last_name }}</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">ID: {{ $member->membership_no }}</p>
        </div>

        <div class="mt-6 flex justify-center rounded-xl bg-gray-50 dark:bg-gray-800 p-4">
            {!! $qrSvg !!}
        </div>

        <div class="mt-4 text-center text-xs text-gray-500 dark:text-gray-400">
            Scanner ce QR pour check-in rapide
        </div>

        <div class="mt-5 flex justify-center">
            <button onclick="window.print()" class="rounded-lg bg-gray-900 px-4 py-2 text-sm text-white dark:bg-white dark:text-gray-900">Imprimer le badge</button>
        </div>
    </div>
</x-app-layout>
