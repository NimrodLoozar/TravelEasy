<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Officiële Factuur') }} #{{ $invoice->number }}
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
                        @if ($invoice->booking && $invoice->booking->customer && $invoice->booking->customer->person)
                            <p>{{ $invoice->booking->customer->person->first_name }} 
                               {{ $invoice->booking->customer->person->middle_name }} 
                               {{ $invoice->booking->customer->person->last_name }}</p>
                            <p>Relatienummer: {{ $invoice->booking->customer->relation_number }}</p>
                        @else
                            <p>N/A</p>
                        @endif
                    </div>
                </div>

                <!-- Factuurgegevens -->
                <div class="mt-6">
                    <p><strong>Factuurnummer:</strong> #{{ $invoice->number }}</p>
                    <p><strong>Factuurdatum:</strong> {{ $invoice->date }}</p>
                    <p><strong>Status:</strong> 
                        @if ($invoice->status == 'in behandeling')
                            <span class="bg-yellow-400 text-white py-1 px-3 rounded-full text-xs font-semibold">In behandeling</span>
                        @elseif ($invoice->status == 'betaald')
                            <span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Betaald</span>
                        @elseif ($invoice->status == 'onbetaald')
                            <span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Onbetaald</span>
                        @else
                            <span class="bg-gray-500 text-white py-1 px-3 rounded-full text-xs font-semibold">{{ $invoice->status }}</span>
                        @endif
                    </p>
                </div>

                <!-- Vluchtdetails -->
                @if ($invoice->booking && $invoice->booking->trip)
                    <div class="mt-6 border-t pt-4">
                        <h3 class="text-lg font-bold">Vluchtinformatie</h3>
                        <p><strong>Vluchtcode:</strong> {{ $invoice->booking->trip->flight_number }}</p>
                        <p><strong>Vertrek:</strong> {{ $invoice->booking->trip->departure_date }} {{ $invoice->booking->trip->departure_time }}</p>
                        <p><strong>Aankomst:</strong> {{ $invoice->booking->trip->arrival_date }} {{ $invoice->booking->trip->arrival_time }}</p>
                        <p><strong>Status:</strong> {{ $invoice->booking->trip->trip_status }}</p>
                    </div>
                @endif

                <!-- Bedragen -->
                <div class="mt-6 border-t pt-4">
                    <p><strong>Stoelnummer:</strong> {{ $invoice->booking->seat_number }}</p>
                    <p><strong>Aantal tickets:</strong> {{ $invoice->booking->quantity }}</p>
                    <p><strong>Bedrag excl. BTW:</strong> € {{ number_format($invoice->amount_excl_vat, 2, ',', '.') }}</p>
                    <p><strong>BTW (21%):</strong> € {{ number_format($invoice->vat, 2, ',', '.') }}</p>
                    <p class="text-xl font-bold"><strong>Totaal:</strong> € {{ number_format($invoice->amount_incl_vat, 2, ',', '.') }}</p>
                </div>

                <!-- Opmerkingen -->
                @if ($invoice->note)
                    <div class="mt-6 border-t pt-4">
                        <p><strong>Opmerking:</strong> {{ $invoice->note }}</p>
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
