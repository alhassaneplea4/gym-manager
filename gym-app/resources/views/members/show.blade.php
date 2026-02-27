<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Profil membre</h2>
    </x-slot>

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6 space-y-3 text-sm">
        <p><span class="font-medium">N°:</span> {{ $member->membership_no }}</p>
        <p><span class="font-medium">Nom:</span> {{ $member->first_name }} {{ $member->last_name }}</p>
        <p><span class="font-medium">Téléphone:</span> {{ $member->phone }}</p>
        <p><span class="font-medium">Email:</span> {{ $member->email ?? '-' }}</p>
        <p><span class="font-medium">Statut:</span> {{ $member->status }}</p>
        <p><span class="font-medium">Inscription:</span> {{ $member->join_date?->format('d/m/Y') }}</p>
    </div>
</x-app-layout>
