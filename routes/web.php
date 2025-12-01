<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PegawaiDashboardController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\BookManagementController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;

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
Route::get('/books', [BookController::class, 'index'])->name('books.catalog');
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

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION ROUTES - Untuk semua role yang terautentikasi
    |--------------------------------------------------------------------------
    */
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::get('/recent', [NotificationController::class, 'getRecent'])->name('recent');
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
    });

    /*
    |--------------------------------------------------------------------------
    | REVIEW ROUTES - Hanya untuk mahasiswa
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });
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

        // Loans Management
        Route::get('/loans', [AdminDashboardController::class, 'loans'])->name('loans.index');
        Route::post('/loans/{loan}/approve', [AdminDashboardController::class, 'approveLoan'])->name('loans.approve');
        Route::post('/loans/{loan}/reject', [AdminDashboardController::class, 'rejectLoan'])->name('loans.reject');
        Route::post('/loans/{loan}/return', [AdminDashboardController::class, 'returnBook'])->name('loans.return');

        // Fines Management - Perbaiki parameter menjadi loan
        Route::get('/fines', [AdminDashboardController::class, 'fines'])->name('fines.index');
        Route::post('/fines/{loan}/pay', [AdminDashboardController::class, 'markAsPaid'])->name('fines.pay');

        // Reviews Management (Admin bisa lihat dan hapus review)
        Route::get('/reviews', [AdminDashboardController::class, 'reviews'])->name('reviews.index');
        Route::delete('/reviews/{review}', [AdminDashboardController::class, 'deleteReview'])->name('reviews.destroy');

        // Notifications Management
        Route::get('/notifications', [AdminDashboardController::class, 'notifications'])->name('notifications.index');
        Route::post('/notifications/send-bulk', [AdminDashboardController::class, 'sendBulkNotification'])->name('notifications.send-bulk');

        // Settings
        Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
    });


/*
|--------------------------------------------------------------------------
| PEGAWAI ROUTES - DIPERBAIKI (TAMBAH ROUTE EDIT/UPDATE/DELETE)
|--------------------------------------------------------------------------
*/
Route::prefix('pegawai')
    ->name('pegawai.')
    ->middleware(['auth', 'role:pegawai'])
    ->group(function () {

        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])
            ->name('dashboard');

        // Books Management - FULL CRUD
        Route::get('/books', [PegawaiDashboardController::class, 'books'])->name('books.index');
        Route::get('/books/create', [PegawaiDashboardController::class, 'createBook'])->name('books.create');
        Route::post('/books', [PegawaiDashboardController::class, 'storeBook'])->name('books.store');
        
        // TAMBAHAN: Route untuk edit, update, dan delete
        Route::get('/books/{book}/edit', [PegawaiDashboardController::class, 'editBook'])->name('books.edit');
        Route::put('/books/{book}', [PegawaiDashboardController::class, 'updateBook'])->name('books.update');
        Route::delete('/books/{book}', [PegawaiDashboardController::class, 'destroyBook'])->name('books.destroy');

        // Loans Management
        Route::get('/loans', [PegawaiDashboardController::class, 'loans'])->name('loans.index');
        Route::post('/loans/{loan}/approve', [PegawaiDashboardController::class, 'approveLoan'])
            ->name('loans.approve');
        Route::post('/loans/{loan}/reject', [PegawaiDashboardController::class, 'rejectLoan'])
            ->name('loans.reject');
        Route::post('/loans/{loan}/return', [PegawaiDashboardController::class, 'returnBook'])
            ->name('loans.return');

        // Reviews Management (Pegawai bisa lihat review)
        Route::get('/reviews', [PegawaiDashboardController::class, 'reviews'])->name('reviews.index');

        // Fines Management
        Route::get('/fines', [PegawaiDashboardController::class, 'fines'])->name('fines.index');
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

        // Reviews & Ratings (Mahasiswa)
        Route::get('/reviews', [MahasiswaDashboardController::class, 'myReviews'])
            ->name('reviews.my-reviews');

        // Notifications (Mahasiswa)
        Route::get('/notifications', [MahasiswaDashboardController::class, 'notifications'])
            ->name('notifications.index');
    });


/*
|--------------------------------------------------------------------------
| PUBLIC REVIEW ROUTES - Bisa diakses tanpa login untuk melihat review
|--------------------------------------------------------------------------
*/
Route::get('/books/{book}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/latest', [ReviewController::class, 'latest'])->name('reviews.latest');


/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE - Untuk handle 404
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});