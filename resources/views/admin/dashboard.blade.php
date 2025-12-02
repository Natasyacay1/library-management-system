<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - N-CLiterASi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #D24C49 0%, #A52C2A 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -6px rgba(0,0,0,0.2);
        }
        .soft-bg {
            background-color: #EEC8A3;
        }
        .sidebar {
            background: linear-gradient(180deg, #3A2E2A 0%, #2B211E 100%);
            transition: all 0.3s ease;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .main-content {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .alert-item {
            animation: fadeIn 0.5s ease;
        }
        .nav-item.active {
            background-color: #D24C49 !important;
        }
        .nav-item:hover {
            background-color: #A52C2A;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-[#FAF4EF] flex">

    <!-- Sidebar -->
    <div class="sidebar w-64 min-h-screen p-4 flex flex-col text-white">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="bg-[#D24C49] text-white p-2 rounded-xl shadow-md mr-3">
                    <i class="fas fa-book-open text-xl"></i>
                </div>
                <h1 class="text-xl font-bold sidebar-text">N-C<span class="text-[#EEC8A3]">LiterASi</span></h1>
            </div>
            <button id="toggleSidebar" class="text-white hover:text-[#EEC8A3]">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-item flex items-center p-3 rounded-lg bg-[#D24C49]">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span class="sidebar-text font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.books.index') }}" class="nav-item flex items-center p-3 hover:bg-[#A52C2A] rounded-lg">
                        <i class="fas fa-book mr-3"></i>
                        <span class="sidebar-text font-medium">Manajemen Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center p-3 hover:bg-[#A52C2A] rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        <span class="sidebar-text font-medium">Manajemen User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.loans.index') }}" class="nav-item flex items-center p-3 hover:bg-[#A52C2A] rounded-lg">
                        <i class="fas fa-exchange-alt mr-3"></i>
                        <span class="sidebar-text font-medium">Peminjaman</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.fines.index') }}" class="nav-item flex items-center p-3 hover:bg-[#A52C2A] rounded-lg">
                        <i class="fas fa-money-bill-wave mr-3"></i>
                        <span class="sidebar-text font-medium">Denda</span>
                    </a>
                </li>
                <li class="mt-8 pt-4 border-t border-[#4A3D38]">
                    <a href="{{ route('books.catalog') }}" class="nav-item flex items-center p-3 hover:bg-[#A52C2A] rounded-lg">
                        <i class="fas fa-search mr-3"></i>
                        <span class="sidebar-text font-medium">Katalog Buku (Public)</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="mt-auto pt-4 border-t border-[#4A3D38]">
            <div class="flex items-center p-2">
                <div class="bg-[#EEC8A3] text-[#3A2E2A] p-2 rounded-full">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div class="ml-3 sidebar-text">
                    <p class="font-medium">Administrator</p>
                    <p class="text-sm text-[#EEC8A3]">admin@ncliterasi.com</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="nav-item flex items-center w-full p-3 hover:bg-[#A52C2A] rounded-lg text-white">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <span class="sidebar-text font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-1 p-6">
        <!-- Header -->
        <header class="bg-white/110 backdrop-blur-md shadow-md rounded-xl p-4 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
                    <p class="text-gray-600">Selamat datang di sistem manajemen perpustakaan digital</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#D24C49]">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button class="bg-[#D24C49] text-white p-3 rounded-lg relative hover:bg-red-700 transition shadow-md">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 bg-white text-[#D24C49] rounded-full w-5 h-5 text-xs flex items-center justify-center font-bold">3</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total Pengguna</p>
                        <h3 class="text-3xl font-bold text-[#D24C49]">5</h3>
                    </div>
                    <div class="bg-[#EEC8A3] p-3 rounded-full">
                        <i class="fas fa-users text-[#D24C49] text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-600 text-sm mt-2 font-medium"><i class="fas fa-arrow-up"></i> 12% dari bulan lalu</p>
            </div>

            <div class="stat-card bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total Buku</p>
                        <h3 class="text-3xl font-bold text-[#D24C49]">20</h3>
                    </div>
                    <div class="bg-[#EEC8A3] p-3 rounded-full">
                        <i class="fas fa-book text-[#D24C49] text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-600 text-sm mt-2 font-medium"><i class="fas fa-arrow-up"></i> 8% dari bulan lalu</p>
            </div>

            <div class="stat-card bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Peminjaman Aktif</p>
                        <h3 class="text-3xl font-bold text-[#D24C49]">2+</h3>
                    </div>
                    <div class="bg-[#EEC8A3] p-3 rounded-full">
                        <i class="fas fa-exchange-alt text-[#D24C49] text-2xl"></i>
                    </div>
                </div>
                <p class="text-red-600 text-sm mt-2 font-medium"><i class="fas fa-arrow-down"></i> 5% dari bulan lalu</p>
            </div>

            <div class="stat-card bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total Denda</p>
                        <h3 class="text-3xl font-bold text-[#D24C49]">0</h3>
                    </div>
                    <div class="bg-[#EEC8A3] p-3 rounded-full">
                        <i class="fas fa-money-bill-wave text-[#D24C49] text-2xl"></i>
                    </div>
                </div>
                <p class="text-red-600 text-sm mt-2 font-medium"><i class="fas fa-arrow-up"></i> 15% dari bulan lalu</p>
            </div>
        </div>

        <!-- Charts dan Alert Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Chart Peminjaman Bulanan -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-800">Peminjaman Bulanan</h3>
                    <select class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-[#D24C49]">
                        <option>Tahun 2025</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="loansChart"></canvas>
                </div>
            </div>
            
            <!-- System Alerts -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <h3 class="font-bold text-lg text-gray-800 mb-4">System Alerts</h3>
                <div class="space-y-4">
                    <div class="alert-item p-4 bg-[#FFE9D6] border-l-4 border-[#D24C49] rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-[#D24C49] mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-gray-800">Buku Terlambat</h4>
                                <p class="text-sm text-gray-600">0 buku belum dikembalikan setelah jatuh tempo</p>
                                <a href="{{ route('admin.loans.index') }}" class="text-[#D24C49] text-sm hover:underline mt-1 inline-block font-medium">Lihat detail</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-item p-4 bg-[#FFE9D6] border-l-4 border-[#EEC8A3] rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-box-open text-[#A52C2A] mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-gray-800">Stok Habis</h4>
                                <p class="text-sm text-gray-600">10+ buku sudah habis stoknya</p>
                                <a href="{{ route('admin.books.index') }}" class="text-[#D24C49] text-sm hover:underline mt-1 inline-block font-medium">Kelola stok</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-item p-4 bg-[#FFE9D6] border-l-4 border-[#3A2E2A] rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-book-open text-[#3A2E2A] mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-gray-800">Peminjaman Aktif</h4>
                                <p class="text-sm text-gray-600">1 buku sedang dipinjam</p>
                                <a href="{{ route('admin.loans.index') }}" class="text-[#D24C49] text-sm hover:underline mt-1 inline-block font-medium">Lihat semua</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-item p-4 bg-[#FFE9D6] border-l-4 border-[#D24C49] rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-clock text-[#D24C49] mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-gray-800">Jatuh Tempo Segera</h4>
                                <p class="text-sm text-gray-600">0 fbuku akan jatuh tempo dalam 2 hari</p>
                                <a href="{{ route('admin.loans.index') }}" class="text-[#D24C49] text-sm hover:underline mt-1 inline-block font-medium">Notifikasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3] mb-8">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.books.create') }}" class="bg-gradient-to-r from-[#D24C49] to-[#A52C2A] text-white p-4 rounded-lg text-center hover:opacity-90 transition transform hover:scale-105 shadow-md">
                    <i class="fas fa-plus text-2xl mb-2"></i>
                    <p class="font-medium">Tambah Buku</p>
                </a>
                <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-[#3A2E2A] to-[#2B211E] text-white p-4 rounded-lg text-center hover:opacity-90 transition transform hover:scale-105 shadow-md">
                    <i class="fas fa-user-plus text-2xl mb-2"></i>
                    <p class="font-medium">Tambah User</p>
                </a>
                <a href="{{ route('admin.loans.index') }}" class="bg-gradient-to-r from-[#D24C49] to-[#EEC8A3] text-[#3A2E2A] p-4 rounded-lg text-center hover:opacity-90 transition transform hover:scale-105 shadow-md">
                    <i class="fas fa-exchange-alt text-2xl mb-2"></i>
                    <p class="font-medium">Kelola Peminjaman</p>
                </a>
                <a href="{{ route('admin.fines.index') }}" class="bg-gradient-to-r from-[#EEC8A3] to-[#FFE9D6] text-[#3A2E2A] p-4 rounded-lg text-center hover:opacity-90 transition transform hover:scale-105 shadow-md">
                    <i class="fas fa-money-bill-wave text-2xl mb-2"></i>
                    <p class="font-medium">Kelola Denda</p>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Users -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Pengguna Terbaru</h3>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-[#FAF4EF] rounded-lg">
                        <div class="bg-[#EEC8A3] text-[#3A2E2A] p-2 rounded-full">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Mahasiswa 1</p>
                            <p class="text-sm text-gray-500">Bergabung 6 hari yang lalu</p>
                        </div>
                        <span class="ml-auto bg-[#EEC8A3] text-[#3A2E2A] text-xs px-2 py-1 rounded-full font-medium">Mahasiswa</span>
                    </div>
                    <div class="flex items-center p-3 bg-[#FAF4EF] rounded-lg">
                        <div class="bg-[#EEC8A3] text-[#3A2E2A] p-2 rounded-full">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Pegawai Perpus </p>
                            <p class="text-sm text-gray-500">Bergabung 6 hari lalu</p>
                        </div>
                        <span class="ml-auto bg-[#3A2E2A] text-white text-xs px-2 py-1 rounded-full font-medium">Pegawai</span>
                    </div>
                    <div class="flex items-center p-3 bg-[#FAF4EF] rounded-lg">
                        <div class="bg-[#EEC8A3] text-[#3A2E2A] p-2 rounded-full">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Natasya</p>
                            <p class="text-sm text-gray-500">Bergabung 3 hari yang lalu</p>
                        </div>
                        <span class="ml-auto bg-[#EEC8A3] text-[#3A2E2A] text-xs px-2 py-1 rounded-full font-medium">Mahasiswa</span>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="block text-center text-[#D24C49] hover:text-red-700 mt-4 font-medium">
                    Lihat Semua Pengguna
                </a>
            </div>

            <!-- Recent Loans -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-[#EEC8A3]">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Peminjaman Terbaru</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-[#FAF4EF] rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Machine Learning Fundamentals</p>
                            <p class="text-sm text-gray-500">Natasya •29 November 2025</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-[#FAF4EF] rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Bumi</p>
                            <p class="text-sm text-gray-500">Mahasiswa 1 • 30 Nov 2024</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-[#FAF4EF] rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Bumi</p>
                            <p class="text-sm text-gray-500">Mahasiswa 1 • 2 Desember 2024</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-medium">Akan Jatuh Tempo</span>
                    </div>
                </div>
                <a href="{{ route('admin.loans.index') }}" class="block text-center text-[#D24C49] hover:text-red-700 mt-4 font-medium">
                    Lihat Semua Peminjaman
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center text-gray-500 text-sm py-4 border-t border-[#EEC8A3]">
            <p>© 2025 N-CLiterASi Perpustakaan Digital. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Toggle Sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
        });

        // Chart Data
        const monthlyLoansData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            data: [65, 59, 80, 81, 56, 55, 70, 65, 60, 75, 80, 90]
        };

        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Loans Chart
            const loansCtx = document.getElementById('loansChart').getContext('2d');
            const loansChart = new Chart(loansCtx, {
                type: 'line',
                data: {
                    labels: monthlyLoansData.labels,
                    datasets: [{
                        label: 'Peminjaman Bulanan',
                        data: monthlyLoansData.data,
                        backgroundColor: 'rgba(210, 76, 73, 0.1)',
                        borderColor: '#D24C49',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>