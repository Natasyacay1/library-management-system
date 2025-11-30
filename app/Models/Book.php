<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn', 
        'publisher',
        'year',
        'category',
        'stock',
        'max_loan_days',
        'daily_fine',
        'description',
        'cover',
        'pages', 
        'language', 
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->stock > 0;
    }

    public function getStatusAttribute()
    {
        if ($this->stock > 5) {
            return 'Tersedia';
        } elseif ($this->stock > 0) {
            return 'Terbatas';
        } else {
            return 'Habis';
        }
    }

    public function getStatusColorAttribute()
    {
        if ($this->stock > 5) {
            return 'green';
        } elseif ($this->stock > 0) {
            return 'yellow';
        } else {
            return 'red';
        }
    }

    public function getFormattedFineAttribute()
    {
        return 'Rp ' . number_format($this->daily_fine, 0, ',', '.');
    }

    // Scope untuk buku tersedia
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Scope untuk buku populer (banyak dipinjam)
    public function scopePopular($query)
    {
        return $query->withCount('loans')->orderBy('loans_count', 'desc');
    }
}