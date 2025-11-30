<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'book_id', 'rating', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Scope untuk rating tertinggi
    public function scopeHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    // Scope untuk buku dengan review
    public function scopeWithReviews($query)
    {
        return $query->whereHas('reviews');
    }
}