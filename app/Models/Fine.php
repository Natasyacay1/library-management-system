<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_OVERDUE = 'overdue';

    protected $fillable = [
        'user_id',
        'loan_id',
        'amount',
        'reason',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public function markAsPaid()
    {
        $this->status = self::STATUS_PAID;
        $this->paid_at = now();
        $this->save();

        // Update user's fines balance
        $this->user->fines_balance = max(0, $this->user->fines_balance - $this->amount);
        $this->user->save();
    }

    public function isOverdue()
    {
        return $this->status === self::STATUS_OVERDUE;
    }

    public function isPaid()
    {
        return $this->status === self::STATUS_PAID;
    }
}