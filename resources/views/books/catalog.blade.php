@extends('layouts.guest')

@section('content')
    <section class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Katalog Buku</h2>

        @if($books->count() === 0)
            <p class="text-sm text-slate-500">Belum ada data buku.</p>
        @else
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($books as $book)
                    <a href="{{ route('books.show', $book) }}"
                       class="border rounded-md p-4 hover:shadow-sm bg-slate-50">
                        <h3 class="font-semibold text-slate-900">{{ $book->title }}</h3>
                        <p class="text-xs text-slate-500">
                            {{ $book->author }} • {{ $book->year }}
                        </p>
                        <p class="mt-1 text-xs">
                            Kategori:
                            <span class="font-medium">{{ $book->category }}</span>
                        </p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
