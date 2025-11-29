<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <nav class="bg-white shadow-lg border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Profile Saya</h1>
                        <p class="text-sm text-gray-600">Kelola informasi akun Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="text-center mb-8">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
                <span class="inline-block mt-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Mahasiswa
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Nama Lengkap</span>
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Email</span>
                            <span class="font-medium">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Role</span>
                            <span class="font-medium capitalize">{{ $user->role }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Bergabung</span>
                            <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Total Pinjaman</span>
                            <span class="font-medium">{{ $totalLoans }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Sedang Dipinjam</span>
                            <span class="font-medium">{{ $activeLoans }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Denda Aktif</span>
                            <span class="font-medium text-red-600">Rp {{ number_format($totalFines, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Rating</span>
                            <span class="font-medium text-yellow-600">
                                <i class="fas fa-star"></i> 4.8/5.0
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('mahasiswa.books.index') }}" class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 transition text-center">
                        <i class="fas fa-book mb-2"></i>
                        <p>Pinjam Buku</p>
                    </a>
                    <a href="{{ route('mahasiswa.loans.history') }}" class="bg-green-600 text-white p-4 rounded-lg hover:bg-green-700 transition text-center">
                        <i class="fas fa-history mb-2"></i>
                        <p>Riwayat</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>