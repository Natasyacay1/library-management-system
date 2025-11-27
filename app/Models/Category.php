<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getBooksCount()
    {
        return $this->books()->count();
    }

    public function getAvailableBooksCount()
    {
        return $this->books()->where('available_stock', '>', 0)->count();
    }
}