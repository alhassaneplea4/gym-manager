<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">Dashboard Salle de Gym</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total membres</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalMembers) }}</p>
            </div>
            <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Membres actifs</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ number_format($activeMembers) }}</p>
            </div>
            <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Revenus mensuels</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ number_format($monthlyRevenue, 2, ',', ' ') }} FG</p>
            </div>
            <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Abonnements expirant bientôt</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $expiringSoon->count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-5">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Revenus des 6 derniers mois</h3>
                <div class="mt-4 h-80">
                    <canvas id="revenueChart" data-labels='@json($chartLabels)' data-values='@json($chartData)'></canvas>
                </div>
            </div>

            <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-5">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Expirations proches (7 jours)</h3>
                <div class="mt-4 space-y-3">
                    @forelse($expiringSoon as $subscription)
                        <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $subscription->member->first_name }} {{ $subscription->member->last_name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subscription->plan_name }} · {{ $subscription->end_date->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">Aucune expiration imminente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            const labels = JSON.parse(ctx.dataset.labels || '[]');
            const values = JSON.parse(ctx.dataset.values || '[]');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Revenus',
                        data: values,
                        borderWidth: 2,
                        tension: 0.35,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }
    </script>
</x-app-layout>
