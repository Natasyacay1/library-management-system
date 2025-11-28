<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    // Mahasiswa: pinjam buku
    public function borrow(Book $book)
    {
        $user = auth()->user();

        if ($user->hasUnpaidFines()) {
            return back()->withErrors('Anda masih memiliki denda tertunggak.');
        }

        if ($book->stock < 1) {
            return back()->withErrors('Stok buku habis.');
        }

        DB::transaction(function () use ($book, $user) {
            $borrowedAt = now();
            $dueAt = now()->addDays($book->max_loan_days);

            Loan::create([
                'user_id'     => $user->id,
                'book_id'     => $book->id,
                'borrowed_at' => $borrowedAt,
                'due_at'      => $dueAt,
                'fine'        => 0,
            ]);

            $book->decrement('stock');
        });

        return back()->with('status', 'Buku berhasil dipinjam.');
    }

    // Pegawai: konfirmasi pengembalian
    public function return(Loan $loan)
    {
        if ($loan->returned_at) {
            return back()->withErrors('Buku ini sudah dikembalikan.');
        }

        $loan->returned_at = now();

        // Hitung denda sederhana (boleh diubah nanti)
        if ($loan->returned_at->greaterThan($loan->due_at)) {
            $daysLate = $loan->returned_at->diffInDays($loan->due_at);
            $loan->fine = $daysLate * ($loan->book->daily_fine ?? 0);
        }

        $loan->save();

        // kembalikan stok
        $loan->book->increment('stock');

        return back()->with('status', 'Pengembalian buku dikonfirmasi.');
    }

    // Mahasiswa: riwayat peminjaman
    public function history()
    {
        $loans = Loan::where('user_id', auth()->id())
            ->with('book')
            ->orderBy('borrowed_at', 'desc')
            ->get();

        return view('mahasiswa.loans.history', compact('loans'));
    }
}
