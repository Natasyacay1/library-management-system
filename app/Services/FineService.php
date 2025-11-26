<?php

namespace App\Services;

use App\Models\Fine;
use App\Models\User;
use App\Models\Loan;

class FineService
{
    public function createFine(User $user, Loan $loan, $amount, $reason = 'Denda keterlambatan')
    {
        // Validate amount
        if ($amount <= 0) {
            throw new \Exception('Amount denda harus lebih dari 0.');
        }

        // Create fine record
        $fine = Fine::create([
            'user_id' => $user->id,
            'loan_id' => $loan->id,
            'amount' => $amount,
            'reason' => $reason,
            'status' => Fine::STATUS_PENDING,
        ]);

        // Update user's fines balance
        $user->fines_balance += $amount;
        $user->save();

        return $fine;
    }

    public function processPayment(User $user, $amount)
    {
        if ($amount <= 0) {
            throw new \Exception('Amount pembayaran harus lebih dari 0.');
        }

        if ($amount > $user->fines_balance) {
            throw new \Exception('Amount pembayaran melebihi total denda.');
        }

        // Get pending fines
        $pendingFines = $user->fines()->pending()->orderBy('created_at')->get();
        $remainingAmount = $amount;

        foreach ($pendingFines as $fine) {
            if ($remainingAmount <= 0) break;

            if ($fine->amount <= $remainingAmount) {
                // Pay full fine
                $fine->markAsPaid();
                $remainingAmount -= $fine->amount;
            } else {
                // Partial payment - create new fine record for remaining amount
                $this->createFine(
                    $user, 
                    $fine->loan, 
                    $fine->amount - $remainingAmount, 
                    $fine->reason . ' (sisa)'
                );
                
                $fine->update(['amount' => $remainingAmount]);
                $fine->markAsPaid();
                $remainingAmount = 0;
            }
        }

        return [
            'paid_amount' => $amount,
            'remaining_balance' => $user->fresh()->fines_balance,
        ];
    }

    public function calculateTotalFines(User $user)
    {
        return [
            'total_fines' => $user->fines_balance,
            'pending_fines' => $user->fines()->pending()->sum('amount'),
            'paid_fines' => $user->fines()->where('status', Fine::STATUS_PAID)->sum('amount'),
        ];
    }

    public function waiveFine(Fine $fine, $reason = 'Pengampunan admin')
    {
        if ($fine->isPaid()) {
            throw new \Exception('Denda sudah dibayar.');
        }

        // Update user's fines balance
        $fine->user->fines_balance = max(0, $fine->user->fines_balance - $fine->amount);
        $fine->user->save();

        // Mark fine as paid with waiver reason
        $fine->update([
            'status' => Fine::STATUS_PAID,
            'reason' => $fine->reason . ' (dihapus: ' . $reason . ')',
        ]);

        return $fine;
    }

    public function checkOverdueFines()
    {
        // Find fines that are overdue (pending for more than 30 days)
        $overdueFines = Fine::pending()
                           ->where('created_at', '<', now()->subDays(30))
                           ->get();

        foreach ($overdueFines as $fine) {
            $fine->update(['status' => Fine::STATUS_OVERDUE]);
        }

        return $overdueFines->count();
    }

    public function getUserFineHistory(User $user, $limit = 10)
    {
        return $user->fines()
                   ->with('loan.book')
                   ->orderBy('created_at', 'desc')
                   ->paginate($limit);
    }
}