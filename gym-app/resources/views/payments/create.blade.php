<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Nouveau paiement</h2>
    </x-slot>

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <form method="POST" action="{{ route('payments.store') }}">
            @include('payments._form', ['submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
