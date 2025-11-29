<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda - Perpustakaan Digital</title>
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
                    <div class="bg-red-500 p-2 rounded-lg">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Manajemen Denda</h1>
                        <p class="text-sm text-gray-600">Kelola denda peminjaman Anda</p>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-lg mr-4">
                        <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Denda</h3>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">Seluruh denda yang belum dibayar</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                        <i class="fas fa-list text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Jumlah Denda</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $loansWithFines->count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">Total record denda</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 {{ $totalUnpaid > 0 ? 'border-red-500' : 'border-green-500' }}">
                <div class="flex items-center">
                    <div class="p-3 {{ $totalUnpaid > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-lg mr-4">
                        <i class="fas {{ $totalUnpaid > 0 ? 'fa-exclamation-triangle text-red-600' : 'fa-check-circle text-green-600' }} text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Status</h3>
                        <p class="text-xl font-bold {{ $totalUnpaid > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $totalUnpaid > 0 ? 'Ada Denda' : 'Bebas Denda' }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">
                        {{ $totalUnpaid > 0 ? 'Segera lunasi untuk meminjam buku' : 'Anda dapat meminjam buku' }}
                    </span>
                </div>
            </div>
        </div>

        @if($totalUnpaid > 0)
        <!-- Warning Banner -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl mt-1"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-red-800 mb-2">Peringatan Denda</h3>
                    <p class="text-red-700 mb-4">
                        Anda memiliki denda tertunggak sebesar <strong>Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</strong>. 
                        Peminjaman buku baru akan diblokir sampai denda dilunasi.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition flex items-center">
                            <i class="fas fa-credit-card mr-2"></i> Bayar Denda Sekarang
                        </button>
                        <button class="border border-red-600 text-red-600 px-6 py-2 rounded-lg hover:bg-red-50 transition flex items-center">
                            <i class="fas fa-question-circle mr-2"></i> Bantuan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Denda List -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-receipt text-primary mr-2"></i>
                        Detail Denda
                    </h2>
                    <span class="text-sm text-gray-600">
                        {{ $loansWithFines->count() }} record ditemukan
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if($loansWithFines->count() > 0)
                    <div class="space-y-4">
                        @foreach($loansWithFines as $loan)
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
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
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
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Amount -->
                                <div class="flex flex-col items-end space-y-3">
                                    <!-- Amount Badge -->
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-red-600">
                                            Rp {{ number_format($loan->fine, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">Jumlah Denda</p>
                                    </div>

                                    <!-- Status Badge -->
                                    @if($loan->returned_at)
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-clock mr-1"></i> Belum Bayar
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Additional Info -->
                            @if(!$loan->returned_at && now()->gt($loan->due_at))
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center text-red-700">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span class="font-medium">Terlambat {{ now()->diffInDays($loan->due_at) }} hari - Denda: Rp {{ number_format($loan->fine, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-xl border">
                        <div class="flex flex-col sm:flex-row justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-gray-800 text-lg">Ringkasan Denda</h4>
                                <p class="text-sm text-gray-600 mt-1">Total denda belum dibayar</p>
                            </div>
                            <div class="text-center sm:text-right mt-4 sm:mt-0">
                                <p class="text-3xl font-bold text-red-600">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">{{ $loansWithFines->where('returned_at', null)->count() }} denda aktif</p>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-600 mb-3">Tidak Ada Denda</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">
                            Selamat! Anda tidak memiliki denda tertunggak. Terus pertahankan ketepatan waktu dalam pengembalian buku.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('books.index') }}" 
                               class="inline-flex items-center bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition">
                                <i class="fas fa-book mr-2"></i> Pinjam Buku
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

        <!-- Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <h3 class="font-semibold text-blue-800 mb-3 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Denda
                </h3>
                <ul class="text-sm text-blue-700 space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-chevron-right text-xs mt-1 mr-2"></i>
                        Denda keterlambatan: Rp 5.000 per hari
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-chevron-right text-xs mt-1 mr-2"></i>
                        Pembayaran denda dilakukan di perpustakaan
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-chevron-right text-xs mt-1 mr-2"></i>
                        Peminjaman baru diblokir jika ada denda
                    </li>
                </ul>
            </div>

            <div class="bg-orange-50 border border-orange-200 rounded-xl p-6">
                <h3 class="font-semibold text-orange-800 mb-3 flex items-center">
                    <i class="fas fa-phone-alt mr-2"></i>
                    Butuh Bantuan?
                </h3>
                <p class="text-sm text-orange-700 mb-4">
                    Hubungi admin perpustakaan untuk informasi lebih lanjut tentang denda.
                </p>
                <div class="flex items-center text-orange-600">
                    <i class="fas fa-envelope mr-2"></i>
                    <span class="text-sm">admin@perpus.ac.id</span>
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