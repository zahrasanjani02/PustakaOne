<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

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
        'cover_image'
    ];

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

    // Check apakah buku ini difavoritkan oleh user tertentu
    public function isFavoritedBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    // Check apakah buku masih tersedia
    public function isAvailable()
    {
        return $this->available_copies > 0;
    }

    // Get emoji berdasarkan kategori (untuk fallback jika tidak ada cover_image)
    public function getCategoryEmoji()
    {
        $emojis = [
            'Biography' => '📚',
            'Kids' => '🎨',
            'Sports' => '🏏',
            'Technology' => '💻',
            'Fiction' => '📖',
            'Self-Help' => '🧠',
            'Science' => '🔬',
            'History' => '📜',
            'Business' => '💼',
        ];

        return $emojis[$this->category] ?? '📚';
    }
}