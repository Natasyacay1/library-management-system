<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Peminjaman - Perpustakaan Digital</title>
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
                <h2 class="text-2xl font-bold text-gray-800">Kelola Peminjaman</h2>
                <p class="text-gray-600">Kelola semua peminjaman buku</p>
            </div>
            <a href="{{ route('pegawai.dashboard') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Semua Peminjaman</h3>
                    <div class="text-sm text-gray-500">
                        Total: {{ $loans->total() }} peminjaman
                    </div>
                </div>
            </div>

            @if($loans->count() > 0)
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
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $loan->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $loan->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $loan->book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $loan->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($loan->status === 'pending')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                                Menunggu
                                            </span>
                                        @elseif($loan->status === 'approved')
                                            @if($loan->returned_at)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                                    Dikembalikan
                                                </span>
                                            @elseif($loan->due_at->isPast())
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                                    Terlambat
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                                    Aktif
                                                </span>
                                            @endif
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($loan->approved_at)
                                                {{ $loan->approved_at->format('d M Y') }}
                                            @else
                                                {{ $loan->created_at->format('d M Y') }}
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            @if($loan->due_at && !$loan->returned_at)
                                                Jatuh tempo: {{ $loan->due_at->format('d M Y') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($loan->status === 'pending')
                                            <form action="{{ route('pegawai.loans.approve', $loan->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('pegawai.loans.reject', $loan->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Tolak
                                                </button>
                                            </form>
                                        @elseif($loan->status === 'approved' && !$loan->returned_at)
                                            <form action="{{ route('pegawai.loans.return', $loan->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $loans->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada peminjaman</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-500 text-sm">
            &copy; 2024 Perpustakaan Digital. All rights reserved.
        </div>
    </footer>
</body>
</html>