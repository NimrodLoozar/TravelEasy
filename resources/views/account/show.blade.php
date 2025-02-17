<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Account Details') }} #{{ $account->id }}
            </h2>
        </div>
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
                                    <p class="mt-1">
                                        @if($account->passport_details)
                                            @php
                                                $passportDetails = json_decode($account->passport_details, true);
                                            @endphp
                                            @foreach($passportDetails as $key => $value)
                                                <span class="block">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-gray-500 italic">Niet opgegeven</span>
                                        @endif
                                    </p>
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
                                        @if($account->street && $account->house_number)
                                            {{ $account->street }} 
                                            {{ $account->house_number }}
                                            {{ $account->addition }}
                                        @else
                                            <span class="text-gray-500 italic">Niet opgegeven</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Postcode:</label>
                                    <p>
                                        @if($account->postal_code)
                                            {{ $account->postal_code }}
                                        @else
                                            <span class="text-gray-500 italic">Niet opgegeven</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Plaats:</label>
                                    <p>
                                        @if($account->city)
                                            {{ $account->city }}
                                        @else
                                            <span class="text-gray-500 italic">Niet opgegeven</span>
                                        @endif
                                    </p>
                                </div>

                                
                            </div>
                        </div>
                    </div>

                   
                    <!-- Terugknop -->
                 <div class="flex justify-end mt-6">
                    <a href="{{ route('account.index') }}" class="bg-gray-600 text-white px-5 py-2 rounded-md transition duration-300 hover:bg-gray-400">
                        Terug naar overzicht
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    h2 {
        color: #fff;
    }
</style>