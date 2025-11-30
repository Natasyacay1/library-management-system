<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Library Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {
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
            background-color: #1e40af;
        }
        .nav-item:hover {
            background-color: #1e40af;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans flex">
    <!-- Sidebar -->
    <div class="sidebar bg-blue-800 text-white w-64 min-h-screen p-4 flex flex-col">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <i class="fas fa-book text-2xl mr-3"></i>
                <h1 class="text-xl font-bold sidebar-text">Library System</h1>
            </div>
            <button id="toggleSidebar" class="text-white">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center p-3 bg-blue-700 rounded-lg active">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.books.index') }}" class="nav-item flex items-center p-3 hover:bg-blue-700 rounded-lg">
                        <i class="fas fa-book mr-3"></i>
                        <span class="sidebar-text">Manajemen Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center p-3 hover:bg-blue-700 rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        <span class="sidebar-text">Manajemen User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.loans.index') }}" class="nav-item flex items-center p-3 hover:bg-blue-700 rounded-lg">
                        <i class="fas fa-exchange-alt mr-3"></i>
                        <span class="sidebar-text">Peminjaman</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.fines.index') }}" class="nav-item flex items-center p-3 hover:bg-blue-700 rounded-lg">
                        <i class="fas fa-money-bill-wave mr-3"></i>
                        <span class="sidebar-text">Denda</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="mt-auto pt-4 border-t border-blue-700">
            <div class="flex items-center p-2">
                <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" 
                    alt="Admin" class="w-8 h-8 rounded-full">
                <div class="ml-3 sidebar-text">
                    <p class="font-medium">Administrator</p>
                    <p class="text-sm text-blue-200">admin@library.com</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="nav-item flex items-center w-full p-3 hover:bg-blue-700 rounded-lg text-red-200 hover:text-white">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <span class="sidebar-text">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-1 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
                <p class="text-gray-600">Selamat datang di sistem manajemen perpustakaan</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Cari..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 relative">
                    <i class="fas fa-bell"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">3</span>
                </button>
            </div>
        </div>

        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total Pengguna</p>
                        <h3 class="text-2xl font-bold">1,248</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-users text-blue-500 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-500 text-sm mt-2"><i class="fas fa-arrow-up"></i> 12% dari bulan lalu</p>
            </div>
            
            <div class="stat-card bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total Buku</p>
                        <h3 class="text-2xl font-bold">5,367</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-book text-green-500 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-500 text-sm mt-2"><i class="fas fa-arrow-up"></i> 8% dari bulan lalu</p>
            </div>
            
            <div class="stat-card bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Peminjaman Aktif</p>
                        <h3 class="text-2xl font-bold">324</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-exchange-alt text-purple-500 text-xl"></i>
                    </div>
                </div>
                <p class="text-red-500 text-sm mt-2"><i class="fas fa-arrow-down"></i> 5% dari bulan lalu</p>
            </div>
            
            <div class="stat-card bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total Denda</p>
                        <h3 class="text-2xl font-bold">Rp 1.250.000</h3>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-money-bill-wave text-yellow-500 text-xl"></i>
                    </div>
                </div>
                <p class="text-red-500 text-sm mt-2"><i class="fas fa-arrow-up"></i> 15% dari bulan lalu</p>
            </div>
        </div>

        <!-- Charts dan Alert Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Chart Peminjaman Bulanan -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Peminjaman Bulanan</h3>
                    <select class="border border-gray-300 rounded-lg px-3 py-1 text-sm">
                        <option>Tahun 2025</option>
                        <option>Tahun 2024</option>
                        <option>Tahun 2023</option>
                        <option>Tahun 2022</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="loansChart"></canvas>
                </div>
            </div>
            
            <!-- System Alerts -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="font-bold text-lg mb-4">System Alerts</h3>
                <div class="space-y-4">
                    <div class="alert-item p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium">Buku Terlambat</h4>
                                <p class="text-sm text-gray-600">24 buku belum dikembalikan setelah jatuh tempo</p>
                                <a href="{{ route('admin.loans.index') }}" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Lihat detail</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-item p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-box-open text-blue-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium">Stok Habis</h4>
                                <p class="text-sm text-gray-600">18 buku sudah habis stoknya</p>
                                <a href="{{ route('admin.books.index') }}" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Kelola stok</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-item p-4 bg-purple-50 border-l-4 border-purple-500 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-book-open text-purple-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium">Peminjaman Aktif</h4>
                                <p class="text-sm text-gray-600">324 buku sedang dipinjam</p>
                                <a href="{{ route('admin.loans.index') }}" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Lihat semua</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-item p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-clock text-red-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium">Jatuh Tempo Segera</h4>
                                <p class="text-sm text-gray-600">15 buku akan jatuh tempo dalam 2 hari</p>
                                <a href="{{ route('admin.loans.index') }}" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Notifikasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8">
            <h3 class="font-bold text-lg mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.books.create') }}" class="bg-blue-600 text-white p-4 rounded-lg text-center hover:bg-blue-700 transition">
                    <i class="fas fa-plus text-2xl mb-2"></i>
                    <p class="font-medium">Tambah Buku</p>
                </a>
                <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white p-4 rounded-lg text-center hover:bg-green-700 transition">
                    <i class="fas fa-user-plus text-2xl mb-2"></i>
                    <p class="font-medium">Tambah User</p>
                </a>
                <a href="{{ route('admin.loans.index') }}" class="bg-purple-600 text-white p-4 rounded-lg text-center hover:bg-purple-700 transition">
                    <i class="fas fa-exchange-alt text-2xl mb-2"></i>
                    <p class="font-medium">Kelola Peminjaman</p>
                </a>
                <a href="{{ route('admin.fines.index') }}" class="bg-yellow-600 text-white p-4 rounded-lg text-center hover:bg-yellow-700 transition">
                    <i class="fas fa-money-bill-wave text-2xl mb-2"></i>
                    <p class="font-medium">Kelola Denda</p>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Users -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="font-bold text-lg mb-4">Pengguna Terbaru</h3>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <img src="https://ui-avatars.com/api/?name=Ahmad+Rizki&background=0D8ABC&color=fff" 
                            alt="User" class="w-10 h-10 rounded-full">
                        <div class="ml-3">
                            <p class="font-medium">Ahmad Rizki</p>
                            <p class="text-sm text-gray-500">Bergabung 2 jam lalu</p>
                        </div>
                        <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Mahasiswa</span>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <img src="https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=10B981&color=fff" 
                            alt="User" class="w-10 h-10 rounded-full">
                        <div class="ml-3">
                            <p class="font-medium">Siti Nurhaliza</p>
                            <p class="text-sm text-gray-500">Bergabung 1 hari lalu</p>
                        </div>
                        <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Pegawai</span>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=F59E0B&color=fff" 
                            alt="User" class="w-10 h-10 rounded-full">
                        <div class="ml-3">
                            <p class="font-medium">Budi Santoso</p>
                            <p class="text-sm text-gray-500">Bergabung 2 hari lalu</p>
                        </div>
                        <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Mahasiswa</span>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="block text-center text-blue-600 hover:text-blue-800 mt-4 font-medium">
                    Lihat Semua Pengguna
                </a>
            </div>

            <!-- Recent Loans -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="font-bold text-lg mb-4">Peminjaman Terbaru</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Machine Learning Fundamentals</p>
                            <p class="text-sm text-gray-500">Ahmad Rizki • 15 Nov 2025</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Data Science Handbook</p>
                            <p class="text-sm text-gray-500">Siti Nurhaliza • 14 Nov 2024</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Web Development Guide</p>
                            <p class="text-sm text-gray-500">Budi Santoso • 10 Nov 2024</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Akan Jatuh Tempo</span>
                    </div>
                </div>
                <a href="{{ route('admin.loans.index') }}" class="block text-center text-blue-600 hover:text-blue-800 mt-4 font-medium">
                    Lihat Semua Peminjaman
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center text-gray-500 text-sm py-4">
            <p>© 2025 Library Management System. All rights reserved.</p>
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
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#3b82f6',
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

        // Add active class to clicked nav item
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.nav-item').forEach(nav => {
                    nav.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>