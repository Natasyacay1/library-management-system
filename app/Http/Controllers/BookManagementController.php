<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookManagementController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('title')->paginate(15);

        return view('books.index', compact('books'));
    }

    // Form tambah buku
    public function create()
    {
        return view('books.create');
    }

    // Simpan buku baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'publisher'     => 'nullable|string|max:255',
            'year'          => 'nullable|integer',
            'category'      => 'nullable|string|max:255',
            'stock'         => 'required|integer|min:0',
            'max_loan_days' => 'required|integer|min:1',
            'daily_fine'    => 'required|integer|min:0',
        ]);

        Book::create($data);

        return redirect()
            ->route(auth()->user()->isAdmin() ? 'admin.books.index' : 'pegawai.books.index')
            ->with('status', 'Buku berhasil ditambahkan.');
    }

    // Form edit buku
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // Update buku
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'publisher'     => 'nullable|string|max:255',
            'year'          => 'nullable|integer',
            'category'      => 'nullable|string|max:255',
            'stock'         => 'required|integer|min:0',
            'max_loan_days' => 'required|integer|min:1',
            'daily_fine'    => 'required|integer|min:0',
        ]);

        $book->update($data);

        return redirect()
            ->route(auth()->user()->isAdmin() ? 'admin.books.index' : 'pegawai.books.index')
            ->with('status', 'Data buku berhasil diperbarui.');
    }

    // Hapus buku
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route(auth()->user()->isAdmin() ? 'admin.books.index' : 'pegawai.books.index')
            ->with('status', 'Buku berhasil dihapus.');
    }
}
