<<<<<<< HEAD
<header class="fixed top-0 left-0 right-0 z-50 flex justify-between items-center px-1 py-1 bg-blue-400 custom-shadow">
    <div class="flex">
        <a href="{{ url('/') }}"><img src="{{ asset('img/aviation_18222397.png') }}" class="w-16" alt=""></a>
        <a href="{{ url('/about') }}" class="ml-4 text-lg font-semibold text-white hover:text-gray-300">About</a>
        <a href="{{ url('/contact') }}" class="ml-4 text-lg font-semibold text-white hover:text-gray-300">Contact</a>
        <a href="{{ url('/packages') }}" class="ml-4 text-lg font-semibold text-white hover:text-gray-300">Packages</a>
        <a href="{{ url('/destinations') }}"
            class="ml-4 text-lg font-semibold text-white hover:text-gray-300">Destinations</a>
    </div>
    @if (Route::has('login'))
        <nav class="flex"></nav>
        @auth
            <a href="{{ url('/dashboard') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                Dashboard
            </a>
        @else
            <div>
                <a href="{{ route('login') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                        Register
                    </a>
            </div>
        @endif
    @endauth
    </nav>
    @endif
</header>
=======
<header class="bg-teal-400 text-white shadow-[2px_2px_5px_rgba(0,0,0,0.75)]">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div>
            <h1 class="text-2xl font-bold">TravelEasy</h1>
            <p class="text-sm italic">Uw reis, onze vlucht</p>
        </div>
        @if (Route::has('login'))
            <nav class="-mx-3 flex flex-1 justify-end">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Admin Dashboard
                        </a>
                    @endif
                    <a href="{{ url('/dashboard') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif

    </div>
</header>
<!-- Header -->
>>>>>>> feature
