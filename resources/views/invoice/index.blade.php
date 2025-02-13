<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Facturen') }}
            </h2>
            <div class="flex items-center">
                <label class="flex items-center mr-4">
                    <span class="mr-2 text-white-900 toon">Toon Data</span>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" id="dataToggle"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                            checked />
                        <label for="dataToggle"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </label>
                <a href="{{ route('invoice.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Factuur Aanmaken</a>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Facturen List -->
                <div class="w-full">
                    <div class="bg-white shadow-lg rounded-lg my-6 overflow-x-auto">
                        @if ($invoices->count() > 0)
                            <table class="min-w-max w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                        <th class="py-4 px-6 text-left">Factuurnummer</th>
                                        <!-- <th class="py-4 px-6 text-left">Patient</th>
                                        <th class="py-4 px-6 text-left">Datum</th>
                                        <th class="py-4 px-6 text-center">Bedrag</th>
                                        <th class="py-4 px-6 text-center">Status</th>
                                        <th class="py-4 px-6 text-center">Acties</th> -->
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 text-sm font-light">
                                    @foreach ($invoices as $invoice)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left whitespace-nowrap font-medium"># {{ $invoice->number }}</td>
                                            <!-- <td class="py-3 px-6 text-left">{{ $invoice->patient->name }}</td>
                                            <td class="py-3 px-6 text-left">{{ $invoice->date }}</td>
                                            <td class="py-3 px-6 text-center">€ {{ $invoice->amount }}</td> -->

                                            <!-- <td class="py-3 px-6 text-center">
                                                @if($invoice->status == 'in behandeling')
                                                    <span class="bg-yellow-400 text-white py-1 px-3 rounded-full text-xs font-medium">in behandeling</span>
                                                @elseif($invoice->status == 'betaald')
                                                    <span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs font-medium">betaald</span>
                                                @elseif($invoice->status == 'onbetaald')
                                                    <span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs font-medium">onbetaald</span>
                                                @else
                                                    <span class="bg-gray-500 text-white py-1 px-3 rounded-full text-xs font-medium">{{ $invoice->status }}</span>
                                                @endif
                                            </td> -->


                                            <td class="py-3 px-6 text-center space-x-4">
                                                <a href="{{ route('invoice.show', $invoice->id) }}" class="text-blue-600 hover:text-blue-800 transition duration-300">ⓘ</a>
                                                <a href="{{ route('invoice.edit', $invoice->id) }}" class="text-yellow-500 hover:text-yellow-700 transition duration-300">✎</a>
                                                
                                                <!-- <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" class="inline-block" onsubmit="return confirmDeletion('{{ $invoice->date }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300">🗑️</button>
                                                </form> -->

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <tbody class="text-gray-600 text-sm font-light">
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="bg-red-500 text-white p-4 rounded mb-4" colspan="6">Geen facturen gevonden. Probeer later opnieuw.</td>
                                </tr>
                            </tbody>
                        @endif
                    </div>
                </div>
            </div>
            <div class="py-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Geen facturen gevonden. Probeer later opnieuw.</p>
    </div>
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
    
    function confirmDeletion(invoiceDate) {
        const invoiceDateObj = new Date(invoiceDate);
        const currentDate = new Date();
        const sevenYearsAgo = new Date(currentDate.setFullYear(currentDate.getFullYear() - 7));

        if (invoiceDateObj > sevenYearsAgo) {
            alert('De factuur kan niet worden verwijderd vanwege privacy beperkingen (GDPR) binnen 7 jaren');
            return false;
        }

        return confirm('Weet je zeker dat je deze factuur wilt verwijderen?');
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