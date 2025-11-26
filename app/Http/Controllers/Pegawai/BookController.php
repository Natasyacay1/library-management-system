<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category', 'reviews');
    
        
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->byCategory($request->category);
        }
        
        if ($request->has('availability')) {
            if ($request->availability === 'available') {
                $query->available();
            } elseif ($request->availability === 'unavailable') {
                $query->where('available_stock', 0);
            }
        }
        
        $books = $query->withCount(['loans' => function($q) {
            $q->where('status', 'borrowed');
        }])
        ->orderBy('title')
        ->paginate(12);
        
        $categories = Category::all();
        
        return view('staff.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load(['category', 'loans.user', 'reviews.user']);
        
        $currentLoans = $book->loans()
                        ->where('status', 'borrowed')
                        ->with('user')
                        ->get();
        
        return view('staff.books.show', compact('book', 'currentLoans'));
    }

    public function updateStock(Request $request, Book $book)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $book->updateStock($request->stock);
        return redirect()->back()
            ->with('success', 'Stok buku berhasil diperbarui.');
    }
}
