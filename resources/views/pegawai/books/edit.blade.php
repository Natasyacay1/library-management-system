<!DOCTYPE html>
<html lang="id" class="h-full">
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
            border-radius: 16px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(210, 76, 73, 0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #3A2E2A 0%, #2B211E 100%);
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(58, 46, 42, 0.3);
        }
        .input-focus:focus {
            border-color: #D24C49 !important;
            box-shadow: 0 0 0 3px rgba(210, 76, 73, 0.2) !important;
        }
        .file-upload {
            background: linear-gradient(135deg, #FFE9D6 0%, #FAF4EF 100%);
            border: 2px dashed #EEC8A3;
        }
        .file-upload:hover {
            background: linear-gradient(135deg, #FAF4EF 0%, #FFE9D6 100%);
            border-color: #D24C49;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        .required-star {
            color: #D24C49;
            margin-left: 2px;
        }
        .book-cover-preview {
            box-shadow: 0 10px 25px rgba(58, 46, 42, 0.15);
            border: 3px solid #EEC8A3;
        }
    </style>
</head>
<body class="bg-[#FAF4EF] min-h-full">

    <!-- Header/Navigation -->
    <header class="nav-gradient shadow-xl">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">N-CLiterASi</h1>
                        <p class="text-[#EEC8A3] text-sm">Edit Data Buku</p>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:block text-right">
                        <p class="font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[#EEC8A3] text-sm">Pegawai Perpustakaan</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" 
                                class="bg-white/20 text-white px-4 py-2 rounded-lg hover:bg-white/30 transition flex items-center shadow-md">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8 animate-fadeIn">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-[#3A2E2A]/70 mb-6">
            <a href="{{ route('pegawai.dashboard') }}" class="hover:text-[#D24C49] transition">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
            <i class="fas fa-chevron-right mx-2"></i>
            <a href="{{ route('pegawai.books.index') }}" class="hover:text-[#D24C49] transition">
                Kelola Buku
            </a>
            <i class="fas fa-chevron-right mx-2"></i>
            <span class="text-[#D24C49] font-medium">Edit Buku</span>
        </div>

        <!-- Book Info Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 card-border">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Book Cover -->
                <div class="relative">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" 
                             alt="{{ $book->title }}" 
                             class="w-48 h-64 object-cover rounded-xl book-cover-preview">
                    @else
                        <div class="w-48 h-64 bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] rounded-xl flex items-center justify-center border-2 border-[#EEC8A3]">
                            <i class="fas fa-book text-[#3A2E2A]/40 text-5xl"></i>
                        </div>
                    @endif
                    <div class="absolute -bottom-3 -right-3 bg-[#3A2E2A] text-white px-3 py-1 rounded-full text-sm font-medium">
                        ID: {{ $book->id }}
                    </div>
                </div>
                
                <!-- Book Info -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-[#3A2E2A] mb-2">{{ $book->title }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-[#3A2E2A]/70">Penulis</p>
                            <p class="font-medium text-[#3A2E2A]">{{ $book->author }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-[#3A2E2A]/70">ISBN</p>
                            <code class="font-mono text-[#3A2E2A]">{{ $book->isbn }}</code>
                        </div>
                        <div>
                            <p class="text-sm text-[#3A2E2A]/70">Penerbit</p>
                            <p class="font-medium text-[#3A2E2A]">{{ $book->publisher }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-[#3A2E2A]/70">Tahun</p>
                            <p class="font-medium text-[#3A2E2A]">{{ $book->year }}</p>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex flex-wrap gap-3 mt-4">
                        <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] px-4 py-2 rounded-lg border border-[#EEC8A3]">
                            <p class="text-xs text-[#3A2E2A]/70">Stok Tersedia</p>
                            <p class="text-xl font-bold {{ $book->stock > 0 ? 'text-[#10B981]' : 'text-[#DC2626]' }}">
                                {{ $book->stock }} buku
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] px-4 py-2 rounded-lg border border-[#EEC8A3]">
                            <p class="text-xs text-[#3A2E2A]/70">Total Views</p>
                            <p class="text-xl font-bold text-[#3A2E2A]">{{ number_format($book->views ?? 0) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF4EF] px-4 py-2 rounded-lg border border-[#EEC8A3]">
                            <p class="text-xs text-[#3A2E2A]/70">Tanggal Ditambah</p>
                            <p class="text-sm font-medium text-[#3A2E2A]">{{ $book->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-border">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-[#F59E0B] p-3 rounded-xl mr-4">
                            <i class="fas fa-edit text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Edit Data Buku</h2>
                            <p class="text-[#EEC8A3]">Perbarui informasi buku yang ada di koleksi perpustakaan</p>
                        </div>
                    </div>
                    <a href="{{ route('pegawai.books.index') }}" 
                       class="btn-secondary text-white px-5 py-2.5 rounded-lg flex items-center shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-[#D24C49] m-6 rounded-lg p-4 animate-fadeIn">
                    <div class="flex items-center">
                        <div class="bg-[#D24C49] text-white p-2 rounded-lg mr-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-[#3A2E2A] font-semibold">Periksa kembali data yang dimasukkan</h4>
                            <ul class="text-[#3A2E2A]/80 text-sm mt-1 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center">
                                        <i class="fas fa-circle text-[#D24C49] text-xs mr-2"></i>{{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-[#10B981] m-6 rounded-lg p-4 animate-fadeIn">
                    <div class="flex items-center">
                        <div class="bg-[#10B981] text-white p-2 rounded-lg mr-3">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p class="text-[#3A2E2A] font-semibold">{{ session('success') }}</p>
                            <p class="text-[#3A2E2A]/70 text-sm mt-1">Data buku berhasil diperbarui</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Content -->
            <div class="p-6">
                <form action="{{ route('pegawai.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Two Columns Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Judul Buku -->
                            <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-4 rounded-xl border border-[#EEC8A3]">
                                <label for="title" class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                    <div class="bg-[#D24C49] text-white p-1 rounded mr-2">
                                        <i class="fas fa-heading text-xs"></i>
                                    </div>
                                    Judul Buku <span class="required-star">*</span>
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $book->title) }}"
                                       required
                                       class="input-focus w-full px-4 py-3 bg-white/50 border border-[#EEC8A3] rounded-lg focus:outline-none text-[#3A2E2A] placeholder-[#3A2E2A]/50"
                                       placeholder="Masukkan judul buku lengkap">
                            </div>

                            <!-- Penulis -->
                            <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-4 rounded-xl border border-[#EEC8A3]">
                                <label for="author" class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                    <div class="bg-[#3A2E2A] text-white p-1 rounded mr-2">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    Penulis <span class="required-star">*</span>
                                </label>
                                <input type="text" 
                                       id="author" 
                                       name="author" 
                                       value="{{ old('author', $book->author) }}"
                                       required
                                       class="input-focus w-full px-4 py-3 bg-white/50 border border-[#EEC8A3] rounded-lg focus:outline-none text-[#3A2E2A] placeholder-[#3A2E2A]/50"
                                       placeholder="Nama lengkap penulis">
                            </div>

                            <!-- ISBN -->
                            <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-4 rounded-xl border border-[#EEC8A3]">
                                <label for="isbn" class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                    <div class="bg-[#10B981] text-white p-1 rounded mr-2">
                                        <i class="fas fa-barcode text-xs"></i>
                                    </div>
                                    ISBN <span class="required-star">*</span>
                                </label>
                                <input type="text" 
                                       id="isbn" 
                                       name="isbn" 
                                       value="{{ old('isbn', $book->isbn) }}"
                                       required
                                       class="input-focus w-full px-4 py-3 bg-white/50 border border-[#EEC8A3] rounded-lg focus:outline-none text-[#3A2E2A] placeholder-[#3A2E2A]/50"
                                       placeholder="Contoh: 978-3-16-148410-0">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Penerbit -->
                            <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-4 rounded-xl border border-[#EEC8A3]">
                                <label for="publisher" class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                    <div class="bg-[#F59E0B] text-white p-1 rounded mr-2">
                                        <i class="fas fa-building text-xs"></i>
                                    </div>
                                    Penerbit <span class="required-star">*</span>
                                </label>
                                <input type="text" 
                                       id="publisher" 
                                       name="publisher" 
                                       value="{{ old('publisher', $book->publisher) }}"
                                       required
                                       class="input-focus w-full px-4 py-3 bg-white/50 border border-[#EEC8A3] rounded-lg focus:outline-none text-[#3A2E2A] placeholder-[#3A2E2A]/50"
                                       placeholder="Nama perusahaan penerbit">
                            </div>

                            <!-- Tahun Terbit -->
                            <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-4 rounded-xl border border-[#EEC8A3]">
                                <label for="year" class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                    <div class="bg-[#3B82F6] text-white p-1 rounded mr-2">
                                        <i class="fas fa-calendar text-xs"></i>
                                    </div>
                                    Tahun Terbit <span class="required-star">*</span>
                                </label>
                                <input type="number" 
                                       id="year" 
                                       name="year" 
                                       value="{{ old('year', $book->year) }}"
                                       min="1900" 
                                       max="{{ date('Y') }}"
                                       required
                                       class="input-focus w-full px-4 py-3 bg-white/50 border border-[#EEC8A3] rounded-lg focus:outline-none text-[#3A2E2A] placeholder-[#3A2E2A]/50"
                                       placeholder="Tahun terbit">
                            </div>

                            <!-- Stok -->
                            <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-4 rounded-xl border border-[#EEC8A3]">
                                <label for="stock" class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                    <div class="bg-[#8B5CF6] text-white p-1 rounded mr-2">
                                        <i class="fas fa-boxes text-xs"></i>
                                    </div>
                                    Jumlah Stok <span class="required-star">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="stock" 
                                           name="stock" 
                                           value="{{ old('stock', $book->stock) }}"
                                           min="0"
                                           required
                                           class="input-focus w-full px-4 py-3 bg-white/50 border border-[#EEC8A3] rounded-lg focus:outline-none text-[#3A2E2A] placeholder-[#3A2E2A]/50"
                                           placeholder="Jumlah buku tersedia">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Buku -->
                    <div class="mt-8">
                        <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-6 rounded-xl border border-[#EEC8A3]">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                        <div class="bg-[#EC4899] text-white p-1 rounded mr-2">
                                            <i class="fas fa-image text-xs"></i>
                                        </div>
                                        Cover Buku
                                    </label>
                                    <p class="text-[#3A2E2A]/70 text-sm">Unggah gambar cover baru (opsional) atau biarkan kosong untuk mempertahankan cover saat ini</p>
                                    <p class="text-[#3A2E2A]/50 text-xs mt-1">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                                    
                                    @if($book->cover)
                                        <div class="mt-3">
                                            <p class="text-sm font-medium text-[#3A2E2A]">Cover saat ini:</p>
                                            <div class="flex items-center space-x-3 mt-2">
                                                <img src="{{ asset('storage/' . $book->cover) }}" 
                                                     alt="{{ $book->title }}" 
                                                     class="w-16 h-24 object-cover rounded-lg border border-[#EEC8A3]">
                                                <span class="text-sm text-[#3A2E2A]/70">Cover buku saat ini</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="file-upload rounded-xl p-4 text-center cursor-pointer transition-all hover:border-[#D24C49]">
                                    <input type="file" 
                                           id="cover" 
                                           name="cover"
                                           accept="image/jpeg,image/png,image/jpg,image/gif"
                                           class="hidden"
                                           onchange="previewImage(event)">
                                    <label for="cover" class="cursor-pointer">
                                        <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mx-auto mb-2 border border-[#EEC8A3]">
                                            <i class="fas fa-cloud-upload-alt text-[#3A2E2A]/50 text-2xl"></i>
                                        </div>
                                        <span class="text-[#3A2E2A] font-medium">Unggah File Baru</span>
                                        <p class="text-[#3A2E2A]/50 text-xs mt-1">Klik untuk memilih</p>
                                    </label>
                                </div>
                            </div>
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <p class="text-sm font-medium text-[#3A2E2A] mb-2">Pratinjau Cover Baru:</p>
                                <div class="w-32 h-48 border-2 border-[#EEC8A3] rounded-lg overflow-hidden bg-white">
                                    <img id="preview" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-8">
                        <div class="bg-gradient-to-br from-[#FAF4EF] to-[#FFE9D6] p-6 rounded-xl border border-[#EEC8A3]">
                            <label for="description" class="block text-sm font-semibold text-[#3A2E2A] mb-2 flex items-center">
                                <div class="bg-[#06B6D4] text-white p-1 rounded mr-2">
                                    <i class="fas fa-align-left text-xs"></i>
                                </div>
                                Deskripsi Buku
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="6"
                                      class="input-focus w-full px-4 py-3 bg-white/50 border border-[#EEC8A3] rounded-lg focus:outline-none text-[#3A2E2A] placeholder-[#3A2E2A]/50 resize-none"
                                      placeholder="Deskripsi singkat tentang isi buku, sinopsis, atau informasi penting lainnya...">{{ old('description', $book->description) }}</textarea>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-[#3A2E2A]/50 text-xs">Berikan deskripsi yang informatif</p>
                                <p id="charCount" class="text-[#3A2E2A]/50 text-xs">0/1000 karakter</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 pt-6 border-t border-[#EEC8A3] flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-[#3A2E2A]/70 text-sm">
                            <i class="fas fa-info-circle mr-1 text-[#D24C49]"></i>
                            Pastikan semua data yang dimasukkan sudah benar sebelum menyimpan
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('pegawai.books.index') }}" 
                               class="btn-secondary text-white px-8 py-3 rounded-lg flex items-center font-semibold">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" 
                                    class="btn-primary text-white px-8 py-3 rounded-lg flex items-center font-semibold">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="mt-8 bg-gradient-to-r from-red-50 to-red-100 rounded-2xl shadow-xl overflow-hidden card-border border-red-200">
            <div class="bg-gradient-to-r from-[#DC2626] to-[#B91C1C] p-6">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-lg mr-4">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Zona Berbahaya</h2>
                        <p class="text-red-100">Hati-hati dengan aksi ini, tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-[#3A2E2A] mb-1">Hapus Buku</h3>
                        <p class="text-[#3A2E2A]/70 text-sm">
                            Setelah dihapus, semua data buku termasuk riwayat peminjaman akan hilang permanen.
                        </p>
                    </div>
                    <form action="{{ route('pegawai.books.destroy', $book->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirmDelete()"
                                class="bg-gradient-to-r from-[#DC2626] to-[#B91C1C] text-white px-6 py-3 rounded-lg hover:opacity-90 transition flex items-center font-semibold">
                            <i class="fas fa-trash mr-2"></i>Hapus Buku
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#3A2E2A] border-t border-[#2B211E] mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 text-[#EEC8A3]">
                    <i class="fas fa-book"></i>
                    <span class="text-sm">N-CLiterASi © 2025</span>
                </div>
                <div class="text-[#EEC8A3] text-sm mt-2 md:mt-0">
                    Semua hak dilindungi undang-undang
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Image Preview Function
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            
            reader.onload = function(){
                preview.src = reader.result;
                previewContainer.classList.remove('hidden');
            }
            
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // Character Counter for Description
        const textarea = document.getElementById('description');
        const charCount = document.getElementById('charCount');
        
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = `${length}/1000 karakter`;
            
            if (length > 1000) {
                charCount.classList.add('text-[#D24C49]');
            } else {
                charCount.classList.remove('text-[#D24C49]');
            }
        });

        // Initialize character count
        charCount.textContent = `${textarea.value.length}/1000 karakter`;

        // Form validation on submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-[#D24C49]');
                } else {
                    field.classList.remove('border-[#D24C49]');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        });

        // Year input max validation
        const yearInput = document.getElementById('year');
        yearInput.addEventListener('change', function() {
            const currentYear = new Date().getFullYear();
            if (this.value > currentYear) {
                this.value = currentYear;
                alert(`Tahun tidak boleh melebihi ${currentYear}`);
            }
        });

        // Confirm delete
        function confirmDelete() {
            const bookTitle = "{{ $book->title }}";
            return confirm(`Apakah Anda yakin ingin menghapus buku "${bookTitle}"?\n\nAksi ini tidak dapat dibatalkan dan semua data terkait buku ini akan hilang permanen.`);
        }

        // Stock validation
        const stockInput = document.getElementById('stock');
        stockInput.addEventListener('change', function() {
            if (this.value < 0) {
                this.value = 0;
                alert('Stok tidak boleh kurang dari 0');
            }
        });

        // ISBN format hint
        const isbnInput = document.getElementById('isbn');
        isbnInput.addEventListener('focus', function() {
            const hint = document.createElement('div');
            hint.className = 'text-xs text-[#3A2E2A]/60 mt-1';
            hint.textContent = 'Format: 978-3-16-148410-0 atau 9783161484100';
            
            if (!this.parentNode.querySelector('.isbn-hint')) {
                hint.classList.add('isbn-hint');
                this.parentNode.appendChild(hint);
            }
        });

        isbnInput.addEventListener('blur', function() {
            const hint = this.parentNode.querySelector('.isbn-hint');
            if (hint) {
                hint.remove();
            }
        });
    </script>
</body>
</html>