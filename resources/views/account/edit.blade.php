<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Nieuw account') }} #{{ $account->id }}
            </h2>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                
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
            </div>
        </div>
            <div id="errorContainer" class="py-12 hidden ml-64">
                <p class="text-red-500">bewerken van accountsgegevens is mislukt. Probeer later opnieuw.</p>
            </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('account.update', $account->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Persoonlijke informatie -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Persoonlijke informatie</h3>
                                
                                <div class="mb-4">
                                    <label for="first_name" class="block text-gray-700 font-bold mb-2">Voornaam</label>
                                    <input type="text" name="first_name" id="first_name" 
                                        value="{{ old('first_name', $account->first_name) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                </div>

                                <div class="mb-4">
                                    <label for="middle_name" class="block text-gray-700 font-bold mb-2">Tussenvoegsel</label>
                                    <input type="text" name="middle_name" id="middle_name" 
                                        value="{{ old('middle_name', $account->middle_name) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                                </div>

                                <div class="mb-4">
                                    <label for="last_name" class="block text-gray-700 font-bold mb-2">Achternaam</label>
                                    <input type="text" name="last_name" id="last_name" 
                                        value="{{ old('last_name', $account->last_name) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                </div>

                                <div class="mb-4">
                                    <label for="birth_date" class="block text-gray-700 font-bold mb-2">Geboortedatum</label>
                                    <input type="date" name="birth_date" id="birth_date" 
                                        value="{{ old('birth_date', $account->birth_date) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                                </div>
                            </div>

                            <!-- Contact informatie -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Contact informatie</h3>
                                
                                <div class="mb-4">
                                    <label for="relation_number" class="block text-gray-700 font-bold mb-2">Relatienummer</label>
                                    <input type="text" name="relation_number" id="relation_number" 
                                        value="{{ old('relation_number', $account->relation_number) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                                    <input type="email" name="email" id="email" 
                                        value="{{ old('email', $account->email) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                </div>

                                <div class="mb-4">
                                    <label for="mobile" class="block text-gray-700 font-bold mb-2">Mobiel</label>
                                    <input type="text" name="mobile" id="mobile" 
                                        value="{{ old('mobile', $account->mobile) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                </div>
                            </div>
                        </div>

                        <!-- Adres informatie -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-4">Adres informatie</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label for="street" class="block text-gray-700 font-bold mb-2">Straat</label>
                                    <input type="text" name="street" id="street" 
                                        value="{{ old('street', $account->street) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="house_number" class="block text-gray-700 font-bold mb-2">Huisnummer</label>
                                        <input type="text" name="house_number" id="house_number" 
                                            value="{{ old('house_number', $account->house_number) }}" 
                                            class="form-input rounded-md shadow-sm mt-1 block w-full">
                                    </div>

                                    <div class="mb-4">
                                        <label for="addition" class="block text-gray-700 font-bold mb-2">Toevoeging</label>
                                        <input type="text" name="addition" id="addition" 
                                            value="{{ old('addition', $account->addition) }}" 
                                            class="form-input rounded-md shadow-sm mt-1 block w-full">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="postal_code" class="block text-gray-700 font-bold mb-2">Postcode</label>
                                    <input type="text" name="postal_code" id="postal_code" 
                                        value="{{ old('postal_code', $account->postal_code) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                                </div>

                                <div class="mb-4">
                                    <label for="city" class="block text-gray-700 font-bold mb-2">Stad</label>
                                    <input type="text" name="city" id="city" 
                                        value="{{ old('city', $account->city) }}" 
                                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" class="form-checkbox" 
                                    {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                                <span class="ml-2">Account actief</span>
                            </label>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                        <a href="{{ route('account.index') }}" 
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300">
                            Annuleren
                        </a>
                        <button type="submit" 
                            class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">
                            Bijwerken
                        </button>
                    </div>
                </form>



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