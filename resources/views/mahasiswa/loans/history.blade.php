<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Perpustakaan Digital</title>
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
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Riwayat Peminjaman</h1>
                        <p class="text-sm text-gray-600">Semua aktivitas peminjaman Anda</p>
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
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-4 text-center">
                <div class="text-2xl font-bold text-primary">{{ $loans->total() }}</div>
                <div class="text-sm text-gray-600">Total Peminjaman</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-600">
                    {{ $loans->where('returned_at', '!=', null)->count() }}
                </div>
                <div class="text-sm text-gray-600">Selesai</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">
                    {{ $loans->where('returned_at', null)->count() }}
                </div>
                <div class="text-sm text-gray-600">Aktif</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-4 text-center">
                <div class="text-2xl font-bold text-red-600">
                    Rp {{ number_format($loans->sum('fine'), 0, ',', '.') }}
                </div>
                <div class="text-sm text-gray-600">Total Denda</div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-filter text-primary mr-2"></i>
                        Filter Riwayat
                    </h2>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari judul buku..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="active">Sedang Dipinjam</option>
                        <option value="returned">Sudah Dikembalikan</option>
                        <option value="overdue">Terlambat</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Loans History -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ul text-primary mr-2"></i>
                        Daftar Peminjaman
                    </h2>
                    <span class="text-sm text-gray-600">
                        Menampilkan {{ $loans->count() }} dari {{ $loans->total() }} peminjaman
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if($loans->count() > 0)
                    <div class="space-y-4">
                        @foreach($loans as $loan)
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-all duration-300">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <!-- Book Info -->
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="w-16 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center shadow">
                                        <i class="fas fa-book text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800 text-lg mb-1">{{ $loan->book->title }}</h3>
                                        <p class="text-gray-600 mb-2">{{ $loan->book->author }}</p>
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                                            <div class="flex items-center text-gray-500">
                                                <i class="fas fa-calendar-plus mr-2 w-4"></i>
                                                <span>Pinjam: {{ $loan->borrowed_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center text-gray-500">
                                                <i class="fas fa-calendar-check mr-2 w-4"></i>
                                                <span>Jatuh Tempo: {{ $loan->due_at->format('d M Y') }}</span>
                                            </div>
                                            @if($loan->returned_at)
                                            <div class="flex items-center text-green-600">
                                                <i class="fas fa-calendar-minus mr-2 w-4"></i>
                                                <span>Kembali: {{ $loan->returned_at->format('d M Y') }}</span>
                                            </div>
                                            @endif
                                            @if($loan->fine > 0)
                                            <div class="flex items-center text-red-600 font-semibold">
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
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Selesai
                                        </span>
                                    @elseif(now()->gt($loan->due_at))
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Terlambat
                                        </span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-clock mr-1"></i> Aktif
                                        </span>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        @if(!$loan->returned_at && now()->lt($loan->due_at))
                                        <form method="POST" action="{{ route('mahasiswa.loans.extend', $loan) }}">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition flex items-center">
                                                <i class="fas fa-redo mr-1"></i> Perpanjang
                                            </button>
                                        </form>
                                        @endif

                                        @if(!$loan->returned_at)
                                        <form method="POST" action="{{ route('mahasiswa.loans.return', $loan) }}">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition flex items-center">
                                                <i class="fas fa-undo mr-1"></i> Kembalikan
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            @if(now()->gt($loan->due_at) && !$loan->returned_at)
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center text-red-700">
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
                    <div class="mt-8">
                        {{ $loans->links() }}
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-history text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-600 mb-3">Belum Ada Riwayat</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">
                            Anda belum memiliki riwayat peminjaman buku. Mulai jelajahi koleksi buku kami dan pinjam buku pertama Anda.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('books.index') }}" 
                               class="inline-flex items-center bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition">
                                <i class="fas fa-search mr-2"></i> Jelajahi Katalog
                            </a>
                            <a href="{{ route('mahasiswa.dashboard') }}" 
                               class="inline-flex items-center border border-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Buku Favorit</h3>
                        <p class="text-sm opacity-90">Lihat rekomendasi berdasarkan minat Anda</p>
                    </div>
                    <i class="fas fa-heart text-2xl opacity-80"></i>
                </div>
                <button class="mt-4 bg-white text-purple-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition">
                    Lihat Rekomendasi
                </button>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Butuh Bantuan?</h3>
                        <p class="text-sm opacity-90">Hubungi admin untuk pertanyaan</p>
                    </div>
                    <i class="fas fa-question-circle text-2xl opacity-80"></i>
                </div>
                <button class="mt-4 bg-white text-orange-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition">
                    Kontak Admin
                </button>
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