<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Loan;
use App\Models\Fine;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendLoanConfirmation(User $user, Loan $loan)
    {
        $notification = NotificationService::createLoanReminder($user->id, $loan);
        return $notification;
    }

    public function sendReturnConfirmation(User $user, Loan $loan)
    {
        $notification = NotificationService::create([
            'user_id' => $user->id,
            'type' => NotificationService::TYPE_RETURN_CONFIRMATION,
            'title' => 'Konfirmasi Pengembalian Buku',
            'message' => "Buku '{$loan->book->title}' telah berhasil dikembalikan.",
            'data' => ['loan_id' => $loan->id, 'book_title' => $loan->book->title],
        ]);

        return $notification;
    }

    public function sendFineNotification(User $user, Fine $fine)
    {
        $notification = NotificationService::createFineNotification($user->id, $fine);
        return $notification;
    }

    public function sendLoanReminders()
    {
        $dueSoonLoans = Loan::where('due_date', '<=', now()->addDay())
                        ->where('due_date', '>', now())
                        ->where('status', Loan::STATUS_BORROWED)
                        ->with(['user', 'book'])
                        ->get();

        $sentCount = 0;

        foreach ($dueSoonLoans as $loan) {
            $this->sendDueSoonReminder($loan->user, $loan);
            $sentCount++;
        }

        return $sentCount;
    }

    public function sendDueSoonReminder(User $user, Loan $loan)
    {
        $daysUntilDue = now()->diffInDays($loan->due_date, false);

        if ($daysUntilDue >= 0) {
            $message = $daysUntilDue == 0 
                ? "Buku '{$loan->book->title}' jatuh tempo hari ini!" 
                : "Buku '{$loan->book->title}' akan jatuh tempo dalam {$daysUntilDue} hari.";

            return NotificationService::create([
                'user_id' => $user->id,
                'type' => NotificationService::TYPE_LOAN_REMINDER,
                'title' => 'Pengingat Jatuh Tempo',
                'message' => $message,
                'data' => ['loan_id' => $loan->id, 'due_date' => $loan->due_date],
            ]);
        }

        return null;
    }

    public function sendOverdueNotifications()
    {
        $overdueLoans = Loan::overdue()
                        ->with(['user', 'book'])
                        ->get();

        $sentCount = 0;

        foreach ($overdueLoans as $loan) {
            $this->sendOverdueNotification($loan->user, $loan);
            $sentCount++;
        }

        return $sentCount;
    }

    public function sendOverdueNotification(User $user, Loan $loan)
    {
        $overdueDays = $loan->getDaysOverdue();
        $fineAmount = $loan->calculateFine();

        return NotificationService::create([
            'user_id' => $user->id,
            'type' => NotificationService::TYPE_FINE_NOTIFICATION,
            'title' => 'Buku Terlambat Dikembalikan',
            'message' => "Buku '{$loan->book->title}' terlambat {$overdueDays} hari. Denda: Rp " . number_format($fineAmount, 0, ',', '.'),
            'data' => [
                'loan_id' => $loan->id, 
                'overdue_days' => $overdueDays,
                'fine_amount' => $fineAmount
            ],
        ]);
    }

    public function sendSystemAnnouncement($userIds, $title, $message)
    {
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }

        $sentCount = 0;

        foreach ($userIds as $userId) {
            NotificationService::create([
                'user_id' => $userId,
                'type' => NotificationService::TYPE_SYSTEM_ANNOUNCEMENT,
                'title' => $title,
                'message' => $message,
                'data' => ['announcement' => true],
            ]);
            $sentCount++;
        }

        return $sentCount;
    }

    public function getUserUnreadCount(User $user)
    {
        return NotificationService::forUser($user->id)->unread()->count();
    }

    public function markAllAsRead(User $user)
    {
        return NotificationService::forUser($user->id)
                        ->unread()
                        ->update(['is_read' => true, 'read_at' => now()]);
    }
}