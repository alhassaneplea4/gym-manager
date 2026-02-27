<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Membres</h2>
            <a href="{{ route('members.create') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm text-white dark:bg-white dark:text-gray-900">Nouveau membre</a>
        </div>
    </x-slot>

    <x-status-alert />

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="p-4 border-b border-gray-200 dark:border-gray-800">
            <form method="GET" class="flex gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher membre" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" />
                <button class="rounded-lg border border-gray-300 px-4 py-2 text-sm dark:border-gray-700 dark:text-gray-200">Filtrer</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">N°</th>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Téléphone</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr class="border-t border-gray-100 dark:border-gray-800 text-gray-800 dark:text-gray-200">
                            <td class="px-4 py-3">{{ $member->membership_no }}</td>
                            <td class="px-4 py-3">{{ $member->first_name }} {{ $member->last_name }}</td>
                            <td class="px-4 py-3">{{ $member->phone }}</td>
                            <td class="px-4 py-3">{{ $member->status }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('members.show', $member) }}" class="text-gray-700 dark:text-gray-300">Voir</a>
                                <a href="{{ route('members.edit', $member) }}" class="text-blue-600">Modifier</a>
                                <form method="POST" action="{{ route('members.destroy', $member) }}" onsubmit="return confirm('Supprimer ce membre ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Aucun membre.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $members->links() }}</div>
    </div>
</x-app-layout>
