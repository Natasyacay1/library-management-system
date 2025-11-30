<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Review - Perpustakaan Digital</title>
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
                <h2 class="text-2xl font-bold text-gray-800">Kelola Review</h2>
                <p class="text-gray-600">Kelola ulasan dan rating dari pembaca</p>
            </div>
            <a href="{{ route('pegawai.dashboard') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if($reviews->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Daftar Review</h3>
                        <div class="text-sm text-gray-500">
                            Total: {{ $reviews->total() }} review
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach($reviews as $review)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $review->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $review->book->title }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center space-x-1 mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow-400' : 'gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            @if($review->comment)
                                <div class="bg-gray-50 rounded-lg p-4 mb-3">
                                    <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm italic">Tidak ada komentar</p>
                            @endif

                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                                </button>
                                <button class="text-red-600 hover:text-red-800 text-sm flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reviews->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-comment-slash text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Review</h3>
                <p class="text-gray-600">Belum ada ulasan dari pembaca</p>
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