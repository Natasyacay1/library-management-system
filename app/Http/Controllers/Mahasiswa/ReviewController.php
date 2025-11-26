<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $user = Auth::user();

        $hasBorrowed = $user->loans()
                        ->where('book_id', $book->id)
                        ->where('status', 'returned')
                        ->exists();
        
        if (!$hasBorrowed) {
            return redirect()->back()
                ->with('error', 'Anda hanya dapat memberikan ulasan untuk buku yang pernah dipinjam.');
        }

        $existingReview = Review::where('user_id', $user->id)
                            ->where('book_id', $book->id)
                            ->exists();
        
        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }
        
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        
        Review::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => true, // Auto-approve for now, bisa diganti perlu approval
        ]);
        
        return redirect()->back()
            ->with('success', 'Ulasan berhasil ditambahkan.');
    }

    public function destroy(Review $review)
    {
        $user = Auth::user();
        
        if ($review->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        
        $review->delete();
        
        return redirect()->back()
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}