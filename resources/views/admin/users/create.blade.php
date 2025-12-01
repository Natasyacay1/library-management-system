<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Admin Panel | N-CLiterASi</title>
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
        .btn-primary {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .input-focus:focus {
            border-color: #D24C49;
            box-shadow: 0 0 0 3px rgba(210, 76, 73, 0.1);
        }
        .header-gradient {
            background: linear-gradient(135deg, #3A2E2A 0%, #2B211E 100%);
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
                            <i class="fas fa-user-plus text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Tambah Pengguna Baru</h1>
                            <p class="text-[#EEC8A3] text-sm">Kelola sistem perpustakaan dengan mudah</p>
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[#EEC8A3] text-sm">Administrator</p>
                    </div>
                    <div class="w-10 h-10 bg-[#EEC8A3] text-[#3A2E2A] rounded-full flex items-center justify-center font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-border animate-fadeIn">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] p-6">
                <div class="flex items-center space-x-4">
                    <div class="bg-[#D24C49] p-3 rounded-xl shadow-md">
                        <i class="fas fa-user-cog text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Form Tambah Pengguna</h2>
                        <p class="text-[#EEC8A3] text-sm mt-1">Isi data pengguna baru dengan lengkap</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
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
                               value="{{ old('name') }}">
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
                               value="{{ old('email') }}">
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
                                <option value="" disabled selected>Pilih peran pengguna</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }} 
                                        class="py-2">👑 Administrator</option>
                                <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}
                                        class="py-2">👔 Pegawai Perpustakaan</option>
                                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}
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

                    <!-- Password Fields - Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="flex items-center text-sm font-semibold text-[#3A2E2A]">
                                <i class="fas fa-key mr-2 text-[#D24C49]"></i>
                                Password
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                       class="w-full px-4 py-3 border border-[#EEC8A3] rounded-xl input-focus transition-all 
                                              placeholder-gray-400 bg-[#FAF9F7] pr-10"
                                       placeholder="Minimal 8 karakter">
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
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full px-4 py-3 border border-[#EEC8A3] rounded-xl input-focus transition-all 
                                              placeholder-gray-400 bg-[#FAF9F7] pr-10"
                                       placeholder="Ulangi password">
                                <button type="button" onclick="togglePassword('password_confirmation')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#D24C49]">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-gradient-to-r from-[#FFE9D6] to-[#FAF4EF] border border-[#EEC8A3] rounded-xl p-4 mt-6">
                        <div class="flex items-start space-x-3">
                            <div class="bg-[#D24C49] p-2 rounded-lg">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#3A2E2A]">Informasi Penting</h4>
                                <ul class="text-sm text-[#3A2E2A]/80 space-y-1 mt-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                        Password harus minimal 8 karakter
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                        Email harus valid dan belum terdaftar
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                        Pilih role sesuai kebutuhan akses
                                    </li>
                                </ul>
                            </div>
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
                            <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform"></i>
                            Simpan Pengguna Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Role Information -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF9F7] border border-[#EEC8A3] rounded-xl p-5">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="bg-[#D24C49] p-2 rounded-lg">
                        <i class="fas fa-crown text-white"></i>
                    </div>
                    <h3 class="font-bold text-[#3A2E2A]">Administrator</h3>
                </div>
                <p class="text-sm text-[#3A2E2A]/80">Akses penuh ke semua fitur sistem, termasuk manajemen pengguna dan konfigurasi.</p>
            </div>

            <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF9F7] border border-[#EEC8A3] rounded-xl p-5">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="bg-[#10B981] p-2 rounded-lg">
                        <i class="fas fa-user-tie text-white"></i>
                    </div>
                    <h3 class="font-bold text-[#3A2E2A]">Pegawai</h3>
                </div>
                <p class="text-sm text-[#3A2E2A]/80">Dapat mengelola buku, peminjaman, dan melihat laporan. Tidak bisa mengelola pengguna.</p>
            </div>

            <div class="bg-gradient-to-br from-[#FFE9D6] to-[#FAF9F7] border border-[#EEC8A3] rounded-xl p-5">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="bg-[#3B82F6] p-2 rounded-lg">
                        <i class="fas fa-user-graduate text-white"></i>
                    </div>
                    <h3 class="font-bold text-[#3A2E2A]">Mahasiswa</h3>
                </div>
                <p class="text-sm text-[#3A2E2A]/80">Dapat meminjam buku, melihat katalog, dan memberikan review pada buku.</p>
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
                    <span class="font-medium">Admin Panel</span> • Semua hak dilindungi undang-undang
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

        // Form validation styling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                // Add focus/blur effects
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-[#D24C49]/20');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-[#D24C49]/20');
                });
                
                // Real-time validation feedback
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

            // Animate form elements on load
            const formElements = document.querySelectorAll('.space-y-2, .grid > div');
            formElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.05}s`;
                el.classList.add('animate-fadeIn');
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
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>