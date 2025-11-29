<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeLoans = Loan::with('book')
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->orderBy('borrowed_at', 'desc')
            ->get();

        $loanHistory = Loan::with('book')
            ->where('user_id', $user->id)
            ->orderBy('borrowed_at', 'desc')
            ->take(10)
            ->get();

        $unpaidFines = Loan::where('user_id', $user->id)
            ->where('fine', '>', 0)
            ->whereNull('returned_at')
            ->sum('fine');

        $recommendedBooks = Book::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'user',
            'activeLoans',
            'loanHistory', 
            'unpaidFines',
            'recommendedBooks'
        ));
    }

    public function history()
    {
        $user = Auth::user();

        $loans = Loan::with('book')
            ->where('user_id', $user->id)
            ->orderBy('borrowed_at', 'desc')
            ->paginate(10);

        return view('mahasiswa.loans.history', compact('loans', 'user'));
    }

    public function checkFines()
    {
        $user = Auth::user();
        
        // Karena struktur database menggunakan kolom 'fine' di tabel loans, 
        // kita hitung denda dari sana
        $loansWithFines = Loan::with('book')
            ->where('user_id', $user->id)
            ->where('fine', '>', 0)
            ->orderBy('borrowed_at', 'desc')
            ->get();

        $totalUnpaid = $loansWithFines->sum('fine');

        return view('mahasiswa.fines', compact('loansWithFines', 'totalUnpaid', 'user'));
    }

    public function borrow(Book $book)
    {
        $user = Auth::user();

        $hasUnpaidFines = Loan::where('user_id', $user->id)
            ->where('fine', '>', 0)
            ->whereNull('returned_at')
            ->exists();
            
        if ($hasUnpaidFines) {
            return back()->with('error', 'Anda masih memiliki denda tertunggak. Tidak dapat meminjam.');
        }

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        $existingLoan = Loan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereNull('returned_at')
            ->exists();
            
        if ($existingLoan) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(14),
            'fine' => 0,
        ]);

        $book->decrement('stock');

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('success', 'Buku berhasil dipinjam! Jatuh tempo: ' . now()->addDays(14)->format('d M Y'));
    }

    public function extend(Loan $loan)
    {
        $user = Auth::user();

        if ($loan->user_id !== $user->id) {
            abort(403);
        }

        if ($loan->returned_at) {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        if (now()->greaterThan($loan->due_at)) {
            return back()->with('error', 'Tidak bisa memperpanjang karena sudah lewat jatuh tempo.');
        }

        $loan->update([
            'due_at' => $loan->due_at->addDays(7)
        ]);

        return back()->with('success', 'Peminjaman berhasil diperpanjang 7 hari.');
    }

    public function booksCatalog()
    {
        $user = Auth::user();
        $books = Book::where('stock', '>', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(12);

    return view('mahasiswa.books.index', compact('books', 'user'));
}
    public function profile()
    {
        $user = Auth::user();
        
        $totalLoans = Loan::where('user_id', $user->id)->count();
        $activeLoans = Loan::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->count();
        $totalFines = Loan::where('user_id', $user->id)
            ->where('fine', '>', 0)
            ->whereNull('returned_at')
            ->sum('fine');

        return view('mahasiswa.profile', compact('user', 'totalLoans', 'activeLoans', 'totalFines'));
    }

    public function returnBook(Loan $loan)
{
    $user = Auth::user();

    if ($loan->user_id !== $user->id) {
        abort(403);
    }

    if ($loan->returned_at) {
        return back()->with('error', 'Buku sudah dikembalikan.');
    }

    $fine = 0;
    if (now()->greaterThan($loan->due_at)) {
        $daysLate = now()->diffInDays($loan->due_at);
        $fine = $daysLate * 5000;
    }

    $loan->update([
        'returned_at' => now(),
        'fine' => $fine
    ]);

    $loan->book->increment('stock');

    $message = 'Buku berhasil dikembalikan.';
    if ($fine > 0) {
        $message .= ' Denda: Rp ' . number_format($fine, 0, ',', '.');
    }

    return back()->with('success', $message);
} 
}
