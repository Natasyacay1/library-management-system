<?php

namespace App\Http\Controllers;

use App\Models\Loan;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $currentLoans = Loan::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->with('book')
            ->get();

        $history = Loan::where('user_id', $user->id)
            ->whereNotNull('returned_at')
            ->with('book')
            ->orderBy('returned_at', 'desc')
            ->take(10)
            ->get();

        return view('mahasiswa.dashboard', compact('currentLoans', 'history'));
    }
}
