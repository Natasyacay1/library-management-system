<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBooks     = Book::count();
        $totalUsers     = User::count();
        $totalLoans     = Loan::count();
        $activeLoans    = Loan::whereNull('returned_at')->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalLoans',
            'activeLoans'
        ));
    }
}
