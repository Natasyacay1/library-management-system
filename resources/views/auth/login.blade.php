<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - N-CLiterASi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#D24C49',
                        secondary: '#A63A38',
                        soft: '#EEC8A3'
                    },
                    fontFamily: {
                        inter: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-soft font-inter">
    <div class="min-h-screen flex">
        <!-- Left Section -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">

                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="bg-primary p-3 rounded-2xl shadow-md">
                            <i class="fas fa-book-open text-white text-3xl"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Masuk ke Akun</h2>
                    <p class="mt-2 text-sm text-gray-700">Selamat datang kembali di N-CLiterASi</p>
                </div>

                <!-- Login Form -->
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-800">Alamat Email</label>
                        <div class="mt-1 relative">
                            <input id="email" name="email" type="email" required
                                value="{{ old('email') }}"
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="masukkan email anda">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-800">Password</label>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="masukkan password">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                        </div>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="h-4 w-4 text-primary border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                        </div>

                        @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-secondary">Lupa password?</a>
                        </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 text-sm font-medium rounded-lg text-white bg-primary hover:bg-secondary transition shadow-md">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt text-white"></i>
                            </span>
                            Masuk ke Sistem
                        </button>
                    </div>
                </form>

                <!-- Register link -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-700">Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-primary hover:text-secondary">Daftar di sini</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Hero Section -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-primary to-secondary opacity-95">
                <div class="flex items-center justify-center h-full">
                    <div class="text-center text-white px-12">
                        <i class="fas fa-book-open text-white text-8xl mb-8 opacity-80"></i>
                        <h1 class="text-4xl font-bold mb-4">N-CLiterASi</h1>
                        <p class="text-xl opacity-90">Jelajahi dunia pengetahuan tanpa batas</p>
                        <div class="mt-12 grid grid-cols-1 gap-6 text-left">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check-circle"></i>
                                <span>Akses buku digital</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check-circle"></i>
                                <span>Pinjam buku dengan mudah</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check-circle"></i>
                                <span>Kelola peminjaman online</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check-circle"></i>
                                <span>Membaca Novel Populer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Flash -->
    @if ($errors->any())
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <span>Email atau password salah</span>
        </div>
    </div>
    @endif

    <!-- Success Flash -->
    @if (session('status'))
    <div class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('status') }}</span>
        </div>
    </div>
    @endif

</body>
</html>
