<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    const TYPE_LOAN_REMINDER = 'loan_reminder';
    const TYPE_FINE_NOTIFICATION = 'fine_notification';
    const TYPE_LOAN_CONFIRMATION = 'loan_confirmation';
    const TYPE_RETURN_CONFIRMATION = 'return_confirmation';
    const TYPE_SYSTEM_ANNOUNCEMENT = 'system_announcement';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Methods
    public function markAsRead()
    {
        $this->is_read = true;
        $this->read_at = now();
        $this->save();
    }

    public function markAsUnread()
    {
        $this->is_read = false;
        $this->read_at = null;
        $this->save();
    }

    public static function createLoanReminder($userId, $loan)
    {
        return self::create([
            'user_id' => $userId,
            'type' => self::TYPE_LOAN_REMINDER,
            'title' => 'Pengingat Jatuh Tempo Peminjaman',
            'message' => "Buku '{$loan->book->title}' akan jatuh tempo pada {$loan->due_date->format('d M Y')}",
            'data' => ['loan_id' => $loan->id]
        ]);
    }

    public static function createFineNotification($userId, $fine)
    {
        return self::create([
            'user_id' => $userId,
            'type' => self::TYPE_FINE_NOTIFICATION,
            'title' => 'Pemberitahuan Denda Baru',
            'message' => "Anda memiliki denda sebesar Rp " . number_format($fine->amount, 0, ',', '.'),
            'data' => ['fine_id' => $fine->id]
        ]);
    }
}