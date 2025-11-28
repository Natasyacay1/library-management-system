@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Manajemen Pengguna</h1>
        <a href="{{ route('admin.users.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">
            + Tambah User
        </a>
    </div>

    <div class="bg-white rounded-md shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->role }}</td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 text-xs">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-xs"
                                    onclick="return confirm('Hapus user ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-slate-500">
                        Belum ada user.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
