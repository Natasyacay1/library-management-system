@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-md shadow">
        <h1 class="text-2xl font-semibold mb-2">{{ $book->title }}</h1>
        <p class="text-sm text-slate-500 mb-4">
            {{ $book->author }} • {{ $book->year }} • {{ $book->category }}
        </p>
        <p class="text-sm mb-2">Penerbit: {{ $book->publisher }}</p>
        <p class="text-sm mb-2">Stok tersedia: {{ $book->stock }}</p>
        <p class="text-sm mb-2">Maks. hari pinjam: {{ $book->max_loan_days }}</p>
        <p class="text-sm">Denda per hari: Rp {{ number_format($book->daily_fine, 0, ',', '.') }}</p>
    </div>
@endsection
