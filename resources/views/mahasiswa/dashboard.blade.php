<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - N-CLiterASi</title>
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
        .welcome-gradient {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
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
        .status-card {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
        }
        .loan-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
                    <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                        <i class="fas fa-book-open text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">N-CLiterASi</h1>
                        <p class="text-sm text-[#EEC8A3]">Dashboard Mahasiswa</p>
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
        <!-- Welcome Section -->
        <div class="welcome-gradient rounded-2xl shadow-xl p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ $user->name }}! 👋</h1>
                    <p class="opacity-90">Mari jelajahi koleksi buku kami dan tingkatkan pengetahuan Anda</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-graduation-cap text-4xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Active Loans Card -->
            <div class="status-card rounded-xl shadow-lg p-6 card-border">
                <div class="flex items-center">
                    <div class="bg-[#FFE9D6] p-3 rounded-lg mr-4">
                        <div class="bg-[#D24C49] text-white p-2 rounded-lg">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-[#3A2E2A]/70 text-sm font-medium">Sedang Dipinjam</h3>
                        <p class="text-3xl font-bold text-[#3A2E2A]">{{ $activeLoans->count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-[#3A2E2A]/70">Buku aktif saat ini</span>
                </div>
            </div>

            <!-- Pending Loans Card -->
            <div class="status-card rounded-xl shadow-lg p-6 card-border">
                <div class="flex items-center">
                    <div class="bg-[#FFE9D6] p-3 rounded-lg mr-4">
                        <div class="bg-[#3A2E2A] text-white p-2 rounded-lg">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-[#3A2E2A]/70 text-sm font-medium">Menunggu</h3>
                        <p class="text-3xl font-bold text-[#3A2E2A]">
                            {{ $loanHistory->where('returned_at', null)->where('created_at', '>', now()->subDay())->count() }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-[#3A2E2A]/70">Peminjaman terbaru</span>
                </div>
            </div>

            <!-- Fines Card -->
            <div class="status-card rounded-xl shadow-lg p-6 card-border">
                <div class="flex items-center">
                    <div class="bg-[#FFE9D6] p-3 rounded-lg mr-4">
                        <div class="bg-[#A52C2A] text-white p-2 rounded-lg">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-[#3A2E2A]/70 text-sm font-medium">Total Denda</h3>
                        <p class="text-3xl font-bold text-[#3A2E2A]">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-[#3A2E2A]/70">Denda belum dibayar</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Active Loans -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Active Loans Section -->
                <div class="bg-white rounded-xl shadow-lg card-border overflow-hidden">
                    <div class="px-6 py-4 border-b bg-[#3A2E2A]">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <div class="bg-[#D24C49] p-2 rounded-lg mr-3">
                                    <i class="fas fa-bookmark text-white"></i>
                                </div>
                                Buku Sedang Dipinjam
                            </h2>
                            <span class="bg-[#D24C49] text-white px-3 py-1 rounded-full text-sm">
                                {{ $activeLoans->count() }} Aktif
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($activeLoans->count() > 0)
                            <div class="space-y-4">
                                @foreach($activeLoans as $loan)
                                <div class="loan-card border border-[#EEC8A3] rounded-xl p-4 bg-white hover:shadow-md transition-all duration-300">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <div class="w-12 h-12 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded-lg flex items-center justify-center">
                                                <i class="fas fa-book text-[#D24C49]"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-[#3A2E2A] text-lg">{{ $loan->book->title }}</h4>
                                                <p class="text-[#3A2E2A]/80 text-sm">{{ $loan->book->author }}</p>
                                                <div class="flex flex-wrap gap-4 mt-2 text-xs">
                                                    <span class="flex items-center text-[#3A2E2A]/70">
                                                        <i class="fas fa-calendar-plus mr-1"></i>
                                                        {{ $loan->borrowed_at->format('d M Y') }}
                                                    </span>
                                                    <span class="flex items-center {{ now()->gt($loan->due_at) ? 'text-[#DC2626] font-semibold' : 'text-[#3A2E2A]/70' }}">
                                                        <i class="fas fa-calendar-check mr-1"></i>
                                                        {{ $loan->due_at->format('d M Y') }}
                                                    </span>
                                                    @if($loan->fine > 0)
                                                    <span class="flex items-center text-[#DC2626] font-semibold">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                                        Denda: Rp {{ number_format($loan->fine, 0, ',', '.') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col space-y-2 ml-4">
                                            @if(now()->lt($loan->due_at))
                                            <form method="POST" action="{{ route('mahasiswa.loans.extend', $loan) }}">
                                                @csrf
                                                <button type="submit" 
                                                        onclick="return confirm('Perpanjang peminjaman buku ini?')"
                                                        class="btn-warning text-white px-3 py-2 rounded-lg text-sm hover:opacity-90 transition flex items-center shadow-sm">
                                                    <i class="fas fa-redo mr-1"></i> Perpanjang
                                                </button>
                                            </form>
                                            @endif
                                            <form method="POST" action="{{ route('mahasiswa.loans.return', $loan) }}">
                                                @csrf
                                                <button type="submit" 
                                                        onclick="return confirm('Kembalikan buku: {{ $loan->book->title }}?')"
                                                        class="btn-success text-white px-3 py-2 rounded-lg text-sm hover:opacity-90 transition flex items-center shadow-sm">
                                                    <i class="fas fa-undo mr-1"></i> Kembalikan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    @if(now()->gt($loan->due_at))
                                    <div class="mt-3 p-3 bg-[#FEE2E2] border border-[#FECACA] rounded-lg">
                                        <div class="flex items-center text-[#DC2626]">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            <span class="text-sm font-medium">Buku sudah melewati jatuh tempo!</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-[#FFE9D6] rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-book-open text-[#D24C49] text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-[#3A2E2A] mb-2">Belum ada buku yang dipinjam</h3>
                                <p class="text-[#3A2E2A]/70 mb-6">Mulai jelajahi koleksi buku kami</p>
                                <a href="{{ route('mahasiswa.books.index') }}" 
                                   class="inline-flex items-center btn-primary text-white px-6 py-3 rounded-xl hover:opacity-90 transition transform hover:scale-105 shadow-md">
                                    <i class="fas fa-plus mr-2"></i> Pinjam Buku Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg card-border p-6">
                    <h3 class="font-semibold text-[#3A2E2A] mb-4 flex items-center">
                        <div class="bg-[#EEC8A3] p-2 rounded-lg mr-3">
                            <i class="fas fa-bolt text-[#D24C49]"></i>
                        </div>
                        Akses Cepat
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('mahasiswa.books.index') }}" class="flex items-center p-3 border border-[#EEC8A3] rounded-lg hover:bg-[#FFE9D6] hover:border-[#D24C49] transition">
                            <div class="bg-[#FFE9D6] p-2 rounded-lg mr-3">
                                <i class="fas fa-search text-[#D24C49]"></i>
                            </div>
                            <span class="text-[#3A2E2A] font-medium">Cari Buku</span>
                        </a>
                        <a href="{{ route('mahasiswa.loans.history') }}" class="flex items-center p-3 border border-[#EEC8A3] rounded-lg hover:bg-[#FFE9D6] hover:border-[#10B981] transition">
                            <div class="bg-[#FFE9D6] p-2 rounded-lg mr-3">
                                <i class="fas fa-history text-[#10B981]"></i>
                            </div>
                            <span class="text-[#3A2E2A] font-medium">Riwayat Pinjam</span>
                        </a>
                        <a href="{{ route('mahasiswa.fines') }}" class="flex items-center p-3 border border-[#EEC8A3] rounded-lg hover:bg-[#FFE9D6] hover:border-[#DC2626] transition">
                            <div class="bg-[#FFE9D6] p-2 rounded-lg mr-3">
                                <i class="fas fa-money-bill-wave text-[#DC2626]"></i>
                            </div>
                            <span class="text-[#3A2E2A] font-medium">Lihat Denda</span>
                        </a>
                    </div>
                </div>

                <!-- Recommended Books -->
                <div class="bg-white rounded-xl shadow-lg card-border p-6">
                    <h3 class="font-semibold text-[#3A2E2A] mb-4 flex items-center">
                        <div class="bg-[#FFE9D6] p-2 rounded-lg mr-3">
                            <i class="fas fa-star text-[#F59E0B]"></i>
                        </div>
                        Rekomendasi Buku
                    </h3>
                    <div class="space-y-3">
                        @foreach($recommendedBooks as $book)
                        <div class="flex items-center space-x-3 p-3 border border-[#EEC8A3] rounded-lg hover:bg-[#FAF4EF] transition">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-[#D24C49] text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-[#3A2E2A] text-sm truncate">{{ $book->title }}</p>
                                <p class="text-xs text-[#3A2E2A]/70 truncate">{{ $book->author }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-[#EEC8A3]">
                        <a href="{{ route('mahasiswa.books.index') }}" class="text-[#D24C49] text-sm font-medium hover:text-[#A52C2A] transition flex items-center justify-center">
                            Lihat Semua Buku
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-semibold flex items-center">
                            <div class="bg-[#D24C49] p-1 rounded mr-2">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            Status Sistem
                        </h3>
                        <div class="w-2 h-2 bg-[#10B981] rounded-full animate-pulse"></div>
                    </div>
                    <p class="text-sm text-[#EEC8A3]">Semua layanan berjalan normal</p>
                    <div class="mt-4 flex items-center text-xs text-[#EEC8A3]">
                        <div class="w-2 h-2 bg-[#10B981] rounded-full mr-2"></div>
                        <span>Online • 24/7</span>
                    </div>
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