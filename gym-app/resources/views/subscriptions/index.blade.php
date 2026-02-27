<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Abonnements</h2>
            <a href="{{ route('subscriptions.create') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm text-white dark:bg-white dark:text-gray-900">Nouvel abonnement</a>
        </div>
    </x-slot>

    <x-status-alert />

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">Membre</th>
                    <th class="px-4 py-3">Plan</th>
                    <th class="px-4 py-3">Montant</th>
                    <th class="px-4 py-3">Fin</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $subscription)
                    <tr class="border-t border-gray-100 dark:border-gray-800 text-gray-800 dark:text-gray-200">
                        <td class="px-4 py-3">{{ $subscription->member->first_name }} {{ $subscription->member->last_name }}</td>
                        <td class="px-4 py-3">{{ $subscription->plan_name }}</td>
                        <td class="px-4 py-3">{{ number_format($subscription->amount, 2, ',', ' ') }}</td>
                        <td class="px-4 py-3">{{ $subscription->end_date?->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $subscription->status }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('subscriptions.show', $subscription) }}">Voir</a>
                            <a href="{{ route('subscriptions.edit', $subscription) }}" class="text-blue-600">Modifier</a>
                            <form method="POST" action="{{ route('subscriptions.destroy', $subscription) }}" onsubmit="return confirm('Supprimer ?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucun abonnement.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $subscriptions->links() }}</div>
    </div>
</x-app-layout>
