<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Kelola Buku</h1>
                        <p class="text-sm text-gray-600">Manajemen koleksi buku perpustakaan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-800">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Buku</h2>
                <p class="text-gray-600">Total {{ $books->total() }} buku dalam koleksi</p>
            </div>
            <a href="{{ route('admin.books.create') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Buku Baru
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative max-w-xl">
                        <input type="text" placeholder="Cari judul, penulis, atau ISBN..." 
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                        <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="available">Tersedia</option>
                        <option value="out-of-stock">Habis</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                        <option value="">Urutkan</option>
                        <option value="newest">Terbaru</option>
                        <option value="popular">Populer</option>
                        <option value="title">Judul A-Z</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($books as $book)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center text-blue-600 mr-4">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $book->publisher }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $book->author }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-mono">{{ $book->isbn }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas {{ $book->stock > 0 ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                    {{ $book->stock }} tersedia
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $book->published_year }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.books.edit', $book) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition flex items-center"
                                                onclick="return confirm('Yakin hapus buku ini?')">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $books->links() }}
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $books->total() }}</div>
                <div class="text-gray-600">Total Buku</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-2xl font-bold text-green-600">{{ $books->where('stock', '>', 0)->count() }}</div>
                <div class="text-gray-600">Tersedia</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-2xl font-bold text-red-600">{{ $books->where('stock', 0)->count() }}</div>
                <div class="text-gray-600">Habis</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $books->sum('stock') }}</div>
                <div class="text-gray-600">Total Stok</div>
            </div>
        </div>
    </div>
</body>
</html>