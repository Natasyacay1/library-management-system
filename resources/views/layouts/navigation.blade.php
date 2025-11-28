<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
            📚 Perpus Digital
        </a>

        <!-- Menu -->
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('books.index') }}"
               class="text-gray-700 hover:text-blue-600 transition">
                Katalog
            </a>

            @auth
                <a href="{{ route('dashboard') }}"
                   class="text-gray-700 hover:text-blue-600 transition">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-red-600 hover:text-red-700 font-semibold">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a>
            @endauth
        </div>
    </div>
</nav>
