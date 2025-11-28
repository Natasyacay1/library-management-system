<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'fine',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at'      => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Hitung denda sederhana
    public function calculateFine(): int
    {
        if ($this->returned_at === null && now()->greaterThan($this->due_at)) {
            $daysLate = $this->due_at->diffInDays(now());
        } elseif ($this->returned_at && $this->returned_at->greaterThan($this->due_at)) {
            $daysLate = $this->due_at->diffInDays($this->returned_at);
        } else {
            $daysLate = 0;
        }

        $dailyFine = $this->book->daily_fine ?? 0;

        return $daysLate * $dailyFine;
    }
}
