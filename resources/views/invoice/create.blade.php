<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Factuur Aanmaken') }}
            </h2>
            <div class="flex mt-4 sm:mt-0">
                <label class="flex">
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

    <div id="dataContainer" class="py-6 px-4 sm:px-6 lg:px-8 bg-white shadow-md rounded-md">
        <form action="{{ route('invoice.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Factuurnummer -->
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700">Factuurnummer</label>
                <input type="text" name="number" id="number"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ $newNumber }}" readonly placeholder="Factuurnummer wordt automatisch gegenereerd">
            </div>


            <!-- booking info still needed for flights and stuff. -->

            <!-- Booking Selectie -->
            <div>
                <label for="booking_id" class="block text-sm font-medium text-gray-700">Booking</label>
                <select name="booking_id" id="booking_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @if($bookings->isEmpty())
                        <option value="" disabled>Geen bookings beschikbaar</option>
                    @else
                        @foreach($bookings as $booking)
                            <option value="{{ $booking->id }}">{{ $booking->name }} (ID: {{ $booking->id }})</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Datum -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Datum</label>
                <input type="date" name="date" id="date"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <!-- Bedrag exclusief BTW -->
            <div>
                <label for="amount_excl_vat" class="block text-sm font-medium text-gray-700">Bedrag exclusief BTW</label>
                <input type="number" name="amount_excl_vat" id="amount_excl_vat" step="0.01"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <!-- BTW Percentage -->
            <div>
                <label for="vat" class="block text-sm font-medium text-gray-700">BTW Percentage</label>
                <input type="number" name="vat" id="vat" step="0.01"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="21" required readonly>
            </div>

            <!-- Bedrag inclusief BTW -->
            <div>
                <label for="amount_incl_vat" class="block text-sm font-medium text-gray-700">Bedrag inclusief BTW</label>
                <input type="number" name="amount_incl_vat" id="amount_incl_vat" step="0.01"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    readonly>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="in behandeling">In Behandeling</option>
                    <option value="betaald">Betaald</option>
                    <option value="onbetaald">Onbetaald</option>
                </select>
            </div>

            <!-- Notitie -->
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Notitie</label>
                <textarea name="note" id="note" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Actieknoppen -->
            <div class="flex flex-wrap gap-4">
                <button type="submit"
                    class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Aanmaken
                </button>
                <a href="{{ route('invoice.index') }}"
                    class="w-full sm:w-auto bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-600 text-center">
                    Annuleren
                </a>
            </div>
        </form>
    </div>

    <div id="errorContainer" class="ml-6 py-6 px-4 sm:px-6 lg:px-8 hidden">
        <p class="text-red-500">De factuur kan niet worden aangemaakt. Controleer de gegevens en probeer het opnieuw.</p>
    </div>
</x-app-layout>

<script>
    // Toggle visibility
    document.getElementById('dataToggle').addEventListener('change', function () {
    const dataContainer = document.getElementById('dataContainer');
    const errorContainer = document.getElementById('errorContainer');

    dataContainer.classList.toggle('hidden', !this.checked);
    errorContainer.classList.toggle('hidden', this.checked);

    if (!this.checked) {
        errorContainer.classList.add('hidden'); // Zorg ervoor dat foutmeldingen ook verborgen zijn
    }
    });

    document.querySelector('a[href="{{ route('invoice.index') }}"]').addEventListener('click', function (e) {
        if (!confirm('Weet je zeker dat je wilt annuleren? Niet-opgeslagen gegevens gaan verloren.')) {
            e.preventDefault();
        }
    });

    // Calculate amount incl. VAT
    document.getElementById('amount_excl_vat').addEventListener('input', calculateVat);
    document.getElementById('vat').addEventListener('input', calculateVat);

    function calculateVat() {
        const amountExclVat = parseFloat(document.getElementById('amount_excl_vat').value) || 0;
        const vatPercentage = parseFloat(document.getElementById('vat').value) || 0;
        const vatAmount = (amountExclVat * vatPercentage) / 100;
        const amountInclVat = amountExclVat + vatAmount;

        document.getElementById('amount_incl_vat').value = amountInclVat.toFixed(2);
    }
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