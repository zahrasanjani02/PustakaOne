<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin atau user
        'phone',
        'address',
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

    // Relasi ke borrowings
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // Relasi ke favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Check apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check apakah user adalah member biasa
    public function isUser()
    {
        return $this->role === 'user';
    }
}