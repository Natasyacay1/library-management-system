<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use App\Models\Fine;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->get('date_range', 'this_month');
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        switch ($dateRange) {
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            case 'last_year':
                $startDate = now()->subYear()->startOfYear();
                $endDate = now()->subYear()->endOfYear();
                break;
            case 'custom':
                $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : $startDate;
                $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : $endDate;
                break;
        }

        $loanStats = Loan::whereBetween('created_at', [$startDate, $endDate])
                        ->selectRaw('COUNT(*) as total_loans,
                                    SUM(CASE WHEN status = "borrowed" THEN 1 ELSE 0 END) as active_loans,
                                    SUM(CASE WHEN status = "returned" THEN 1 ELSE 0 END) as returned_loans,
                                    SUM(CASE WHEN due_date < return_date THEN 1 ELSE 0 END) as overdue_loans')
                        ->first();

        $fineStats = Fine::whereBetween('created_at', [$startDate, $endDate])
                        ->selectRaw('SUM(amount) as total_fines,
                                    SUM(CASE WHEN status = "paid" THEN amount ELSE 0 END) as paid_fines,
                                    SUM(CASE WHEN status = "pending" THEN amount ELSE 0 END) as pending_fines')
                        ->first();

        $popularBooks = Book::withCount(['loans' => function($q) use ($startDate, $endDate) {
                            $q->whereBetween('created_at', [$startDate, $endDate]);
                        }])
                        ->orderBy('loans_count', 'desc')
                        ->limit(10)
                        ->get();

        $activeUsers = User::whereHas('loans', function($q) use ($startDate, $endDate) {
                            $q->whereBetween('created_at', [$startDate, $endDate]);
                        })
                        ->withCount(['loans' => function($q) use ($startDate, $endDate) {
                            $q->whereBetween('created_at', [$startDate, $endDate]);
                        }])
                        ->orderBy('loans_count', 'desc')
                        ->limit(10)
                        ->get();

        return view('admin.reports.index', compact(
            'loanStats', 
            'fineStats', 
            'popularBooks', 
            'activeUsers',
            'startDate',
            'endDate',
            'dateRange'
        ));
    }

    public function export(Request $request)
    {
        // Basic export functionality - bisa dikembangkan dengan Maatwebsite/Laravel-Excel
        $type = $request->get('type', 'loans');
        
        // Logic untuk export data akan ditambahkan nanti
        return redirect()->back()
            ->with('info', 'Fitur export akan segera tersedia.');
    }
}