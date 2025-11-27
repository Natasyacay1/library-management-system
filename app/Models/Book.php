<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'category_id',
        'isbn',
        'description',
        'stock',
        'available_stock',
        'max_loan_days',
        'fine_per_day',
        'image_path'
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'stock' => 'integer',
        'available_stock' => 'integer',
        'max_loan_days' => 'integer',
        'fine_per_day' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('available_stock', '>', 0);
    }

    public function scopePopular($query)
    {
        return $query->withCount('loans')
                    ->orderBy('loans_count', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('publisher', 'like', "%{$search}%");
        });
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Methods
    public function isAvailable()
    {
        return $this->available_stock > 0;
    }

    public function getAverageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewsCount()
    {
        return $this->reviews()->count();
    }

    public function decreaseStock()
    {
        $this->available_stock = max(0, $this->available_stock - 1);
        $this->save();
    }

    public function increaseStock()
    {
        $this->available_stock = min($this->stock, $this->available_stock + 1);
        $this->save();
    }

    public function updateStock($newStock)
    {
        $this->stock = $newStock;
        $this->available_stock = $newStock - $this->loans()->where('status', 'borrowed')->count();
        $this->save();
    }
}