<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Factuur') }} #{{ $invoice->number }}
            </h2>
            <div class="flex items-center">
                <label class="flex items-center mr-4">
                    <span class="mr-2 text-white">Toon Data</span>
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

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6 border">
               
            <!-- Factuurinformatie -->
<div class="mb-6">
    <h3 class="text-2xl font-bold text-gray-700">Factuurnummer: <span class="text-blue-600">#{{ $invoice->number }}</span></h3>
</div>

<!-- Datum -->
<div class="mb-4">
    <p><strong>Datum:</strong> {{ $invoice->date }}</p>
</div>

<!-- Klantnaam -->
<div class="mb-4">
    <p><strong>Naam:</strong> 
        @if ($invoice->booking && $invoice->booking->customer && $invoice->booking->customer->person)
            {{ $invoice->booking->customer->person->first_name }} {{ $invoice->booking->customer->person->middle_name }} {{ $invoice->booking->customer->person->last_name }}
        @else
            N/A
        @endif
    </p>
</div>

<!-- vlucht info -->

<!-- Bedrag excl. BTW -->
<div class="mb-4">
    <p><strong>Bedrag excl. BTW:</strong> € {{ number_format($invoice->amount_excl_vat, 2, ',', '.') }}</p>
</div>

<!-- BTW -->
<div class="mb-4">
    <p><strong>BTW:</strong> € {{ number_format($invoice->vat, 2, ',', '.') }}</p>
</div>

<!-- Bedrag incl. BTW -->
<div class="mb-4">
    <p><strong>Totaal:</strong> <span class="font-bold">€ {{ number_format($invoice->amount_incl_vat, 2, ',', '.') }}</span></p>
</div>

<!-- Status -->
<div class="mb-6">
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

                <!-- Actieknoppen -->
                <div class="flex justify-end">
                    <a href="{{ route('invoice.index') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">
                        Terug naar overzicht
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Foutmelding Container -->
    <div id="errorContainer" class="py-12 hidden text-center">
        <p class="text-red-500 font-semibold">De factuur kon niet worden ingeladen. Probeer het later opnieuw.</p>
    </div>
</x-app-layout>

<!-- JavaScript -->
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

<!-- CSS -->
<style>
    .toggle-checkbox:checked {
        right: 0;
        border-color: #38A169;
    }

    .toggle-checkbox:checked + .toggle-label {
        background-color: #38A169;
    }
</style>