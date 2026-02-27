<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Rapport financier annuel</h2>
    </x-slot>

    <div class="mb-4 rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-4">
        <form class="flex items-center gap-3" method="GET">
            <x-input-label for="year" value="Année" />
            <x-text-input id="year" name="year" type="number" min="2020" max="2100" :value="$year" class="w-36" />
            <x-primary-button>Afficher</x-primary-button>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-5">
        <p class="text-sm text-gray-500 dark:text-gray-400">Revenu total {{ $year }}</p>
        <p class="text-3xl font-semibold text-gray-900 dark:text-white mt-1">{{ number_format($totalRevenue, 2, ',', ' ') }} FCFA</p>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="py-2">Mois</th>
                        <th class="py-2">Revenu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthly as $line)
                        <tr class="border-t border-gray-100 dark:border-gray-800 text-gray-800 dark:text-gray-200">
                            <td class="py-2">{{ $line->month_label }}</td>
                            <td class="py-2">{{ number_format($line->revenue, 2, ',', ' ') }} FCFA</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 text-center text-gray-500">Aucune donnée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
