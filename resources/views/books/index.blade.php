<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        accent: '#F59E0B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-3 text-gray-600 hover:text-primary transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-primary p-2 rounded-lg">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Katalog Buku</h1>
                        <p class="text-sm text-gray-600">Jelajahi koleksi buku kami</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Search and Filter -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative max-w-xl">
                        <input type="text" placeholder="Cari judul, penulis, atau ISBN..." 
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        <option value="teknologi">Teknologi</option>
                        <option value="sains">Sains</option>
                        <option value="fiksi">Fiksi</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Urutkan</option>
                        <option value="newest">Terbaru</option>
                        <option value="popular">Populer</option>
                        <option value="title">Judul A-Z</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-books text-primary mr-2"></i>
                        Daftar Buku Tersedia
                    </h2>
                    <span class="text-sm text-gray-600">
                        {{ $books->total() }} buku ditemukan
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if($books->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($books as $book)
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                            <div class="flex flex-col h-full">
                                <!-- Book Cover & Basic Info -->
                                <div class="flex items-start space-x-4 mb-4">
                                    <div class="w-16 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center shadow group-hover:scale-105 transition-transform">
                                        <i class="fas fa-book text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-800 text-lg mb-1 line-clamp-2">{{ $book->title }}</h3>
                                        <p class="text-gray-600 text-sm mb-2">by {{ $book->author }}</p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-hashtag mr-1"></i>
                                            <span>{{ $book->isbn }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book Details -->
                                <div class="space-y-2 mb-4 flex-1">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Penerbit</span>
                                        <span class="text-gray-800 font-medium">{{ $book->publisher }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Tahun</span>
                                        <span class="text-gray-800 font-medium">{{ $book->published_year }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Stok</span>
                                        <span class="font-medium {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $book->stock }} tersedia
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="pt-4 border-t">
                                    @if($book->stock > 0)
                                        <form method="POST" action="{{ route('mahasiswa.books.borrow', $book) }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-primary text-white py-2.5 rounded-lg hover:bg-secondary transition flex items-center justify-center group/btn">
                                                <i class="fas fa-plus mr-2 group-hover/btn:rotate-90 transition-transform"></i>
                                                Pinjam Buku
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="w-full bg-gray-300 text-gray-500 py-2.5 rounded-lg cursor-not-allowed flex items-center justify-center">
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
                    <div class="mt-8">
                        {{ $books->links() }}
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-book-open text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-600 mb-3">Tidak Ada Buku</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">
                            Maaf, tidak ada buku yang tersedia saat ini. Silakan coba lagi nanti.
                        </p>
                        <a href="{{ route('mahasiswa.dashboard') }}" 
                           class="inline-flex items-center bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition">
                            <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Total Buku</h3>
                        <p class="text-2xl font-bold">{{ $books->total() }}</p>
                    </div>
                    <i class="fas fa-book-open text-2xl opacity-80"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Tersedia</h3>
                        <p class="text-2xl font-bold">{{ $books->where('stock', '>', 0)->count() }}</p>
                    </div>
                    <i class="fas fa-check-circle text-2xl opacity-80"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Kategori</h3>
                        <p class="text-2xl font-bold">12+</p>
                    </div>
                    <i class="fas fa-tags text-2xl opacity-80"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 text-gray-600 mb-4 md:mb-0">
                    <i class="fas fa-book"></i>
                    <span class="text-sm">Perpustakaan Digital © 2024</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="text-gray-600 hover:text-primary transition flex items-center text-sm">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('mahasiswa.loans.history') }}" class="text-gray-600 hover:text-primary transition flex items-center text-sm">
                        <i class="fas fa-history mr-1"></i> Riwayat
                    </a>
                    <a href="{{ route('mahasiswa.fines') }}" class="text-gray-600 hover:text-primary transition flex items-center text-sm">
                        <i class="fas fa-money-bill-wave mr-1"></i> Denda
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 transition flex items-center text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </footer>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 animate-slide-in">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 animate-slide-in">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <style>
        @keyframes slide-in {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>