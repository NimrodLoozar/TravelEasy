<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 p-4 bg-gray-800">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Account bewerken') }}
        </h2>
        <div class="flex items-center">
            <span class="text-white mr-3">Toon Data</span>
            <label class="switch">
                <input type="checkbox" id="dataToggle" checked>
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div id="errorContainer" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative ml-64" role="alert">
        <span class="block sm:inline">Bewerken van accountsgegevens is mislukt. Probeer later opnieuw.</span>
    </div>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.update', $account->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Section -->
                        <div class="border-b border-gray-100 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Persoonlijke informatie</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Voornaam</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $account->first_name) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tussenvoegsel</label>
                                    <input type="text" name="middle_name" value="{{ old('middle_name', $account->middle_name) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Achternaam</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $account->last_name) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Geboortedatum</label>
                                    <input type="date" name="birth_date" value="{{ old('birth_date', $account->birth_date) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100">
                                </div>
                            </div>
                        </div>

                        <!-- Passport Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Paspoort informatie</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Paspoort nummer</label>
                                    <input type="text" name="passport_number" 
                                        value="{{ old('passport_number', $account->passport_details ? json_decode($account->passport_details)->passport_number ?? '' : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Paspoort vervaldatum</label>
                                    <input type="date" name="passport_expiry" 
                                        value="{{ old('passport_expiry', $account->passport_details ? json_decode($account->passport_details)->passport_expiry ?? '' : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100">
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="border-b border-gray-100 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact informatie</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Relatienummer</label>
                                    <input type="text" name="relation_number" value="{{ old('relation_number', $account->relation_number) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" 
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $account->email) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" 
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mobiel</label>
                                    <input type="text" name="mobile" value="{{ old('mobile', $account->mobile) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" 
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Section -->
                        <div class="border-b border-gray-100 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Adres informatie</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Straat</label>
                                    <input type="text" name="street" value="{{ old('street', $account->street) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Huisnummer</label>
                                    <input type="text" name="house_number" value="{{ old('house_number', $account->house_number) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Toevoeging</label>
                                    <input type="text" name="addition" value="{{ old('addition', $account->addition) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Postcode</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code', $account->postal_code) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Stad</label>
                                    <input type="text" name="city" value="{{ old('city', $account->city) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-100 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Status</h3>
                            <div class="mt-2">
                                <label class="inline-flex items-center space-x-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="form-checkbox h-5 w-5 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        {{ $account->is_active ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">Account is actief (uitvinken om account te deactiveren)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('account.index') }}" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                                Annuleren
                            </a>
                            <button type="submit" 
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors">
                                Bijwerken
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dataToggle').addEventListener('change', function() {
            const dataContainer = document.getElementById('dataContainer');
            const errorContainer = document.getElementById('errorContainer');
            dataContainer.classList.toggle('hidden', !this.checked);
            errorContainer.classList.toggle('hidden', this.checked);
        });
    </script>

    <style>
        h2, .toon { color: #fff; }
        .toggle-checkbox:checked { right: 0; border-color: #38A169; }
        .toggle-checkbox:checked + .toggle-label { background-color: #38A169; }
    </style>
</x-app-layout>