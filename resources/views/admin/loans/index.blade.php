<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman - N-CLiterASi</title>
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
        .status-dikembalikan {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .status-terlambat {
            background-color: #FEE2E2;
            color: #DC2626;
        }
        .status-aktif {
            background-color: #E0F2FE;
            color: #0369A1;
        }
        .status-menunggu {
            background-color: #FEF3C7;
            color: #92400E;
        }
    </style>
</head>
<body class="bg-[#FAF4EF]">

    <!-- Navigation Header -->
    <nav class="nav-gradient shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-[#EEC8A3] hover:text-white transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                        <i class="fas fa-exchange-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Manajemen Peminjaman</h1>
                        <p class="text-sm text-[#EEC8A3]">Kelola semua peminjaman buku</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#D24C49]">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
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
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-lg card-border p-6 text-center">
                <div class="text-3xl font-bold text-[#D24C49] mb-2">{{ $loans->total() }}</div>
                <div class="text-[#3A2E2A] font-medium">Total Peminjaman</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg card-border p-6 text-center">
                <div class="text-3xl font-bold text-[#3A2E2A] mb-2">{{ $loans->where('returned_at', null)->where('due_at', '>=', now())->count() }}</div>
                <div class="text-[#3A2E2A] font-medium">Aktif</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg card-border p-6 text-center">
                <div class="text-3xl font-bold text-[#DC2626] mb-2">{{ $loans->where('returned_at', null)->where('due_at', '<', now())->count() }}</div>
                <div class="text-[#3A2E2A] font-medium">Terlambat</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg card-border p-6 text-center">
                <div class="text-3xl font-bold text-[#10B981] mb-2">{{ $loans->whereNotNull('returned_at')->count() }}</div>
                <div class="text-[#3A2E2A] font-medium">Dikembalikan</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-lg card-border p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative max-w-xl">
                        <input type="text" placeholder="Cari nama peminjam, judul buku..." 
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="overdue">Terlambat</option>
                        <option value="returned">Dikembalikan</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent">
                        <option value="">Urutkan</option>
                        <option value="latest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="due_soon">Jatuh Tempo</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Peminjaman Table -->
        <div class="bg-white rounded-xl shadow-lg card-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#3A2E2A]">
                        <tr>
                            <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">Peminjam</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">Buku</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#EEC8A3]/30">
                        @forelse($loans as $loan)
                        <tr class="hover:bg-[#FAF4EF] transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center text-sm font-bold mr-3">
                                        {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-[#3A2E2A]">{{ $loan->user->name }}</div>
                                        <div class="text-xs text-[#3A2E2A]/70">{{ $loan->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-10 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded flex items-center justify-center text-[#D24C49] mr-3">
                                        <i class="fas fa-book text-xs"></i>
                                    </div>
                                    <div class="text-sm text-[#3A2E2A]">{{ Str::limit($loan->book->title, 30) }}</div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-[#3A2E2A]">{{ $loan->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-[#3A2E2A]/70">{{ $loan->created_at->format('H:i') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-[#3A2E2A]">{{ $loan->due_at->format('d M Y') }}</div>
                                @if($loan->due_at < now() && !$loan->returned_at)
                                    <div class="text-xs text-[#DC2626] font-medium">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Terlambat {{ now()->diffInDays($loan->due_at) }} hari
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($loan->returned_at)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium status-dikembalikan">
                                        <i class="fas fa-check-circle mr-1"></i> Dikembalikan
                                    </span>
                                @elseif($loan->due_at < now())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium status-terlambat">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium status-aktif">
                                        <i class="fas fa-sync-alt mr-1"></i> Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if(!$loan->returned_at)
                                    <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')"
                                                class="btn-success text-white px-4 py-2 rounded-xl hover:opacity-90 transition font-medium flex items-center text-sm">
                                            <i class="fas fa-undo mr-1"></i> Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-sm text-[#10B981] font-medium">
                                        <i class="fas fa-check-circle mr-1"></i> Sudah dikembalikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-[#FFE9D6] p-4 rounded-full mb-3">
                                        <i class="fas fa-exchange-alt text-[#D24C49] text-2xl"></i>
                                    </div>
                                    <p class="text-[#3A2E2A] font-medium mb-1">Tidak ada data peminjaman</p>
                                    <p class="text-sm text-[#3A2E2A]/70">Belum ada peminjaman yang tercatat</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($loans->hasPages())
            <div class="px-6 py-4 border-t bg-[#FAF4EF]">
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
        </div>
    </div>
</body>
</html>