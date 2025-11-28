@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Manajemen Buku</h1>
        <a href="{{ route('admin.books.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">
            + Tambah Buku
        </a>
    </div>

    <div class="bg-white rounded-md shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2 text-left">Penulis</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-center">Stok</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $book->title }}</td>
                        <td class="px-4 py-2">{{ $book->author }}</td>
                        <td class="px-4 py-2">{{ $book->category }}</td>
                        <td class="px-4 py-2 text-center">{{ $book->stock }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <a href="{{ route('admin.books.edit', $book) }}"
                               class="text-blue-600 text-xs">
                                Edit
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 text-xs"
                                        onclick="return confirm('Hapus buku?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-slate-500">
                            Belum ada buku.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
