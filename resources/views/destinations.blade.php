<x-html-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Featured Destinations</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach (['Paris', 'Bali', 'New York', 'Tokyo', 'Rome', 'Maldives'] as $destination)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/placeholder.jpg') }}" alt="{{ $destination }}"
                        class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $destination }}</h3>
                        <p class="text-gray-600 mb-4">Experience the magic of {{ $destination }} with our exclusive
                            travel packages.</p>
                        <a href="{{ route('packages') }}#{{ strtolower($destination) }}"
                            class="text-blue-600 hover:underline">
                            View Packages
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-html-layout>
