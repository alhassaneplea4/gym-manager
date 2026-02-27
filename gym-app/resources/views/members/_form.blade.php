@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="membership_no" value="Numéro membre" />
        <x-text-input id="membership_no" name="membership_no" type="text" class="mt-1 block w-full" :value="old('membership_no', $member->membership_no ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('membership_no')" />
    </div>
    <div>
        <x-input-label for="phone" value="Téléphone" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $member->phone ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <div>
        <x-input-label for="first_name" value="Prénom" />
        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $member->first_name ?? '')" required />
    </div>
    <div>
        <x-input-label for="last_name" value="Nom" />
        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $member->last_name ?? '')" required />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $member->email ?? '')" />
    </div>
    <div>
        <x-input-label for="join_date" value="Date d'inscription" />
        <x-text-input id="join_date" name="join_date" type="date" class="mt-1 block w-full" :value="old('join_date', optional($member->join_date ?? null)?->format('Y-m-d'))" required />
    </div>

    <div>
        <x-input-label for="status" value="Statut" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            @foreach(['active', 'inactive', 'suspended'] as $status)
                <option value="{{ $status }}" @selected(old('status', $member->status ?? 'active') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="gender" value="Genre" />
        <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            <option value="">--</option>
            @foreach(['male', 'female', 'other'] as $gender)
                <option value="{{ $gender }}" @selected(old('gender', $member->gender ?? '') === $gender)>{{ $gender }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('members.index') }}" class="text-sm text-gray-600 dark:text-gray-300">Annuler</a>
</div>
