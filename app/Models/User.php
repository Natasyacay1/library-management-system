<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'pegawai';
    const ROLE_STUDENT = 'mahasiswa';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'university_email',
        'phone',
        'address',
        'fines_balance',
        'is_blocked'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fines_balance' => 'decimal:2',
            'is_blocked' => 'boolean',
        ];
    }

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoans()
    {
        return $this->loans()->where('status', 'borrowed');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    // Scopes
    public function scopeStudents($query)
    {
        return $query->where('role', self::ROLE_STUDENT);
    }

    public function scopeStaff($query)
    {
        return $query->where('role', self::ROLE_STAFF);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isStudent()
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function hasOverdueFines()
    {
        return $this->fines_balance > 0;
    }

    public function canBorrowBooks()
    {
        return $this->isStudent() && !$this->is_blocked && !$this->hasOverdueFines();
    }

    public function getActiveLoansCount()
    {
        return $this->activeLoans()->count();
    }

    public function getRoleName()
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_STAFF => 'Pegawai Perpustakaan',
            self::ROLE_STUDENT => 'Mahasiswa',
            default => 'Pengguna',
        };
    }
}