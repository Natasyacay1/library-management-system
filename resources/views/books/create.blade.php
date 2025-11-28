@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Tambah Buku</h1>

    <form action="{{ route('admin.books.store') }}" method="POST" class="bg-white p-6 rounded-md shadow space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Judul</label>
            <input type="text" name="title" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                   value="{{ old('title') }}" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Penulis</label>
            <input type="text" name="author" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                   value="{{ old('author') }}" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Penerbit</label>
                <input type="text" name="publisher" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('publisher') }}">
            </div>
            <div>
                <label class="block text-sm font-medium">Tahun</label>
                <input type="number" name="year" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('year') }}">
            </div>
            <div>
                <label class="block text-sm font-medium">Kategori</label>
                <input type="text" name="category" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('category') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Stok</label>
                <input type="number" name="stock" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('stock', 0) }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Maks. Hari Pinjam</label>
                <input type="number" name="max_loan_days" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('max_loan_days', 7) }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Denda / hari</label>
                <input type="number" name="daily_fine" class="mt-1 w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('daily_fine', 2000) }}" required>
            </div>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">
            Simpan
        </button>
    </form>
@endsection
