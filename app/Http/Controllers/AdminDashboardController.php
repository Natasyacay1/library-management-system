<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Fine;
use App\Models\Notification;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalLoans = Loan::count();
        $totalFines = Loan::where('fine', '>', 0)->sum('fine');

        // Statistik role
        $adminCount = User::where('role', 'admin')->count();
        $pegawaiCount = User::where('role', 'pegawai')->count();
        $mahasiswaCount = User::where('role', 'mahasiswa')->count();

        // Buku berdasarkan status
        $availableBooks = Book::where('stock', '>', 0)->count();
        $borrowedBooks = Loan::whereNull('returned_at')->count();
        $outOfStockBooks = Book::where('stock', 0)->count();

        // Data untuk charts (contoh)
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentLoans = Loan::with(['user', 'book'])->orderBy('created_at', 'desc')->take(5)->get();
        $popularBooks = Book::orderBy('stock', 'desc')->take(5)->get();

        // Monthly statistics for charts
        $monthlyLoans = $this->getMonthlyLoans();
        $userRegistrations = $this->getUserRegistrations();
        $popularCategories = $this->getPopularCategories();

        // System alerts
        $systemAlerts = $this->getSystemAlerts();

        // Recent activities
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'totalLoans',
            'totalFines',
            'adminCount',
            'pegawaiCount',
            'mahasiswaCount',
            'availableBooks',
            'borrowedBooks',
            'outOfStockBooks',
            'recentUsers',
            'recentLoans',
            'popularBooks',
            'monthlyLoans',
            'userRegistrations',
            'popularCategories',
            'systemAlerts',
            'recentActivities'
        ));
    }

    // Method untuk halaman loans
    public function loans()
    {
        $loans = Loan::with(['user', 'book'])->latest()->paginate(10);
        return view('admin.loans.index', compact('loans'));
    }

    // Method untuk halaman fines
    public function fines()
    {
        // Jika menggunakan model Fine
        // $fines = Fine::with(['user', 'loan'])->where('status', 'unpaid')->latest()->paginate(10);
        
        // Jika tidak ada model Fine, gunakan data dari Loan
        $fines = Loan::where('fine', '>', 0)
                    ->with(['user', 'book'])
                    ->latest()
                    ->paginate(10);
                    
        return view('admin.fines.index', compact('fines'));
    }

    // Method untuk settings
    public function settings()
    {
        return view('admin.settings');
    }

    // Method untuk approve loan
    public function approveLoan(Loan $loan)
    {
        $loan->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Peminjaman disetujui');
    }

    // Method untuk reject loan
    public function rejectLoan(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Peminjaman ditolak');
    }

    // Method untuk return book
    public function returnBook(Loan $loan)
    {
        $loan->update(['returned_at' => now()]);
        $loan->book->increment('stock');
        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }

    // Method untuk mark fine as paid
    public function markAsPaid($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->update(['fine' => 0]); // Reset fine to 0
        return redirect()->back()->with('success', 'Denda telah dibayar');
    }

    // Existing methods...
    private function getMonthlyLoans()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'data' => [65, 59, 80, 81, 56, 55, 40, 45, 60, 75, 80, 90]
        ];
    }

    private function getUserRegistrations()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [12, 19, 3, 5, 2, 3]
        ];
    }

    private function getPopularCategories()
    {
        return [
            'labels' => ['Teknologi', 'Sains', 'Fiksi', 'Sejarah', 'Bisnis'],
            'data' => [30, 25, 20, 15, 10]
        ];
    }

    private function getSystemAlerts()
    {
        $alerts = [];

        // Check for overdue books
        $overdueLoans = Loan::where('due_at', '<', now())
            ->whereNull('returned_at')
            ->count();

        if ($overdueLoans > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'fas fa-exclamation-triangle',
                'title' => 'Buku Terlambat',
                'message' => "{$overdueLoans} buku belum dikembalikan setelah jatuh tempo",
                'action' => route('admin.loans.index')
            ];
        }

        // Check for out of stock books
        $outOfStock = Book::where('stock', 0)->count();
        if ($outOfStock > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'fas fa-box-open',
                'title' => 'Stok Habis',
                'message' => "{$outOfStock} buku sudah habis stoknya",
                'action' => route('admin.books.index')
            ];
        }

        return $alerts;
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Recent user registrations
        $recentUsers = User::orderBy('created_at', 'desc')->take(3)->get();
        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user',
                'icon' => 'fas fa-user-plus',
                'color' => 'text-green-500',
                'message' => "{$user->name} bergabung sebagai " . ucfirst($user->role),
                'time' => $user->created_at->diffForHumans()
            ];
        }

        // Recent loans
        $recentLoans = Loan::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentLoans as $loan) {
            $activities[] = [
                'type' => 'loan',
                'icon' => 'fas fa-exchange-alt',
                'color' => 'text-purple-500',
                'message' => "{$loan->user->name} meminjam '{$loan->book->title}'",
                'time' => $loan->created_at->diffForHumans()
            ];
        }

        return $activities;
    }

    public function systemStats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_loans' => Loan::count(),
            'active_loans' => Loan::whereNull('returned_at')->count(),
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'overdue_loans' => Loan::where('due_at', '<', now())
                ->whereNull('returned_at')
                ->count(),
            'total_fines' => Loan::where('fine', '>', 0)->sum('fine'),
        ];

        return response()->json($stats);
    }
}