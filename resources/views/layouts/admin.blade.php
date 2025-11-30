<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Library System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Simple Header untuk Testing -->
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold">Admin Dashboard - Library System</h1>
            <p class="text-blue-100">Layout Admin Loaded</p>
        </div>
    </header>

    <!-- Simple Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex space-x-4 py-3">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 font-medium">Dashboard</a>
                <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-blue-600">Buku</a>
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-blue-600">User</a>
                <a href="{{ route('admin.loans.index') }}" class="text-gray-600 hover:text-blue-600">Peminjaman</a>
                <a href="{{ route('admin.fines.index') }}" class="text-gray-600 hover:text-blue-600">Denda</a>
                <a href="{{ route('admin.settings') }}" class="text-gray-600 hover:text-blue-600">Settings</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="container mx-auto px-4 py-4 text-center text-gray-500">
            <p>© 2023 Library Management System</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>