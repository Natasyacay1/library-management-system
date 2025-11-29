<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;

class PegawaiDashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard pegawai
        $pendingLoans = Loan::where('status', 'pending')->count();
        $activeLoans = Loan::whereNull('returned_at')->count();
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'mahasiswa')->count();

        // Peminjaman pending untuk approval
        $pendingApprovals = Loan::with(['user', 'book'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Peminjaman aktif
        $activeBorrowings = Loan::with(['user', 'book'])
            ->whereNull('returned_at')
            ->orderBy('due_at', 'asc')
            ->take(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'pendingLoans',
            'activeLoans', 
            'totalBooks',
            'totalMembers',
            'pendingApprovals',
            'activeBorrowings'
        ));
    }

    public function approveLoan(Loan $loan)
    {
        $loan->update(['status' => 'approved']);
        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function rejectLoan(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);
        // Kembalikan stok buku
        $loan->book->increment('stock');
        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function manageLoans()
    {
        $loans = Loan::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pegawai.loans.index', compact('loans'));
    }
}