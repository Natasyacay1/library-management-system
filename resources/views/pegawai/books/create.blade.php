<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Perpustakaan Digital</title>
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
    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Buku Baru</h2>
                    <p class="text-gray-600">Tambahkan buku baru ke koleksi perpustakaan</p>
                </div>
                <a href="{{ route('pegawai.books.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <div>
                            <h4 class="text-red-800 font-semibold">Terjadi Kesalahan</h4>
                            <ul class="text-red-700 text-sm mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('pegawai.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Judul Buku -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Judul Buku <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Masukkan judul buku">
                        </div>

                        <!-- Penulis -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">
                                Penulis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="author" 
                                   name="author" 
                                   value="{{ old('author') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Nama penulis">
                        </div>

                        <!-- ISBN -->
                        <div>
                            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">
                                ISBN <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="{{ old('isbn') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Nomor ISBN">
                        </div>

                        <!-- Penerbit -->
                        <div>
                            <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">
                                Penerbit <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="publisher" 
                                   name="publisher" 
                                   value="{{ old('publisher') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Nama penerbit">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- Tahun Terbit -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">
                                Tahun Terbit <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="year" 
                                   name="year" 
                                   value="{{ old('year') }}"
                                   min="1900" 
                                   max="{{ date('Y') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Tahun terbit">
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                                Jumlah Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', 1) }}"
                                   min="1"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Jumlah stok">
                        </div>

                        <!-- Cover Buku -->
                        <div>
                            <label for="cover" class="block text-sm font-medium text-gray-700 mb-1">
                                Cover Buku
                            </label>
                            <input type="file" 
                                   id="cover" 
                                   name="cover"
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Buku
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Deskripsi singkat tentang buku">{{ old('description') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('pegawai.books.index') }}" 
                       class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition font-medium">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-500 text-sm">
            &copy; 2025 Perpustakaan Digital. All rights reserved.
        </div>
    </footer>
</body>
</html>