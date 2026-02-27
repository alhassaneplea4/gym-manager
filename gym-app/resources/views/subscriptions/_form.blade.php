@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="member_id" value="Membre" />
        <select id="member_id" name="member_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            <option value="">Sélectionner</option>
            @foreach($members as $memberOption)
                <option value="{{ $memberOption->id }}" @selected((string)old('member_id', $subscription->member_id ?? '') === (string)$memberOption->id)>{{ $memberOption->first_name }} {{ $memberOption->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="plan_name" value="Plan" />
        <x-text-input id="plan_name" name="plan_name" type="text" class="mt-1 block w-full" :value="old('plan_name', $subscription->plan_name ?? '')" required />
    </div>
    <div>
        <x-input-label for="amount" value="Montant" />
        <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('amount', $subscription->amount ?? '')" required />
    </div>
    <div>
        <x-input-label for="status" value="Statut" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            @foreach(['active','expired','cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $subscription->status ?? 'active') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="start_date" value="Début" />
        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', optional($subscription->start_date ?? null)?->format('Y-m-d'))" required />
    </div>
    <div>
        <x-input-label for="end_date" value="Fin" />
        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date', optional($subscription->end_date ?? null)?->format('Y-m-d'))" required />
    </div>
</div>
<div class="mt-4">
    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
        <input type="checkbox" name="auto_renew" value="1" @checked(old('auto_renew', $subscription->auto_renew ?? false)) class="rounded border-gray-300 dark:border-gray-700">
        Renouvellement automatique
    </label>
</div>
<div class="mt-6 flex gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('subscriptions.index') }}" class="text-sm text-gray-600 dark:text-gray-300">Annuler</a>
</div>
