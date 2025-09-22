<!doctype html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Web-based Conference Paper Submission & Evaluation System')</title>

    <!-- Favicon & Manifest -->
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/logo.jpg') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yNf5F6UiwXtEMVnQJqZzO2N0PjYx6TRZfVxQK9LuH7/mq5B6iUmri+9rLQZCJDLwJykLJHho3e1ZkBuHJzFg8w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gradient-to-r from-purple-200 to-pink-200 text-gray-800 antialiased">

    {{-- Header --}}
    @include('guest.layout.Header')

    {{-- Main Content --}}
    <main class="relative min-h-screen py-12 px-4 sm:px-6 lg:px-8 text-white overflow-hidden">
        <!-- Background with blur -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/bg/conference.jpg') }}'); filter: blur(1px);">
        </div>

        <!-- Dark overlay (optional, improves text readability) -->
        <div class="absolute inset-0 bg-black/10"></div>

        <!-- Content -->
        <div class="relative z-10">
            @yield('main-content')
        </div>
    </main>




    {{-- Footer --}}
    @include('guest.layout.footer')

    {{-- Optional JS Plugins --}}
    <script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>
