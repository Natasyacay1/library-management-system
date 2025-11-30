# 📚 Sistem Manajemen Perpustakaan Digital

Sistem manajemen perpustakaan digital berbasis web yang dibangun dengan Laravel framework. Mendukung multi-role user (Admin, Pegawai, Mahasiswa) dengan fitur lengkap untuk mengelola koleksi buku, peminjaman, dan ulasan.

## 🚀 Fitur Utama

### 👨‍💼 Role Admin
- **Dashboard** admin dengan statistik lengkap
- **Manajemen User** - kelola semua pengguna
- **Manajemen Buku** - CRUD lengkap koleksi buku
- **Manajemen Peminjaman** - approve/reject/tracking
- **Kelola Denda** - sistem denda otomatis
- **Manajemen Review** - moderasi ulasan buku
- **Notifikasi Sistem** - kirim notifikasi massal

### 👨‍💻 Role Pegawai
- **Dashboard** dengan overview peminjaman
- **Approve/Reject** permintaan peminjaman
- **Kelola Buku** - tambah dan edit koleksi
- **Tracking Peminjaman** - monitor status buku
- **Kelola Denda** - hitung dan kelola keterlambatan
- **Lihat Review** - monitor ulasan pembaca

### 🎓 Role Mahasiswa
- **Dashboard** personal dengan riwayat
- **Peminjaman Buku** - ajukan pinjam buku
- **Katalog Buku** - jelajahi koleksi
- **Sistem Rating & Review** - beri ulasan buku
- **Riwayat Peminjaman** - lihat history
- **Notifikasi** - dapatkan pemberitahuan
- **Kelola Profil** - update data pribadi

## 🛠 Teknologi yang Digunakan

- **Backend**: Laravel 10.x
- **Frontend**: Tailwind CSS, Blade Templates
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Icons**: Font Awesome 6
- **Fonts**: Inter Font Family

## 📦 Instalasi dan Setup

### Prerequisites
- PHP 8.0+
- Composer
- MySQL 5.7+
- Node.js & NPM

### Step-by-Step Installation

1. **Clone Repository**
```bash
git clone [repository-url]
cd library-management-system
Install Dependencies

bash
composer install
npm install
Setup Environment

bash
cp .env.example .env
php artisan key:generate
Konfigurasi Database
Edit file .env:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=root
DB_PASSWORD=
Jalankan Migration & Seeder

bash
php artisan migrate --seed
Build Assets

bash
npm run build
Jalankan Server

bash
php artisan serve
Akses aplikasi di: http://localhost:8000

👥 Default User Accounts
Admin
Email: admin@perpus.com

Password: password

Role: admin

Pegawai
Email: pegawai@perpus.com

Password: password

Role: pegawai

Mahasiswa
Email: mahasiswa@perpus.com

Password: password

Role: mahasiswa

🗂 Struktur Project
text
library-management-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminDashboardController.php
│   │   ├── PegawaiDashboardController.php
│   │   └── MahasiswaDashboardController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Book.php
│   │   ├── Loan.php
│   │   ├── Review.php
│   │   └── Notification.php
│   └── Services/
│       └── NotificationService.php
├── resources/views/
│   ├── admin/
│   ├── pegawai/
│   │   ├── dashboard.blade.php
│   │   ├── books/
│   │   ├── loans/
│   │   ├── fines/
│   │   └── reviews/
│   └── mahasiswa/
├── routes/
│   └── web.php
└── database/
    ├── migrations/
    └── seeders/
🔧 Fitur Khusus
Sistem Rating & Review
Rating 1-5 bintang

Komentar ulasan

Satu user satu review per buku

Average rating otomatis

Notifikasi Real-time
Bell notification di navbar

Jenis: due reminder, overdue, new book, system

Mark as read functionality

Auto-cleanup old notifications

Automation Commands
bash
# Pengingat jatuh tempo
php artisan notifications:send-due-reminders

# Notifikasi keterlambatan  
php artisan notifications:send-overdue-alerts

# Cleanup notifikasi lama
php artisan notifications:cleanup
Middleware & Authorization
Role-based access control

Custom middleware: role:admin, role:pegawai, role:mahasiswa

Policy untuk Review & Notification

🚀 Cara Menjalankan
Development Mode
bash
php artisan serve
npm run dev
Production Mode
bash
php artisan config:cache
php artisan route:cache  
php artisan view:cache
npm run build
Scheduled Tasks (Cron Jobs)
Tambahkan ke crontab:

bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
📊 Database Schema
Tables:
users - Data pengguna dengan role

books - Koleksi buku

loans - Data peminjaman

reviews - Rating dan ulasan

notifications - Sistem notifikasi

Relationships:
User → Loans (One to Many)

Book → Loans (One to Many)

User → Reviews (One to Many)

Book → Reviews (One to Many)

User → Notifications (One to Many)

🐛 Troubleshooting
Common Issues:
View not found error

bash
php artisan cache:clear
php artisan view:clear
Route not defined

bash
php artisan route:clear
php artisan route:list
Class not found

bash
composer dump-autoload
Migration error

bash
php artisan migrate:fresh --seed

🤝 Kontribusi
Fork repository

Create feature branch (git checkout -b feature/AmazingFeature)

Commit changes (git commit -m 'Add some AmazingFeature')

Push to branch (git push origin feature/AmazingFeature)

Open Pull Request

📄 License
Project ini menggunakan lisensi MIT - lihat file LICENSE untuk detail.

👨‍💻 Author
Natasya Bokek

💡 Tips: Untuk development, pastikan menjalankan php artisan serve dan npm run dev secara bersamaan untuk hot-reload.

📞 Support: Jika mengalami masalah, buka issue di repository atau hubungi developer.

🔄 Update Terakhir: December 2024

Sistem Perpustakaan Digital - Modern, Efisien, dan User-Friendly

