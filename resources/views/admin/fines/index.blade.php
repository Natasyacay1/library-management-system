@extends('layouts.admin')

@section('title', 'Manajemen Denda')
@section('page-title', 'Manajemen Denda')
@section('page-description', 'Kelola semua denda peminjaman')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Daftar Denda</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm">
                    <th class="py-3 px-4 text-left">Peminjam</th>
                    <th class="py-3 px-4 text-left">Buku</th>
                    <th class="py-3 px-4 text-left">Jatuh Tempo</th>
                    <th class="py-3 px-4 text-left">Keterlambatan</th>
                    <th class="py-3 px-4 text-left">Jumlah Denda</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($fines as $loan)
                <tr>
                    <td class="py-3 px-4">{{ $loan->user->name }}</td>
                    <td class="py-3 px-4">{{ $loan->book->title }}</td>
                    <td class="py-3 px-4">{{ $loan->due_at->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        @if($loan->due_at < now() && !$loan->returned_at)
                            {{ now()->diffInDays($loan->due_at) }} hari
                        @else
                            -
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <span class="text-red-600 font-semibold">
                            Rp {{ number_format($loan->fine, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        @if($loan->fine > 0)
                            <form action="{{ route('admin.fines.pay', $loan) }}" method="POST" class="inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                    Tandai Sudah Bayar
                                </button>
                            </form>
                        @else
                            <span class="text-green-600 text-sm">Lunas</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">
                        Tidak ada data denda
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $fines->links() }}
    </div>
</div>
@endsection