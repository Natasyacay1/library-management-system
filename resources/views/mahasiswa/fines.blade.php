<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda - N-CLiterASi</title>
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
        .btn-warning {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        }
        .btn-warning:hover {
            opacity: 0.9;
        }
        .stat-card {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
        }
        .fine-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .status-unpaid {
            background-color: #FEE2E2;
            color: #DC2626;
        }
        .status-paid {
            background-color: #D1FAE5;
            color: #065F46;
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
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Manajemen Denda</h1>
                        <p class="text-sm text-[#EEC8A3]">Kelola denda peminjaman Anda</p>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card rounded-xl shadow-lg p-6 card-border">
                <div class="flex items-center">
                    <div class="bg-[#FFE9D6] p-3 rounded-lg mr-4">
                        <div class="bg-[#D24C49] text-white p-2 rounded-lg">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-[#3A2E2A]/70 text-sm font-medium">Total Denda</h3>
                        <p class="text-2xl font-bold text-[#3A2E2A]">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-[#3A2E2A]/70">Seluruh denda yang belum dibayar</span>
                </div>
            </div>

            <div class="stat-card rounded-xl shadow-lg p-6 card-border">
                <div class="flex items-center">
                    <div class="bg-[#FFE9D6] p-3 rounded-lg mr-4">
                        <div class="bg-[#3A2E2A] text-white p-2 rounded-lg">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-[#3A2E2A]/70 text-sm font-medium">Jumlah Denda</h3>
                        <p class="text-2xl font-bold text-[#3A2E2A]">{{ $loansWithFines->count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-[#3A2E2A]/70">Total record denda</span>
                </div>
            </div>

            <div class="stat-card rounded-xl shadow-lg p-6 card-border">
                <div class="flex items-center">
                    <div class="bg-[#FFE9D6] p-3 rounded-lg mr-4">
                        <div class="{{ $totalUnpaid > 0 ? 'bg-[#DC2626]' : 'bg-[#10B981]' }} text-white p-2 rounded-lg">
                            <i class="fas {{ $totalUnpaid > 0 ? 'fa-exclamation-triangle' : 'fa-check-circle' }}"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-[#3A2E2A]/70 text-sm font-medium">Status</h3>
                        <p class="text-xl font-bold {{ $totalUnpaid > 0 ? 'text-[#DC2626]' : 'text-[#10B981]' }}">
                            {{ $totalUnpaid > 0 ? 'Ada Denda' : 'Bebas Denda' }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-[#3A2E2A]/70">
                        {{ $totalUnpaid > 0 ? 'Segera lunasi untuk meminjam buku' : 'Anda dapat meminjam buku' }}
                    </span>
                </div>
            </div>
        </div>

        @if($totalUnpaid > 0)
        <!-- Warning Banner -->
        <div class="bg-[#FEE2E2] border border-[#FECACA] rounded-xl p-6 mb-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-[#DC2626] text-white p-3 rounded-lg">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-[#DC2626] mb-2">Peringatan Denda</h3>
                    <p class="text-[#DC2626] mb-4">
                        Anda memiliki denda tertunggak sebesar <strong>Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</strong>. 
                        Peminjaman buku baru akan diblokir sampai denda dilunasi.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <button class="btn-warning text-white px-6 py-3 rounded-xl hover:opacity-90 transition flex items-center shadow-md">
                            <i class="fas fa-credit-card mr-2"></i> Bayar Denda Sekarang
                        </button>
                        <button class="border border-[#DC2626] text-[#DC2626] px-6 py-3 rounded-xl hover:bg-[#FEE2E2] transition flex items-center">
                            <i class="fas fa-question-circle mr-2"></i> Bantuan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Denda List -->
        <div class="bg-white rounded-xl shadow-lg card-border overflow-hidden">
            <div class="px-6 py-4 border-b bg-[#3A2E2A]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <div class="bg-[#D24C49] p-2 rounded-lg mr-3">
                            <i class="fas fa-receipt text-white"></i>
                        </div>
                        Detail Denda
                    </h2>
                    <span class="text-sm text-[#EEC8A3]">
                        {{ $loansWithFines->count() }} record ditemukan
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if($loansWithFines->count() > 0)
                    <div class="space-y-4">
                        @foreach($loansWithFines as $loan)
                        <div class="fine-card border border-[#EEC8A3] rounded-xl p-6 bg-white hover:shadow-md transition-all duration-300">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <!-- Book Info -->
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="w-16 h-20 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded-lg flex items-center justify-center shadow">
                                        <i class="fas fa-book text-[#D24C49] text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-[#3A2E2A] text-lg mb-1">{{ $loan->book->title }}</h3>
                                        <p class="text-[#3A2E2A]/80 mb-2">{{ $loan->book->author }}</p>
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
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
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Amount -->
                                <div class="flex flex-col items-end space-y-3">
                                    <!-- Amount Badge -->
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-[#DC2626]">
                                            Rp {{ number_format($loan->fine, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-[#3A2E2A]/70 mt-1">Jumlah Denda</p>
                                    </div>

                                    <!-- Status Badge -->
                                    @if($loan->returned_at)
                                        <span class="status-paid px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="status-unpaid px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-clock mr-1"></i> Belum Bayar
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Additional Info -->
                            @if(!$loan->returned_at && now()->gt($loan->due_at))
                            <div class="mt-4 p-3 bg-[#FEE2E2] border border-[#FECACA] rounded-lg">
                                <div class="flex items-center text-[#DC2626]">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span class="font-medium">Terlambat {{ now()->diffInDays($loan->due_at) }} hari - Denda: Rp {{ number_format($loan->fine, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="mt-8 p-6 bg-[#FFE9D6] rounded-xl border border-[#EEC8A3]">
                        <div class="flex flex-col sm:flex-row justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-[#3A2E2A] text-lg">Ringkasan Denda</h4>
                                <p class="text-sm text-[#3A2E2A]/70 mt-1">Total denda belum dibayar</p>
                            </div>
                            <div class="text-center sm:text-right mt-4 sm:mt-0">
                                <p class="text-3xl font-bold text-[#DC2626]">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                                <p class="text-sm text-[#3A2E2A]/70">{{ $loansWithFines->where('returned_at', null)->count() }} denda aktif</p>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-[#D1FAE5] rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check-circle text-[#10B981] text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-[#3A2E2A] mb-3">Tidak Ada Denda</h3>
                        <p class="text-[#3A2E2A]/70 mb-8 max-w-md mx-auto">
                            Selamat! Anda tidak memiliki denda tertunggak. Terus pertahankan ketepatan waktu dalam pengembalian buku.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('mahasiswa.books.index') }}" 
                               class="inline-flex items-center btn-primary text-white px-8 py-3 rounded-xl hover:opacity-90 transition transform hover:scale-105 shadow-md">
                                <i class="fas fa-book mr-2"></i> Pinjam Buku
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

        <!-- Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-[#E0F2FE] border border-[#BAE6FD] rounded-xl p-6">
                <h3 class="font-semibold text-[#0369A1] mb-3 flex items-center">
                    <div class="bg-[#0369A1] text-white p-2 rounded-lg mr-3">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    Informasi Denda
                </h3>
                <ul class="text-sm text-[#0369A1] space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-chevron-right text-xs mt-1 mr-2"></i>
                        Denda keterlambatan: Rp 2.000 per hari
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

            <div class="bg-[#FFE9D6] border border-[#EEC8A3] rounded-xl p-6">
                <h3 class="font-semibold text-[#3A2E2A] mb-3 flex items-center">
                    <div class="bg-[#D24C49] text-white p-2 rounded-lg mr-3">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    Butuh Bantuan?
                </h3>
                <p class="text-sm text-[#3A2E2A] mb-4">
                    Hubungi admin perpustakaan untuk informasi lebih lanjut tentang denda.
                </p>
                <div class="flex items-center text-[#3A2E2A]">
                    <div class="bg-[#FAF4EF] p-2 rounded-lg mr-2">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <span class="text-sm font-medium">admin@ncliterasi.com</span>
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
                    <a href="{{ route('mahasiswa.dashboard') }}" class="text-[#EEC8A3] hover:text-white transition flex items-center text-sm">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('mahasiswa.loans.history') }}" class="text-[#EEC8A3] hover:text-white transition flex items-center text-sm">
                        <i class="fas fa-history mr-1"></i> Riwayat
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