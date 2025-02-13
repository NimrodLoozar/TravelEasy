<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Factuur Aanmaken') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6 border">
                <form action="{{ route('invoice.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Boeking selecteren -->
                    <div>
                        <label for="booking_id" class="block text-sm font-medium text-gray-700">Boeking</label>
                        <select name="booking_id" id="booking_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100">
                            <option value="" disabled selected>Selecteer boeking</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}">
                                    {{ $booking->customer->person->first_name }} {{ $booking->customer->person->last_name }} - Vlucht #{{ $booking->trip->flight_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dynamische factuurgegevens -->
                    <div id="invoiceDetails" class="hidden">
                        <!-- Klantgegevens -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Factuur voor:</h3>
                            <p id="customerName" class="text-gray-600"></p>
                            <p id="relationNumber" class="text-gray-600"></p>
                        </div>

                        <!-- Factuurgegevens -->
                        <div class="mt-6">
                            <p class="text-gray-800"><strong>Factuurnummer:</strong> #{{ $newNumber }}</p>
                            <p class="text-gray-800"><strong>Factuurdatum:</strong> <span id="invoiceDate"></span></p>
                            <p class="text-gray-800"><strong>Status:</strong>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100">
                                    <option value="in behandeling">In Behandeling</option>
                                    <option value="betaald">Betaald</option>
                                    <option value="onbetaald">Onbetaald</option>
                                </select>
                            </p>
                        </div>

                        <!-- Vluchtdetails -->
                        <div class="mt-6 border-t pt-4">
                            <h3 class="text-lg font-bold text-gray-800">Vluchtinformatie</h3>
                            <p class="text-gray-600"><strong>Vluchtcode:</strong> <span id="flightNumber"></span></p>
                            <p class="text-gray-600"><strong>Vertrek:</strong> <span id="departure"></span></p>
                            <p class="text-gray-600"><strong>Aankomst:</strong> <span id="arrival"></span></p>
                            <p class="text-gray-600"><strong>Status:</strong> <span id="tripStatus"></span></p>
                        </div>

                        <!-- Bedragen -->
                        <div class="mt-6 border-t pt-4">
                            <p class="text-gray-600"><strong>Stoelnummer:</strong> <span id="seatNumber"></span></p>
                            <p class="text-gray-600"><strong>Aantal tickets:</strong> <span id="ticketQuantity"></span></p>
                            <p class="text-gray-800"><strong>Bedrag excl. BTW (€):</strong> 
                                <input type="number" name="amount_excl_vat" id="amount_excl_vat" step="0.01" min="0" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100">
                            </p>
                            <p class="text-gray-800"><strong>BTW (21%):</strong> € <span id="vatAmount"></span></p>
                            <p class="text-xl font-bold text-gray-800"><strong>Totaal (€):</strong> <span id="totalAmount"></span></p>
                        </div>

                        <!-- Opmerkingen -->
                        <div class="mt-6 border-t pt-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">Opmerking</label>
                            <textarea name="note" id="note" rows="3" maxlength="500"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100"></textarea>
                        </div>
                    </div>

                    <!-- Foutmeldingen -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Actieknoppen -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('invoice.index') }}"
                            class="bg-gray-400 text-white px-5 py-2 rounded-md hover:bg-gray-600 transition">
                            Annuleren
                        </a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Factuur Aanmaken
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('booking_id').addEventListener('change', function () {
        let selectedBookingId = this.value;
        let bookings = @json($bookings);
        let selectedBooking = bookings.find(booking => booking.id == selectedBookingId);

        if (selectedBooking) {
            document.getElementById('invoiceDetails').classList.remove('hidden');

            // Klantgegevens
            document.getElementById('customerName').innerText = selectedBooking.customer.person.first_name + ' ' + 
                (selectedBooking.customer.person.middle_name ? selectedBooking.customer.person.middle_name + ' ' : '') + 
                selectedBooking.customer.person.last_name;
            document.getElementById('relationNumber').innerText = 'Relatienummer: ' + selectedBooking.customer.relation_number;

            // Factuurgegevens
            document.getElementById('invoiceDate').innerText = new Date().toISOString().split('T')[0];

            // Vluchtdetails
            document.getElementById('flightNumber').innerText = selectedBooking.trip.flight_number;
            document.getElementById('departure').innerText = selectedBooking.trip.departure_date + ' ' + selectedBooking.trip.departure_time;
            document.getElementById('arrival').innerText = selectedBooking.trip.arrival_date + ' ' + selectedBooking.trip.arrival_time;
            document.getElementById('tripStatus').innerText = selectedBooking.trip.trip_status;

            // Bedragen
            document.getElementById('seatNumber').innerText = selectedBooking.seat_number;
            document.getElementById('ticketQuantity').innerText = selectedBooking.quantity;
        }
    });

    document.getElementById('amount_excl_vat').addEventListener('input', function () {
        let amountExclVat = parseFloat(this.value) || 0;
        let vatAmount = (amountExclVat * 21) / 100;
        let totalAmount = amountExclVat + vatAmount;

        document.getElementById('vatAmount').innerText = vatAmount.toFixed(2);
        document.getElementById('totalAmount').innerText = totalAmount.toFixed(2);
    });
</script>
