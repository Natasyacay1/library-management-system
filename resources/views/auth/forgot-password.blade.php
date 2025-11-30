<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-orange-500 p-3 rounded-xl">
                        <i class="fas fa-key text-white text-3xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Lupa Password</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Masukkan email Anda untuk reset password
                </p>
            </div>

            <!-- Form -->
            <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative">
                        <input id="email" name="email" type="email" required 
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                               placeholder="masukkan email anda">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Link Reset
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-500 transition">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>