<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - N-CLiterASi</title>
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
        .btn-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .btn-success:hover {
            opacity: 0.9;
        }
        .btn-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }
        .btn-warning:hover {
            opacity: 0.9;
        }
        .stat-card {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
        }
        .loan-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .status-selesai {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .status-aktif {
            background-color: #E0F2FE;
            color: #0369A1;
        }
        .status-terlambat {
            background-color: #FEE2E2;
            color: #DC2626;
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
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Riwayat Peminjaman</h1>
                        <p class="text-sm text-[#EEC8A3]">Semua aktivitas peminjaman Anda</p>
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
        <!-- Header Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="stat-card rounded-xl shadow-lg p-4 text-center card-border">
                <div class="text-2xl font-bold text-[#D24C49]">{{ $loans->total() }}</div>
                <div class="text-sm text-[#3A2E2A] font-medium">Total Peminjaman</div>
            </div>
            <div class="stat-card rounded-xl shadow-lg p-4 text-center card-border">
                <div class="text-2xl font-bold text-[#10B981]">
                    {{ $loans->where('returned_at', '!=', null)->count() }}
                </div>
                <div class="text-sm text-[#3A2E2A] font-medium">Selesai</div>
            </div>
            <div class="stat-card rounded-xl shadow-lg p-4 text-center card-border">
                <div class="text-2xl font-bold text-[#3A2E2A]">
                    {{ $loans->where('returned_at', null)->count() }}
                </div>
                <div class="text-sm text-[#3A2E2A] font-medium">Aktif</div>
            </div>
            <div class="stat-card rounded-xl shadow-lg p-4 text-center card-border">
                <div class="text-2xl font-bold text-[#A52C2A]">
                    Rp {{ number_format($loans->sum('fine'), 0, ',', '.') }}
                </div>
                <div class="text-sm text-[#3A2E2A] font-medium">Total Denda</div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-lg card-border p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-[#3A2E2A] flex items-center">
                        <div class="bg-[#EEC8A3] p-2 rounded-lg mr-3">
                            <i class="fas fa-filter text-[#D24C49]"></i>
                        </div>
                        Filter Riwayat
                    </h2>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari judul buku..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="active">Sedang Dipinjam</option>
                        <option value="returned">Sudah Dikembalikan</option>
                        <option value="overdue">Terlambat</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Loans History -->
        <div class="bg-white rounded-xl shadow-lg card-border overflow-hidden">
            <div class="px-6 py-4 border-b bg-[#3A2E2A]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <div class="bg-[#D24C49] p-2 rounded-lg mr-3">
                            <i class="fas fa-list-ul text-white"></i>
                        </div>
                        Daftar Peminjaman
                    </h2>
                    <span class="text-sm text-[#EEC8A3]">
                        Menampilkan {{ $loans->count() }} dari {{ $loans->total() }} peminjaman
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if($loans->count() > 0)
                    <div class="space-y-4">
                        @foreach($loans as $loan)
                        <div class="loan-card border border-[#EEC8A3] rounded-xl p-6 bg-white hover:shadow-md transition-all duration-300">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <!-- Book Info -->
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="w-16 h-20 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded-lg flex items-center justify-center shadow">
                                        <i class="fas fa-book text-[#D24C49] text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-[#3A2E2A] text-lg mb-1">{{ $loan->book->title }}</h3>
                                        <p class="text-[#3A2E2A]/80 mb-2">{{ $loan->book->author }}</p>
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                                            <div class="flex items-center text-[#3A2E2A]/70">
                                                <i class="fas fa-calendar-plus mr-2 w-4"></i>
                                                <span>Pinjam: {{ $loan->borrowed_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center text-[#3A2E2A]/70">
                                                <i class="fas fa-calendar-check mr-2 w-4"></i>
                                                <span>Jatuh Tempo: {{ $loan->due_at->format('d M Y') }}</span>
                                            </div>
                                            @if($loan->returned_at)
                                            <div class="flex items-center text-[#10B981]">
                                                <i class="fas fa-calendar-minus mr-2 w-4"></i>
                                                <span>Kembali: {{ $loan->returned_at->format('d M Y') }}</span>
                                            </div>
                                            @endif
                                            @if($loan->fine > 0)
                                            <div class="flex items-center text-[#DC2626] font-semibold">
                                                <i class="fas fa-money-bill-wave mr-2 w-4"></i>
                                                <span>Denda: Rp {{ number_format($loan->fine, 0, ',', '.') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex flex-col items-end space-y-3">
                                    <!-- Status Badge -->
                                    @if($loan->returned_at)
                                        <span class="status-selesai px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Selesai
                                        </span>
                                    @elseif(now()->gt($loan->due_at))
                                        <span class="status-terlambat px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Terlambat
                                        </span>
                                    @else
                                        <span class="status-aktif px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-clock mr-1"></i> Aktif
                                        </span>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        @if(!$loan->returned_at && now()->lt($loan->due_at))
                                        <form method="POST" action="{{ route('mahasiswa.loans.extend', $loan) }}">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Perpanjang peminjaman buku ini?')"
                                                    class="btn-warning text-white px-4 py-2 rounded-lg text-sm hover:opacity-90 transition flex items-center shadow-sm">
                                                <i class="fas fa-redo mr-1"></i> Perpanjang
                                            </button>
                                        </form>
                                        @endif

                                        @if(!$loan->returned_at)
                                        <form method="POST" action="{{ route('mahasiswa.loans.return', $loan) }}">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Kembalikan buku: {{ $loan->book->title }}?')"
                                                    class="btn-success text-white px-4 py-2 rounded-lg text-sm hover:opacity-90 transition flex items-center shadow-sm">
                                                <i class="fas fa-undo mr-1"></i> Kembalikan
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            @if(now()->gt($loan->due_at) && !$loan->returned_at)
                            <div class="mt-4 p-3 bg-[#FEE2E2] border border-[#FECACA] rounded-lg">
                                <div class="flex items-center text-[#DC2626]">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span class="font-medium">Terlambat {{ now()->diffInDays($loan->due_at) }} hari</span>
                                    <span class="mx-2">•</span>
                                    <span>Denda bertambah Rp {{ number_format(now()->diffInDays($loan->due_at) * 5000, 0, ',', '.') }}/hari</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($loans->hasPages())
                    <div class="mt-8 pt-6 border-t border-[#EEC8A3]">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-[#3A2E2A]/70">
                                Menampilkan {{ $loans->firstItem() }} - {{ $loans->lastItem() }} dari {{ $loans->total() }} peminjaman
                            </div>
                            <div class="flex space-x-2">
                                @if($loans->onFirstPage())
                                    <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $loans->previousPageUrl() }}" class="px-3 py-1 bg-[#FFE9D6] text-[#3A2E2A] rounded-lg hover:bg-[#EEC8A3]">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif
                                
                                @foreach(range(1, min(5, $loans->lastPage())) as $page)
                                    <a href="{{ $loans->url($page) }}" 
                                       class="px-3 py-1 rounded-lg {{ $loans->currentPage() == $page ? 'bg-[#D24C49] text-white' : 'bg-[#FFE9D6] text-[#3A2E2A] hover:bg-[#EEC8A3]' }}">
                                        {{ $page }}
                                    </a>
                                @endforeach
                                
                                @if($loans->hasMorePages())
                                    <a href="{{ $loans->nextPageUrl() }}" class="px-3 py-1 bg-[#FFE9D6] text-[#3A2E2A] rounded-lg hover:bg-[#EEC8A3]">
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
                            <i class="fas fa-history text-[#D24C49] text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-[#3A2E2A] mb-3">Belum Ada Riwayat</h3>
                        <p class="text-[#3A2E2A]/70 mb-8 max-w-md mx-auto">
                            Anda belum memiliki riwayat peminjaman buku. Mulai jelajahi koleksi buku kami dan pinjam buku pertama Anda.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('mahasiswa.books.index') }}" 
                               class="inline-flex items-center btn-primary text-white px-8 py-3 rounded-xl hover:opacity-90 transition transform hover:scale-105 shadow-md">
                                <i class="fas fa-search mr-2"></i> Jelajahi Katalog
                            </a>
                            <a href="{{ route('mahasiswa.dashboard') }}" 
                               class="inline-flex items-center border border-[#EEC8A3] text-[#3A2E2A] px-8 py-3 rounded-xl hover:bg-[#FAF4EF] transition">
                                <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2 flex items-center">
                            <div class="bg-[#D24C49] p-1 rounded mr-2">
                                <i class="fas fa-heart"></i>
                            </div>
                            Buku Favorit
                        </h3>
                        <p class="text-sm text-[#EEC8A3]">Lihat rekomendasi berdasarkan minat Anda</p>
                    </div>
                    <i class="fas fa-heart text-2xl opacity-80"></i>
                </div>
                <button class="mt-4 bg-[#EEC8A3] text-[#3A2E2A] px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#FFE9D6] transition">
                    Lihat Rekomendasi
                </button>
            </div>

            <div class="bg-gradient-to-r from-[#D24C49] to-[#A52C2A] rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2 flex items-center">
                            <div class="bg-white/20 p-1 rounded mr-2">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            Butuh Bantuan?
                        </h3>
                        <p class="text-sm text-[#FFE9D6]">Hubungi admin untuk pertanyaan</p>
                    </div>
                    <i class="fas fa-question-circle text-2xl opacity-80"></i>
                </div>
                <button class="mt-4 bg-white text-[#D24C49] px-4 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition">
                    Kontak Admin
                </button>
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