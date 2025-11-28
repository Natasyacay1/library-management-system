@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Edit Pengguna</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST"
          class="bg-white p-6 rounded-md shadow space-y-5">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium">Nama</label>
            <input type="text" name="name"
                   value="{{ old('name', $user->name) }}"
                   class="mt-1 w-full border rounded px-3 py-2 text-sm"
                   required>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email"
                   value="{{ old('email', $user->email) }}"
                   class="mt-1 w-full border rounded px-3 py-2 text-sm"
                   required>
        </div>

        {{-- Password (opsional) --}}
        <div>
            <label class="block text-sm font-medium">
                Password (kosongkan jika tidak diganti)
            </label>
            <input type="password" name="password"
                class="mt-1 w-full border rounded px-3 py-2 text-sm">
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-sm font-medium">Role</label>
            <select name="role"
                    class="mt-1 w-full border rounded px-3 py-2 text-sm"
                    required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pegawai" {{ $user->role == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            </select>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">
            Update Pengguna
        </button>
    </form>
@endsection
