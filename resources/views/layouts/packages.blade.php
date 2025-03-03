<section id="packages" class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Our Travel Packages</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div x-blade="foreach($packages as $package)">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('img/Rome.png') }}" alt="Package" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 x-blade="$package['title']" class="text-xl font-semibold mb-2"></h3>
                        <p x-blade="$package['description']" class="text-gray-600 mb-4"></p>
                        <div class="flex justify-between items-center mt-4">
                            <span x-blade="$package['duration']" class="text-sm text-gray-500"></span>
                            <span x-blade="$package['price']" class="text-lg font-bold text-blue-600"></span>
                        </div>
                        <a href="/underdevelopment" {{-- x-blade="'href=package.html?id=' . $package['id']" --}}
                            class="mt-4 inline-block w-full text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

            <div x-blade="foreach($packages as $package)">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('img/Paris.png') }}" alt="Package" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 x-blade="$package['title']" class="text-xl font-semibold mb-2"></h3>
                        <p x-blade="$package['description']" class="text-gray-600 mb-4"></p>
                        <div class="flex justify-between items-center mt-4">
                            <span x-blade="$package['duration']" class="text-sm text-gray-500"></span>
                            <span x-blade="$package['price']" class="text-lg font-bold text-blue-600"></span>
                        </div>
                        <a href="/underdevelopment" {{-- x-blade="'href=package.html?id=' . $package['id']" --}}
                            class="mt-4 inline-block w-full text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

            <div x-blade="foreach($packages as $package)">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('img/Tokyo.png') }}" alt="Package" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 x-blade="$package['title']" class="text-xl font-semibold mb-2"></h3>
                        <p x-blade="$package['description']" class="text-gray-600 mb-4"></p>
                        <div class="flex justify-between items-center mt-4">
                            <span x-blade="$package['duration']" class="text-sm text-gray-500"></span>
                            <span x-blade="$package['price']" class="text-lg font-bold text-blue-600"></span>
                        </div>
                        <a href="/underdevelopment" {{-- x-blade="'href=package.html?id=' . $package['id']" --}}
                            class="mt-4 inline-block w-full text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
