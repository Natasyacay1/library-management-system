<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Home guest
    public function homepage()
    {
        $books = Book::latest()->take(6)->get();

        return view('homepage', compact('books'));
        // atau kalau kamu punya view lain untuk home, ganti di sini
    }

    // /books -> katalog
    public function index(Request $request)
    {
        $query = Book::query();

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
        }

        $books = $query->orderBy('title')->paginate(12);

        return view('books.catalog', compact('books'));
    }

    // /books/{book}
    public function show(Book $book)
    {
        $book->load('reviews.user');

        return view('books.show', compact('book'));
    }
}
