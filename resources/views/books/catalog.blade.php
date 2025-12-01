<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - N-CLiterASi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .book-card {
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(210, 76, 73, 0.3);
        }
    </style>
</head>
<body class="bg-[#FAF4EF] text-gray-800">

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

    <!-- Main Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-4xl font-bold text-[#D24C49] mb-2">Katalog Buku</h1>
            <p class="text-gray-600 mb-8">Temukan berbagai koleksi buku digital yang tersedia</p>

            <!-- Search and Filter -->
            <div class="bg-white rounded-xl p-6 mb-8 shadow-md">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" placeholder="Cari judul, penulis, atau kategori..." 
                                   class="w-full p-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D24C49]">
                            <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                        </div>
                    </div>
                    <select class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D24C49]">
                        <option>Semua Kategori</option>
                        <option>Fiksi</option>
                        <option>Non-Fiksi</option>
                        <option>Sains</option>
                        <option>Teknologi</option>
                    </select>
                    <button class="bg-[#D24C49] text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-medium">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </div>

            <!-- Books Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                <div class="book-card bg-white rounded-xl overflow-hidden shadow-md border border-[#EEC8A3]">
                    <div class="p-5">
                        <div class="bg-[#EEC8A3] h-40 rounded-lg mb-4 flex items-center justify-center">
                            <i class="fas fa-book text-5xl text-[#D24C49]"></i>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800 mb-1 truncate">{{ $book->title ?? 'Judul Buku' }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $book->author ?? 'Penulis' }}</p>
                        <div class="flex items-center justify-between mt-4">
                            <span class="bg-[#EEC8A3] text-gray-800 text-xs font-medium px-3 py-1 rounded-full">
                                {{ $book->category ?? 'Kategori' }}
                            </span>
                            @auth
                            <button class="bg-[#D24C49] text-white text-sm px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-bookmark mr-1"></i> Pinjam
                            </button>
                            @else
                            <a href="{{ route('login') }}" class="bg-gray-200 text-gray-800 text-sm px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                Login untuk Pinjam
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
            <div class="mt-10 flex justify-center">
                <div class="flex space-x-2">
                    @if($books->onFirstPage())
                    <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                    </span>
                    @else
                    <a href="{{ $books->previousPageUrl() }}" class="px-4 py-2 bg-white text-[#D24C49] border border-[#D24C49] rounded-lg hover:bg-[#D24C49] hover:text-white transition">
                        <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                    </a>
                    @endif

                    @if($books->hasMorePages())
                    <a href="{{ $books->nextPageUrl() }}" class="px-4 py-2 bg-white text-[#D24C49] border border-[#D24C49] rounded-lg hover:bg-[#D24C49] hover:text-white transition">
                        Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                    @else
                    <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">
                        Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                    </span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Footer (SAMA PERSIS dengan homepage) -->
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