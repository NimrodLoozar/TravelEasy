<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Account Details') }}
            </h2>
            <a href="{{ route('account.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Terug naar Overzicht</a>
        </div>

        <label class="flex items-center">
                    <span class="mr-2 text-white-900 toon">Toon Data</span>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" id="dataToggle"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                            checked />
                        <label for="dataToggle"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </label>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Persoonlijke Informatie -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Persoonlijke Informatie</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="font-medium text-gray-700">Naam:</label>
                                    <p>{{ $account->first_name }} {{ $account->middle_name }} {{ $account->last_name }}</p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Relatienummer:</label>
                                    <p>{{ $account->relation_number }}</p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Geboortedatum:</label>
                                    <p>{{ $account->birth_date ? \Carbon\Carbon::parse($account->birth_date)->format('d-m-Y') : 'Niet opgegeven' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Paspoort Details:</label>
                                    <p>{{ $account->passport_details ?? 'Niet opgegeven' }}</p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Status:</label>
                                    <span class="px-2 py-1 rounded {{ $account->is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $account->is_active ? 'Actief' : 'Inactief' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Informatie -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Contact Informatie</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="font-medium text-gray-700">E-mail:</label>
                                    <p>{{ $account->email }}</p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Telefoon:</label>
                                    <p>{{ $account->mobile }}</p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Adres:</label>
                                    <p>
                                        {{ $account->street }} 
                                        {{ $account->house_number }}
                                        {{ $account->addition }}
                                    </p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Postcode:</label>
                                    <p>{{ $account->postal_code }}</p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Plaats:</label>
                                    <p>{{ $account->city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actie Knoppen -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('account.edit', $account->id) }}" 
                           class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                            Account Bewerken
                        </a>
                        <form action="{{ route('account.destroy', $account->id) }}" method="POST" 
                              onsubmit="return confirm('Weet je zeker dat je dit account wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                Account Verwijderen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
     document.getElementById('dataToggle').addEventListener('change', function() {
        const dataContainer = document.getElementById('dataContainer');
        const errorContainer = document.getElementById('errorContainer');
        if (this.checked) {
            dataContainer.classList.remove('hidden');
            errorContainer.classList.add('hidden');
        } else {
            dataContainer.classList.add('hidden');
            errorContainer.classList.remove('hidden');
        }
    });

    function toggleVisibility(button) {
    const span = button.previousElementSibling;
    if (span.textContent.includes('••••')) {
        if (span.classList.contains('email')) {
            span.textContent = span.getAttribute('data-email');
        } else if (span.classList.contains('phone')) {
            span.textContent = span.getAttribute('data-phone');
        }
    } else {
        if (span.classList.contains('email')) {
            span.textContent = '••••@••••.com';
        } else if (span.classList.contains('phone')) {
            span.textContent = '••••••••••';
        }
    }
}
</script>

<style>
    h2 {
        color: #fff;
    }

    .toon {
        color: #fff;
    }

    .toggle-checkbox:checked {
        right: 0;
        border-color: #38A169;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #38A169;
    }

</style>
