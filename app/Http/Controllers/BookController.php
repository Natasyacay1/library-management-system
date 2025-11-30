<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function homepage()
    {
        $books = Book::latest()->take(6)->get();

        return view('homepage', compact('books'));
    }

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

    public function show(Book $book)
    {
        $book->load('reviews.user');

        return view('books.show', compact('book'));
    }
}