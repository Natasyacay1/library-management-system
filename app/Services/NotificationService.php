<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Book;

class NotificationService
{
    public static function sendLoanDueReminder()
    {
        $loansDueSoon = Loan::where('due_at', '<=', Carbon::now()->addDays(2))
            ->where('due_at', '>', Carbon::now())
            ->whereNull('returned_at')
            ->with('user')
            ->get();

        foreach ($loansDueSoon as $loan) {
            Notification::create([
                'user_id' => $loan->user_id,
                'type' => 'loan_due_soon',
                'title' => 'Pengingat Jatuh Tempo',
                'message' => "Buku '{$loan->book->title}' akan jatuh tempo pada {$loan->due_at->format('d M Y')}",
                'data' => [
                    'loan_id' => $loan->id,
                    'book_title' => $loan->book->title,
                    'due_date' => $loan->due_at->format('d M Y')
                ]
            ]);
        }
    }

    public static function sendOverdueAlert()
    {
        $overdueLoans = Loan::where('due_at', '<', Carbon::now())
            ->whereNull('returned_at')
            ->with('user')
            ->get();

        foreach ($overdueLoans as $loan) {
            Notification::create([
                'user_id' => $loan->user_id,
                'type' => 'loan_overdue',
                'title' => 'Buku Terlambat',
                'message' => "Buku '{$loan->book->title}' sudah melewati jatuh tempo. Silakan kembalikan segera.",
                'data' => [
                    'loan_id' => $loan->id,
                    'book_title' => $loan->book->title,
                    'days_overdue' => Carbon::now()->diffInDays($loan->due_at)
                ]
            ]);
        }
    }

    public static function sendNewBookNotification(Book $book)
    {
        $users = User::where('role', 'mahasiswa')->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'new_book',
                'title' => 'Buku Baru Tersedia',
                'message' => "Buku baru '{$book->title}' oleh {$book->author} telah ditambahkan ke koleksi.",
                'data' => [
                    'book_id' => $book->id,
                    'book_title' => $book->title,
                    'author' => $book->author
                ]
            ]);
        }
    }
}