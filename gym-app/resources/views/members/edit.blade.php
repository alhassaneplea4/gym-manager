<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Modifier membre</h2>
    </x-slot>

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <form method="POST" action="{{ route('members.update', $member) }}">
            @method('PUT')
            @include('members._form', ['submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
