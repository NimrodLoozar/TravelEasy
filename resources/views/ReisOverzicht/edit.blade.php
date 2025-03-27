<x-app-layout>
    <div class="min-h-screen p-6 flex items-center justify-center dark:bg-gray-900 dark:text-white">
        <div class="container max-w-screen-lg mx-auto">
            <h2 class="font-semibold text-xl text-gray-600 dark:text-gray-300">Reis Details</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Bekijk en bewerk de gegevens van de Reis.</p>

            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-800">
                <form action="{{ route('reisoverzicht.update', $reis->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="bg-red-100 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-700" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="md:col-span-5">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country" value="{{ old('country', $reis->departure->country ?? '') }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                        <label for="airport">Airport</label>
                        <input type="text" id="airport" name="airport" value="{{ old('airport', $reis->departure->airport ?? '') }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                        <label for="departure_date">Departure Date</label>
                        <input type="date" id="departure_date" name="departure_date" value="{{ old('departure_date', $reis->departure_date?->format('Y-m-d')) }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                        <label for="departure_time">Departure Time</label>
                        <input type="time" id="departure_time" name="departure_time" value="{{ old('departure_time', substr($reis->departure_time, 0, 5)) }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                        <label for="arrival_date">Arrival Date</label>
                        <input type="date" id="arrival_date" name="arrival_date" value="{{ old('arrival_date', $reis->arrival_date?->format('Y-m-d')) }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                        <label for="arrival_time">Arrival Time</label>
                        <input type="time" id="arrival_time" name="arrival_time" value="{{ old('arrival_time', substr($reis->arrival_time, 0, 5)) }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                        <label for="status">Status</label>
                        <select name="is_active" id="status" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <option value="1" {{ $reis->is_active ? 'selected' : '' }}>Actief</option>
                            <option value="0" {{ !$reis->is_active ? 'selected' : '' }}>Inactief</option>
                        </select>
                    </div>

                    <div class="md:col-span-5">
                        <label for="note">Note (optioneel)</label>
                        <input type="text" id="note" name="note" value="{{ old('note', $reis->note) }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5 text-right">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
