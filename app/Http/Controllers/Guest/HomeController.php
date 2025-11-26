<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $newBooks = Book::with('category')
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get();
        
        $popularBooks = Book::with('category')
                        ->popular()
                        ->limit(8)
                        ->get();

        $categories = Category::withCount('books')
                            ->orderBy('books_count', 'desc')
                            ->limit(6)
                            ->get();
        
        return view('guest.homepage', compact('newBooks', 'popularBooks', 'categories'));
    }

    public function about()
    {
        return view('guest.about');
    }

    public function contact()
    {
        return view('guest.contact');
    }
}