<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Détail paiement</h2>
    </x-slot>

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6 space-y-3 text-sm">
        <p><span class="font-medium">Membre:</span> {{ $payment->member->first_name }} {{ $payment->member->last_name }}</p>
        <p><span class="font-medium">Montant:</span> {{ number_format($payment->amount, 2, ',', ' ') }}</p>
        <p><span class="font-medium">Méthode:</span> {{ $payment->payment_method }}</p>
        <p><span class="font-medium">Référence:</span> {{ $payment->reference }}</p>
        <p><span class="font-medium">Date:</span> {{ $payment->paid_at?->format('d/m/Y H:i') }}</p>
        <p><span class="font-medium">Statut:</span> {{ $payment->status }}</p>
    </div>
</x-app-layout>
