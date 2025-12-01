<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru - N-CLiterASi</title>
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
    </style>
</head>
<body class="bg-[#FAF4EF]">

    <!-- Navigation Header -->
    <nav class="nav-gradient shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.books.index') }}" class="flex items-center space-x-3 text-[#EEC8A3] hover:text-white transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                        <i class="fas fa-book-plus text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Tambah Buku Baru</h1>
                        <p class="text-sm text-[#EEC8A3]">Lengkapi form untuk menambahkan buku baru</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white">{{ Auth::user()->name }}</span>
                    <div class="w-10 h-10 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center text-lg font-bold shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded-xl shadow-lg card-border overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] px-6 py-4">
                <div class="flex items-center">
                    <div class="bg-[#D24C49] p-3 rounded-xl shadow-md mr-4">
                        <i class="fas fa-book-plus text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Informasi Buku</h2>
                        <p class="text-[#EEC8A3] text-sm">Lengkapi semua field yang diperlukan</p>
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
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Judul Buku
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   placeholder="Masukkan judul buku"
                                   required>
                            @error('title')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penulis -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Penulis
                            </label>
                            <input type="text" name="author" value="{{ old('author') }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   placeholder="Nama penulis"
                                   required>
                            @error('author')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ISBN -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> ISBN
                            </label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   placeholder="Contoh: 978-3-16-148410-0"
                                   required>
                            @error('isbn')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penerbit -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Penerbit
                            </label>
                            <input type="text" name="publisher" value="{{ old('publisher') }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   placeholder="Nama penerbit"
                                   required>
                            @error('publisher')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun Terbit -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Tahun Terbit
                            </label>
                            <input type="number" name="year" value="{{ old('year') }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   min="1900" max="{{ date('Y') }}" 
                                   placeholder="{{ date('Y') }}"
                                   required>
                            @error('year')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Kategori
                            </label>
                            <select name="category" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition" required>
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
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Stok Buku
                            </label>
                            <input type="number" name="stock" value="{{ old('stock') }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   min="0" 
                                   placeholder="0"
                                   required>
                            @error('stock')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Maksimal Hari Peminjaman -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Maksimal Hari Peminjaman
                            </label>
                            <input type="number" name="max_loan_days" value="{{ old('max_loan_days', 7) }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   min="1" 
                                   placeholder="7"
                                   required>
                            @error('max_loan_days')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Denda per Hari -->
                        <div>
                            <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                                <span class="text-[#D24C49]">*</span> Denda per Hari (Rp)
                            </label>
                            <input type="number" name="daily_fine" value="{{ old('daily_fine', 2000) }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                   min="0" 
                                   placeholder="2000"
                                   required>
                            @error('daily_fine')
                                <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Deskripsi (Full Width) -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-[#3A2E2A] mb-2">
                        Deskripsi Buku
                    </label>
                    <textarea name="description" rows="4" 
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                              placeholder="Tulis deskripsi singkat tentang buku ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informasi -->
                <div class="mt-6 p-4 bg-[#FFE9D6] rounded-xl border border-[#EEC8A3]">
                    <div class="flex items-start">
                        <div class="bg-[#D24C49] p-2 rounded-lg mr-3">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-[#3A2E2A]">
                                <span class="font-medium">Informasi:</span> Field dengan tanda <span class="text-[#D24C49] font-bold">*</span> wajib diisi.
                                Pastikan data yang dimasukkan sudah benar sebelum menyimpan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.books.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-[#3A2E2A] rounded-xl hover:bg-[#FAF4EF] transition font-medium flex items-center shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 btn-primary text-white rounded-xl hover:opacity-90 transition font-medium flex items-center shadow-md transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i> Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>