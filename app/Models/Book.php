<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisher',
        'year',
        'category',
        'description',
        'total_copies',
        'available_copies',
        'fine_per_day',
        'cover_image',
    ];

    // Relasi ke borrowings
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}