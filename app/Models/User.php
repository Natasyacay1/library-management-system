<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Loan;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // kalau kamu belum pakai Review/Notification model, boleh dihapus dua relasi ini
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ROLE helper
    public function isAdmin()     { return $this->role === 'admin'; }
    public function isPegawai()   { return $this->role === 'pegawai'; }
    public function isMahasiswa() { return $this->role === 'mahasiswa'; }

    // cek denda tertunggak (dipakai mahasiswa.borrow)
    public function hasUnpaidFines(): bool
    {
        return $this->loans()
            ->where('fine', '>', 0)
            ->whereNull('returned_at')
            ->exists();
    }

    
}
