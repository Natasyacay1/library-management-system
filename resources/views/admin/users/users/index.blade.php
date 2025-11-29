<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pengguna
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

            <div class="bg-white shadow-sm rounded-lg p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-semibold">Daftar Pengguna</h3>
                    <a href="{{ route('admin.users.create') }}"
                       class="px-4 py-2 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-500">
                        + Tambah User
                    </a>
                </div>

                @if ($users->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada pengguna.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-4">Nama</th>
                                    <th class="py-2 pr-4">Email</th>
                                    <th class="py-2 pr-4">Role</th>
                                    <th class="py-2 pr-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2 pr-4">{{ $user->name }}</td>
                                        <td class="py-2 pr-4">{{ $user->email }}</td>
                                        <td class="py-2 pr-4 capitalize">{{ $user->role }}</td>
                                        <td class="py-2 pr-4 space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="text-xs px-2 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-400">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs px-2 py-1 rounded bg-red-600 text-white hover:bg-red-500">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
