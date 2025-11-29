<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Loan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBooks   = Book::count();
        $totalUsers   = User::count();
        $totalLoans   = Loan::count();
        $activeLoans  = Loan::whereNull('returned_at')->count();
        $overdueLoans = Loan::whereNull('returned_at')
                            ->where('due_at', '<', now())
                            ->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalLoans',
            'activeLoans',
            'overdueLoans'
        ));
    }
}
