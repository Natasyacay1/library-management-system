<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pegawai
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-4">
                    <p class="text-xs text-gray-500">Peminjaman Aktif</p>
                    <p class="text-2xl font-bold mt-1">{{ $activeLoans->count() }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <p class="text-xs text-gray-500">Lewat Jatuh Tempo</p>
                    <p class="text-2xl font-bold mt-1 text-red-600">{{ $overdueCount }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <p class="text-xs text-gray-500">Pengembalian Hari Ini</p>
                    <p class="text-2xl font-bold mt-1">{{ $todayReturns }}</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-sm">Peminjaman Aktif Terbaru</h3>
                    <a href="{{ route('pegawai.loans.index') }}" class="text-xs text-blue-600 hover:underline">
                        Lihat semua
                    </a>
                </div>

                @if ($activeLoans->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada peminjaman aktif.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-3">Mahasiswa</th>
                                    <th class="py-2 pr-3">Buku</th>
                                    <th class="py-2 pr-3">Dipinjam</th>
                                    <th class="py-2 pr-3">Jatuh Tempo</th>
                                    <th class="py-2 pr-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activeLoans as $loan)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2 pr-3">{{ $loan->user->name }}</td>
                                        <td class="py-2 pr-3">{{ $loan->book->title }}</td>
                                        <td class="py-2 pr-3">{{ $loan->borrowed_at?->format('d-m-Y') }}</td>
                                        <td class="py-2 pr-3">{{ $loan->due_at?->format('d-m-Y') }}</td>
                                        <td class="py-2 pr-3">
                                            @if($loan->isOverdue())
                                                <span class="px-2 py-1 text-[10px] rounded bg-red-100 text-red-700">
                                                    Telat
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-[10px] rounded bg-green-100 text-green-700">
                                                    Aktif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
