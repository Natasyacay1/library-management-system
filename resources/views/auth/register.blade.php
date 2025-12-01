<!-- Register Page Redesign - Cherry Red & Soft Taupe Theme -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - N-CLiterASi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#D24C49',
                        soft: '#EEC8A3',
                        dark: '#1A1A1A'
                    },
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-soft font-inter">
    <div class="min-h-screen flex">

        <!-- Left Section - Form Card -->
        <div class="flex-1 flex flex-col justify-center p-8 lg:p-20">
            <div class="bg-white shadow-xl rounded-2xl p-10 max-w-md mx-auto border border-primary/20">

                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="bg-primary p-4 rounded-2xl shadow-lg">
                            <i class="fas fa-user-plus text-white text-3xl"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-dark">Buat Akun Baru</h2>
                    <p class="mt-2 text-sm text-gray-600">Bergabung dengan Perpustakaan Digital</p>
                </div>

                <!-- FORM -->
                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <div class="mt-1 relative">
                            <input name="name" type="text" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition placeholder-gray-400"
                                placeholder="masukkan nama lengkap" value="{{ old('name') }}">
                            <i class="fas fa-user absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="mt-1 relative">
                            <input name="email" type="email" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition placeholder-gray-400"
                                placeholder="masukkan email" value="{{ old('email') }}">
                            <i class="fas fa-envelope absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative">
                            <input name="password" type="password" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition placeholder-gray-400"
                                placeholder="buat password minimal 8 karakter">
                            <i class="fas fa-lock absolute right-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="mt-1 relative">
                            <input name="password_confirmation" type="password" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition placeholder-gray-400"
                                placeholder="ulangi password">
                            <i class="fas fa-lock absolute right-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Daftar Sebagai</label>
                        <select name="role" required
                                class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition">
                            <option value="">Pilih peran...</option>
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                        @error('role')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">* Admin hanya bisa dibuat oleh admin yang sudah ada</p>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required
                        class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                        <label for="terms" class="ml-2 text-sm text-gray-700">
                            Saya menyetujui <a class="text-primary hover:underline">syarat & ketentuan</a>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 bg-primary hover:bg-dark text-white rounded-xl font-semibold shadow-lg transition">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Section Image -->
        <div class="hidden lg:flex flex-1 items-center justify-center bg-primary">
            <div class="text-center text-white p-12">
                <i class="fas fa-book-open text-8xl mb-6 opacity-90"></i>
                <h1 class="text-4xl font-bold mb-4">N-CLiterASi</h1>
                <h1 class="text-4xl font-bold mb-4">Bergabung Bersama Kami</h1>
                <p class="text-lg opacity-90">Mulai petualangan membaca Anda</p>
                <div class="mt-8 space-y-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-white"></i>
                        <span>Akses ribuan buku digital</span>
                    </div>  
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-white"></i>
                        <span>Jelajahi koleksi terbaru</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
