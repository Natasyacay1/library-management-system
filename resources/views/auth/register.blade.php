{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
    <h2 class="text-xl font-semibold text-center mb-6">
        {{ __('Register') }}
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

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
                Name
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                Confirm Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </div>

        {{-- Tombol register --}}
        <div class="pt-2">
            <button type="submit"
                    class="w-full inline-flex justify-center items-center px-4 py-2
                           bg-indigo-600 border border-transparent rounded-md font-semibold
                           text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                REGISTER
            </button>
        </div>

        {{-- Link ke login --}}
        <p class="text-center text-xs text-gray-600 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">
                Login
            </a>
        </p>
    </form>
</x-guest-layout>
