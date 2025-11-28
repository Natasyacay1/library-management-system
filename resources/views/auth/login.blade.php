{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <h2 class="text-xl font-semibold text-center mb-6">
        {{ __('Login') }}
    </h2>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                Password
            </label>
            <input id="password" type="password" name="password" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </div>

        {{-- Remember me --}}
        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm
                              focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <span class="ml-2 text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-indigo-600 hover:underline"
                   href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>

        {{-- Tombol login --}}
        <div class="pt-2">
            <button type="submit"
                    class="w-full inline-flex justify-center items-center px-4 py-2
                           bg-indigo-600 border border-transparent rounded-md font-semibold
                           text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                LOG IN
            </button>
        </div>

        {{-- Link ke register --}}
        <p class="text-center text-xs text-gray-600 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">
                Register
            </a>
        </p>
    </form>
</x-guest-layout>
