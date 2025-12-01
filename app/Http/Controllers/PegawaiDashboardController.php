<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class PegawaiDashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard pegawai
        $pendingLoansCount = Loan::where('status', 'pending')->count();
        $activeLoansCount = Loan::where('status', 'approved')
            ->whereNull('returned_at')
            ->count();
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'mahasiswa')->count();

        // Hitung keterlambatan
        $overdueCount = Loan::where('status', 'approved')
            ->whereNull('returned_at')
            ->where('due_at', '<', Carbon::now())
            ->count();

        // Pengembalian hari ini
        $todayReturns = Loan::where('status', 'approved')
            ->whereNull('returned_at')
            ->whereDate('due_at', Carbon::today())
            ->count();

        // Peminjaman pending untuk approval
        $pendingApprovals = Loan::with(['user', 'book'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Peminjaman aktif
        $activeLoans = Loan::with(['user', 'book'])
            ->where('status', 'approved')
            ->whereNull('returned_at')
            ->orderBy('due_at', 'asc')
            ->take(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'pendingLoansCount',
            'activeLoansCount',
            'totalBooks',
            'totalMembers',
            'overdueCount',
            'todayReturns',
            'pendingApprovals',
            'activeLoans'
        ));
    }
    public function editBook(Book $book)
    {
        return view('pegawai.books.edit', compact('book'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'description' => 'required|string',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update($validated);

        return redirect()->route('pegawai.books.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroyBook(Book $book)
    {
        try {
            // Cek apakah buku sedang dipinjam
            // Gunakan query langsung untuk menghindari error relationship
            $hasActiveLoans = false;

            // Cek apakah model Loan ada
            if (class_exists(\App\Models\Loan::class)) {
                $hasActiveLoans = \App\Models\Loan::where('book_id', $book->id)
                    ->whereIn('status', ['active', 'pending', 'overdue'])
                    ->exists();
            }

            if ($hasActiveLoans) {
                return redirect()->route('pegawai.books.index')
                    ->with('error', 'Tidak dapat menghapus buku "' . $book->title . '" karena sedang dipinjam!');
            }

            $book->delete();

            return redirect()->route('pegawai.books.index')
                ->with('success', 'Buku "' . $book->title . '" berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pegawai.books.index')
                ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    public function loans()
    {
        $loans = Loan::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pegawai.loans.index', compact('loans'));
    }

    public function approveLoan(Request $request, $loan)
    {
        try {
            $loan = Loan::findOrFail($loan);

            // Cek apakah buku masih tersedia
            if ($loan->book->stock < 1) {
                return redirect()->back()->with('error', 'Stok buku tidak tersedia.');
            }

            $loan->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'due_at' => now()->addDays(14) // 2 minggu
            ]);

            // Kurangi stok buku
            $loan->book->decrement('stock');

            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectLoan(Request $request, $loan)
    {
        try {
            $loan = Loan::findOrFail($loan);

            $loan->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'rejected_by' => Auth::id()
            ]);

            return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function returnBook(Request $request, $loan)
    {
        try {
            $loan = Loan::findOrFail($loan);

            $loan->update([
                'returned_at' => now()
            ]);

            // Update stock buku
            $loan->book->increment('stock');

            return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function books()
    {
        $books = Book::latest()->paginate(10);
        return view('pegawai.books.index', compact('books'));
    }

    public function createBook()
    {
        return view('pegawai.books.create');
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bookData = $request->all();

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('book-covers', 'public');
            $bookData['cover'] = $coverPath;
        }

        Book::create($bookData);

        return redirect()->route('pegawai.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function fines()
    {
        $overdueLoans = Loan::with(['user', 'book'])
            ->where('status', 'approved')
            ->whereNull('returned_at')
            ->where('due_at', '<', Carbon::now())
            ->get();

        return view('pegawai.fines.index', compact('overdueLoans'));
    }

    public function reviews()
    {
        $reviews = \App\Models\Review::with(['user', 'book'])
            ->latest()
            ->paginate(10);

        return view('pegawai.reviews.index', compact('reviews'));
    }

    public function extendLoan(Request $request, $loan)
    {
        try {
            $loan = Loan::findOrFail($loan);

            $request->validate([
                'extended_days' => 'required|integer|min:1|max:7'
            ]);

            $loan->update([
                'due_at' => Carbon::parse($loan->due_at)->addDays($request->extended_days),
                'extended' => true
            ]);

            return redirect()->back()->with('success', 'Peminjaman berhasil diperpanjang.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
