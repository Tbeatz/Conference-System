<footer class="bg-gradient-to-r from-green-100 to-blue-500 text-dark py-6 mt-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-700 pt-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Left: Copyright -->
            <div class="text-lg text-center md:text-left">
                &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script> All rights reserved.
            </div>

            <!-- Right: Footer Links -->
            <ul class="flex flex-wrap justify-center md:justify-end space-x-4 text-lg font-medium">
                {{-- <li><a href="#" class="hover:text-red-400 transition">Terms of Use</a></li>
                <li><a href="#" class="hover:text-red-400 transition">Privacy Policy</a></li> --}}
                <li><a href="{{ route('guest.home', ['section' => 'contact']) }}"
                        class="hover:text-red-400 transition">Contact</a></li>
            </ul>
        </div>
    </div>
</footer>
