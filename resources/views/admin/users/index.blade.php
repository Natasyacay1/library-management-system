<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin Panel | N-CLiterASi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FAF4EF;
            font-family: 'Inter', sans-serif;
        }
        .card-border {
            border: 1px solid #EEC8A3;
        }
        .header-gradient {
            background: linear-gradient(135deg, #3A2E2A 0%, #2B211E 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .role-admin { background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); }
        .role-pegawai { background: linear-gradient(135deg, #10B981 0%, #059669 100%); }
        .role-mahasiswa { background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); }
        .table-row-hover:hover {
            background: linear-gradient(90deg, #FFE9D6 0%, #FAF4EF 100%);
            transform: translateX(4px);
            transition: all 0.2s ease;
        }
        .stat-card {
            background: linear-gradient(135deg, #FFFFFF 0%, #FAF9F7 100%);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#FAF4EF] text-gray-800 min-h-screen">

    <!-- Header/Navigation -->
    <header class="header-gradient shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Back Button & Title -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-[#EEC8A3] hover:text-white transition p-2 rounded-lg hover:bg-white/10">
                        <i class="fas fa-arrow-left text-lg"></i>
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                            <i class="fas fa-users-cog text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Kelola Pengguna</h1>
                            <p class="text-[#EEC8A3] text-sm">Manajemen semua akun pengguna sistem</p>
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[#EEC8A3] text-sm">Administrator</p>
                    </div>
                    <div class="w-10 h-10 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center font-bold shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 animate-fadeIn">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div>
                    <h2 class="text-3xl font-bold text-[#3A2E2A] mb-2">Daftar Pengguna Sistem</h2>
                    <p class="text-[#3A2E2A]/70">Total <span class="font-semibold text-[#D24C49]">{{ $users->total() }}</span> pengguna terdaftar</p>
                </div>
                <a href="{{ route('admin.users.create') }}" 
                   class="btn-primary text-white px-8 py-3 rounded-xl hover:opacity-90 
                          transition-all flex items-center shadow-lg group min-w-[200px]">
                    <i class="fas fa-user-plus mr-3 group-hover:scale-110 transition-transform"></i>
                    Tambah Pengguna Baru
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card rounded-2xl p-6 card-border shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm font-medium">Total Admin</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $users->where('role', 'admin')->count() }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl">
                        <div class="role-admin text-white p-2 rounded-lg">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stat-card rounded-2xl p-6 card-border shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm font-medium">Total Pegawai</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $users->where('role', 'pegawai')->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl">
                        <div class="role-pegawai text-white p-2 rounded-lg">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stat-card rounded-2xl p-6 card-border shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#3A2E2A]/70 text-sm font-medium">Total Mahasiswa</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $users->where('role', 'mahasiswa')->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <div class="role-mahasiswa text-white p-2 rounded-lg">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-border animate-fadeIn">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-list mr-3"></i>
                        Daftar Semua Pengguna
                    </h3>
                    <div class="flex items-center space-x-4">
                        <div class="text-white text-sm">
                            Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#FFE9D6] to-[#FAF4EF]">
                            <th class="px-8 py-4 text-left text-sm font-semibold text-[#3A2E2A]">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    Pengguna
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-[#3A2E2A]">
                                <div class="flex items-center">
                                    <i class="fas fa-user-tag mr-2"></i>
                                    Peran
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-[#3A2E2A]">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Email
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-[#3A2E2A]">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Bergabung
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-[#3A2E2A]">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs mr-2"></i>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EEC8A3]/30">
                        @foreach($users as $index => $user)
                        <tr class="table-row-hover" style="animation-delay: {{ $index * 0.05 }}s">
                            <!-- User Info -->
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md
                                            {{ $user->role == 'admin' ? 'role-admin' : 
                                            ($user->role == 'pegawai' ? 'role-pegawai' : 'role-mahasiswa') }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        @if($user->email_verified_at)
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-[#3A2E2A]">{{ $user->name }}</div>
                                        <div class="text-sm text-[#3A2E2A]/60">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role -->
                            <td class="px-8 py-5">
                                <div class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white
                                    {{ $user->role == 'admin' ? 'role-admin' : 
                                       ($user->role == 'pegawai' ? 'role-pegawai' : 'role-mahasiswa') }}">
                                    <i class="fas 
                                        {{ $user->role == 'admin' ? 'fa-crown' : 
                                           ($user->role == 'pegawai' ? 'fa-user-tie' : 'fa-user-graduate') }} mr-2"></i>
                                    {{ ucfirst($user->role) }}
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-[#D24C49]"></i>
                                    <div>
                                        <div class="font-medium text-[#3A2E2A]">{{ $user->email }}</div>
                                        @if($user->email_verified_at)
                                        <div class="text-xs text-green-600 flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                        </div>
                                        @else
                                        <div class="text-xs text-amber-600 flex items-center">
                                            <i class="fas fa-clock mr-1"></i>Belum verifikasi
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Join Date -->
                            <td class="px-8 py-5">
                                <div class="space-y-1">
                                    <div class="font-medium text-[#3A2E2A]">
                                        {{ $user->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-[#3A2E2A]/60">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="group relative"
                                       title="Edit pengguna">
                                        <div class="bg-blue-50 text-blue-600 p-2 rounded-lg group-hover:bg-blue-100 
                                                   transition-all flex items-center space-x-2">
                                            <i class="fas fa-edit"></i>
                                            <span class="hidden lg:inline text-sm font-medium">Edit</span>
                                        </div>
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="group relative"
                                                onclick="return confirmDelete('{{ $user->name }}')"
                                                title="Hapus pengguna">
                                            <div class="bg-red-50 text-red-600 p-2 rounded-lg group-hover:bg-red-100 
                                                    transition-all flex items-center space-x-2">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="hidden lg:inline text-sm font-medium">Hapus</span>
                                            </div>
                                        </button>
                                    </form>

                                    <button onclick="showUserDetails({{ $user->id }})"
                                            class="group relative"
                                            title="Detail pengguna">
                                        <div class="bg-gray-50 text-gray-600 p-2 rounded-lg group-hover:bg-gray-100 
                                                transition-all flex items-center space-x-2">
                                            <i class="fas fa-eye"></i>
                                            <span class="hidden lg:inline text-sm font-medium">Lihat</span>
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="px-8 py-6 border-t border-[#EEC8A3] bg-gradient-to-r from-[#FFE9D6] to-[#FAF4EF]">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-[#3A2E2A]/70">
                        Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                    </div>
                    <div class="flex space-x-2">
                        {{ $users->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Empty State -->
        @if($users->isEmpty())
        <div class="text-center py-16 animate-fadeIn">
            <div class="w-24 h-24 bg-gradient-to-r from-[#FFE9D6] to-[#FAF4EF] rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-users text-[#D24C49] text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-[#3A2E2A] mb-2">Belum ada pengguna</h3>
            <p class="text-[#3A2E2A]/70 mb-6">Mulai dengan menambahkan pengguna pertama</p>
            <a href="{{ route('admin.users.create') }}" 
               class="btn-primary text-white px-8 py-3 rounded-xl hover:opacity-90 
                      transition-all inline-flex items-center shadow-lg">
                <i class="fas fa-user-plus mr-3"></i>
                Tambah Pengguna Pertama
            </a>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-[#3A2E2A] border-t border-[#EEC8A3] mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 text-[#EEC8A3] mb-4 md:mb-0">
                    <div class="bg-[#D24C49] p-1 rounded-md">
                        <i class="fas fa-book"></i>
                    </div>
                    <span class="text-sm font-medium">N-CLiterASi © 2025</span>
                </div>
                <div class="text-[#EEC8A3] text-sm">
                    <span class="font-medium">Manajemen Pengguna</span> • Total: {{ $users->total() }} pengguna
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Confirmation dialog for delete
        function confirmDelete(userName) {
            return confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"?\n\nAksi ini tidak dapat dibatalkan.`);
        }

        // Show user details (placeholder for future modal)
        function showUserDetails(userId) {
            alert(`Detail pengguna ID: ${userId}\n\nFitur detail pengguna akan segera hadir!`);
            // TODO: Implement modal with AJAX to show user details
        }

        // Add animation classes on load
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to table rows
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
                row.classList.add('animate-fadeIn');
            });

            // Search functionality (placeholder)
            const searchInput = document.createElement('div');
            searchInput.innerHTML = `
                <div class="relative mb-6">
                    <input type="text" 
                           placeholder="Cari pengguna..." 
                           class="w-full px-4 py-3 pl-12 border border-[#EEC8A3] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D24C49]/20"
                           onkeyup="filterUsers(this.value)">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            `;
            
            // You can add this search bar before the table if needed
            // document.querySelector('main').insertBefore(searchInput, document.querySelector('.bg-white'));

            // Role filter buttons
            const roleFilters = document.createElement('div');
            roleFilters.innerHTML = `
                <div class="flex flex-wrap gap-2 mb-6">
                    <button onclick="filterByRole('all')" class="px-4 py-2 bg-[#3A2E2A] text-white rounded-lg">Semua</button>
                    <button onclick="filterByRole('admin')" class="px-4 py-2 bg-purple-600 text-white rounded-lg">Admin</button>
                    <button onclick="filterByRole('pegawai')" class="px-4 py-2 bg-green-600 text-white rounded-lg">Pegawai</button>
                    <button onclick="filterByRole('mahasiswa')" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Mahasiswa</button>
                </div>
            `;
        });

        // Filter functions (to be implemented with AJAX)
        function filterUsers(searchTerm) {
            console.log('Searching for:', searchTerm);
            // TODO: Implement AJAX search
        }

        function filterByRole(role) {
            console.log('Filter by role:', role);
            // TODO: Implement AJAX filter
        }

        // Export functionality
        function exportUsers(format) {
            alert(`Exporting users as ${format}...\n\nFitur ekspor akan segera hadir!`);
            // TODO: Implement export functionality
        }
    </script>
</body>
</html>