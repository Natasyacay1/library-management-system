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
            background-color: #FAF4EF;
        }
        .nav-gradient {
            background: linear-gradient(135deg, #3A2E2A 0%, #2B211E 100%);
        }
        .card-border {
            border: 1px solid #EEC8A3;
        }
        .btn-primary {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .btn-disabled {
            background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
        }
        .stat-card {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-[#FAF4EF]">

    <!-- Navigation -->
    <nav class="nav-gradient shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-3 text-[#EEC8A3] hover:text-white transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Katalog Buku</h1>
                        <p class="text-sm text-[#EEC8A3]">Jelajahi koleksi buku N-CLiterASi</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="font-semibold text-white">{{ $user->name }}</p>
                        <p class="text-sm text-[#EEC8A3]">{{ $user->email }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center text-lg font-bold shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Search and Filter -->
        <div class="bg-white rounded-xl shadow-lg card-border p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative max-w-xl">
                        <input type="text" placeholder="Cari judul, penulis, atau ISBN..." 
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        <option value="Teknologi">Teknologi</option>
                        <option value="Sains">Sains</option>
                        <option value="Fiksi">Fiksi</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Bisnis">Bisnis</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <option value="">Urutkan</option>
                        <option value="newest">Terbaru</option>
                        <option value="popular">Populer</option>
                        <option value="title">Judul A-Z</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="bg-white rounded-xl shadow-lg card-border overflow-hidden">
            <div class="px-6 py-4 border-b bg-[#3A2E2A]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <div class="bg-[#D24C49] p-2 rounded-lg mr-3">
                            <i class="fas fa-books text-white"></i>
                        </div>
                        Daftar Buku Tersedia
                    </h2>
                    <span class="text-sm text-[#EEC8A3]">
                        {{ $books->total() }} buku ditemukan
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if($books->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($books as $book)
                        <div class="book-card border border-[#EEC8A3] rounded-xl p-6 bg-white hover:shadow-xl transition-all duration-300 group">
                            <div class="flex flex-col h-full">
                                <!-- Book Cover & Basic Info -->
                                <div class="flex items-start space-x-4 mb-4">
                                    <div class="w-16 h-20 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded-lg flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                        <i class="fas fa-book text-[#D24C49] text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-[#3A2E2A] text-lg mb-1 line-clamp-2">{{ $book->title }}</h3>
                                        <p class="text-[#3A2E2A]/80 text-sm mb-2">by {{ $book->author }}</p>
                                        <div class="flex items-center text-xs text-[#3A2E2A]/60 bg-[#FAF4EF] px-2 py-1 rounded">
                                            <i class="fas fa-hashtag mr-1"></i>
                                            <span>{{ $book->isbn }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book Details -->
                                <div class="space-y-2 mb-4 flex-1">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-[#3A2E2A]/70">Penerbit</span>
                                        <span class="text-[#3A2E2A] font-medium">{{ $book->publisher }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-[#3A2E2A]/70">Tahun</span>
                                        <span class="text-[#3A2E2A] font-medium">{{ $book->published_year }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-[#3A2E2A]/70">Stok</span>
                                        <span class="font-medium {{ $book->stock > 0 ? 'text-[#10B981]' : 'text-[#DC2626]' }}">
                                            {{ $book->stock }} tersedia
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="pt-4 border-t border-[#EEC8A3]">
                                    @if($book->stock > 0)
                                        <form method="POST" action="{{ route('mahasiswa.books.borrow', $book) }}">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin meminjam buku: {{ $book->title }}?')"
                                                    class="w-full btn-primary text-white py-2.5 rounded-xl hover:opacity-90 transition transform hover:scale-105 flex items-center justify-center shadow-md">
                                                <i class="fas fa-plus mr-2"></i>
                                                Pinjam Buku
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="w-full btn-disabled text-gray-300 py-2.5 rounded-xl cursor-not-allowed flex items-center justify-center">
                                            <i class="fas fa-times mr-2"></i>
                                            Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                    <div class="mt-8 pt-6 border-t border-[#EEC8A3]">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-[#3A2E2A]/70">
                                Menampilkan {{ $books->firstItem() }} - {{ $books->lastItem() }} dari {{ $books->total() }} buku
                            </div>
                            <div class="flex space-x-2">
                                @if($books->onFirstPage())
                                    <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $books->previousPageUrl() }}" class="px-3 py-1 bg-[#FFE9D6] text-[#3A2E2A] rounded-lg hover:bg-[#EEC8A3]">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif
                                
                                @foreach(range(1, min(5, $books->lastPage())) as $page)
                                    <a href="{{ $books->url($page) }}" 
                                       class="px-3 py-1 rounded-lg {{ $books->currentPage() == $page ? 'bg-[#D24C49] text-white' : 'bg-[#FFE9D6] text-[#3A2E2A] hover:bg-[#EEC8A3]' }}">
                                        {{ $page }}
                                    </a>
                                @endforeach
                                
                                @if($books->hasMorePages())
                                    <a href="{{ $books->nextPageUrl() }}" class="px-3 py-1 bg-[#FFE9D6] text-[#3A2E2A] rounded-lg hover:bg-[#EEC8A3]">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-[#FFE9D6] rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-book-open text-[#D24C49] text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-[#3A2E2A] mb-3">Tidak Ada Buku</h3>
                        <p class="text-[#3A2E2A]/70 mb-8 max-w-md mx-auto">
                            Maaf, tidak ada buku yang tersedia saat ini. Silakan coba lagi nanti.
                        </p>
                        <a href="{{ route('mahasiswa.dashboard') }}" 
                           class="inline-flex items-center btn-primary text-white px-8 py-3 rounded-xl hover:opacity-90 transition transform hover:scale-105 shadow-md">
                            <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="stat-card rounded-xl shadow p-6 text-center card-border">
                <div class="text-3xl font-bold text-[#D24C49] mb-2">{{ $books->total() }}</div>
                <div class="text-[#3A2E2A] font-medium">Total Buku</div>
                <div class="mt-2">
                    <i class="fas fa-book-open text-[#D24C49] text-xl"></i>
                </div>
            </div>

            <div class="stat-card rounded-xl shadow p-6 text-center card-border">
                <div class="text-3xl font-bold text-[#3A2E2A] mb-2">{{ $books->where('stock', '>', 0)->count() }}</div>
                <div class="text-[#3A2E2A] font-medium">Tersedia</div>
                <div class="mt-2">
                    <i class="fas fa-check-circle text-[#3A2E2A] text-xl"></i>
                </div>
            </div>

            <div class="stat-card rounded-xl shadow p-6 text-center card-border">
                <div class="text-3xl font-bold text-[#A52C2A] mb-2">{{ $books->unique('category')->count() }}</div>
                <div class="text-[#3A2E2A] font-medium">Kategori</div>
                <div class="mt-2">
                    <i class="fas fa-tags text-[#A52C2A] text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#3A2E2A] border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 text-[#EEC8A3] mb-4 md:mb-0">
                    <i class="fas fa-book"></i>
                    <span class="text-sm">N-CLiterASi © 2025</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="text-[#EEC8A3] hover:text-white transition flex items-center text-sm">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('mahasiswa.loans.history') }}" class="text-[#EEC8A3] hover:text-white transition flex items-center text-sm">
                        <i class="fas fa-history mr-1"></i> Riwayat
                    </a>
                    <a href="{{ route('mahasiswa.fines') }}" class="text-[#EEC8A3] hover:text-white transition flex items-center text-sm">
                        <i class="fas fa-money-bill-wave mr-1"></i> Denda
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[#EEC8A3] hover:text-red-300 transition flex items-center text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </footer>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-[#D24C49] text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in z-50">
        <div class="flex items-center">
            <div class="bg-white/20 p-1 rounded mr-2">
                <i class="fas fa-check-circle"></i>
            </div>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in z-50">
        <div class="flex items-center">
            <div class="bg-white/20 p-1 rounded mr-2">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            {{ session('error') }}
        </div>
    </div>
    @endif
</body>
</html>