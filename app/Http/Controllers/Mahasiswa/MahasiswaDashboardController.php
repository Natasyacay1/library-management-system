<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $currentLoans = Loan::with('book')
            ->where('user_id', $user->id)
            ->active()
            ->get();

        $dueSoonLoans = $currentLoans->filter(function ($loan) {
            return $loan->due_date->isFuture() && 
                $loan->due_date->diffInDays(now()) <= 2;
        });

        $totalFines = Loan::where('user_id', $user->id)
            ->where('fine_status', 'unpaid')
            ->sum('fine_amount');

        $notifications = Notifikasi::where('user_id', $user->id)
            ->recent(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'currentLoans', 
            'dueSoonLoans', 
            'totalFines',
            'notifications'
        ));
    }

    public function loanHistory()
    {
        $loans = Loan::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mahasiswa.loan-history', compact('loans'));
    }
}