<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Admin Panel | N-CLiterASi</title>
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
        .input-focus:focus {
            border-color: #D24C49;
            box-shadow: 0 0 0 3px rgba(210, 76, 73, 0.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
        .user-avatar {
            background: linear-gradient(135deg, var(--color1) 0%, var(--color2) 100%);
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
                    <a href="{{ route('admin.users.index') }}" 
                       class="text-[#EEC8A3] hover:text-white transition p-2 rounded-lg hover:bg-white/10">
                        <i class="fas fa-arrow-left text-lg"></i>
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <div class="bg-[#D24C49] p-2 rounded-xl shadow-md">
                            <i class="fas fa-user-edit text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Edit Pengguna</h1>
                            <p class="text-[#EEC8A3] text-sm">Perbarui data akun pengguna</p>
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
    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- User Profile Card -->
        <div class="mb-8 animate-fadeIn">
            <div class="bg-gradient-to-r from-[#FFE9D6] to-[#FAF4EF] rounded-2xl p-6 card-border">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar -->
                    <div class="relative">
                        <div class="w-24 h-24 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-lg
                            {{ $user->role == 'admin' ? 'role-admin' : 
                               ($user->role == 'pegawai' ? 'role-pegawai' : 'role-mahasiswa') }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        @if($user->email_verified_at)
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center border-2 border-white">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        @endif
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-[#3A2E2A]">{{ $user->name }}</h2>
                                <div class="flex items-center justify-center md:justify-start space-x-4 mt-2">
                                    <span class="inline-flex items-center px-4 py-1 rounded-full text-sm font-semibold text-white
                                        {{ $user->role == 'admin' ? 'role-admin' : 
                                           ($user->role == 'pegawai' ? 'role-pegawai' : 'role-mahasiswa') }}">
                                        <i class="fas 
                                            {{ $user->role == 'admin' ? 'fa-crown' : 
                                               ($user->role == 'pegawai' ? 'fa-user-tie' : 'fa-user-graduate') }} mr-2"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <span class="text-[#3A2E2A]/70 text-sm">
                                        <i class="fas fa-id-card mr-1"></i>ID: {{ $user->id }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-center md:text-right">
                                <div class="text-sm text-[#3A2E2A]/70 mb-1">Status Akun</div>
                                @if($user->email_verified_at)
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </div>
                                @else
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="text-center p-3 bg-white/50 rounded-xl">
                                <div class="text-sm text-[#3A2E2A]/70">Email</div>
                                <div class="font-medium text-[#3A2E2A] truncate">{{ $user->email }}</div>
                            </div>
                            <div class="text-center p-3 bg-white/50 rounded-xl">
                                <div class="text-sm text-[#3A2E2A]/70">Bergabung</div>
                                <div class="font-medium text-[#3A2E2A]">{{ $user->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="text-center p-3 bg-white/50 rounded-xl">
                                <div class="text-sm text-[#3A2E2A]/70">Terakhir Diperbarui</div>
                                <div class="font-medium text-[#3A2E2A]">{{ $user->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-border animate-fadeIn">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] p-6">
                <div class="flex items-center space-x-4">
                    <div class="bg-[#D24C49] p-3 rounded-xl shadow-md">
                        <i class="fas fa-user-cog text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Form Edit Pengguna</h2>
                        <p class="text-[#EEC8A3] text-sm mt-1">Perbarui informasi akun pengguna</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="flex items-center text-sm font-semibold text-[#3A2E2A]">
                            <i class="fas fa-user-circle mr-2 text-[#D24C49]"></i>
                            Nama Lengkap
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               class="w-full px-4 py-3 border border-[#EEC8A3] rounded-xl input-focus transition-all 
                                      placeholder-gray-400 bg-[#FAF9F7]"
                               placeholder="Masukkan nama lengkap pengguna"
                               value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="flex items-center text-sm font-semibold text-[#3A2E2A]">
                            <i class="fas fa-envelope mr-2 text-[#D24C49]"></i>
                            Alamat Email
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-4 py-3 border border-[#EEC8A3] rounded-xl input-focus transition-all 
                                      placeholder-gray-400 bg-[#FAF9F7]"
                               placeholder="contoh: user@email.com"
                               value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <label for="role" class="flex items-center text-sm font-semibold text-[#3A2E2A]">
                            <i class="fas fa-user-tag mr-2 text-[#D24C49]"></i>
                            Peran (Role)
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <select name="role" id="role" required
                                    class="w-full px-4 py-3 border border-[#EEC8A3] rounded-xl input-focus transition-all 
                                           appearance-none bg-[#FAF9F7] cursor-pointer">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }} 
                                        class="py-2">👑 Administrator</option>
                                <option value="pegawai" {{ $user->role == 'pegawai' ? 'selected' : '' }}
                                        class="py-2">👔 Pegawai Perpustakaan</option>
                                <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}
                                        class="py-2">🎓 Mahasiswa</option>
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i class="fas fa-chevron-down text-[#D24C49]"></i>
                            </div>
                        </div>
                        @error('role')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Update Section -->
                    <div class="bg-gradient-to-r from-[#FFE9D6] to-[#FAF4EF] border border-[#EEC8A3] rounded-xl p-5 mt-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="bg-[#D24C49] p-2 rounded-lg">
                                <i class="fas fa-key text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#3A2E2A]">Perbarui Password</h4>
                                <p class="text-sm text-[#3A2E2A]/70">Kosongkan jika tidak ingin mengubah password</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- New Password -->
                            <div class="space-y-2">
                                <label for="password" class="flex items-center text-sm font-semibold text-[#3A2E2A]">
                                    <i class="fas fa-key mr-2 text-[#D24C49]"></i>
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                           class="w-full px-4 py-3 border border-[#EEC8A3] rounded-xl input-focus transition-all 
                                                  placeholder-gray-400 bg-[#FAF9F7] pr-10"
                                           placeholder="Minimal 8 karakter (opsional)">
                                    <button type="button" onclick="togglePassword('password')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#D24C49]">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="flex items-center text-red-500 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-2">
                                <label for="password_confirmation" class="flex items-center text-sm font-semibold text-[#3A2E2A]">
                                    <i class="fas fa-key mr-2 text-[#D24C49]"></i>
                                    Konfirmasi Password
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="w-full px-4 py-3 border border-[#EEC8A3] rounded-xl input-focus transition-all 
                                                  placeholder-gray-400 bg-[#FAF9F7] pr-10"
                                           placeholder="Ulangi password baru">
                                    <button type="button" onclick="togglePassword('password_confirmation')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#D24C49]">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="mt-4">
                            <p class="text-sm font-medium text-[#3A2E2A] mb-2">Password harus mengandung:</p>
                            <ul class="text-xs text-[#3A2E2A]/70 space-y-1">
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Minimal 8 karakter
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Kombinasi huruf dan angka
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Additional Options -->
                    <div class="space-y-4 mt-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="send_notification" id="send_notification" 
                                   class="w-5 h-5 text-[#D24C49] border-[#EEC8A3] rounded focus:ring-[#D24C49]">
                            <label for="send_notification" class="ml-3 text-sm text-[#3A2E2A]">
                                Kirim notifikasi email tentang perubahan akun
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="force_password_change" id="force_password_change" 
                                   class="w-5 h-5 text-[#D24C49] border-[#EEC8A3] rounded focus:ring-[#D24C49]">
                            <label for="force_password_change" class="ml-3 text-sm text-[#3A2E2A]">
                                Wajibkan pengguna untuk mengganti password saat login berikutnya
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-8 mt-8 border-t border-[#EEC8A3]">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-8 py-3 border border-[#EEC8A3] text-[#3A2E2A] rounded-xl hover:bg-[#FAF4EF] 
                                  transition-all flex items-center justify-center group">
                            <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="btn-primary text-white px-8 py-3 rounded-xl hover:opacity-90 
                                       transition-all flex items-center justify-center shadow-lg group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="mt-8 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-2xl overflow-hidden animate-fadeIn">
            <div class="bg-gradient-to-r from-red-600 to-rose-600 p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Zona Berbahaya</h3>
                        <p class="text-white/80 text-sm">Aksi yang tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Deactivate Account -->
                    <div>
                        <h4 class="font-semibold text-red-700 mb-2">Nonaktifkan Akun</h4>
                        <p class="text-sm text-gray-600 mb-4">Pengguna tidak dapat login sampai diaktifkan kembali</p>
                        @if($user->is_active)
                        <form action="{{ route('admin.users.deactivate', $user) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Nonaktifkan akun {{ $user->name }}?')"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-user-slash mr-2"></i>Nonaktifkan
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Aktifkan kembali akun {{ $user->name }}?')"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-user-check mr-2"></i>Aktifkan
                            </button>
                        </form>
                        @endif
                    </div>

                    <!-- Delete Account -->
                    <div>
                        <h4 class="font-semibold text-red-700 mb-2">Hapus Akun Permanen</h4>
                        <p class="text-sm text-gray-600 mb-4">Akun akan dihapus secara permanen dari sistem</p>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirmDelete('{{ $user->name }}')"
                                    class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 transition">
                                <i class="fas fa-trash-alt mr-2"></i>Hapus Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                    <span class="font-medium">Edit Pengguna</span> • ID: {{ $user->id }}
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Confirmation dialog for delete
        function confirmDelete(userName) {
            return confirm(`⚠️ PERINGATAN: Aksi tidak dapat dibatalkan!\n\nApakah Anda yakin ingin menghapus akun pengguna "${userName}" secara permanen?\n\nSemua data yang terkait akan ikut terhapus.`);
        }

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to form elements
            const formElements = document.querySelectorAll('.space-y-2, .grid > div');
            formElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.05}s`;
                el.classList.add('animate-fadeIn');
            });

            // Real-time validation
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.checkValidity()) {
                        this.classList.add('border-green-400');
                        this.classList.remove('border-red-400');
                    } else {
                        this.classList.add('border-red-400');
                        this.classList.remove('border-green-400');
                    }
                });
            });

            // Role change visual feedback
            const roleSelect = document.getElementById('role');
            const avatar = document.querySelector('.w-24.h-24');
            
            roleSelect.addEventListener('change', function() {
                const role = this.value;
                let colorClass = '';
                
                switch(role) {
                    case 'admin':
                        colorClass = 'role-admin';
                        break;
                    case 'pegawai':
                        colorClass = 'role-pegawai';
                        break;
                    case 'mahasiswa':
                        colorClass = 'role-mahasiswa';
                        break;
                }
                
                // Remove existing role classes
                avatar.classList.remove('role-admin', 'role-pegawai', 'role-mahasiswa');
                // Add new role class
                avatar.classList.add(colorClass);
            });
        });

        // Animation style
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out forwards;
            }
            .transition-all {
                transition: all 0.2s ease;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>