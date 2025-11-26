<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Services\LoanService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    protected $loanService;
    protected $notificationService;

    public function __construct(LoanService $loanService, NotificationService $notificationService)
    {
        $this->loanService = $loanService;
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $user = Auth::user();
        $loans = Loan::with('book')
                    ->forUser($user->id)
                    ->recent()
                    ->paginate(10);
        
        return view('student.loans.index', compact('loans'));
    }

    public function history()
    {
        $user = Auth::user();
        $loans = Loan::with('book')
                    ->forUser($user->id)
                    ->where('status', 'returned')
                    ->recent()
                    ->paginate(10);
        
        return view('student.loans.history', compact('loans'));
    }

    public function borrow(Book $book)
    {
        $user = Auth::user();
        
        if (!$user->canBorrowBooks()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat meminjam buku karena memiliki denda atau akun diblokir.');
        }
        
        if (!$book->isAvailable()) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        $loan = $this->loanService->createLoan($user, $book, $book->max_loan_days);
        $this->notificationService->sendLoanConfirmation($user, $loan);
        
        return redirect()->route('student.loans.index')
            ->with('success', 'Buku berhasil dipinjam. Jatuh tempo: ' . $loan->due_date->format('d M Y'));
    }

    public function renew(Loan $loan)
    {
        $user = Auth::user();

        if ($loan->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        
        if (!$loan->canBeExtended()) {
            return redirect()->back()->with('error', 'Peminjaman tidak dapat diperpanjang.');
        }
        
        if ($this->loanService->extendLoan($loan)) {
            $this->notificationService->sendLoanConfirmation($user, $loan);
            
            return redirect()->back()
                ->with('success', 'Peminjaman berhasil diperpanjang hingga ' . $loan->due_date->format('d M Y'));
        }
        
        return redirect()->back()->with('error', 'Gagal memperpanjang peminjaman.');
    }
}