<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Check-in membre</h2>
    </x-slot>

    <div class="max-w-2xl rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <div class="rounded-lg {{ $wasRecent ? 'bg-yellow-50 border-yellow-200 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-300' : 'bg-green-50 border-green-200 text-green-700 dark:bg-green-900/20 dark:text-green-300' }} border px-4 py-3 text-sm">
            @if($wasRecent)
                Check-in déjà enregistré récemment pour ce membre.
            @else
                Check-in QR enregistré avec succès.
            @endif
        </div>

        <div class="mt-5 space-y-2 text-sm text-gray-700 dark:text-gray-300">
            <p><span class="font-medium">Membre:</span> {{ $member->first_name }} {{ $member->last_name }}</p>
            <p><span class="font-medium">ID:</span> {{ $member->membership_no }}</p>
            <p><span class="font-medium">Heure:</span> {{ $attendanceLog->check_in_at?->format('d/m/Y H:i:s') }}</p>
            <p><span class="font-medium">Méthode:</span> QR Code</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('members.show', $member) }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm text-white dark:bg-white dark:text-gray-900">Voir le membre</a>
        </div>
    </div>
</x-app-layout>
