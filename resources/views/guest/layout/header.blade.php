{{-- <header class="bg-gradient-to-r from-green-100 to-blue-500 text-white shadow-md sticky top-0 z-50"
    x-data="{ mobileOpen: false, profileOpen: false }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top Bar -->
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
<a href="/" class="flex items-center gap-4 hover:opacity-90 transition">
    <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="Logo" class="h-14 max-w-[60px] object-contain">
    <span class="text-xl font-semibold text-black">Web-based Conference Paper Submission & Evaluation System</span>
</a> --}}
<header class="bg-gradient-to-r from-green-100 to-blue-500 text-white shadow-md sticky top-0 z-50"
    x-data="{ mobileOpen: false, profileOpen: false }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top Bar -->
        <div class="flex justify-between items-center py-4">

            <!-- Logo + Title -->
            <a href="/" class="flex items-center gap-2 hover:opacity-90 transition ml-4">
                <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="Logo" class="h-14 w-14 object-contain">
                <span class="text-2xl font-bold text-blue-900 tracking-wide drop-shadow-md">
                    Web-based Conference <br>
                    <span class="text-sm font-medium text-blue-700">
                        Paper Submission & Evaluation System
                    </span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-6 text-lg font-semibold">

                <a href="{{ route('guest.home', ['section' => 'home']) }}"
                    class="text-black hover:text-orange-500 transition"
                    style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">Home</a>

                <a href="{{ route('guest.home', ['section' => 'events']) }}"
                    class="text-black hover:text-orange-500 transition"
                    style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">Events</a>
                {{-- <div class="relative group inline-block">
                    <button class="text-black hover:text-green-200 transition">
                        Journals&Conferences ▼
                    </button>

                    <div
                        class="absolute hidden group-hover:block ... bg-white shadow-md rounded mt-1 z-50 text-sm min-w-[150px]">

                        <a href="{{ route('guest.home', ['section' => 'journal']) }}"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-800">Journal</a>
                        <a href="{{ route('guest.home', ['section' => 'conference']) }}"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-800">Conference</a>
                    </div>
                </div> --}}
                @if (Auth::check() && Auth::user()->roles->contains('name', 'reviewer'))
                    <a href="{{ route('guest.home', ['section' => 'conferences']) }}"
                        class="text-black hover:text-orange-500 transition"
                        style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">Review Paper</a>
                    {{-- <div class="relative group inline-block"> --}}
                    {{-- <button class="text-black hover:text-green-200 transition "
                            style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">
                            Review ▼
                        </button> --}}

                    {{-- <!-- Dropdown -->
                        <div
                            class="absolute  group-hover:block ... bg-white shadow-md rounded mt-1 z-50 text-sm min-w-[150px]"> --}}
                    {{-- <a href="{{ route('guest.home', ['section' => 'journals']) }}"
                                class="block px-4 py-2 hover:bg-green-100 text-gray-800">Journal</a> --}}
                    {{-- <a href="{{ route('guest.home', ['section' => 'conferences']) }}"
                            class="block px-4 py-2 hover:bg-green-100 text-gray-800">Review Conference</a> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                @endif
                <a href="{{ route('guest.home', ['section' => 'about']) }}"
                    class="text-black hover:text-orange-500 transition"
                    style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">About</a>
                <a href="{{ route('guest.home', ['section' => 'contact']) }}"
                    class="text-black hover:text-orange-500 transition"
                    style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">Contact</a>





                @auth
                    @php
                        $unreadCount = Auth::user()->unreadNotifications()->count();
                    @endphp

                    @if (Auth::user()->roles->contains('name', 'author'))
                        <a href="{{ route('guest.home', ['section' => 'notification']) }}"
                            class="relative flex items-center gap-1 text-black hover:text-orange-500 transition"
                            style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">

                            <!-- Bell Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                <path d="M10 18a2 2 0 002-2H8a2 2 0 002 2z" />
                            </svg>

                            <span>Notifications</span>

                            <!-- Unread count badge -->
                            @if ($unreadCount > 0)
                                <span
                                    class="absolute -top-3 -right-3 bg-orange-500 text-white text-sm font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                    @elseif (Auth::user()->roles->contains('name', 'reviewer'))
                        <a href="{{ route('guest.home', ['section' => 'noti']) }}"
                            class="relative flex items-center gap-1 text-black hover:text-orange-500 transition"
                            style="text-shadow: 2px 2px 4px rgba(222, 222, 222, 0.936);">

                            <!-- Bell Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                <path d="M10 18a2 2 0 002-2H8a2 2 0 002 2z" />
                            </svg>

                            <span>Notifications</span>

                            <!-- Unread count badge -->
                            @if ($unreadCount > 0)
                                <span
                                    class="absolute -top-3 -right-3 bg-orange-500 text-white text-sm font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                    @endif
                @endauth



            </nav>

            <!-- Auth Buttons / Profile -->
            <div class="flex items-center gap-3">
                @auth
                    <div class="relative" x-data="{ open: false, showProfile: false }">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/profile.png') }}"
                                class="w-9 h-9 rounded-full border border-green-300 shadow object-cover" alt="Avatar">
                            <div class="text-lg ">
                                <span class="block">{{ Auth::user()->name }}</span>
                                <span class="block text-white text-lg">
                                    {{ Auth::user()->roles->first() ? ucfirst(Auth::user()->roles->first()->name) : 'No Role' }}
                                </span>
                            </div>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-green-500 text-white rounded-md shadow-md py-2 z-50"
                            x-transition>
                            <button @click="showProfile = true; open = false"
                                class="w-full text-left px-4 py-2 hover:bg-green-600">View Profile</button>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 hover:bg-green-600">Logout</button>
                            </form>
                        </div>

                        <!-- Profile Modal -->
                        <div x-show="showProfile"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-96 max-w-full p-6 relative">
                                <button @click="showProfile = false"
                                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">&times;</button>
                                <div class="text-center">
                                    <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/profile.png') }}"
                                        class="w-24 h-24 mx-auto rounded-full border border-green-300 shadow object-cover"
                                        alt="Avatar">
                                    <h2 class="text-xl font-semibold text-gray-600 mt-4">{{ Auth::user()->name }}</h2>
                                    <p class="text-gray-600 mt-1">{{ Auth::user()->email }}</p>
                                    <p class="text-yellow-500 mt-1">
                                        {{ Auth::user()->roles->first() ? ucfirst(Auth::user()->roles->first()->name) : 'No Role' }}
                                    </p>

                                    <!-- Add more profile info here if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth


                @guest
                    <a href="{{ route('guest.home', ['section' => 'register']) }}"
                        class="bg-gradient-to-r from-green-100 to-green-100 hover:bg-purple-500 text-black px-4 py-1.5 rounded-md text-lg font-medium transition">
                        Register
                    </a>
                    <a href="{{ route('guest.home', ['section' => 'login']) }}"
                        class="bg-gradient-to-r from-green-100 to-green-100 hover:bg-puple-400 text-black px-4 py-1.5 rounded-md text-lg font-medium transition">
                        Login
                    </a>
                @endguest

                <!-- Mobile Toggle -->
                <button @click="mobileOpen = !mobileOpen"
                    class="md:hidden text-white hover:text-green-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileOpen" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden" x-show="mobileOpen" x-transition>
        <div
            class="bg-gradient-to-r from-green-400 to-blue-600 border-t border-green-300 px-4 py-4 space-y-3 text-sm font-medium text-white">
            <a href="{{ route('guest.home', ['section' => 'events']) }}" class="block hover:text-green-200">Events</a>
            <a href="{{ route('guest.home', ['section' => 'about']) }}" class="block hover:text-green-200">About</a>
            <a href="{{ route('guest.home', ['section' => 'contact']) }}"
                class="block hover:text-green-200">Contact</a>

            @auth
                <a href="{{ route('guest.home', ['section' => 'notification']) }}" class="block hover:text-green-200">
                    Notifications ({{ $unreadCount }})
                </a>
            @endauth

            @guest
                <a href="{{ route('guest.home', ['section' => 'register']) }}"
                    class="bg-gradient-to-r from-green-100 block hover:text-white-200">Register</a>
                <a href="{{ route('guest.home', ['section' => 'login']) }}"
                    class="bg-gradient-to-r from-green-100 block hover:text-white-200">Login</a>
            @endguest
        </div>
    </div>
</header>
