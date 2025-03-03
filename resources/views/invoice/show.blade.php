<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Officiële Factuur') }} #{{ $invoices->number }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6 border">

                <!-- Bedrijfs- en Klantinformatie -->
                <div class="grid grid-cols-2 gap-6 border-b pb-4">
                    <!-- Bedrijfsgegevens -->
                    <div>
                        <h3 class="text-lg font-bold">Uitgegeven door:</h3>
                        <p>TravelEasy B.V.</p>
                        <p>Hoofdstraat 123, 1000 AB Amsterdam</p>
                        <p>KvK: 12345678</p>
                        <p>BTW-nummer: NL123456789B01</p>
                    </div>

                    <!-- Klantgegevens -->
                    <div>
                        <h3 class="text-lg font-bold">Factuur voor:</h3>
                        <p>
                            {{ $invoices->first_name }} 
                            {{ trim(($invoices->middle_name ?? '') . ' ' . $invoices->last_name) }}
                        </p>
                    </div>
                </div>

                <!-- Factuurgegevens -->
                <div class="mt-6">
                    <p><strong>Factuurnummer:</strong> #{{ $invoices->number }}</p>
                    <p><strong>Factuurdatum:</strong> {{ $invoices->date }}</p>

                    <p><strong>Status:</strong> 
                        @if ($invoices->status == 'in behandeling')
                            <span class="bg-yellow-400 text-white py-1 px-3 rounded-full text-xs font-semibold">In behandeling</span>
                        @elseif ($invoices->status == 'betaald')
                            <span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Betaald</span>
                        @elseif ($invoices->status == 'onbetaald')
                            <span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Onbetaald</span>
                        @else
                            <span class="bg-gray-500 text-white py-1 px-3 rounded-full text-xs font-semibold">{{ $invoices->status }}</span>
                        @endif
                    </p>
                </div>

                <!-- Vluchtdetails -->
                    <div class="mt-6 border-t pt-4">
                        <h3 class="text-lg font-bold">Vluchtinformatie</h3>
                        <p><strong>Vluchtcode:</strong> {{ $invoices->flight_number }}</p>
                        <p><strong>Vertrek:</strong> {{ $invoices->departure_date }}</p>
                        <p><strong>Aankomst:</strong> {{ $invoices->arrival_date }}</p>
                     </div>

                <!-- Bedragen -->
                    <div class="mt-6 border-t pt-4">
                    <p><strong>Bedrag excl. BTW:</strong> € {{ number_format($invoices->amount_excl_vat, 2, ',', '.') }}</p>
                    <p><strong>BTW (21%):</strong> € {{ number_format($invoices->vat, 2, ',', '.') }}</p>
                    <p class="text-xl font-bold"><strong>Totaal:</strong> € {{ number_format($invoices->amount_incl_vat, 2, ',', '.') }}</p>
                </div>

                <div class="mt-6 border-t pt-4">
                <p class="text-l font-bold">aantal tickets:</p>
                        <p>{{ $invoices->quantity }}</p>
                        
                </div>

                <!-- Opmerkingen -->
                @if ($invoices->note)
                    <div class="mt-6 border-t pt-4">
                        <p><strong>Opmerking:</strong> {{ $invoices->note }}</p>
                    </div>
                @endif

                <!-- Terugknop -->
                <div class="flex justify-end mt-6">
                    <a href="{{ route('invoice.index') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md transition duration-300 hover:bg-blue-700">
                        Terug naar overzicht
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
