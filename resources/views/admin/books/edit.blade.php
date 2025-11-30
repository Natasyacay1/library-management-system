<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <nav class="bg-white shadow-lg border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.books.index') }}" class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Edit Buku</h1>
                        <p class="text-sm text-gray-600">Update data buku</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <form action="{{ route('admin.books.update', $book) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Current Book Info -->
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg mb-6">
                    <div class="w-16 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center text-blue-600 text-xl">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $book->title }}</p>
                        <p class="text-sm text-gray-600">by {{ $book->author }}</p>
                        <p class="text-xs text-gray-500">ISBN: {{ $book->isbn }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Book Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Buku *</label>
                        <input type="text" name="title" id="title" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                               value="{{ old('title', $book->title) }}">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div class="md:col-span-2">
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Penulis *</label>
                        <input type="text" name="author" id="author" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                               value="{{ old('author', $book->author) }}">
                        @error('author')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">ISBN *</label>
                        <input type="text" name="isbn" id="isbn" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                               value="{{ old('isbn', $book->isbn) }}">
                        @error('isbn')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher -->
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2">Penerbit *</label>
                        <input type="text" name="publisher" id="publisher" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                               value="{{ old('publisher', $book->publisher) }}">
                        @error('publisher')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published Year -->
                    <div>
                        <label for="published_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun Terbit *</label>
                        <input type="number" name="published_year" id="published_year" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                               value="{{ old('published_year', $book->published_year) }}"
                               min="1900" max="{{ date('Y') }}">
                        @error('published_year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok *</label>
                        <input type="number" name="stock" id="stock" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                               value="{{ old('stock', $book->stock) }}"
                               min="0">
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                    <a href="{{ route('admin.books.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                        <i class="fas fa-save mr-2"></i>Update Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>