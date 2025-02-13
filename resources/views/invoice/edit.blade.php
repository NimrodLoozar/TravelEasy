<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Factuur Aanpassen') }}
            </h2>
            <div class="flex items-center mt-4 sm:mt-0">
                <label class="flex items-center">
                    <span class="mr-2 text-gray-200">Toon Data</span>
                    <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" id="dataToggle"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                            checked />
                        <label for="dataToggle"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </label>
            </div>
        </div>
    </x-slot>

    <!-- Data Container -->
    <div id="dataContainer" class="py-5 px-3 sm:px-6 lg:px-8 bg-white shadow-md rounded-md">
        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" class="space-y-4 ml-8 mr-8">
            @csrf
            @method('PUT')

            <!-- Factuurnummer -->
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700">Factuurnummer</label>
                <input type="text" name="number" id="number" value="{{ old('number', $invoice->number) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    readonly>
            </div>

            <!-- Booking Selectie -->
            <div>
                <label for="booking_id" class="block text-sm font-medium text-gray-700">Booking</label>
                <select name="booking_id" id="booking_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @foreach($bookings as $booking)
                        <option value="{{ $booking->id }}" {{ old('booking_id', $invoice->booking_id) == $booking->id ? 'selected' : '' }}>
                            {{ $booking->name }} (ID: {{ $booking->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Datum -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Datum</label>
                <input type="date" name="date" id="date" value="{{ old('date', $invoice->date) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <!-- Bedrag exclusief BTW -->
            <div>
                <label for="amount_excl_vat" class="block text-sm font-medium text-gray-700">Bedrag exclusief BTW</label>
                <input type="number" name="amount_excl_vat" id="amount_excl_vat" step="0.01"
                    value="{{ old('amount_excl_vat', $invoice->amount_excl_vat) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <!-- BTW Percentage -->
            <div>
                <label for="vat" class="block text-sm font-medium text-gray-700">BTW Percentage</label>
                <input type="number" name="vat" id="vat" step="0.01" value="{{ old('vat', $invoice->vat) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <!-- Bedrag inclusief BTW -->
            <div>
                <label for="amount_incl_vat" class="block text-sm font-medium text-gray-700">Bedrag inclusief BTW</label>
                <input type="number" name="amount_incl_vat" id="amount_incl_vat" step="0.01"
                    value="{{ old('amount_incl_vat', $invoice->amount_incl_vat) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    readonly>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="in behandeling" {{ old('status', $invoice->status) == 'in behandeling' ? 'selected' : '' }}>In Behandeling</option>
                    <option value="betaald" {{ old('status', $invoice->status) == 'betaald' ? 'selected' : '' }}>Betaald</option>
                    <option value="onbetaald" {{ old('status', $invoice->status) == 'onbetaald' ? 'selected' : '' }}>Onbetaald</option>
                </select>
            </div>

            <!-- Notitie -->
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Notitie</label>
                <textarea name="note" id="note" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('note', $invoice->note) }}</textarea>
            </div>

            <!-- Actieknoppen -->
            <div class="flex justify-end gap-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Opslaan
                </button>
                <a href="{{ route('invoice.index') }}"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">
                    Annuleren
                </a>
            </div>
        </form>
    </div>

    <!-- Error Container -->
    <div id="errorContainer" class="py-6 hidden">
        <p class="text-red-500 font-semibold text-center">De factuur kon niet worden gewijzigd. Controleer de gegevens en probeer het opnieuw.</p>
    </div>
</x-app-layout>

<script>
    // Toggle visibility
    document.getElementById('dataToggle').addEventListener('change', function () {
        document.getElementById('dataContainer').classList.toggle('hidden', !this.checked);
        document.getElementById('errorContainer').classList.toggle('hidden', this.checked);
    });

    // BTW-berekening
    document.getElementById('amount_excl_vat').addEventListener('input', calculateVat);
    document.getElementById('vat').addEventListener('input', calculateVat);

    function calculateVat() {
        const amountExclVat = parseFloat(document.getElementById('amount_excl_vat').value) || 0;
        const vatPercentage = parseFloat(document.getElementById('vat').value) || 0;
        const vatAmount = (amountExclVat * vatPercentage) / 100;
        const amountInclVat = amountExclVat + vatAmount;

        document.getElementById('amount_incl_vat').value = amountInclVat.toFixed(2);
    }

    // Bereken BTW bij het laden van de pagina
    calculateVat();
</script>

<style>
    .toggle-checkbox:checked {
        right: 0;
        border-color: #68D391;
    }

    .toggle-checkbox:checked + .toggle-label {
        background-color: #68D391;
    }
</style>