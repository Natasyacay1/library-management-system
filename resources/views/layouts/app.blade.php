<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Perpustakaan Digital' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">
    @include('layouts.navigation')

    <main class="max-w-7xl mx-auto px-4 py-8">
        {{ $slot ?? '' }}
        @yield('content')
    </main>
</body>
</html>
