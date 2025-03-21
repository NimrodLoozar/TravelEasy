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
                        <label for="country">country</label>
                        <input type="text" id="country" name="country" value="{{ $reis->country }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                        <label for="airport">airport</label>
                        <input type="text" id="airport" name="airport" value="{{ $reis->airport }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5">
                                <label for="status">Status</label>
                                <select name="is_active" id="status"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="1">Actief</option>
                                    <option value="0">Inactief</option>
                                </select>
                            </div>

                    <div class="md:col-span-5">
                        <label for="note">Note (optineel)</label>
                        <input type="text" id="note" name="note" value="{{ $reis->note }}" class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full">
                    </div>

                    <div class="md:col-span-5 text-right">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
