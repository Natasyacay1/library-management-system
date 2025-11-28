@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Tambah Pengguna</h1>

    <form action="{{ route('admin.users.store') }}" method="POST"
          class="bg-white p-6 rounded-md shadow space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium">Nama</label>
            <input type="text" name="name"
                   value="{{ old('name') }}"
                   class="mt-1 w-full border rounded px-3 py-2 text-sm"
                   required>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email"
                   value="{{ old('email') }}"
                   class="mt-1 w-full border rounded px-3 py-2 text-sm"
                   required>
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password"
                   class="mt-1 w-full border rounded px-3 py-2 text-sm"
                   required>
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-sm font-medium">Role</label>
            <select name="role"
                    class="mt-1 w-full border rounded px-3 py-2 text-sm"
                    required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="pegawai">Pegawai</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">
            Simpan Pengguna
        </button>
    </form>
@endsection
