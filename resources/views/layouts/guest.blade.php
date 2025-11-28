<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Perpustakaan Digital' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">

    {{-- Navbar Guest --}}
    <header class="border-b bg-white">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="font-bold text-blue-600">
                📚 Perpus Digital
            </a>

            <nav class="space-x-4 text-sm">
                <a href="{{ route('login') }}" class="text-slate-700 hover:underline">Log in</a>
                <a href="{{ route('register') }}" class="px-3 py-1 rounded-md bg-slate-900 text-white">
                    Register
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-10">
        {{ $slot ?? '' }}
        @yield('content')
    </main>
</body>
</html>
