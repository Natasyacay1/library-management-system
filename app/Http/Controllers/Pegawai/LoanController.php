<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use App\Services\LoanService;
use App\Services\FineService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanService;
    protected $fineService;
    protected $notificationService;

    public function __construct(
        LoanService $loanService, 
        FineService $fineService,
        NotificationService $notificationService
    ) {
        $this->loanService = $loanService;
        $this->fineService = $fineService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Loan::with(['user', 'book']);
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        
        $loans = $query->recent()->paginate(15);
        
        return view('staff.loans.index', compact('loans'));
    }

    public function processLoan(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_days' => 'required|integer|min:1|max:30',
        ]);

        $user = User::find($validated['user_id']);
        $book = Book::find($validated['book_id']);

        if (!$user->isStudent()) {
            return redirect()->back()
                ->with('error', 'Hanya mahasiswa yang dapat meminjam buku.');
        }

        if (!$user->canBorrowBooks()) {
            return redirect()->back()
                ->with('error', 'User tidak dapat meminjam buku karena denda atau blokir.');
        }

        if (!$book->isAvailable()) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        $loan = $this->loanService->createLoan($user, $book, $validated['loan_days']);
        $this->notificationService->sendLoanConfirmation($user, $loan);

        return redirect()->route('staff.loans.index')
            ->with('success', 'Peminjaman berhasil diproses.');
    }

    public function processReturn(Loan $loan)
    {
        if ($loan->status !== 'borrowed') {
            return redirect()->back()
                ->with('error', 'Buku sudah dikembalikan.');
        }

        $fineAmount = $this->loanService->processReturn($loan);
        
        if ($fineAmount > 0) {
            $fine = $this->fineService->createFine(
                $loan->user, 
                $loan, 
                $fineAmount, 
                'Denda keterlambatan pengembalian buku'
            );

            $this->notificationService->sendFineNotification($loan->user, $fine);
            return redirect()->route('staff.loans.index')
                ->with('warning', "Buku berhasil dikembalikan dengan denda Rp " . number_format($fineAmount, 0, ',', '.'));
        }

        $this->notificationService->sendReturnConfirmation($loan->user, $loan)
        return redirect()->route('staff.loans.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }

    public function show(Loan $loan)
    {
        $loan->load(['user', 'book', 'fine']);
        return view('staff.loans.show', compact('loan'));
    }
}