<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getLoanStatistics($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?: now()->startOfMonth();
        $endDate = $endDate ?: now()->endOfMonth();

        return [
            'total_loans' => Loan::whereBetween('created_at', [$startDate, $endDate])->count(),
            'active_loans' => Loan::whereBetween('loan_date', [$startDate, $endDate])
                                    ->where('status', 'borrowed')
                                    ->count(),
            'returned_loans' => Loan::whereBetween('return_date', [$startDate, $endDate])
                                    ->where('status', 'returned')
                                    ->count(),
            'overdue_loans' => Loan::whereBetween('due_date', [$startDate, $endDate])
                                    ->overdue()
                                    ->count(),
            'average_loan_duration' => $this->getAverageLoanDuration($startDate, $endDate),
        ];
    }

    public function getFineStatistics($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?: now()->startOfMonth();
        $endDate = $endDate ?: now()->endOfMonth();

        return [
            'total_fines' => Fine::whereBetween('created_at', [$startDate, $endDate])->sum('amount'),
            'paid_fines' => Fine::whereBetween('paid_at', [$startDate, $endDate])
                                ->where('status', 'paid')
                                ->sum('amount'),
            'pending_fines' => Fine::whereBetween('created_at', [$startDate, $endDate])
                                    ->where('status', 'pending')
                                    ->sum('amount'),
            'average_fine_amount' => Fine::whereBetween('created_at', [$startDate, $endDate])->avg('amount') ?? 0,
        ];
    }

    public function getUserStatistics($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?: now()->startOfMonth();
        $endDate = $endDate ?: now()->endOfMonth();

        $activeUsers = User::whereHas('loans', function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->count();

        return [
            'total_users' => User::count(),
            'active_users' => $activeUsers,
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'users_with_fines' => User::where('fines_balance', '>', 0)->count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
        ];
    }

    public function getBookStatistics($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?: now()->startOfMonth();
        $endDate = $endDate ?: now()->endOfMonth();

        $mostBorrowed = Book::withCount(['loans' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])
        ->orderBy('loans_count', 'desc')
        ->limit(10)
        ->get();

        return [
            'total_books' => Book::count(),
            'available_books' => Book::available()->count(),
            'unavailable_books' => Book::where('available_stock', 0)->count(),
            'most_borrowed_books' => $mostBorrowed,
            'average_rating' => Book::join('reviews', 'books.id', '=', 'reviews.book_id')
                                ->avg('reviews.rating') ?? 0,
        ];
    }

    private function getAverageLoanDuration($startDate, $endDate)
    {
        $averageDuration = Loan::whereBetween('loan_date', [$startDate, $endDate])
                                ->whereNotNull('return_date')
                                ->selectRaw('AVG(DATEDIFF(return_date, loan_date)) as avg_days')
                                ->first();

        return $averageDuration->avg_days ?? 0;
    }

    public function getMonthlyReport($year = null)
    {
        $year = $year ?: now()->year;

        $monthlyData = Loan::whereYear('created_at', $year)
                            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get()
                            ->keyBy('month');

        $report = [];
        for ($month = 1; $month <= 12; $month++) {
            $report[] = [
                'month' => $month,
                'month_name' => Carbon::create()->month($month)->format('M'),
                'loans' => $monthlyData->get($month)->count ?? 0,
            ];
        }

        return $report;
    }

    public function generateComprehensiveReport($startDate, $endDate)
    {
        return [
            'period' => [
                'start' => $startDate->format('d M Y'),
                'end' => $endDate->format('d M Y'),
            ],
            'loan_statistics' => $this->getLoanStatistics($startDate, $endDate),
            'fine_statistics' => $this->getFineStatistics($startDate, $endDate),
            'user_statistics' => $this->getUserStatistics($startDate, $endDate),
            'book_statistics' => $this->getBookStatistics($startDate, $endDate),
            'top_performers' => $this->getTopPerformers($startDate, $endDate),
        ];
    }

    private function getTopPerformers($startDate, $endDate)
    {
        return [
            'top_books' => Book::withCount(['loans' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('loans_count', 'desc')
            ->limit(5)
            ->get(),
            
            'top_users' => User::withCount(['loans' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('loans_count', 'desc')
            ->limit(5)
            ->get(),
        ];
    }
}