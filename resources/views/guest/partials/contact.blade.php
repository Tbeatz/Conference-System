{{-- preparation --}}
<section class="bg-white py-8 px-4 max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div>
            {{-- <h2 class="text-2xl font-bold uppercase mb-4">Leave Us Your Info</h2> --}}
                <h2 class="text-2xl font-bold uppercase mb-4 text-black">Contact Us</h2>
            <p class="text-gray-600 mb-6">Please feel free to contact us.</p>

            @if (session('success'))
                <div class="mb-4 text-green-700 bg-green-100 p-2 rounded">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Your Name (required)</label>
                    <input type="text" name="name" class="w-full border border-gray-300 text-black rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Your Email (required)</label>
                    <input type="email" name="email" class="w-full border border-gray-300 text-black rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" class="w-full border border-gray-300 text-black rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Your Message</label>
                    <textarea name="message" rows="4" class="w-full border border-gray-300 text-black rounded p-2"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit"
                        class="bg-gradient-to-r from-green-100 to-blue-200 text-black hover:bg-yellow-300  text-sm font-semibold px-4 py-2 rounded transition cursor-pointer">Send
                        Message</button>
                </div>
            </form>
        </div>

        <!-- Location / Contact Info -->
        <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto">
            <h2 class="text-2xl font-bold mb-4 flex items-center gap-2 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0-2.21-1.79-4-4-4s-4 1.79-4 4 1.79 4 4 4 4-1.79 4-4zm0 0v4a4 4 0 004 4h4m-8-8H8" />
                </svg>
                Location
            </h2>

            <div class="space-y-3">
                <!-- University -->
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-full flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0-2.21-1.79-4-4-4s-4 1.79-4 4 1.79 4 4 4 4-1.79 4-4z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800">University of Computer Studies, Pyay</p>
                </div>

                <!-- Address -->
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 text-green-600 p-2 rounded-full flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a5 5 0 00-10 0v2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 11h14l-1 9H6l-1-9z" />
                        </svg>
                    </div>
                    <p class="text-gray-600"><span class="font-semibold">Address:</span>Pyay-Aung Lan Road, Pyay, Myanmar
                    </p>
                </div>

                <!-- Phone -->
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5l3 3 2-2 4 4-2 2 3 3" />
                        </svg>
                    </div>
                    <p class="text-gray-600"><span class="font-semibold">Phone:</span> +95-1-9664254, +95-775994221,
                        +95-774152166</p>
                </div>

                <!-- Email -->
                <div class="flex items-center gap-3">
                    <div class="bg-red-100 text-red-600 p-2 rounded-full flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12H8m8 0l-8 8m8-8l-8-8" />
                        </svg>
                    </div>
                    <p class="text-gray-600"><span class="font-semibold">Email:</span> contact@ucspyay.edu.mm</p>
                </div>

                <!-- Nearest Bus Stop -->
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 text-purple-600 p-2 rounded-full flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M3 6h18M3 14h12" />
                        </svg>
                    </div>
                    <p class="text-gray-600"><span class="font-semibold">Nearest Bus Stop:</span> Aung Lan, Pyay Road
                    </p>
                </div>
            </div>
        </div>


    </div>
</section>
