<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - N-CLiterASi</title>
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
            border-radius: 16px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(210, 76, 73, 0.3);
        }
        .btn-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        .btn-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            transition: all 0.3s ease;
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }
        .btn-danger {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3);
        }
        .book-card {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(58, 46, 42, 0.15);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        .status-available {
            background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
            color: #065F46;
        }
        .status-out {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #991B1B;
        }
        .search-input:focus {
            border-color: #D24C49 !important;
            box-shadow: 0 0 0 3px rgba(210, 76, 73, 0.2) !important;
        }
        .pagination-link {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
            border: 1px solid #EEC8A3;
        }
        .pagination-link:hover {
            background: linear-gradient(135deg, #FAF4EF 0%, #FFE9D6 100%);
        }
        .pagination-active {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
            color: white;
            border-color: #D24C49;
        }
        .action-btn {
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-[#FAF4EF] min-h-full">

    <!-- Header/Navigation -->
    <header class="nav-gradient shadow-xl">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">N-CLiterASi</h1>
                        <p class="text-[#EEC8A3] text-sm">Kelola Koleksi Buku</p>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:block text-right">
                        <p class="font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[#EEC8A3] text-sm">Pegawai Perpustakaan</p>
                    </div>
                    <a href="{{ route('pegawai.dashboard') }}" 
                       class="bg-white/20 text-white px-4 py-2 rounded-lg hover:bg-white/30 transition flex items-center shadow-md mr-2">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" 
                                class="bg-white/20 text-white px-4 py-2 rounded-lg hover:bg-white/30 transition flex items-center shadow-md">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8 animate-fadeIn">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-[#3A2E2A] mb-2">Kelola Koleksi Buku</h2>
                    <p class="text-[#3A2E2A]/70">Kelola, edit, dan pantau semua buku di perpustakaan digital</p>
                </div>
                <a href="{{ route('pegawai.books.create') }}" 
                   class="btn-primary text-white px-6 py-3 rounded-lg flex items-center shadow-md font-semibold">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Buku Baru
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-[#10B981] rounded-lg p-4 mb-6 animate-fadeIn">
                <div class="flex items-center">
                    <div class="bg-[#10B981] text-white p-2 rounded-lg mr-3">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-[#3A2E2A] font-semibold">{{ session('success') }}</p>
                        <p class="text-[#3A2E2A]/70 text-sm mt-1">Perubahan berhasil disimpan</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-[#DC2626] rounded-lg p-4 mb-6 animate-fadeIn">
                <div class="flex items-center">
                    <div class="bg-[#DC2626] text-white p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="text-[#3A2E2A] font-semibold">{{ session('error') }}</p>
                        <p class="text-[#3A2E2A]/70 text-sm mt-1">Terjadi kesalahan</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] rounded-xl p-4 card-border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm">Total Buku</p>
                        <p class="text-2xl font-bold text-[#3A2E2A]">{{ $books->total() }}</p>
                    </div>
                    <div class="bg-[#D24C49] text-white p-2 rounded-lg">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>
            
            @php
                $availableBooks = $books->filter(function($book) {
                    return $book->stock > 0;
                })->count();
                
                $outOfStock = $books->filter(function($book) {
                    return $book->stock == 0;
                })->count();
                
                $totalViews = $books->sum('views') ?? 0;
            @endphp
            
            <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] rounded-xl p-4 card-border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm">Tersedia</p>
                        <p class="text-2xl font-bold text-[#10B981]">{{ $availableBooks }}</p>
                    </div>
                    <div class="bg-[#10B981] text-white p-2 rounded-lg">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] rounded-xl p-4 card-border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm">Habis</p>
                        <p class="text-2xl font-bold text-[#DC2626]">{{ $outOfStock }}</p>
                    </div>
                    <div class="bg-[#DC2626] text-white p-2 rounded-lg">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] rounded-xl p-4 card-border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm">Total Views</p>
                        <p class="text-2xl font-bold text-[#3A2E2A]">{{ number_format($totalViews) }}</p>
                    </div>
                    <div class="bg-[#3A2E2A] text-white p-2 rounded-lg">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 card-border">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#3A2E2A] mb-2">Cari Buku</label>
                    <div class="relative">
                        <input type="text" 
                               placeholder="Judul, penulis, atau ISBN..." 
                               class="search-input w-full pl-10 pr-4 py-2.5 border border-[#EEC8A3] rounded-lg focus:outline-none bg-[#FAF4EF] text-[#3A2E2A]">
                        <i class="fas fa-search absolute left-3 top-3.5 text-[#3A2E2A]/50"></i>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#3A2E2A] mb-2">Status Stok</label>
                    <select class="w-full px-4 py-2.5 border border-[#EEC8A3] rounded-lg focus:outline-none search-input bg-[#FAF4EF] text-[#3A2E2A]">
                        <option value="">Semua Status</option>
                        <option value="available">Tersedia</option>
                        <option value="out">Habis</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#3A2E2A] mb-2">Urutkan</label>
                    <select class="w-full px-4 py-2.5 border border-[#EEC8A3] rounded-lg focus:outline-none search-input bg-[#FAF4EF] text-[#3A2E2A]">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="title">Judul (A-Z)</option>
                        <option value="stock">Stok Tertinggi</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Grid/Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-border">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <div class="bg-[#D24C49] p-2 rounded-lg mr-3">
                            <i class="fas fa-list text-white"></i>
                        </div>
                        Daftar Buku
                    </h3>
                    <div class="text-white/80 text-sm">
                        Menampilkan <span class="font-bold">{{ $books->count() }}</span> dari {{ $books->total() }} buku
                    </div>
                </div>
            </div>

            <!-- Books Table -->
            @if($books->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#FAF4EF] to-[#FFE9D6]">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-[#3A2E2A]">Judul Buku</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-[#3A2E2A]">Penulis</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-[#3A2E2A]">ISBN</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-[#3A2E2A]">Stok</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-[#3A2E2A]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EEC8A3]/30">
                            @foreach($books as $book)
                                <tr class="book-card hover:bg-gradient-to-r hover:from-[#FAF4EF] hover:to-[#FFE9D6] transition-all duration-300">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                @if($book->cover)
                                                    <img src="{{ asset('storage/' . $book->cover) }}" 
                                                         alt="{{ $book->title }}" 
                                                         class="w-14 h-20 object-cover rounded-lg shadow-md border border-[#EEC8A3]">
                                                @else
                                                    <div class="w-14 h-20 bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] rounded-lg flex items-center justify-center border border-[#EEC8A3]">
                                                        <i class="fas fa-book text-[#3A2E2A]/40 text-xl"></i>
                                                    </div>
                                                @endif
                                                @if($book->stock == 0)
                                                    <div class="absolute -top-2 -right-2 bg-[#DC2626] text-white text-xs px-2 py-1 rounded-full">
                                                        Habis
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-[#3A2E2A]">{{ $book->title }}</h4>
                                                <div class="flex items-center space-x-3 mt-1">
                                                    <span class="text-sm text-[#3A2E2A]/70">
                                                        <i class="fas fa-building mr-1"></i>{{ $book->publisher }}
                                                    </span>
                                                    <span class="text-sm text-[#3A2E2A]/70">
                                                        <i class="fas fa-calendar mr-1"></i>{{ $book->year }}
                                                    </span>
                                                </div>
                                                <div class="mt-2">
                                                    <span class="text-xs px-2 py-1 rounded-full bg-[#3A2E2A]/10 text-[#3A2E2A]">
                                                        <i class="fas fa-eye mr-1"></i>{{ number_format($book->views ?? 0) }} views
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-br from-[#EEC8A3] to-[#D24C49]/20 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-[#3A2E2A] text-sm"></i>
                                            </div>
                                            <span class="text-[#3A2E2A] font-medium">{{ $book->author }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-gradient-to-r from-[#FFE9D6] to-[#FAF4EF] border border-[#EEC8A3]">
                                            <i class="fas fa-barcode text-[#3A2E2A]/60 mr-2"></i>
                                            <code class="text-sm font-mono text-[#3A2E2A]">{{ $book->isbn }}</code>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <span class="px-3 py-1.5 rounded-full text-sm font-semibold mr-2 
                                                {{ $book->stock > 0 ? 'status-available' : 'status-out' }}">
                                                {{ $book->stock }} buku
                                            </span>
                                            @if($book->stock > 0 && $book->stock <= 3)
                                                <span class="text-xs text-[#F59E0B]">
                                                    <i class="fas fa-exclamation-triangle"></i> Sedikit
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('pegawai.books.edit', $book) }}" 
                                               class="btn-warning text-white px-3 py-1.5 rounded-lg flex items-center text-sm action-btn">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            
                                            <!-- Delete Button -->
                                            <form action="{{ route('pegawai.books.destroy', $book) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirmDelete('{{ addslashes($book->title) }}')"
                                                        class="btn-danger text-white px-3 py-1.5 rounded-lg flex items-center text-sm action-btn">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                            
                                            <!-- View Button -->
                                            <a href="{{ route('books.show', $book) }}" 
                                               class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] text-white px-3 py-1.5 rounded-lg flex items-center text-sm action-btn"
                                               target="_blank">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                    <div class="px-6 py-4 border-t border-[#EEC8A3]">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-[#3A2E2A]/70">
                                Menampilkan {{ $books->firstItem() }} - {{ $books->lastItem() }} dari {{ $books->total() }} buku
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($books->onFirstPage())
                                    <span class="pagination-link px-4 py-2 rounded-lg text-[#3A2E2A]/50 cursor-not-allowed flex items-center">
                                        <i class="fas fa-chevron-left mr-2"></i> Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $books->previousPageUrl() }}" 
                                       class="pagination-link px-4 py-2 rounded-lg text-[#3A2E2A] hover:text-[#D24C49] transition flex items-center">
                                        <i class="fas fa-chevron-left mr-2"></i> Sebelumnya
                                    </a>
                                @endif
                                
                                <!-- Page Numbers -->
                                @php
                                    $current = $books->currentPage();
                                    $last = $books->lastPage();
                                    $start = max(1, $current - 2);
                                    $end = min($last, $current + 2);
                                    
                                    if($start > 1) {
                                        $start = max(1, $current - 1);
                                        $end = min($last, $current + 1);
                                    }
                                    
                                    if($end == $last && $start > 1) {
                                        $start = max(1, $last - 2);
                                    }
                                @endphp
                                
                                @if($start > 1)
                                    <a href="{{ $books->url(1) }}" 
                                       class="pagination-link w-10 h-10 flex items-center justify-center rounded-lg text-[#3A2E2A] hover:text-[#D24C49]">
                                        1
                                    </a>
                                    @if($start > 2)
                                        <span class="text-[#3A2E2A]/50">...</span>
                                    @endif
                                @endif
                                
                                @for($page = $start; $page <= $end; $page++)
                                    <a href="{{ $books->url($page) }}" 
                                       class="pagination-link w-10 h-10 flex items-center justify-center rounded-lg {{ $books->currentPage() == $page ? 'pagination-active text-white' : 'text-[#3A2E2A] hover:text-[#D24C49]' }}">
                                        {{ $page }}
                                    </a>
                                @endfor
                                
                                @if($end < $last)
                                    @if($end < $last - 1)
                                        <span class="text-[#3A2E2A]/50">...</span>
                                    @endif
                                    <a href="{{ $books->url($last) }}" 
                                       class="pagination-link w-10 h-10 flex items-center justify-center rounded-lg text-[#3A2E2A] hover:text-[#D24C49]">
                                        {{ $last }}
                                    </a>
                                @endif
                                
                                @if($books->hasMorePages())
                                    <a href="{{ $books->nextPageUrl() }}" 
                                       class="pagination-link px-4 py-2 rounded-lg text-[#3A2E2A] hover:text-[#D24C49] transition flex items-center">
                                        Selanjutnya <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                @else
                                    <span class="pagination-link px-4 py-2 rounded-lg text-[#3A2E2A]/50 cursor-not-allowed flex items-center">
                                        Selanjutnya <i class="fas fa-chevron-right ml-2"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] rounded-full flex items-center justify-center mx-auto mb-6 border border-[#EEC8A3]">
                        <i class="fas fa-book-open text-[#3A2E2A]/40 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-[#3A2E2A] mb-2">Koleksi Buku Kosong</h3>
                    <p class="text-[#3A2E2A]/70 max-w-md mx-auto mb-8">
                        Belum ada buku dalam koleksi perpustakaan. Mulai dengan menambahkan buku pertama untuk membangun koleksi digital.
                    </p>
                    <a href="{{ route('pegawai.books.create') }}" 
                       class="btn-primary text-white px-8 py-3 rounded-lg flex items-center justify-center mx-auto w-fit font-semibold shadow-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Buku Pertama
                    </a>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#3A2E2A] border-t border-[#2B211E] mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 text-[#EEC8A3]">
                    <i class="fas fa-book"></i>
                    <span class="text-sm">N-CLiterASi © 2025</span>
                </div>
                <div class="text-[#EEC8A3] text-sm mt-2 md:mt-0">
                    Total: {{ $books->total() }} buku • Pegawai Panel
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.querySelector('input[type="text"]');
            const statusFilter = document.querySelector('select');
            const sortFilter = document.querySelectorAll('select')[1];
            
            // Update table rows based on filters (simulated)
            function filterBooks() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const title = row.querySelector('h4').textContent.toLowerCase();
                    const author = row.querySelector('td:nth-child(2) span').textContent.toLowerCase();
                    const isbn = row.querySelector('code').textContent.toLowerCase();
                    const stockText = row.querySelector('.px-3.py-1\\.5').textContent;
                    const stock = parseInt(stockText);
                    
                    let matchesSearch = title.includes(searchTerm) || 
                                       author.includes(searchTerm) || 
                                       isbn.includes(searchTerm);
                    
                    let matchesStatus = true;
                    if (statusValue === 'available') {
                        matchesStatus = stock > 0;
                    } else if (statusValue === 'out') {
                        matchesStatus = stock === 0;
                    }
                    
                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            searchInput.addEventListener('input', filterBooks);
            statusFilter.addEventListener('change', filterBooks);
            sortFilter.addEventListener('change', function() {
                alert('Fitur pengurutan akan diimplementasikan di backend');
            });
            
            // Add hover effects to book rows
            const bookRows = document.querySelectorAll('tbody tr');
            bookRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Confirm delete function
        function confirmDelete(bookTitle) {
            return confirm(`Apakah Anda yakin ingin menghapus buku:\n\n"${bookTitle}"?\n\nAksi ini tidak dapat dibatalkan dan semua data terkait buku ini akan dihapus.`);
        }

        // Success message auto hide
        @if(session('success') || session('error'))
            setTimeout(function() {
                const messages = document.querySelectorAll('.bg-gradient-to-r');
                messages.forEach(msg => {
                    msg.style.transition = 'opacity 0.5s ease';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                });
            }, 5000);
        @endif
    </script>
</body>
</html>