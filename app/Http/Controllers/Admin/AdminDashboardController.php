<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Fine;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_loans' => Loan::count(),
            'active_loans' => Loan::active()->count(),
            'overdue_loans' => Loan::overdue()->count(),
            'total_fines' => Fine::pending()->sum('amount'),
        ];

        $recentLoans = Loan::with(['user', 'book'])
                        ->recent()
                        ->limit(10)
                        ->get();


        $popularBooks = Book::withCount('loans')
                        ->orderBy('loans_count', 'desc')
                        ->limit(5)
                        ->get();

        $monthlyLoans = Loan::where('created_at', '>=', Carbon::now()->subMonths(6))
                        ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) count')
                        ->groupBy('year', 'month')
                        ->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->get();

        return view('admin.dashboard', compact('stats', 'recentLoans', 'popularBooks', 'monthlyLoans'));
    }
}