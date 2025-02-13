<x-html-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Our Travel Packages</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ([
        ['title' => 'Paris Getaway', 'destination' => 'Paris', 'duration' => '5 days', 'price' => '$1,299', 'description' => 'Experience the romance of Paris with guided tours of iconic landmarks and exquisite cuisine.', 'image' => 'Paris.png'],
        ['title' => 'Bali Beach Retreat', 'destination' => 'Bali', 'duration' => '7 days', 'price' => '$1,599', 'description' => 'Relax on pristine beaches and immerse yourself in Balinese culture and spirituality.', 'image' => 'Bali.png'],
        ['title' => 'New York City Explorer', 'destination' => 'New York', 'duration' => '4 days', 'price' => '$1,099', 'description' => 'Discover the Big Apple\'s famous sights, diverse neighborhoods, and vibrant nightlife.', 'image' => 'New_York.png'],
        ['title' => 'Tokyo Technology Tour', 'destination' => 'Tokyo', 'duration' => '6 days', 'price' => '$1,799', 'description' => 'Explore Japan\'s capital and its cutting-edge technology, ancient temples, and unique pop culture.', 'image' => 'Tokyo.png'],
        ['title' => 'Roman Holiday', 'destination' => 'Rome', 'duration' => '6 days', 'price' => '$1,499', 'description' => 'Walk through history in the streets of Rome, enjoying Italian cuisine and ancient wonders.', 'image' => 'Rome.png'],
        ['title' => 'Maldives Paradise', 'destination' => 'Maldives', 'duration' => '8 days', 'price' => '$2,999', 'description' => 'Indulge in luxury and relaxation in overwater bungalows on pristine Maldivian atolls.', 'image' => 'Maldives.png'],
    ] as $package)
                <div id="{{ Str::slug($package['title']) }}" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('img/' . $package['image']) }}" alt="{{ $package['title'] }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $package['title'] }}</h3>
                        <p class="text-gray-600 mb-2">{{ $package['description'] }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-sm text-gray-500">{{ $package['duration'] }}</span>
                            <span class="text-lg font-bold text-blue-600">{{ $package['price'] }}</span>
                        </div>
                        <button
                            class="mt-4 w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                            Book Now
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-html-layout>
