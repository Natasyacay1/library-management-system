<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PegawaiDashboardController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\BookManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LoanController;

Route::get('/', [BookController::class, 'homepage'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin())   return app(AdminDashboardController::class)->index();
        if ($user->isPegawai()) return app(PegawaiDashboardController::class)->index();
        if ($user->isMahasiswa()) return app(MahasiswaDashboardController::class)->index();
        abort(403);
    })->name('dashboard');

    // Admin
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::resource('users', UserManagementController::class)->names('admin.users');
        Route::resource('books', BookManagementController::class)->names('admin.books');
    });

    // Pegawai
    Route::middleware('pegawai')->prefix('pegawai')->group(function () {
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('pegawai.dashboard');
        Route::get('/books', [BookManagementController::class, 'index'])->name('pegawai.books.index');
    });

    // Mahasiswa
    Route::middleware(['mahasiswa', 'fine'])->prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('mahasiswa.dashboard');
        Route::get('/loans/history', [MahasiswaDashboardController::class, 'loanHistory'])->name('mahasiswa.loans.history');
        Route::post('/books/{book}/borrow', [LoanController::class, 'borrow'])->name('mahasiswa.books.borrow');
        Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('mahasiswa.loans.return');
    });

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});
