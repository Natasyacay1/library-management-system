<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookManagementController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(10);
        $user = Auth::user();
        
        return view('admin.books.index', compact('books', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('admin.books.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'max_loan_days' => 'required|integer|min:1',
            'daily_fine' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'category' => $request->category,
            'stock' => $request->stock,
            'max_loan_days' => $request->max_loan_days,
            'daily_fine' => $request->daily_fine,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $user = Auth::user();
        return view('admin.books.show', compact('book', 'user'));
    }

    public function edit(Book $book)
    {
        $user = Auth::user();
        return view('admin.books.edit', compact('book', 'user'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'max_loan_days' => 'required|integer|min:1',
            'daily_fine' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'category' => $request->category,
            'stock' => $request->stock,
            'max_loan_days' => $request->max_loan_days,
            'daily_fine' => $request->daily_fine,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}