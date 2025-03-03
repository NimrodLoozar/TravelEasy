<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Gebruikersgegevens -->
                <div
                    class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 lg:mb-0">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4">Mijn Gegevens</h3>


                        <h4 class="text-xl font-semibold">Naam</h4>
                        <br>
                        <p>{{ Auth::user()->name }}</p>

                        {{-- <a href="{{ route('messages.index') }}">View All Communications</a> --}}
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4">Facturen</h3>
                        <a href="{{ route('invoice.index') }}" class="text-blue-500 hover:underline">
                            Bekijk facturen
                        </a>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4">Accounts</h3>
                        <a href="{{ route('account.index') }}" class="text-blue-500 hover:underline">
                            Bekijk accounts
                        </a>
                    </div>

                </div>

                <!-- Boekinggegevens -->
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 lg:mb-0">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold">Aantal boekingen per/</h3>
                        </div>
                        <button onclick="toggleBookings()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Toon boekingen
                        </button>
                        <br>
                        <hr>
                        <br>
                        <div id="bookingStats" class="hidden">
                            <h4 class="text-2xl font-bold mb-4">kwartaal</h4>
                            <div class="mb-4">
                                @foreach($bookingStats['quarterly'] as $quarter => $count)
                                    <div class="flex justify-between items-center mb-2">
                                        <a href="{{ route('bookings.index') }}" class="text-blue-500 hover:underline">Q{{ $quarter }}:</a>
                                        <a href="{{ route('bookings.index') }}" class="font-bold text-blue-500 hover:underline">{{ $count }} boekingen</a>
                                    </div>
                                @endforeach
                            </div>

                            <h4 class="text-2xl font-bold mb-4">maand</h4>
                            <div>
                                @foreach($bookingStats['monthly'] as $month => $count)
                                    <div class="flex justify-between items-center mb-2">
                                        <a href="{{ route('bookings.index') }}" class="text-blue-500 hover:underline">{{ DateTime::createFromFormat('!m', $month)->format('F') }}:</a>
                                        <a href="{{ route('bookings.index') }}" class="font-bold text-blue-500 hover:underline">{{ $count }} boekingen</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div>
        <a href="{{ route('chat') }}"
            class="block w-full p-6 text-center text-white bg-[#FF2D20] rounded-lg shadow-lg hover:bg-[#FF1A00] focus:outline-none focus-visible:ring focus-visible:ring-[#FF2D20] focus-visible:ring-opacity-50">
            Chatbot By: <span class="font-bold">T. Tadesse</span>
        </a>
    </div>

    </div>
    </div>

    <script>
        function toggleBookings() {
            const stats = document.getElementById('bookingStats');
            const button = event.target;
            if (stats.classList.contains('hidden')) {
                stats.classList.remove('hidden');
                button.textContent = 'Verberg boekingen';
            } else {
                stats.classList.add('hidden');
                button.textContent = 'Toon boekingen';
            }
        }
    </script>
</x-app-layout>
