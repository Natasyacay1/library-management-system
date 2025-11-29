{{-- resources/views/mahasiswa/loans/homepage.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital</title>

    {{-- pakai asset dari Breeze/Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 antialiased">

    {{-- HEADER + NAVBAR --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                📚 Perpus Digital
            </a>

            <nav class="space-x-4 text-sm">
                <a href="{{ route('books.index') }}" class="text-slate-700 hover:text-blue-600">
                    Katalog Buku
                </a>

                @auth
                    {{-- Kalau sudah login --}}
                    <a href="{{ route('dashboard') }}" class="text-slate-700 hover:text-blue-600">
                        Dashboard
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold">
                            Logout
                        </button>
                    </form>
                @else
                    {{-- Kalau belum login --}}
                    <a href="{{ route('login') }}" class="text-slate-700 hover:text-blue-600">
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-3 py-1 rounded-md bg-slate-900 text-white hover:bg-slate-800">
                        Register
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="max-w-7xl mx-auto px-6 py-10">

        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">
            Selamat Datang di <span class="text-blue-600">Perpustakaan Digital</span>
        </h1>
        <p class="text-slate-600 mb-8 max-w-3xl">
            Temukan koleksi buku terbaik, kelola peminjaman, dan dapatkan rekomendasi buku yang dipersonalisasi.
        </p>

        {{-- KARTU FITUR (SEKARANG BISA DIKLIK) --}}
        <div class="grid gap-6 md:grid-cols-3">

            {{-- 1. Cari Buku --}}
            <a href="{{ route('books.index') }}"
               class="bg-white rounded-xl shadow hover:shadow-md transition p-6 block">
                <div class="text-3xl mb-3">🔍</div>
                <h2 class="font-semibold text-lg text-slate-900 mb-1">Cari Buku</h2>
                <p class="text-sm text-slate-600">
                    Jelajahi berbagai kategori dan penulis di katalog perpustakaan.
                </p>
            </a>

            {{-- 2. Pinjam Buku --}}
            <a href="@auth {{ route('books.index') }} @else {{ route('login') }} @endauth"
               class="bg-white rounded-xl shadow hover:shadow-md transition p-6 block">
                <div class="text-3xl mb-3">📖</div>
                <h2 class="font-semibold text-lg text-slate-900 mb-1">Pinjam Buku</h2>
                <p class="text-sm text-slate-600">
                    Mahasiswa dapat meminjam buku secara online melalui akun masing-masing.
                </p>
            </a>

            {{-- 3. Review & Rating --}}
            <a href="@auth {{ route('books.index') }} @else {{ route('login') }} @endauth"
               class="bg-white rounded-xl shadow hover:shadow-md transition p-6 block">
                <div class="text-3xl mb-3">⭐</div>
                <h2 class="font-semibold text-lg text-slate-900 mb-1">Review &amp; Rating</h2>
                <p class="text-sm text-slate-600">
                    Berikan penilaian dan ulasan untuk membantu pengguna lain memilih buku.
                </p>
            </a>

        </div>
    </main>
</body>
</html>
