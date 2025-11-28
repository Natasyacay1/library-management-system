<?php

namespace App\Http\Controllers;

use App\Models\Loan;

class PegawaiDashboardController extends Controller
{
    public function index()
    {
        $activeLoans = Loan::whereNull('returned_at')->with('book', 'user')->get();

        return view('pegawai.dashboard', compact('activeLoans'));
    }
}
