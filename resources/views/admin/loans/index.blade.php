@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')
@section('page-title', 'Manajemen Peminjaman')
@section('page-description', 'Kelola semua peminjaman buku')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Daftar Peminjaman</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm">
                    <th class="py-3 px-4 text-left">Peminjam</th>
                    <th class="py-3 px-4 text-left">Buku</th>
                    <th class="py-3 px-4 text-left">Tanggal Pinjam</th>
                    <th class="py-3 px-4 text-left">Jatuh Tempo</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($loans as $loan)
                <tr>
                    <td class="py-3 px-4">{{ $loan->user->name }}</td>
                    <td class="py-3 px-4">{{ $loan->book->title }}</td>
                    <td class="py-3 px-4">{{ $loan->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-4">{{ $loan->due_at->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        @if($loan->returned_at)
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Dikembalikan</span>
                        @elseif($loan->due_at < now())
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Terlambat</span>
                        @else
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if(!$loan->returned_at)
                            <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600" onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                    Kembalikan
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm">Sudah dikembalikan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">
                        Tidak ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $loans->links() }}
    </div>
</div>
@endsection