<x-app-layout>
    <div class="max-w-7xl mx-auto py-16 px-6">
        <h1 class="text-4xl font-extrabold text-gray-900">
            Selamat Datang di <span class="text-blue-600">Perpustakaan Digital</span>
        </h1>

        <p class="mt-4 text-lg text-gray-600 max-w-2xl">
            Temukan koleksi buku terbaik, kelola peminjaman, dan dapatkan rekomendasi
            buku yang dipersonalisasi.
        </p>

        <a href="{{ route('books.index') }}"
           class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg 
           hover:bg-blue-700 shadow-md transition">
            📚 Lihat Katalog Buku
        </a>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
                <div class="text-4xl">🔎</div>
                <h3 class="text-xl font-semibold mt-4">Cari Buku</h3>
                <p class="text-gray-600 mt-2">Jelajahi berbagai kategori dan penulis.</p>
            </div>

            <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
                <div class="text-4xl">📖</div>
                <h3 class="text-xl font-semibold mt-4">Pinjam Buku</h3>
                <p class="text-gray-600 mt-2">Mahasiswa dapat meminjam buku secara online.</p>
            </div>

            <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
                <div class="text-4xl">⭐</div>
                <h3 class="text-xl font-semibold mt-4">Review & Rating</h3>
                <p class="text-gray-600 mt-2">Berikan penilaian untuk membantu pengguna lain.</p>
            </div>

        </div>
    </div>
</x-app-layout>
