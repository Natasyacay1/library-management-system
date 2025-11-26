<?php

namespace App\Services;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RecomendationService
{
    public function getPersonalizedRecommendations(User $user, $limit = 6)
    {
        //Metode 1: Berdasarkan kategori riwayat pinjaman pengguna
        $categoryBased = $this->getCategoryBasedRecommendations($user, $limit);

        // Metode 2: Berdasarkan buku populer di sistem
        $popularBased = $this->getPopularRecommendations($limit);

        // Metode 3: Berdasarkan ulasan dan penilaian pengguna
        $ratingBased = $this->getRatingBasedRecommendations($user, $limit);

        // Gabungkan semua rekomendasi dan hilangkan duplikat
        $allRecommendations = $categoryBased->merge($popularBased)->merge($ratingBased);
        $uniqueRecommendations = $allRecommendations->unique('id');

        // Exclude buku yang saat ini dipinjam oleh pengguna
        $borrowedBookIds = $user->activeLoans()->pluck('book_id');
        $filteredRecommendations = $uniqueRecommendations->whereNotIn('id', $borrowedBookIds);

        return $filteredRecommendations->take($limit);
    }

    private function getCategoryBasedRecommendations(User $user, $limit)
    {
        // Dapatkan kategori dari riwayat pinjaman pengguna
        $userCategories = $user->loans()
                            ->with('book.category')
                            ->get()
                            ->pluck('book.category_id')
                            ->filter()
                            ->unique()
                            ->toArray();

        if (empty($userCategories)) {
            return collect();
        }

        return Book::whereIn('category_id', $userCategories)
                ->available()
                ->with('category')
                ->whereNotIn('id', $user->loans()->pluck('book_id'))
                ->inRandomOrder()
                ->limit($limit)
                ->get();
    }

    private function getPopularRecommendations($limit)
    {
        return Book::withCount('loans')
                ->available()
                ->with('category')
                ->orderBy('loans_count', 'desc')
                ->limit($limit)
                ->get();
    }

    private function getRatingBasedRecommendations(User $user, $limit)
    {
        // Get books with high ratings that user hasn't borrowed
        return Book::with(['category', 'reviews'])
                ->available()
                ->whereNotIn('id', $user->loans()->pluck('book_id'))
                ->withAvg('reviews', 'rating')
                ->having('reviews_avg_rating', '>=', 4.0)
                ->orderBy('reviews_avg_rating', 'desc')
                ->limit($limit)
                ->get();
    }

    public function getNewArrivals($limit = 8)
    {
        return Book::with('category')
                    ->available()
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
    }

    public function getTrendingBooks($limit = 8)
    {
        // Books with most loans in the last 30 days
        return Book::withCount(['loans' => function($query) {
                        $query->where('created_at', '>=', now()->subDays(30));
                    }])
                    ->available()
                    ->with('category')
                    ->orderBy('loans_count', 'desc')
                    ->limit($limit)
                    ->get();
    }

    public function getSimilarBooks(Book $book, $limit = 6)
    {
        return Book::where('category_id', $book->category_id)
                    ->where('id', '!=', $book->id)
                    ->available()
                    ->with('category')
                    ->inRandomOrder()
                    ->limit($limit)
                    ->get();
    }

    public function getRecommendedByLibrarians($limit = 5)
    {
        // Books that are frequently borrowed or have high ratings
        return Book::withCount('loans')
                    ->withAvg('reviews', 'rating')
                    ->available()
                    ->with('category')
                    ->orderBy('loans_count', 'desc')
                    ->orderBy('reviews_avg_rating', 'desc')
                    ->limit($limit)
                    ->get();
    }
}