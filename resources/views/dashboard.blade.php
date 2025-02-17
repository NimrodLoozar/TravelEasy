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
                        <p>{{ Auth::user()->name }}</p>

                        <h4 class="text-xl font-semibold mt-4">Email</h4>
                        <p>{{ Auth::user()->email }}</p>


                    </div>

                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-2xl font-bold mb-4">Facturen</h3>
                            <a href="{{ route('invoice.index') }}" class="text-blue-500 hover:underline">
                                Bekijk facturen
                            </a>
                        </div>
                    @endif

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
            </div>
        </div>
    </div>
    </div>

    <div class="py-12">
        <x-responsive-nav-link :href="route('logout')"
            onclick="event.preventDefault();
                                        this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-responsive-nav-link>
    </div>
        



        <div>
        <a href="{{ route('chat') }}"
            class="block w-full p-6 text-center text-white bg-[#FF2D20] rounded-lg shadow-lg hover:bg-[#FF1A00] focus:outline-none focus-visible:ring focus-visible:ring-[#FF2D20] focus-visible:ring-opacity-50">
            Start Chatting with a chatbot
        </a>
        </div>
    </div>
</x-app-layout>
