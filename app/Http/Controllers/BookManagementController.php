<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = Book::query();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->latest()->paginate(10);

        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'author'       => ['required', 'string', 'max:255'],
            'publisher'    => ['nullable', 'string', 'max:255'],
            'year'         => ['nullable', 'integer'],
            'category'     => ['nullable', 'string', 'max:255'],
            'stock'        => ['required', 'integer', 'min:0'],
            'max_loan_days'=> ['required', 'integer', 'min:1'],
            'daily_fine'   => ['required', 'integer', 'min:0'],
        ]);

        Book::create($data);

        return redirect()
            ->route('admin.books.index')
            ->with('status', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'author'       => ['required', 'string', 'max:255'],
            'publisher'    => ['nullable', 'string', 'max:255'],
            'year'         => ['nullable', 'integer'],
            'category'     => ['nullable', 'string', 'max:255'],
            'stock'        => ['required', 'integer', 'min:0'],
            'max_loan_days'=> ['required', 'integer', 'min:1'],
            'daily_fine'   => ['required', 'integer', 'min:0'],
        ]);

        $book->update($data);

        return redirect()
            ->route('admin.books.index')
            ->with('status', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('status', 'Buku berhasil dihapus.');
    }
}
