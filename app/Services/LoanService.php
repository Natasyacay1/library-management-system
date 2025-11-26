<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanService
{
    public function createLoan(User $user, Book $book, $loanDays = 7)
    {
        if (!$book->isAvailable()) {
            throw new \Exception('Buku tidak tersedia untuk dipinjam.');
        }

        if (!$user->canBorrowBooks()) {
            throw new \Exception('User tidak dapat meminjam buku karena denda atau blokir.');
        }

        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays($loanDays),
            'status' => Loan::STATUS_BORROWED,
            'is_extended' => false,
        ]);

        $book->decreaseStock();

        return $loan;
    }

    public function processReturn(Loan $loan)
    {
        if ($loan->status !== Loan::STATUS_BORROWED) {
            throw new \Exception('Buku sudah dikembalikan.');
        }

        $fineAmount = $loan->calculateFine();
        $loan->markAsReturned();
        if ($fineAmount > 0) {
            $loan->user->fines_balance += $fineAmount;
            $loan->user->save();
        }

        return $fineAmount;
    }

    public function extendLoan(Loan $loan, $extensionDays = 7)
    {
        if (!$loan->canBeExtended()) {
            throw new \Exception('Peminjaman tidak dapat diperpanjang.');
        }

        return $loan->extendLoan($extensionDays);
    }

    public function checkOverdueLoans()
    {
        $overdueLoans = Loan::overdue()->get();
        
        foreach ($overdueLoans as $loan) {
            $loan->update(['status' => Loan::STATUS_OVERDUE]);
        }

        return $overdueLoans->count();
    }

    public function getUserLoanStats(User $user)
    {
        return [
            'active_loans' => $user->activeLoans()->count(),
            'total_loans' => $user->loans()->count(),
            'overdue_loans' => $user->loans()->overdue()->count(),
            'can_borrow' => $user->canBorrowBooks(),
        ];
    }

    public function getLoanEligibility(User $user, Book $book)
    {
        $maxLoans = 5; 
        $eligibility = [
            'can_borrow' => true,
            'reasons' => [],
        ];

        if (!$user->canBorrowBooks()) {
            $eligibility['can_borrow'] = false;
            if ($user->hasOverdueFines()) {
                $eligibility['reasons'][] = 'Memiliki denda tertunggak sebesar Rp ' . number_format($user->fines_balance, 0, ',', '.');
            }
            if ($user->is_blocked) {
                $eligibility['reasons'][] = 'Akun sedang diblokir';
            }
        }

        if (!$book->isAvailable()) {
            $eligibility['can_borrow'] = false;
            $eligibility['reasons'][] = 'Buku tidak tersedia';
        }


        if ($user->activeLoans()->count() >= $maxLoans) {
            $eligibility['can_borrow'] = false;
            $eligibility['reasons'][] = "Sudah meminjam {$user->activeLoans()->count()} buku (maksimal: $maxLoans)";
        }

        $existingLoan = $user->activeLoans()->where('book_id', $book->id)->exists();
        if ($existingLoan) {
            $eligibility['can_borrow'] = false;
            $eligibility['reasons'][] = 'Sudah meminjam buku ini';
        }

        return $eligibility;
    }
}