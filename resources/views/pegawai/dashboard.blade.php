<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - N-CLiterASi</title>
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
        .btn-danger {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        }
        .btn-danger:hover {
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
        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
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
                        <i class="fas fa-book-reader text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">N-CLiterASi</h1>
                        <p class="text-[#EEC8A3] text-sm">Dashboard Pegawai</p>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-6">
                    <div class="text-right hidden sm:block">
                        <p class="font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[#EEC8A3] text-sm">Pegawai Perpustakaan</p>
                    </div>
                    <div class="relative group">
                        <div class="w-12 h-12 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center cursor-pointer shadow-md font-bold text-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-[#EEC8A3] py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 animate-fadeIn">
                            <a href="#" class="block px-4 py-2 text-[#3A2E2A] hover:bg-[#FAF4EF]">
                                <i class="fas fa-user mr-3 text-[#D24C49]"></i>Profil Saya
                            </a>
                            <a href="#" class="block px-4 py-2 text-[#3A2E2A] hover:bg-[#FAF4EF]">
                                <i class="fas fa-cog mr-3 text-[#D24C49]"></i>Pengaturan
                            </a>
                            <div class="border-t border-[#EEC8A3] my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-[#DC2626] hover:bg-[#FEE2E2]">
                                    <i class="fas fa-sign-out-alt mr-3"></i>Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-[#3A2E2A] mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-[#3A2E2A]/70">Kelola sistem perpustakaan dengan mudah dan efisien</p>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Peminjaman Aktif -->
            <div class="stat-card rounded-2xl p-6 card-border loan-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm font-medium">Peminjaman Aktif</p>
                        <p class="text-3xl font-bold text-[#3A2E2A] mt-2">{{ $activeLoansCount }}</p>
                        <p class="text-[#10B981] text-sm mt-1 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>Buku sedang dipinjam
                        </p>
                    </div>
                    <div class="p-3 bg-[#FFE9D6] rounded-xl">
                        <div class="bg-[#D24C49] text-white p-2 rounded-lg">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lewat Jatuh Tempo -->
            <div class="stat-card rounded-2xl p-6 card-border loan-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm font-medium">Lewat Jatuh Tempo</p>
                        <p class="text-3xl font-bold text-[#3A2E2A] mt-2">{{ $overdueCount }}</p>
                        <p class="text-[#DC2626] text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>Perlu tindakan
                        </p>
                    </div>
                    <div class="p-3 bg-[#FFE9D6] rounded-xl">
                        <div class="bg-[#DC2626] text-white p-2 rounded-lg">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menunggu Persetujuan -->
            <div class="stat-card rounded-2xl p-6 card-border loan-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm font-medium">Menunggu Persetujuan</p>
                        <p class="text-3xl font-bold text-[#3A2E2A] mt-2">{{ $pendingLoansCount }}</p>
                        <p class="text-[#F59E0B] text-sm mt-1 flex items-center">
                            <i class="fas fa-hourglass-half mr-1"></i>Butuh review
                        </p>
                    </div>
                    <div class="p-3 bg-[#FFE9D6] rounded-xl">
                        <div class="bg-[#F59E0B] text-white p-2 rounded-lg">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengembalian Hari Ini -->
            <div class="stat-card rounded-2xl p-6 card-border loan-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm font-medium">Pengembalian Hari Ini</p>
                        <p class="text-3xl font-bold text-[#3A2E2A] mt-2">{{ $todayReturns }}</p>
                        <p class="text-[#10B981] text-sm mt-1 flex items-center">
                            <i class="fas fa-calendar-day mr-1"></i>Jatuh tempo hari ini
                        </p>
                    </div>
                    <div class="p-3 bg-[#FFE9D6] rounded-xl">
                        <div class="bg-[#10B981] text-white p-2 rounded-lg">
                            <i class="fas fa-undo"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <!-- Peminjaman Menunggu Approval -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-border">
                <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <div class="bg-[#F59E0B] p-2 rounded-lg mr-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            Menunggu Persetujuan
                        </h3>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm font-medium">
                            {{ $pendingApprovals->count() }} Pending
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($pendingApprovals->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingApprovals as $loan)
                                <div class="bg-[#FAF4EF] rounded-xl p-4 border border-[#EEC8A3] animate-fadeIn">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-[#3A2E2A]">{{ $loan->user->name }}</p>
                                                <p class="text-sm text-[#3A2E2A]/70 truncate max-w-xs">{{ $loan->book->title }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-[#3A2E2A]/70">{{ $loan->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        
                                        <form action="{{ route('pegawai.loans.approve', $loan->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Setujui peminjaman ini?')"
                                                    class="w-full btn-success text-white py-2 px-4 rounded-lg hover:opacity-90 transition flex items-center justify-center space-x-2 shadow-sm">
                                                <i class="fas fa-check"></i>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('pegawai.loans.reject', $loan) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Tolak peminjaman ini?')"
                                                    class="w-full btn-danger text-white py-2 px-4 rounded-lg hover:opacity-90 transition flex items-center justify-center space-x-2 shadow-sm">
                                                <i class="fas fa-times"></i>
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-[#D1FAE5] rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check text-[#10B981] text-2xl"></i>
                            </div>
                            <p class="text-[#3A2E2A] font-medium">Tidak ada peminjaman menunggu persetujuan</p>
                            <p class="text-[#3A2E2A]/70 text-sm mt-1">Semua permintaan telah diproses</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Peminjaman Aktif -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-border">
                <div class="bg-gradient-to-r from-[#D24C49] to-[#A52C2A] p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <div class="bg-white/20 p-2 rounded-lg mr-3">
                                <i class="fas fa-book-open text-white"></i>
                            </div>
                            Peminjaman Aktif
                        </h3>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm font-medium">
                            {{ $activeLoans->count() }} Aktif
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($activeLoans->count() > 0)
                        <div class="space-y-4">
                            @foreach($activeLoans as $loan)
                                <div class="bg-[#FAF4EF] rounded-xl p-4 border border-[#EEC8A3] animate-fadeIn">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-[#FFE9D6] rounded-full flex items-center justify-center">
                                                <i class="fas fa-book text-[#D24C49]"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-[#3A2E2A]">{{ $loan->user->name }}</p>
                                                <p class="text-sm text-[#3A2E2A]/70 truncate max-w-xs">{{ $loan->book->title }}</p>
                                            </div>
                                        </div>
                                        @if($loan->due_at->isPast())
                                            <span class="bg-[#FEE2E2] text-[#DC2626] px-3 py-1 rounded-full text-xs font-medium">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="bg-[#D1FAE5] text-[#065F46] px-3 py-1 rounded-full text-xs font-medium">
                                                Aktif
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm">
                                            <p class="text-[#3A2E2A]/70">Jatuh tempo:</p>
                                            <p class="font-semibold {{ $loan->due_at->isPast() ? 'text-[#DC2626]' : 'text-[#3A2E2A]' }}">
                                                {{ $loan->due_at->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right text-sm">
                                            <p class="text-[#3A2E2A]/70">Sisa waktu:</p>
                                            <p class="font-semibold {{ $loan->due_at->isPast() ? 'text-[#DC2626]' : 'text-[#10B981]' }}">
                                                @if($loan->due_at->isPast())
                                                    {{ $loan->due_at->diffInDays(now()) }} hari lewat
                                                @else
                                                    {{ $loan->due_at->diffInDays(now()) }} hari
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-[#E0F2FE] rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book-open text-[#0369A1] text-2xl"></i>
                            </div>
                            <p class="text-[#3A2E2A] font-medium">Tidak ada peminjaman aktif</p>
                            <p class="text-[#3A2E2A]/70 text-sm mt-1">Semua buku telah dikembalikan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-border">
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] p-6">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <div class="bg-[#D24C49] p-2 rounded-lg mr-3">
                        <i class="fas fa-bolt text-white"></i>
                    </div>
                    Aksi Cepat
                </h3>
                <p class="text-[#EEC8A3] mt-1">Akses fitur penting dengan satu klik</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('pegawai.books.create') }}" class="group">
                        <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] border border-[#EEC8A3] rounded-xl p-6 text-center action-card group-hover:from-[#FAF4EF] group-hover:to-[#FFE9D6] transition-all">
                            <div class="w-12 h-12 bg-[#D24C49] rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform shadow-md">
                                <i class="fas fa-plus text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-[#3A2E2A]">Tambah Buku</p>
                            <p class="text-[#3A2E2A]/70 text-sm mt-1">Tambah buku baru</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.loans.index') }}" class="group">
                        <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] border border-[#EEC8A3] rounded-xl p-6 text-center action-card group-hover:from-[#FAF4EF] group-hover:to-[#FFE9D6] transition-all">
                            <div class="w-12 h-12 bg-[#10B981] rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform shadow-md">
                                <i class="fas fa-list text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-[#3A2E2A]">Kelola Peminjaman</p>
                            <p class="text-[#3A2E2A]/70 text-sm mt-1">Lihat semua peminjaman</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.books.index') }}" class="group">
                        <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] border border-[#EEC8A3] rounded-xl p-6 text-center action-card group-hover:from-[#FAF4EF] group-hover:to-[#FFE9D6] transition-all">
                            <div class="w-12 h-12 bg-[#3A2E2A] rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform shadow-md">
                                <i class="fas fa-book text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-[#3A2E2A]">Kelola Buku</p>
                            <p class="text-[#3A2E2A]/70 text-sm mt-1">Kelola koleksi buku</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.fines.index') }}" class="group">
                        <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] border border-[#EEC8A3] rounded-xl p-6 text-center action-card group-hover:from-[#FAF4EF] group-hover:to-[#FFE9D6] transition-all">
                            <div class="w-12 h-12 bg-[#F59E0B] rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform shadow-md">
                                <i class="fas fa-money-bill-wave text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-[#3A2E2A]">Lihat Denda</p>
                            <p class="text-[#3A2E2A]/70 text-sm mt-1">Kelola pembayaran denda</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-[#3A2E2A] border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 text-[#EEC8A3]">
                    <i class="fas fa-book"></i>
                    <span class="text-sm">N-CLiterASi © 2025</span>
                </div>
                <div class="text-[#EEC8A3] text-sm mt-2 md:mt-0">
                    Semua hak dilindungi undang-undang
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript untuk interaksi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.loan-card, .action-card');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Dropdown hover effect
            const userMenu = document.querySelector('.group');
            if (userMenu) {
                userMenu.addEventListener('mouseenter', function() {
                    const dropdown = this.querySelector('div:last-child');
                    dropdown.classList.remove('invisible', 'opacity-0');
                    dropdown.classList.add('visible', 'opacity-100');
                });
                
                userMenu.addEventListener('mouseleave', function() {
                    const dropdown = this.querySelector('div:last-child');
                    dropdown.classList.add('invisible', 'opacity-0');
                    dropdown.classList.remove('visible', 'opacity-100');
                });
            }
        });
    </script>
</body>
</html>