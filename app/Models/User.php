<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin', 'pegawai', 'mahasiswa'
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
        ];
    }

    // ========= RELATIONSHIPS =========
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ========= ROLE HELPERS =========
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    // ========= DENDA =========
    public function hasUnpaidFines(): bool
    {
        return $this->loans()
            ->where('fine', '>', 0)
            ->whereNull('returned_at') // masih dipinjam
            ->exists();
    }
}
