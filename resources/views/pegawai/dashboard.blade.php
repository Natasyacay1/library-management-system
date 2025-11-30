<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        accent: '#F59E0B',
                        success: '#10B981',
                        danger: '#EF4444',
                        warning: '#F59E0B',
                        info: '#06B6D4'
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body class="font-inter bg-gray-50 min-h-full">
    <!-- Header/Navigation -->
    <header class="gradient-bg text-white shadow-xl">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl">
                        <i class="fas fa-book-reader text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Perpustakaan Digital</h1>
                        <p class="text-white/80 text-sm">Dashboard Pegawai</p>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-white/80 text-sm">Pegawai Perpustakaan</p>
                    </div>
                    <div class="relative group">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center cursor-pointer">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user mr-3"></i>Profil Saya
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog mr-3"></i>Pengaturan
                            </a>
                            <div class="border-t my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
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
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-gray-600">Kelola sistem perpustakaan dengan mudah dan efisien</p>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Peminjaman Aktif -->
            <div class="stat-card rounded-2xl p-6 card-hover border-l-4 border-l-primary">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Peminjaman Aktif</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $activeLoansCount }}</p>
                        <p class="text-green-600 text-sm mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>Buku sedang dipinjam
                        </p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <i class="fas fa-book-open text-primary text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Lewat Jatuh Tempo -->
            <div class="stat-card rounded-2xl p-6 card-hover border-l-4 border-l-danger">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Lewat Jatuh Tempo</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $overdueCount }}</p>
                        <p class="text-red-600 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>Perlu tindakan
                        </p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-xl">
                        <i class="fas fa-clock text-danger text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Menunggu Persetujuan -->
            <div class="stat-card rounded-2xl p-6 card-hover border-l-4 border-l-warning">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Menunggu Persetujuan</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingLoansCount }}</p>
                        <p class="text-yellow-600 text-sm mt-1">
                            <i class="fas fa-hourglass-half mr-1"></i>Butuh review
                        </p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl">
                        <i class="fas fa-clipboard-check text-warning text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pengembalian Hari Ini -->
            <div class="stat-card rounded-2xl p-6 card-hover border-l-4 border-l-success">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pengembalian Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $todayReturns }}</p>
                        <p class="text-green-600 text-sm mt-1">
                            <i class="fas fa-calendar-day mr-1"></i>Jatuh tempo hari ini
                        </p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl">
                        <i class="fas fa-undo text-success text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <!-- Peminjaman Menunggu Approval -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-warning to-accent p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Menunggu Persetujuan</h3>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm font-medium">
                            {{ $pendingApprovals->count() }} Pending
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($pendingApprovals->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingApprovals as $loan)
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-warning rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $loan->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $loan->book->title }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $loan->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('pegawai.loans.approve', $loan) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-success text-white py-2 px-4 rounded-lg hover:bg-green-700 transition flex items-center justify-center space-x-2">
                                                <i class="fas fa-check"></i>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('pegawai.loans.reject', $loan) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-danger text-white py-2 px-4 rounded-lg hover:bg-red-700 transition flex items-center justify-center space-x-2">
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
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check text-green-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada peminjaman menunggu persetujuan</p>
                            <p class="text-gray-400 text-sm mt-1">Semua permintaan telah diproses</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Peminjaman Aktif -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-primary to-secondary p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Peminjaman Aktif</h3>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm font-medium">
                            {{ $activeLoans->count() }} Aktif
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($activeLoans->count() > 0)
                        <div class="space-y-4">
                            @foreach($activeLoans as $loan)
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                                                <i class="fas fa-book text-white"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $loan->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $loan->book->title }}</p>
                                            </div>
                                        </div>
                                        @if($loan->due_at->isPast())
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                                Aktif
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm">
                                            <p class="text-gray-600">Jatuh tempo:</p>
                                            <p class="font-semibold {{ $loan->due_at->isPast() ? 'text-red-600' : 'text-gray-800' }}">
                                                {{ $loan->due_at->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right text-sm">
                                            <p class="text-gray-600">Sisa waktu:</p>
                                            <p class="font-semibold {{ $loan->due_at->isPast() ? 'text-red-600' : 'text-green-600' }}">
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
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book-open text-blue-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada peminjaman aktif</p>
                            <p class="text-gray-400 text-sm mt-1">Semua buku telah dikembalikan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-info to-cyan-500 p-6">
                <h3 class="text-xl font-bold text-white">Aksi Cepat</h3>
                <p class="text-white/80 mt-1">Akses fitur penting dengan satu klik</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('pegawai.books.create') }}" class="group">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6 text-center card-hover group-hover:from-blue-100 group-hover:to-blue-200 transition-all">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-gray-800">Tambah Buku</p>
                            <p class="text-gray-600 text-sm mt-1">Tambah buku baru</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.loans.index') }}" class="group">
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6 text-center card-hover group-hover:from-green-100 group-hover:to-green-200 transition-all">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-list text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-gray-800">Kelola Peminjaman</p>
                            <p class="text-gray-600 text-sm mt-1">Lihat semua peminjaman</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.books.index') }}" class="group">
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6 text-center card-hover group-hover:from-purple-100 group-hover:to-purple-200 transition-all">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-book text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-gray-800">Kelola Buku</p>
                            <p class="text-gray-600 text-sm mt-1">Kelola koleksi buku</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.fines.index') }}" class="group">
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-6 text-center card-hover group-hover:from-yellow-100 group-hover:to-yellow-200 transition-all">
                            <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-money-bill-wave text-white text-xl"></i>
                            </div>
                            <p class="font-semibold text-gray-800">Lihat Denda</p>
                            <p class="text-gray-600 text-sm mt-1">Kelola pembayaran denda</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 text-gray-600">
                    <i class="fas fa-heart text-red-500"></i>
                </div>
                <div class="text-gray-500 text-sm mt-2 md:mt-0">
                    &copy; 2024 Perpustakaan Digital. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript untuk interaksi -->
    <script>
        // Animasi sederhana untuk cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-hover');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Notification bell functionality
            const notificationBell = document.querySelector('.notification-bell');
            if (notificationBell) {
                notificationBell.addEventListener('click', function() {
                    // Implement notification dropdown here
                    console.log('Notification bell clicked');
                });
            }
        });
    </script>
</body>
</html>