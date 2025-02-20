<section id="destinations" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Featured Destinations</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div x-blade="foreach(['Paris', 'Bali', 'New York', 'Tokyo', 'Rome', 'Maldives'] as $destination)">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('img/Maldives.png') }}" alt="Destination" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 x-blade="$destination" class="text-xl font-semibold mb-2"></h3>
                        <p class="text-gray-600">Experience the magic of <span x-blade="$destination"></span>
                            with
                            our exclusive travel packages.</p>
                        <a href="/underdevelopment" class="mt-4 inline-block text-blue-600 hover:underline">View
                            Packages</a>
                    </div>
                </div>
            </div>

            <div x-blade="foreach(['Paris', 'Bali', 'New York', 'Tokyo', 'Rome', 'Maldives'] as $destination)">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('img/New_York.png') }}" alt="Destination" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 x-blade="$destination" class="text-xl font-semibold mb-2"></h3>
                        <p class="text-gray-600">Experience the magic of <span x-blade="$destination"></span>
                            with
                            our exclusive travel packages.</p>
                        <a href="/underdevelopment" class="mt-4 inline-block text-blue-600 hover:underline">View
                            Packages</a>
                    </div>
                </div>
            </div>

            <div x-blade="foreach(['Paris', 'Bali', 'New York', 'Tokyo', 'Rome', 'Maldives'] as $destination)">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('img/Bali.png') }}" alt="Destination" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 x-blade="$destination" class="text-xl font-semibold mb-2"></h3>
                        <p class="text-gray-600">Experience the magic of <span x-blade="$destination"></span>
                            with
                            our exclusive travel packages.</p>
                        <a href="/underdevelopment" class="mt-4 inline-block text-blue-600 hover:underline">View
                            Packages</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
