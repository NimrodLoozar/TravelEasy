<x-html-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-6 text-center">About Travel Easy</h2>

        <div class="grid md:grid-cols-2 gap-8 items-center mb-12">
            <div>
                <p class="text-lg mb-4">
                    Travel Easy was founded in 2010 with a simple mission: to make travel accessible, enjoyable, and
                    memorable for everyone. Our team of experienced travel enthusiasts works tirelessly to curate the
                    best experiences around the world.
                </p>
                <p class="text-lg mb-4">
                    We believe that travel has the power to broaden horizons, create lasting memories, and bring people
                    together. Whether you're looking for a relaxing beach getaway, an adventurous trek, or a cultural
                    city exploration, we've got you covered.
                </p>
            </div>
            <div class="order-first md:order-last">
                <img src="{{ asset('img/flying-commercial-airplane-taking-off-sunset-with-dramatic-sky-generated-by-ai.jpg') }}"
                    alt="Travel Easy Team" class="rounded-lg shadow-md w-full">
            </div>
        </div>

        <h3 class="text-2xl font-bold mb-4">Our Values</h3>
        <ul class="list-disc pl-6 mb-8">
            <li class="mb-2">Customer Satisfaction: Your happiness is our top priority.</li>
            <li class="mb-2">Sustainability: We're committed to promoting responsible and eco-friendly travel.</li>
            <li class="mb-2">Innovation: We constantly seek new ways to improve your travel experience.</li>
            <li class="mb-2">Integrity: We believe in transparent pricing and honest communication.</li>
        </ul>

        <div class="bg-gray-100 p-6 rounded-lg">
            <h3 class="text-2xl font-bold mb-4">Why Choose Travel Easy?</h3>
            <ul class="grid md:grid-cols-2 gap-4">
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Expertly curated travel packages
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    24/7 customer support
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Competitive pricing
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Personalized travel planning
                </li>
            </ul>
        </div>
    </div>
</x-html-layout>
