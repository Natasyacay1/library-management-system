<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category', 'reviews')->available();
        
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->byCategory($request->category);
        }
    
        $sort = $request->get('sort', 'title');
        $order = $request->get('order', 'asc');
        
        if ($sort === 'rating') {
            $query->withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating', $order === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy($sort, $order);
        }
        
        $books = $query->paginate(12);
        $categories = Category::all();
        
        return view('student.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load(['category', 'reviews.user', 'loans']);
        $user = Auth::user();
        $canReview = false;
        if ($user) {
            $canReview = Loan::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->where('status', 'returned')
                ->exists();
        }

        $averageRating = $book->getAverageRating();
        $reviewsCount = $book->getReviewsCount();
        
        return view('student.books.show', compact('book', 'canReview', 'averageRating', 'reviewsCount'));
    }
}