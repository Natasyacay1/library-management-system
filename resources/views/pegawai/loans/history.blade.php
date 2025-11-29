<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="font-semibold text-sm mb-3">Daftar Riwayat Peminjaman</h3>

                @if ($loans->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada riwayat peminjaman.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-3">Buku</th>
                                    <th class="py-2 pr-3">Dipinjam</th>
                                    <th class="py-2 pr-3">Jatuh Tempo</th>
                                    <th class="py-2 pr-3">Dikembalikan</th>
                                    <th class="py-2 pr-3">Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr class="border-b last:border-0">
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
