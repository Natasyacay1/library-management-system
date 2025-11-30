@extends('layouts.admin')

@section('title', 'Tambah Buku Baru')
@section('page-title', 'Tambah Buku Baru')
@section('page-description', 'Isi form untuk menambahkan buku baru ke koleksi perpustakaan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center">
                <i class="fas fa-book-plus text-white text-2xl mr-3"></i>
                <div>
                    <h2 class="text-xl font-bold text-white">Tambah Buku Baru</h2>
                    <p class="text-blue-100 text-sm">Lengkapi informasi buku di bawah ini</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.books.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <!-- Judul Buku -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Judul Buku
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Masukkan judul buku"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Penulis
                        </label>
                        <input type="text" name="author" value="{{ old('author') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Nama penulis"
                               required>
                        @error('author')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> ISBN
                        </label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Contoh: 978-3-16-148410-0"
                               required>
                        @error('isbn')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Penerbit
                        </label>
                        <input type="text" name="publisher" value="{{ old('publisher') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Nama penerbit"
                               required>
                        @error('publisher')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Tahun Terbit
                        </label>
                        <input type="number" name="year" value="{{ old('year') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               min="1900" max="{{ date('Y') }}" 
                               placeholder="{{ date('Y') }}"
                               required>
                        @error('year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Kategori
                        </label>
                        <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Teknologi" {{ old('category') == 'Teknologi' ? 'selected' : '' }}>📱 Teknologi</option>
                            <option value="Fiksi" {{ old('category') == 'Fiksi' ? 'selected' : '' }}>📚 Fiksi</option>
                            <option value="Sains" {{ old('category') == 'Sains' ? 'selected' : '' }}>🔬 Sains</option>
                            <option value="Sejarah" {{ old('category') == 'Sejarah' ? 'selected' : '' }}>🏛️ Sejarah</option>
                            <option value="Bisnis" {{ old('category') == 'Bisnis' ? 'selected' : '' }}>💼 Bisnis</option>
                            <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>🎓 Pendidikan</option>
                            <option value="Seni" {{ old('category') == 'Seni' ? 'selected' : '' }}>🎨 Seni</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Stok Buku
                        </label>
                        <input type="number" name="stock" value="{{ old('stock') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               min="0" 
                               placeholder="0"
                               required>
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Maksimal Hari Peminjaman -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Maksimal Hari Peminjaman
                        </label>
                        <input type="number" name="max_loan_days" value="{{ old('max_loan_days', 7) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               min="1" 
                               placeholder="7"
                               required>
                        @error('max_loan_days')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Denda per Hari -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Denda per Hari (Rp)
                        </label>
                        <input type="number" name="daily_fine" value="{{ old('daily_fine', 2000) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               min="0" 
                               placeholder="2000"
                               required>
                        @error('daily_fine')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Deskripsi (Full Width) -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Buku
                </label>
                <textarea name="description" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                          placeholder="Tulis deskripsi singkat tentang buku ini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informasi -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-800">
                            <span class="font-medium">Informasi:</span> Field dengan tanda <span class="text-red-500">*</span> wajib diisi.
                            Pastikan data yang dimasukkan sudah benar sebelum menyimpan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.books.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>
@endsection