<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-CLiterASi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -6px rgba(0,0,0,0.2);
        }
        .soft-bg {
            background-color: #EEC8A3;
        }
    </style>
</head>
<body class="bg-[#FAF4EF] text-gray-800">

    <!-- Header Navigation -->
    <header class="bg-white/110 backdrop-blur-md shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="bg-[#D24C49] text-white p-2 rounded-xl shadow-md">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">N-C<span class="text-[#D24C49]">LiterASi</span></h1>
            </a>

            <nav class="flex items-center space-x-6 text-lg">
                <a href="{{ route('books.catalog') }}" class="hover:text-[#D24C49] transition font-medium">Katalog Buku</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-[#D24C49] transition font-medium">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="text-[#D24C49] hover:text-red-700 font-semibold">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-[#D24C49] transition font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="bg-[#D24C49] text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium shadow-md">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero-gradient text-white py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl animate-fadeIn">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 drop-shadow-lg">Selamat Datang di <span class="text-[#EEC8A3]">Perpustakaan Digital</span></h1>
                <p class="text-xl leading-relaxed mb-10">Temukan koleksi buku terbaik, kelola peminjaman, dan dapatkan rekomendasi buku yang dipersonalisasi dengan tampilan baru yang lebih nyaman dibaca.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('books.catalog') }}" class="bg-white text-[#D24C49] px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-xl text-center">
                        <i class="fas fa-search mr-2"></i> Jelajahi Katalog
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="bg-[#EEC8A3] text-gray-900 px-8 py-4 rounded-lg font-bold text-lg hover:bg-[#e3b58c] transition transform hover:scale-105 shadow-xl text-center">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 soft-bg">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
            <div class="p-6 rounded-xl bg-white shadow-md">
                <div class="text-4xl font-bold text-[#D24C49] mb-2">10+</div>
                <div class="font-medium">Buku Digital</div>
            </div>
            <div class="p-6 rounded-xl bg-white shadow-md">
                <div class="text-4xl font-bold text-[#D24C49] mb-2">5+</div>
                <div class="font-medium">Anggota Aktif</div>
            </div>
            <div class="p-6 rounded-xl bg-white shadow-md">
                <div class="text-4xl font-bold text-[#D24C49] mb-2">5+</div>
                <div class="font-medium">Kategori Buku</div>
            </div>
            <div class="p-6 rounded-xl bg-white shadow-md">
                <div class="text-4xl font-bold text-[#D24C49] mb-2">24/7</div>
                <div class="font-medium">Akses Online</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-[#FAF4EF]">
        <div class="max-w-7xl mx-auto px-6 text-center mb-16">
            <h2 class="text-4xl font-bold mb-4 text-[#D24C49]">Fitur Unggulan Kami</h2>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">Nikmati pengalaman perpustakaan digital yang lebih interaktif, nyaman dibaca, dan estetis.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-7xl mx-auto px-6">
            <a href="{{ route('books.catalog') }}" class="feature-card bg-white rounded-2xl p-8 text-center shadow-lg border border-[#EEC8A3]">
                <div class="bg-[#EEC8A3] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                    <i class="fas fa-search text-[#D24C49] text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Cari Buku</h3>
                <p class="text-gray-600 leading-relaxed">Telusuri berbagai kategori yang telah dikurasi dengan tampilan baru yang lebih nyaman.</p>
            </a>

            <a href="@auth {{ route('books.catalog') }} @else {{ route('login') }} @endauth" class="feature-card bg-white rounded-2xl p-8 text-center shadow-lg border border-[#EEC8A3]">
                <div class="bg-[#EEC8A3] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                    <i class="fas fa-book-reader text-[#D24C49] text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Pinjam Buku</h3>
                <p class="text-gray-600 leading-relaxed">Proses peminjaman yang lebih cepat, elegan, dan mudah dipahami.</p>
            </a>

            <a href="@auth {{ route('books.catalog') }} @else {{ route('login') }} @endauth" class="feature-card bg-white rounded-2xl p-8 text-center shadow-lg border border-[#EEC8A3]">
                <div class="bg-[#EEC8A3] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                    <i class="fas fa-star text-[#D24C49] text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Review & Rating</h3>
                <p class="text-gray-600 leading-relaxed">Bagikan pengalaman membaca untuk membantu pengguna lain.</p>
            </a>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-[#D24C49] to-[#A52C2A] text-white text-center">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-4">Siap Memulai Petualangan Membaca?</h2>
            <p class="text-lg text-[#FFE9D6] mb-8">Gabung sekarang dan nikmati pengalaman membaca yang lebih menyenangkan!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                <a href="{{ route('register') }}" class="bg-white text-[#D24C49] px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-200 transition">Daftar Sekarang</a>
                @endguest
                <a href="{{ route('books.catalog') }}" class="border-2 border-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-[#D24C49] transition">Jelajahi Buku</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#3A2E2A] text-white py-14">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center"><i class="fas fa-book-open text-[#EEC8A3] mr-2"></i>N-CLiterASi</h3>
                <p class="text-gray-300">Akses pengetahuan kapan saja, website dengan tampilan lebih segar dan nyaman digunakan.</p>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-3">Tautan Cepat</h4>
                <ul class="space-y-2 text-gray-300">
                    <li><a class="hover:text-white" href="{{ route('books.catalog') }}">Katalog Buku</a></li>
                    <li><a class="hover:text-white" href="{{ route('home') }}">Beranda</a></li>
                    @auth
                    <li><a class="hover:text-white" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @else
                    <li><a class="hover:text-white" href="{{ route('login') }}">Login</a></li>
                    <li><a class="hover:text-white" href="{{ route('register') }}">Daftar</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-3">Kontak</h4>
                <p class="flex items-center text-gray-300"><i class="fas fa-envelope mr-2"></i> ncLiterERAi@perpusdigital.ac.id</p>
                <p class="flex items-center text-gray-300"><i class="fas fa-phone mr-2"></i> (021) 1234-5678</p>
                <p class="flex items-center text-gray-300"><i class="fas fa-map-marker-alt mr-2"></i>Makassar, Indonesia</p>
            </div>
        </div>
        <div class="text-center text-gray-400 mt-10 border-t border-gray-700 pt-6">
            <p>&copy; 2025 PerpustakaanDigital. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
