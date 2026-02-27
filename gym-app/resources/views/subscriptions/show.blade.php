<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Détail abonnement</h2>
    </x-slot>

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6 space-y-3 text-sm">
        <p><span class="font-medium">Membre:</span> {{ $subscription->member->first_name }} {{ $subscription->member->last_name }}</p>
        <p><span class="font-medium">Plan:</span> {{ $subscription->plan_name }}</p>
        <p><span class="font-medium">Montant:</span> {{ number_format($subscription->amount, 2, ',', ' ') }}</p>
        <p><span class="font-medium">Période:</span> {{ $subscription->start_date?->format('d/m/Y') }} - {{ $subscription->end_date?->format('d/m/Y') }}</p>
        <p><span class="font-medium">Statut:</span> {{ $subscription->status }}</p>
    </div>
</x-app-layout>
