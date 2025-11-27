<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    const STATUS_BORROWED = 'borrowed';
    const STATUS_RETURNED = 'returned';
    const STATUS_OVERDUE = 'overdue';
    const STATUS_EXTENDED = 'extended';

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'extended_due_date',
        'status',
        'fine_amount',
        'is_extended'
    ];

    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
        'extended_due_date' => 'datetime',
        'fine_amount' => 'decimal:2',
        'is_extended' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_BORROWED);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('status', self::STATUS_BORROWED);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function isOverdue()
    {
        return $this->due_date < now() && $this->status === self::STATUS_BORROWED;
    }

    public function canBeExtended()
    {
        return !$this->is_extended && 
            !$this->isOverdue() && 
            $this->status === self::STATUS_BORROWED;
    }

    public function calculateFine()
    {
        if ($this->status === self::STATUS_BORROWED && $this->isOverdue()) {
            $overdueDays = now()->diffInDays($this->due_date);
            return $overdueDays * $this->book->fine_per_day;
        }
        return 0;
    }

    public function getDaysOverdue()
    {
        if ($this->isOverdue()) {
            return now()->diffInDays($this->due_date);
        }
        return 0;
    }

    public function markAsReturned()
    {
        $this->return_date = now();
        $this->status = self::STATUS_RETURNED;
        $this->fine_amount = $this->calculateFine();
        $this->save();

    
        $this->book->increaseStock();
    }

    public function extendLoan($extensionDays = 7)
    {
        if ($this->canBeExtended()) {
            $this->extended_due_date = $this->due_date->copy()->addDays($extensionDays);
            $this->due_date = $this->extended_due_date;
            $this->is_extended = true;
            $this->status = self::STATUS_EXTENDED;
            $this->save();
            return true;
        }
        return false;
    }
}