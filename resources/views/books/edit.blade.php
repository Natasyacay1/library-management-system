<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Edit Buku
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 shadow rounded">

            <form action="{{ route(auth()->user()->isAdmin() ? 'admin.books.update' : 'pegawai.books.update', $book->id) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="font-semibold">Judul Buku</label>
                    <input name="title" value="{{ $book->title }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Penulis</label>
                    <input name="author" value="{{ $book->author }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Penerbit</label>
                    <input name="publisher" value="{{ $book->publisher }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Tahun</label>
                    <input type="number" name="year" value="{{ $book->year }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Kategori</label>
                    <input name="category" value="{{ $book->category }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Stok</label>
                    <input type="number" name="stock" value="{{ $book->stock }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Max Hari Pinjam</label>
                    <input type="number" name="max_loan_days" value="{{ $book->max_loan_days }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Denda Hari</label>
                    <input type="number" name="daily_fine" value="{{ $book->daily_fine }}" class="w-full border rounded p-2">
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Update Buku
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
