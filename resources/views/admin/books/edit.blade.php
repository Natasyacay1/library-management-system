<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - N-CLiterASi</title>
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
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Edit Buku</h1>
                        <p class="text-sm text-[#EEC8A3]">Update informasi buku</p>
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
        <div class="bg-white rounded-xl shadow-lg card-border p-6">
            <!-- Current Book Info -->
            <div class="flex items-center space-x-4 p-4 bg-[#FFE9D6] rounded-lg mb-6 border border-[#EEC8A3]">
                <div class="w-16 h-20 bg-gradient-to-br from-[#FFE9D6] to-[#EEC8A3] rounded-lg flex items-center justify-center text-[#D24C49] text-xl shadow-sm">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <p class="font-semibold text-[#3A2E2A]">{{ $book->title }}</p>
                    <p class="text-sm text-[#3A2E2A]/80">by {{ $book->author }}</p>
                    <p class="text-xs text-[#3A2E2A]/60">ISBN: {{ $book->isbn }}</p>
                </div>
            </div>

            <form action="{{ route('admin.books.update', $book) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Book Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Judul Buku
                        </label>
                        <input type="text" name="title" id="title" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('title', $book->title) }}"
                               placeholder="Masukkan judul buku">
                        @error('title')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div class="md:col-span-2">
                        <label for="author" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Penulis
                        </label>
                        <input type="text" name="author" id="author" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('author', $book->author) }}"
                               placeholder="Nama penulis">
                        @error('author')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> ISBN
                        </label>
                        <input type="text" name="isbn" id="isbn" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('isbn', $book->isbn) }}"
                               placeholder="Contoh: 978-3-16-148410-0">
                        @error('isbn')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher -->
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Penerbit
                        </label>
                        <input type="text" name="publisher" id="publisher" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('publisher', $book->publisher) }}"
                               placeholder="Nama penerbit">
                        @error('publisher')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published Year -->
                    <div>
                        <label for="published_year" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Tahun Terbit
                        </label>
                        <input type="number" name="published_year" id="published_year" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('published_year', $book->published_year) }}"
                               min="1900" max="{{ date('Y') }}"
                               placeholder="{{ date('Y') }}">
                        @error('published_year')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Stok
                        </label>
                        <input type="number" name="stock" id="stock" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('stock', $book->stock) }}"
                               min="0"
                               placeholder="0">
                        @error('stock')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Kategori
                        </label>
                        <select name="category" id="category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition">
                            <option value="">Pilih Kategori</option>
                            <option value="Teknologi" {{ old('category', $book->category) == 'Teknologi' ? 'selected' : '' }}>📱 Teknologi</option>
                            <option value="Fiksi" {{ old('category', $book->category) == 'Fiksi' ? 'selected' : '' }}>📚 Fiksi</option>
                            <option value="Sains" {{ old('category', $book->category) == 'Sains' ? 'selected' : '' }}>🔬 Sains</option>
                            <option value="Sejarah" {{ old('category', $book->category) == 'Sejarah' ? 'selected' : '' }}>🏛️ Sejarah</option>
                            <option value="Bisnis" {{ old('category', $book->category) == 'Bisnis' ? 'selected' : '' }}>💼 Bisnis</option>
                            <option value="Pendidikan" {{ old('category', $book->category) == 'Pendidikan' ? 'selected' : '' }}>🎓 Pendidikan</option>
                            <option value="Seni" {{ old('category', $book->category) == 'Seni' ? 'selected' : '' }}>🎨 Seni</option>
                        </select>
                        @error('category')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Loan Days -->
                    <div>
                        <label for="max_loan_days" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Maks. Hari Peminjaman
                        </label>
                        <input type="number" name="max_loan_days" id="max_loan_days" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('max_loan_days', $book->max_loan_days ?? 7) }}"
                               min="1"
                               placeholder="7">
                        @error('max_loan_days')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Daily Fine -->
                    <div>
                        <label for="daily_fine" class="block text-sm font-medium text-[#3A2E2A] mb-2">
                            <span class="text-[#D24C49]">*</span> Denda per Hari (Rp)
                        </label>
                        <input type="number" name="daily_fine" id="daily_fine" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                               value="{{ old('daily_fine', $book->daily_fine ?? 2000) }}"
                               min="0"
                               placeholder="2000">
                        @error('daily_fine')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-[#3A2E2A] mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49] focus:border-transparent transition"
                                  placeholder="Tulis deskripsi buku...">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <p class="text-[#D24C49] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Information Box -->
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

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.books.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-[#3A2E2A] rounded-xl hover:bg-[#FAF4EF] transition font-medium flex items-center shadow-sm">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 btn-primary text-white rounded-xl hover:opacity-90 transition font-medium flex items-center shadow-md transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>Update Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>