<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'actual_return_date',
        'status',
        'fine_amount',
        'is_fine_paid',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'actual_return_date' => 'date',
    ];

    // Relasi ke User (Member)
    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}