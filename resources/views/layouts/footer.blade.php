<footer class="bg-gray-900 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4">TravelEasy</h3>
                <p class="text-sm text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                    malesuada
                    lorem sed metus vehicula, eget congue felis sollicitudin.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="text-sm">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/destinations') }}">Destinations</a></li>
                    <li><a href="{{ url('/packages') }}">Packages</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <p class="text-sm text-gray-300">123 Main Street<br>Springfield, IL 62701<br>Phone: (555) 555-5555
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                <div class="flex space
                -x-4">
                    <a href="https://facebook.com" target="_blank"
                        class="text-xl text-white hover:text-gray-300 transition duration-300">
                        <img src="{{ asset('img/facebook.png') }}" alt="">
                    </a>
                    <a href="#" target="_blank"
                        class="text-xl text-white hover:text-gray-300 transition duration-300">
                        <img src="{{ asset('img/twitter.png') }}" alt="">
                    </a>
                    <a href="#" target="_blank"
                        class="text-xl text-white hover:text-gray-300 transition duration-300">
                        <img src="{{ asset('img/instagram.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto text-center">
        <p>&copy; {{ date('Y') }} TravelEasy. Alle rechten voorbehouden.</p>
    </div>
</footer>
