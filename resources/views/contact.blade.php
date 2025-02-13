<x-html-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Contact Us</h2>

        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-2xl font-bold mb-4">Get in Touch</h3>
                <p class="mb-4">We'd love to hear from you! Whether you have a question about our packages, need help
                    with a booking, or just want to say hello, don't hesitate to reach out.</p>

                <div class="mb-4">
                    <h4 class="font-bold">Email</h4>
                    <p>info@traveleasy.com</p>
                </div>

                <div class="mb-4">
                    <h4 class="font-bold">Phone</h4>
                    <p>+1 (555) 123-4567</p>
                </div>

                <div class="mb-4">
                    <h4 class="font-bold">Address</h4>
                    <p>123 Travel Street, Wanderlust City, Adventure State 12345, USA</p>
                </div>

                <div class="mb-4">
                    <h4 class="font-bold">Office Hours</h4>
                    <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                    <p>Saturday: 10:00 AM - 4:00 PM</p>
                    <p>Sunday: Closed</p>
                </div>
            </div>

            <div>
                <h3 class="text-2xl font-bold mb-4">Send Us a Message</h3>
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block mb-1">Name</label>
                        <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-md"
                            required>
                    </div>
                    <div>
                        <label for="email" class="block mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-md"
                            required>
                    </div>
                    <div>
                        <label for="subject" class="block mb-1">Subject</label>
                        <input type="text" id="subject" name="subject" class="w-full px-3 py-2 border rounded-md"
                            required>
                    </div>
                    <div>
                        <label for="message" class="block mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 border rounded-md" required></textarea>
                    </div>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">Send
                        Message</button>
                </form>
            </div>
        </div>
    </div>
</x-html-layout>
