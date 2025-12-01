<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Admin Panel</title>
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
        .stat-card {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
        }
    </style>
</head>
<body class="bg-[#FAF4EF]">

    <!-- Navigation -->
    <nav class="nav-gradient shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-[#EEC8A3] hover:text-white transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Kelola Buku</h1>
                        <p class="text-sm text-[#EEC8A3]">Manajemen koleksi buku N-CLiterASi</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white">{{ Auth::user()->name }}</span>
                    <div class="w-10 h-10 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center text-lg font-bold shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-[#3A2E2A]">Daftar Buku</h2>
                <p class="text-[#3A2E2A]/80">Total {{ $books->total() }} buku dalam koleksi</p>
            </div>
            <a href="{{ route('admin.books.create') }}" 
               class="btn-primary text-white px-6 py-3 rounded-xl hover:opacity-90 transition transform hover:scale-105 shadow-lg flex items-center font-medium">
                <i class="fas fa-plus mr-2"></i>Tambah Buku Baru
            </a>
        </div>

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
                        <option value="">Semua Status</option>
                        <option value="available">Tersedia</option>
                        <option value="out-of-stock">Habis</option>
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

        <!-- Books Table -->
        <div class="bg-white rounded-xl shadow-lg card-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#3A2E2A]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Penulis</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">ISBN</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Tahun</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#EEC8A3]/30">
                        @foreach($books as $book)
                        <tr class="hover:bg-[#FAF4EF] transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-16 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded-lg flex items-center justify-center text-[#D24C49] mr-4 shadow-sm">
                                        <i class="fas fa-book text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-[#3A2E2A]">{{ $book->title }}</div>
                                        <div class="text-sm text-[#3A2E2A]/70">{{ $book->publisher }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#3A2E2A]">{{ $book->author }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#3A2E2A] font-mono bg-[#FAF4EF] px-3 py-1 rounded-lg">{{ $book->isbn }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium shadow-sm
                                    {{ $book->stock > 0 ? 'bg-[#FFE9D6] text-[#3A2E2A]' : 'bg-[#FFE9D6] text-[#D24C49]' }}">
                                    <i class="fas {{ $book->stock > 0 ? 'fa-check text-green-600' : 'fa-times text-red-600' }} mr-1"></i>
                                    {{ $book->stock }} tersedia
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#3A2E2A]/70">
                                {{ $book->published_year }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.books.edit', $book) }}" 
                                       class="text-[#3A2E2A] hover:text-[#D24C49] transition flex items-center bg-[#FAF4EF] px-3 py-1 rounded-lg hover:bg-[#FFE9D6]">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-[#D24C49] hover:text-red-800 transition flex items-center bg-[#FAF4EF] px-3 py-1 rounded-lg hover:bg-[#FFE9D6]"
                                                onclick="return confirm('Yakin hapus buku ini?')">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t bg-[#FAF4EF]">
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
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <div class="stat-card rounded-xl shadow p-6 text-center card-border">
                <div class="text-3xl font-bold text-[#D24C49] mb-2">{{ $books->total() }}</div>
                <div class="text-[#3A2E2A] font-medium">Total Buku</div>
            </div>
            <div class="stat-card rounded-xl shadow p-6 text-center card-border">
                <div class="text-3xl font-bold text-[#3A2E2A] mb-2">{{ $books->where('stock', '>', 0)->count() }}</div>
                <div class="text-[#3A2E2A] font-medium">Tersedia</div>
            </div>
            <div class="stat-card rounded-xl shadow p-6 text-center card-border">
                <div class="text-3xl font-bold text-[#A52C2A] mb-2">{{ $books->where('stock', 0)->count() }}</div>
                <div class="text-[#3A2E2A] font-medium">Habis</div>
            </div>
            <div class="stat-card rounded-xl shadow p-6 text-center card-border">
                <div class="text-3xl font-bold text-[#EEC8A3] mb-2">{{ $books->sum('stock') }}</div>
                <div class="text-[#3A2E2A] font-medium">Total Stok</div>
            </div>
        </div>
    </div>
</body>
</html>