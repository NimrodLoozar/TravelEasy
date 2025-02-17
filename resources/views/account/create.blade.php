<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Nieuw account') }}
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
                <p class="text-red-500">Geen account kon aangemaakt worden. Probeer later opnieuw.</p>
            </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('account.store') }}" method="POST" class="p-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Persoonlijke Informatie -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Persoonlijke Informatie</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Voornaam *</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('first_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tussenvoegsel</label>
                                    <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Achternaam *</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('last_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Geboortedatum</label>
                                    <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>

                                <!-- Passport Details -->
                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-gray-700">Paspoort Details</label>
                                    <div>
                                        <input type="text" name="passport_number" placeholder="Paspoortnummer" value="{{ old('passport_number') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <input type="date" name="passport_expiry" placeholder="Verloopdatum" value="{{ old('passport_expiry') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Relatienummer *</label>
                                    <input type="text" name="relation_number" value="{{ old('relation_number') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('relation_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Informatie -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Contact Informatie</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">E-mail *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telefoon *</label>
                                    <input type="text" name="mobile" value="{{ old('mobile') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('mobile')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Straat</label>
                                        <input type="text" name="street" value="{{ old('street') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Huisnummer</label>
                                        <input type="text" name="house_number" value="{{ old('house_number') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Toevoeging</label>
                                    <input type="text" name="addition" value="{{ old('addition') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Postcode</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Plaats</label>
                                    <input type="text" name="city" value="{{ old('city') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <a href="{{ route('account.index') }}" 
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300">
                            Annuleren
                        </a>
                        <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                            Account Aanmaken
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <p class="text-red-500">Geen account kon aangemaakt worden. Probeer later opnieuw.</p>
            </div>
        </div>
    </div>

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
            if (span.textContent.includes('***')) {
                if (span.classList.contains('email')) {
                    span.textContent = span.getAttribute('data-email');
                } else if (span.classList.contains('phone')) {
                    span.textContent = span.getAttribute('data-phone');
                }
            } else {
                if (span.classList.contains('email')) {
                    span.textContent = '***@***.com';
                } else if (span.classList.contains('phone')) {
                    span.textContent = '+31****';
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
</x-app-layout>
