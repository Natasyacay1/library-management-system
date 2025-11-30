<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Denda - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-full">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-book-reader mr-2"></i>Perpustakaan Digital
                </h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Kelola Denda</h2>
                <p class="text-gray-600">Kelola peminjaman yang terlambat dan denda</p>
            </div>
            <a href="{{ route('pegawai.dashboard') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if($overdueLoans->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-red-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Peminjaman Terlambat
                        </h3>
                        <div class="text-sm text-red-600 font-semibold">
                            Total: {{ $overdueLoans->count() }} peminjaman terlambat
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Peminjam
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Buku
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jatuh Tempo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterlambatan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Perkiraan Denda
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($overdueLoans as $loan)
                                @php
                                    $daysOverdue = Carbon\Carbon::now()->diffInDays($loan->due_at);
                                    $fineAmount = $daysOverdue * 5000; // Rp 5,000 per hari
                                @endphp
                                <tr class="hover:bg-red-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $loan->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $loan->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $loan->book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $loan->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $loan->due_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $loan->due_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                            {{ $daysOverdue }} hari
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-red-600">
                                            Rp {{ number_format($fineAmount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('pegawai.loans.return', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900 mr-3"
                                                    onclick="return confirm('Tandai buku sudah dikembalikan?')">
                                                <i class="fas fa-check-circle mr-1"></i>Kembalikan
                                            </button>
                                        </form>
                                        <a href="#" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-edit mr-1"></i>Update
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-red-500 text-2xl mr-3"></i>
                        <div>
                            <p class="text-sm text-red-600">Total Keterlambatan</p>
                            <p class="text-xl font-bold text-red-800">{{ $overdueLoans->count() }} Peminjaman</p>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-money-bill-wave text-yellow-500 text-2xl mr-3"></i>
                        <div>
                            <p class="text-sm text-yellow-600">Total Denda</p>
                            <p class="text-xl font-bold text-yellow-800">
                                Rp {{ number_format($overdueLoans->sum(function($loan) {
                                    return Carbon\Carbon::now()->diffInDays($loan->due_at) * 5000;
                                }), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-users text-blue-500 text-2xl mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-600">Peminjam Terlambat</p>
                            <p class="text-xl font-bold text-blue-800">
                                {{ $overdueLoans->unique('user_id')->count() }} Orang
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Denda</h3>
                <p class="text-gray-600 mb-4">Semua peminjaman tepat waktu atau sudah dikembalikan</p>
                <a href="{{ route('pegawai.dashboard') }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-500 text-sm">
            &copy; 2024 Perpustakaan Digital. All rights reserved.
        </div>
    </footer>
</body>
</html>