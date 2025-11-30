<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-gray-600 hover:text-purple-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-purple-600 p-2 rounded-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Kelola User</h1>
                        <p class="text-sm text-gray-600">Manajemen semua pengguna sistem</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-800">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h2>
                <p class="text-gray-600">Total {{ $users->total() }} pengguna terdaftar</p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah User Baru
            </a>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                       ($user->role == 'pegawai' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    <i class="fas 
                                        {{ $user->role == 'admin' ? 'fa-crown' : 
                                           ($user->role == 'pegawai' ? 'fa-user-tie' : 'fa-user-graduate') }} mr-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition"
                                                onclick="return confirm('Yakin hapus user ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $users->where('role', 'admin')->count() }}</div>
                <div class="text-gray-600">Admin</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $users->where('role', 'pegawai')->count() }}</div>
                <div class="text-gray-600">Pegawai</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-2xl font-bold text-green-600">{{ $users->where('role', 'mahasiswa')->count() }}</div>
                <div class="text-gray-600">Mahasiswa</div>
            </div>
        </div>
    </div>
</body>
</html>