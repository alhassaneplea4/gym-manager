<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Paiements</h2>
            <a href="{{ route('payments.create') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm text-white dark:bg-white dark:text-gray-900">Nouveau paiement</a>
        </div>
    </x-slot>

    <x-status-alert />

    <div class="mb-4">
        <form class="flex gap-3" method="GET">
            <select name="month" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                <option value="">Tous les mois</option>
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" @selected((string)$month === (string)$m)>{{ $m }}</option>
                @endfor
            </select>
            <button class="rounded-lg border border-gray-300 px-4 py-2 text-sm dark:border-gray-700 dark:text-gray-200">Filtrer</button>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Membre</th>
                    <th class="px-4 py-3">Montant</th>
                    <th class="px-4 py-3">Méthode</th>
                    <th class="px-4 py-3">Référence</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr class="border-t border-gray-100 dark:border-gray-800 text-gray-800 dark:text-gray-200">
                        <td class="px-4 py-3">{{ $payment->paid_at?->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $payment->member->first_name }} {{ $payment->member->last_name }}</td>
                        <td class="px-4 py-3">{{ number_format($payment->amount, 2, ',', ' ') }}</td>
                        <td class="px-4 py-3">{{ $payment->payment_method }}</td>
                        <td class="px-4 py-3">{{ $payment->reference }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('payments.show', $payment) }}">Voir</a>
                            @can('update', $payment)
                                <a href="{{ route('payments.edit', $payment) }}" class="text-blue-600">Modifier</a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucun paiement.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $payments->links() }}</div>
    </div>
</x-app-layout>
