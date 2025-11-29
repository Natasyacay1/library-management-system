<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nama
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Password (biarkan kosong jika tidak diubah)
                        </label>
                        <input type="password" name="password"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Role
                        </label>
                        <select name="role"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                            <option value="pegawai" {{ $user->role=='pegawai'?'selected':'' }}>Pegawai</option>
                            <option value="mahasiswa" {{ $user->role=='mahasiswa'?'selected':'' }}>Mahasiswa</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="{{ route('admin.users.index') }}"
                           class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-700">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
