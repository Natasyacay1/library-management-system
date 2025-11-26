<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function catalog(Request $request)
    {
        $query = Book::with('category', 'reviews');

        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
    
        if ($request->has('category') && $request->category != '') {
            $query->byCategory($request->category);
        }
        
        $sort = $request->get('sort', 'title');
        $order = $request->get('order', 'asc');
        
        if ($sort === 'popular') {
            $query->popular();
        } elseif ($sort === 'rating') {
            $query->withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating', $order === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy($sort, $order);
        }
        
        $books = $query->paginate(12);
        $categories = Category::all();
        
        return view('guest.catalog', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load(['category', 'reviews.user']);
        
        $averageRating = $book->getAverageRating();
        $reviewsCount = $book->getReviewsCount();
        
        return view('guest.book-detail', compact('book', 'averageRating', 'reviewsCount'));
    }

    public function homepage()
    {
        $newBooks = Book::with('category')
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get();
        
        $popularBooks = Book::with('category')
                        ->popular()
                        ->limit(8)
                        ->get();
        
        return view('guest.homepage', compact('newBooks', 'popularBooks'));
    }
}