<x-app-layout>
    <div class="min-h-screen p-6 flex items-center justify-center dark:bg-gray-900 dark:text-white">
        <div class="container max-w-screen-lg mx-auto">

            @if ($errors->any())
                <div class="bg-red-100 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-700" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div>
                <h2 class="font-semibold text-xl text-gray-600 dark:text-gray-300">Reis formulier</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Vul het formulier in om een nieuwe reis toe te voegen.</p>

                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-800">
                    <form action="{{ route('reisoverzicht.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600 dark:text-gray-300">
                                <p class="font-medium text-lg">Reis Gegevens</p>
                                <p>Vul alle velden in.</p>
                            </div>

                            <div class="md:col-span-5">
                                <label for="country">country</label>
                                <input type="text" name="country" id="country"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-700 dark:text-gray-300"
                                    placeholder="Bijv. Nederland, Duitsland, China, enz." />
                            </div>

                            <div class="md:col-span-5">
                                <label for="airport">Luchthaven</label>
                                <input type="text" name="airport" id="airport"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-700 dark:text-gray-300"
                                    placeholder="Bijv. Hintzberg International Airport, Walkerbury International Airport, enz." />
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
                                <input type="text" name="note" id="note"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-700 dark:text-gray-300"
                                    placeholder="Bijv. most flyed planes." />
                            </div>

                                    <div class="md:col-span-5 text-right">
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Verstuur</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

