@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="member_id" value="Membre" />
        <select id="member_id" name="member_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            @foreach($members as $memberOption)
                <option value="{{ $memberOption->id }}" @selected((string)old('member_id', $payment->member_id ?? '') === (string)$memberOption->id)>{{ $memberOption->first_name }} {{ $memberOption->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="subscription_id" value="Abonnement" />
        <select id="subscription_id" name="subscription_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            <option value="">--</option>
            @foreach($subscriptions as $sub)
                <option value="{{ $sub->id }}" @selected((string)old('subscription_id', $payment->subscription_id ?? '') === (string)$sub->id)>{{ $sub->plan_name }} - {{ $sub->member->first_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="amount" value="Montant" />
        <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('amount', $payment->amount ?? '')" required />
    </div>
    <div>
        <x-input-label for="payment_method" value="Méthode" />
        <select id="payment_method" name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            @foreach(['cash','card','mobile_money','bank_transfer'] as $method)
                <option value="{{ $method }}" @selected(old('payment_method', $payment->payment_method ?? 'cash') === $method)>{{ $method }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="reference" value="Référence" />
        <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full" :value="old('reference', $payment->reference ?? '')" required />
    </div>
    <div>
        <x-input-label for="status" value="Statut" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            @foreach(['pending','completed','failed','refunded'] as $status)
                <option value="{{ $status }}" @selected(old('status', $payment->status ?? 'completed') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="paid_at" value="Date de paiement" />
        <x-text-input id="paid_at" name="paid_at" type="datetime-local" class="mt-1 block w-full" :value="old('paid_at', isset($payment->paid_at) ? $payment->paid_at->format('Y-m-d\TH:i') : '')" required />
    </div>
</div>
<div class="mt-6 flex gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('payments.index') }}" class="text-sm text-gray-600 dark:text-gray-300">Annuler</a>
</div>
