<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-200 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-200 px-4 py-2 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="font-semibold text-sm mb-3">Daftar Semua Peminjaman</h3>

                @if($loans->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada data peminjaman.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-3">Mahasiswa</th>
                                    <th class="py-2 pr-3">Buku</th>
                                    <th class="py-2 pr-3">Dipinjam</th>
                                    <th class="py-2 pr-3">Jatuh Tempo</th>
                                    <th class="py-2 pr-3">Dikembalikan</th>
                                    <th class="py-2 pr-3">Denda</th>
                                    <th class="py-2 pr-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2 pr-3">{{ $loan->user->name }}</td>
                                        <td class="py-2 pr-3">{{ $loan->book->title }}</td>
                                        <td class="py-2 pr-3">{{ $loan->borrowed_at?->format('d-m-Y') }}</td>
                                        <td class="py-2 pr-3">{{ $loan->due_at?->format('d-m-Y') }}</td>
                                        <td class="py-2 pr-3">
                                            {{ $loan->returned_at ? $loan->returned_at->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="py-2 pr-3">
                                            @if($loan->fine > 0)
                                                Rp {{ number_format($loan->fine, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="py-2 pr-3">
                                            @if(is_null($loan->returned_at))
                                                <form action="{{ route('pegawai.loans.confirm-return', $loan) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                                    @csrf
                                                    <button class="px-2 py-1 text-[11px] rounded bg-green-600 text-white hover:bg-green-500">
                                                        Konfirmasi Kembali
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[11px] text-gray-500">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $loans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
