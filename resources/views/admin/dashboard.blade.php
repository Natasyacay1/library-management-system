<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- STAT KARTU --}}
            <div class="grid gap-4 md:grid-cols-4">
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <p class="text-xs text-gray-500">Total Buku</p>
                    <p class="mt-1 text-2xl font-bold text-blue-600">
                        {{ $totalBooks ?? 0 }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-4">
                    <p class="text-xs text-gray-500">Total Pengguna</p>
                    <p class="mt-1 text-2xl font-bold text-indigo-600">
                        {{ $totalUsers ?? 0 }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-4">
                    <p class="text-xs text-gray-500">Total Peminjaman</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-600">
                        {{ $totalLoans ?? 0 }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-4">
                    <p class="text-xs text-gray-500">Peminjaman Aktif</p>
                    <p class="mt-1 text-2xl font-bold text-amber-600">
                        {{ $activeLoans ?? 0 }}
                    </p>
                </div>
            </div>

            {{-- MENU AKSI --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <h3 class="text-base font-semibold mb-3">Manajemen Sistem</h3>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-2 text-sm rounded-md bg-slate-900 text-white hover:bg-slate-800">
                        Kelola Pengguna
                    </a>

                    <a href="{{ route('admin.books.index') }}"
                       class="px-4 py-2 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-500">
                        Kelola Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
