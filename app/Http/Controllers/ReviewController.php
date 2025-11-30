<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Cek apakah user sudah mereview buku ini
        $existingReview = Review::where('user_id', Auth::id())
                              ->where('book_id', $book->id)
                              ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk buku ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Update average rating buku
        $this->updateBookRating($book);

        return redirect()->back()->with('success', 'Review berhasil ditambahkan.');
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review->update($request->only('rating', 'comment'));

        // Update average rating buku
        $this->updateBookRating($review->book);

        return redirect()->back()->with('success', 'Review berhasil diperbarui.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        $book = $review->book;
        $review->delete();

        // Update average rating buku
        $this->updateBookRating($book);

        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }

    private function updateBookRating(Book $book)
    {
        $averageRating = $book->reviews()->avg('rating');
        $book->update(['average_rating' => $averageRating]);
    }
}