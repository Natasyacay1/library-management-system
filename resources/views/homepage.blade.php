<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header Navigation -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="bg-blue-600 text-white p-2 rounded-xl">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Perpustakaan<span class="text-blue-600">Digital</span></h1>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6">
                <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Katalog Buku</a>

                @auth
                    <!-- Kalau sudah login -->
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Dashboard</a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold transition">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                @else
                    <!-- Kalau belum login -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Log in</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                        Daftar
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Selamat Datang di <span class="text-yellow-300">Perpustakaan Digital</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100 leading-relaxed">
                    Temukan koleksi buku terbaik, kelola peminjaman, dan dapatkan rekomendasi buku yang dipersonalisasi untuk pengalaman membaca yang tak terlupakan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('books.index') }}" 
                       class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-2xl text-center">
                        <i class="fas fa-search mr-2"></i> Jelajahi Katalog
                    </a>
                    @guest
                    <a href="{{ route('register') }}" 
                       class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg font-bold text-lg hover:bg-yellow-300 transition transform hover:scale-105 shadow-2xl text-center">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">5,000+</div>
                    <div class="text-gray-600 font-medium">Buku Digital</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold text-green-600 mb-2">1,200+</div>
                    <div class="text-gray-600 font-medium">Anggota Aktif</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold text-purple-600 mb-2">50+</div>
                    <div class="text-gray-600 font-medium">Kategori Buku</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold text-orange-600 mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">Akses Online</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Nikmati kemudahan akses perpustakaan digital dengan fitur-fitur terbaik
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 - Cari Buku -->
                <a href="{{ route('books.index') }}" class="feature-card bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Cari Buku</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Jelajahi berbagai kategori dan penulis di katalog perpustakaan yang lengkap dan terupdate.
                    </p>
                    <div class="mt-6 text-blue-600 font-semibold flex items-center justify-center">
                        Jelajahi Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </a>

                <!-- Feature 2 - Pinjam Buku -->
                <a href="@auth {{ route('books.index') }} @else {{ route('login') }} @endauth" 
                   class="feature-card bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100">
                    <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-book-reader text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Pinjam Buku</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Mahasiswa dapat meminjam buku secara online melalui akun masing-masing dengan proses yang cepat dan mudah.
                    </p>
                    <div class="mt-6 text-green-600 font-semibold flex items-center justify-center">
                        Mulai Meminjam <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </a>

                <!-- Feature 3 - Review & Rating -->
                <a href="@auth {{ route('books.index') }} @else {{ route('login') }} @endauth" 
                   class="feature-card bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100">
                    <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-star text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Review & Rating</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Berikan penilaian dan ulasan untuk membantu pengguna lain memilih buku yang tepat sesuai kebutuhan.
                    </p>
                    <div class="mt-6 text-purple-600 font-semibold flex items-center justify-center">
                        Beri Ulasan <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 py-20 text-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Siap Memulai Petualangan Membaca?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan komunitas pembaca kami dan temukan dunia pengetahuan tanpa batas
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                <a href="{{ route('register') }}" 
                   class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                </a>
                @endguest
                <a href="{{ route('books.index') }}" 
                   class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition transform hover:scale-105">
                    <i class="fas fa-book-open mr-2"></i> Jelajahi Buku
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-book-open text-2xl text-blue-400"></i>
                        <h3 class="text-xl font-bold">PerpustakaanDigital</h3>
                    </div>
                    <p class="text-gray-400">
                        Membuka jendela dunia melalui literasi digital. 
                        Akses pengetahuan tanpa batas, kapan saja dan di mana saja.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('books.index') }}" class="hover:text-white transition">Katalog Buku</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a></li>
                        @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <div class="space-y-2 text-gray-400">
                        <p class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i> hello@perpusdigital.ac.id
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-phone mr-2"></i> (021) 1234-5678
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 PerpustakaanDigital. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>