<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Bookings') }}
            </h2>
            <label class="flex items-center">
                <span class="mr-2 text-gray-200">Show Data</span>
                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" id="dataToggle"
                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                        checked />
                    <label for="dataToggle"
                        class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </label>
        </div>
    </x-slot>

    <div id="dataContainer" class="container mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-900 border-t-4 border-green-600 rounded-b px-4 py-3 text-green-200" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-white">Bookings</h1>
            <a href="{{ route('bookings.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create New Booking</a>
        </div>

        <!-- Search Form -->
        <div class="mb-6 bg-gray-800 p-4 rounded-lg">
            <form action="{{ route('bookings.index') }}" method="GET" class="flex space-x-4">
                <div class="flex-1">
                    <label for="departure_time" class="block text-gray-300 mb-2">Departure Time</label>
                    <input type="time" name="departure_time" id="departure_time" 
                           value="{{ request('departure_time') }}"
                           class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-1">
                    <label for="destination" class="block text-gray-300 mb-2">Destination</label>
                    <input type="text" name="destination" id="destination" 
                           value="{{ request('destination') }}"
                           class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Search destination...">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Search
                    </button>
                    @if(request('departure_time') || request('destination'))
                        <a href="{{ route('bookings.index') }}" class="ml-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-gray-700">
                    <th class="py-2 px-4 text-left text-gray-200">Customer</th>
                    <th class="py-2 px-4 text-left text-gray-200">Flight Number</th>
                    <th class="py-2 px-4 text-left text-gray-200">Departure</th>
                    <th class="py-2 px-4 text-left text-gray-200">Destination</th>
                    <th class="py-2 px-4 text-left text-gray-200">Departure Time</th>
                    <th class="py-2 px-4 text-left text-gray-200">Seat Number</th>
                    <th class="py-2 px-4 text-left text-gray-200">Status</th>
                    <th class="py-2 px-4 text-left text-gray-200">Price</th>
                    <th class="py-2 px-4 text-left text-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="border-t border-gray-700 hover:bg-gray-700">
                        <td class="py-2 px-4 text-gray-300">{{ $booking->customer->person->first_name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ $booking->trip->flight_number ?? 'N/A' }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ $booking->trip->departure->country ?? 'N/A' }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ $booking->trip->destination->country ?? 'N/A' }}</td>
                        <td class="py-2 px-4 text-gray-300">
                            {{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('d M Y') }}
                            {{ \Carbon\Carbon::parse($booking->trip->departure_time)->format('H:i') }}
                        </td>
                        <td class="py-2 px-4 text-gray-300">{{ $booking->seat_number }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ $booking->booking_status }}</td>
                        <td class="py-2 px-4 text-gray-300">${{ number_format($booking->price, 2) }}</td>
                        <td class="py-2 px-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('bookings.show', $booking->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</a>
                                <a href="{{ route('bookings.edit', $booking->id) }}"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-gray-300">
            {{ $bookings->links() }}
        </div>
    </div>

    <div id="errorContainer" class="container mx-auto mt-8 hidden ml-64">
        <p class="text-red-500">No bookings found at the moment.</p>
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
</script>

<style>
    .toggle-checkbox:checked {
        right: 0;
        border-color: #68D391;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #68D391;
    }
</style>