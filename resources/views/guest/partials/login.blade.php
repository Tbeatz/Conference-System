<div class="min-h-screen flex items-center justify-center  py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white text-black shadow-xl rounded-xl p-8 space-y-6">
        <h2 class="text-center text-3xl font-bold text-gray-900">Login to Your Account</h2>

        @if (session('error'))
            <div class="text-red-600 text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <form class="space-y-5" method="POST" action="{{ route('login.post') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" required autofocus
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- Remember Me -->
            {{-- <div class="flex items-center justify-between">
                <label class="inline-flex items-center text-sm text-gray-700">
                    <input type="checkbox" name="remember" class="form-checkbox text-blue-600" />
                    <span class="ml-2">Remember me</span>
                </label> --}}

            {{-- <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot
                    password?</a> --}}
            {{-- </div> --}}

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 transition duration-300">
                    Login
                </button>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600">
            Don’t have an account?
            <a href="{{ route('guest.home', ['section' => 'register']) }}"
                class="text-blue-500 hover:underline font-medium">Register</a>
        </p>
    </div>
</div>
