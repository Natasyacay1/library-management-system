<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Perpustakaan Digital</title>
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
                    <div class="bg-primary p-2 rounded-lg">
                        <i class="fas fa-book-open text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Perpustakaan Digital</h1>
                        <p class="text-sm text-gray-600">Dashboard Mahasiswa</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-right">
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
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl shadow-xl p-6 mb-8 text-white">
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
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg mr-4">
                        <i class="fas fa-book-open text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Sedang Dipinjam</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $activeLoans->count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">Buku aktif saat ini</span>
                </div>
            </div>

            <!-- Pending Loans Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Menunggu</h3>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ $loanHistory->where('returned_at', null)->where('created_at', '>', now()->subDay())->count() }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">Peminjaman terbaru</span>
                </div>
            </div>

            <!-- Fines Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-lg mr-4">
                        <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Denda</h3>
                        <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">Denda belum dibayar</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Active Loans -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Active Loans Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b bg-gray-50">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-bookmark text-primary mr-2"></i>
                                Buku Sedang Dipinjam
                            </h2>
                            <span class="bg-primary text-white px-3 py-1 rounded-full text-sm">
                                {{ $activeLoans->count() }} Aktif
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($activeLoans->count() > 0)
                            <div class="space-y-4">
                                @foreach($activeLoans as $loan)
                                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-book text-blue-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 text-lg">{{ $loan->book->title }}</h4>
                                                <p class="text-gray-600 text-sm">{{ $loan->book->author }}</p>
                                                <div class="flex flex-wrap gap-4 mt-2 text-xs">
                                                    <span class="flex items-center text-gray-500">
                                                        <i class="fas fa-calendar-plus mr-1"></i>
                                                        {{ $loan->borrowed_at->format('d M Y') }}
                                                    </span>
                                                    <span class="flex items-center {{ now()->gt($loan->due_at) ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                                        <i class="fas fa-calendar-check mr-1"></i>
                                                        {{ $loan->due_at->format('d M Y') }}
                                                    </span>
                                                    @if($loan->fine > 0)
                                                    <span class="flex items-center text-red-600 font-semibold">
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
                                                <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-600 transition flex items-center">
                                                    <i class="fas fa-redo mr-1"></i> Perpanjang
                                                </button>
                                            </form>
                                            @endif
                                            <form method="POST" action="{{ route('mahasiswa.loans.return', $loan) }}">
                                                @csrf
                                                <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-green-600 transition flex items-center">
                                                    <i class="fas fa-undo mr-1"></i> Kembalikan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    @if(now()->gt($loan->due_at))
                                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                        <div class="flex items-center text-red-700">
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
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-book-open text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada buku yang dipinjam</h3>
                                <p class="text-gray-500 mb-6">Mulai jelajahi koleksi buku kami</p>
                                <a href="{{ route('mahasiswa.books.index') }}" 
                                   class="inline-flex items-center bg-primary text-white px-6 py-3 rounded-lg hover:bg-secondary transition">
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
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-bolt text-accent mr-2"></i>
                        Akses Cepat
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('mahasiswa.books.index') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition">
                            <i class="fas fa-search text-blue-600 w-6"></i>
                            <span class="ml-3 text-gray-700">Cari Buku</span>
                        </a>
                        <a href="{{ route('mahasiswa.loans.history') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition">
                            <i class="fas fa-history text-green-600 w-6"></i>
                            <span class="ml-3 text-gray-700">Riwayat Pinjam</span>
                        </a>
                        <a href="{{ route('mahasiswa.fines') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-200 transition">
                            <i class="fas fa-money-bill-wave text-red-600 w-6"></i>
                            <span class="ml-3 text-gray-700">Lihat Denda</span>
                        </a>
                    </div>
                </div>

                <!-- Recommended Books -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Rekomendasi Buku
                    </h3>
                    <div class="space-y-3">
                        @foreach($recommendedBooks as $book)
                        <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-purple-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 text-sm truncate">{{ $book->title }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $book->author }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ route('mahasiswa.books.index') }}" class="text-primary text-sm font-medium hover:text-secondary transition flex items-center justify-center">
                            Lihat Semua Buku
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-semibold">Status Sistem</h3>
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <p class="text-sm opacity-90">Semua layanan berjalan normal</p>
                    <div class="mt-4 flex items-center text-xs">
                        <div class="w-2 h-2 bg-white rounded-full mr-2"></div>
                        <span>Online</span>
                    </div>
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
    </style>
</body>
</html>