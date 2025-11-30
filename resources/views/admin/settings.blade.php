@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')
@section('page-description', 'Kelola pengaturan sistem perpustakaan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Settings -->
    <div class="lg:col-span-2 space-y-6">
        <!-- General Settings -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Pengaturan Umum</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Perpustakaan
                        </label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="Perpustakaan Digital">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Maksimal Hari Peminjaman
                        </label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="7">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Batas Peminjaman per User
                        </label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="5">
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Denda per Hari (Rp)
                        </label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="2000">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Batas Peringatan Jatuh Tempo (hari)
                        </label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Masa Tenggang Pengembalian (hari)
                        </label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="3">
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Pengaturan Notifikasi</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">Notifikasi Email</p>
                        <p class="text-sm text-gray-600">Kirim notifikasi via email kepada pengguna</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">Notifikasi Jatuh Tempo</p>
                        <p class="text-sm text-gray-600">Kirim pengingat sebelum buku jatuh tempo</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">Notifikasi Stok Habis</p>
                        <p class="text-sm text-gray-600">Kirim alert ketika stok buku habis</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">Notifikasi Buku Baru</p>
                        <p class="text-sm text-gray-600">Kirim pemberitahuan ketika ada buku baru</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Sistem</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-database text-blue-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Versi Sistem</p>
                        <p class="font-medium text-gray-800">v2.1.0</p>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <i class="fas fa-calendar text-green-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Terakhir Update</p>
                        <p class="font-medium text-gray-800">30 Nov 2025</p>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                    <i class="fas fa-users text-purple-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Total Pengguna</p>
                        <p class="font-medium text-gray-800">1,248</p>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                    <i class="fas fa-book text-yellow-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Total Buku</p>
                        <p class="font-medium text-gray-800">5,367</p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-red-50 rounded-lg">
                    <i class="fas fa-exchange-alt text-red-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Peminjaman Aktif</p>
                        <p class="font-medium text-gray-800">324</p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-indigo-50 rounded-lg">
                    <i class="fas fa-money-bill-wave text-indigo-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Total Denda</p>
                        <p class="font-medium text-gray-800">Rp 1.250.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Save Settings -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Aksi</h3>
            <div class="space-y-3">
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                </button>
                <button class="w-full bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition font-medium flex items-center justify-center">
                    <i class="fas fa-undo mr-2"></i> Reset ke Default
                </button>
                <button class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-medium flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i> Backup Data
                </button>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Statistik Cepat</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-2">
                    <span class="text-gray-600">Pengguna Aktif</span>
                    <span class="font-medium text-green-600">1,024</span>
                </div>
                <div class="flex justify-between items-center p-2">
                    <span class="text-gray-600">Peminjaman Hari Ini</span>
                    <span class="font-medium text-blue-600">24</span>
                </div>
                <div class="flex justify-between items-center p-2">
                    <span class="text-gray-600">Buku Terlambat</span>
                    <span class="font-medium text-red-600">8</span>
                </div>
                <div class="flex justify-between items-center p-2">
                    <span class="text-gray-600">Denda Belum Bayar</span>
                    <span class="font-medium text-yellow-600">Rp 450.000</span>
                </div>
                <div class="flex justify-between items-center p-2">
                    <span class="text-gray-600">Buku Populer</span>
                    <span class="font-medium text-purple-600">12</span>
                </div>
            </div>
        </div>

        <!-- System Health -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Kesehatan Sistem</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Penggunaan Server</span>
                        <span class="text-sm font-medium text-gray-800">65%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Penyimpanan Database</span>
                        <span class="text-sm font-medium text-gray-800">42%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 42%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Memori Sistem</span>
                        <span class="text-sm font-medium text-gray-800">78%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Kapasitas Backup</span>
                        <span class="text-sm font-medium text-gray-800">35%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 35%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Aktivitas Terbaru</h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="bg-green-100 p-2 rounded-full mr-3">
                        <i class="fas fa-user-plus text-green-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">User baru terdaftar</p>
                        <p class="text-xs text-gray-500">2 menit lalu</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <i class="fas fa-book text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Buku baru ditambahkan</p>
                        <p class="text-xs text-gray-500">1 jam lalu</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-purple-100 p-2 rounded-full mr-3">
                        <i class="fas fa-exchange-alt text-purple-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Peminjaman disetujui</p>
                        <p class="text-xs text-gray-500">3 jam lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Danger Zone -->
<div class="mt-6 bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
    <h3 class="text-lg font-semibold mb-4 text-gray-800">Zona Berbahaya</h3>
    <p class="text-sm text-gray-600 mb-4">Tindakan ini tidak dapat dibatalkan. Hanya lakukan jika Anda yakin.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <button class="bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition font-medium flex items-center justify-center">
            <i class="fas fa-trash mr-2"></i> Hapus Semua Data
        </button>
        <button class="bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition font-medium flex items-center justify-center">
            <i class="fas fa-sync mr-2"></i> Reset Sistem
        </button>
        <button class="bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition font-medium flex items-center justify-center">
            <i class="fas fa-ban mr-2"></i> Nonaktifkan Sistem
        </button>
    </div>
</div>
@endsection