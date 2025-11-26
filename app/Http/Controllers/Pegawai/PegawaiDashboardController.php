<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class PegawaiDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_returns' => Loan::overdue()->count(),
            'today_loans' => Loan::whereDate('loan_date', today())->count(),
            'today_returns' => Loan::whereDate('return_date', today())->count(),
            'total_fines' => Loan::overdue()->get()->sum('fine_amount'),
        ];

        $recentLoans = Loan::with(['user', 'book'])
                        ->recent()
                        ->limit(10)
                        ->get();

        $overdueLoans = Loan::with(['user', 'book'])
                        ->overdue()
                        ->limit(10)
                        ->get();

        return view('staff.dashboard', compact('stats', 'recentLoans', 'overdueLoans'));
    }
}