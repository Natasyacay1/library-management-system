<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PegawaiDashboardController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\BookManagementController;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| Guest Homepage
|--------------------------------------------------------------------------
*/
Route::get('/', [BookController::class, 'homepage'])->name('home');

/*
|--------------------------------------------------------------------------
| Guest Katalog
|--------------------------------------------------------------------------
*/
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');


/*
|--------------------------------------------------------------------------
| Authentication (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Dashboard Redirect by Role
|--------------------------------------------------------------------------
| Setelah login, user langsung diarahkan sesuai role:
| admin -> /admin/dashboard
| pegawai -> /pegawai/dashboard
| mahasiswa -> /mahasiswa/dashboard
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'pegawai'   => redirect()->route('pegawai.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default     => redirect()->route('home'),
        };
    })->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // User Management
        Route::resource('users', UserManagementController::class);

        // Book Management
        Route::resource('books', BookManagementController::class);
    });


/*
|--------------------------------------------------------------------------
| PEGAWAI ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('pegawai')
    ->name('pegawai.')
    ->middleware(['auth', 'role:pegawai'])
    ->group(function () {

        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])
            ->name('dashboard');

        // Approve/Reject Loans
        Route::post('/loans/{loan}/approve', [PegawaiDashboardController::class, 'approveLoan'])
            ->name('loans.approve');
            
        Route::post('/loans/{loan}/reject', [PegawaiDashboardController::class, 'rejectLoan'])
            ->name('loans.reject');
    });


/*
|--------------------------------------------------------------------------
| MAHASISWA ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])
            ->name('dashboard');

        // History Peminjaman
        Route::get('/loans/history', [MahasiswaDashboardController::class, 'history'])
            ->name('loans.history');

        // Profile Mahasiswa
        Route::get('/profile', [MahasiswaDashboardController::class, 'profile'])
            ->name('profile');

        // Pinjam Buku
        Route::post('/books/{book}/borrow', [MahasiswaDashboardController::class, 'borrow'])
            ->name('books.borrow');

        // Perpanjang Peminjaman
        Route::post('/loans/{loan}/extend', [MahasiswaDashboardController::class, 'extend'])
            ->name('loans.extend');

        // Kembalikan Buku
        Route::post('/loans/{loan}/return', [MahasiswaDashboardController::class, 'returnBook'])
            ->name('loans.return');

        // Lihat Denda
        Route::get('/fines', [MahasiswaDashboardController::class, 'checkFines'])
            ->name('fines');

        // Katalog Buku untuk Mahasiswa
        Route::get('/books', [MahasiswaDashboardController::class, 'booksCatalog'])
            ->name('books.index');
    });