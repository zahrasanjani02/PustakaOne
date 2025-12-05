<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Halaman My Favorites
    public function index()
    {
        $user = Auth::user();
        
        $favorites = Favorite::with('book')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->paginate(12);
        
        $stats = [
            'totalFavorites' => $favorites->total(),
        ];
        
        return view('Favorite.favorites', compact('favorites', 'stats'));
    }
    
    // Tambah ke favorites (AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
        
        $user = Auth::user();
        
        // Cek apakah sudah difavoritkan
        $exists = Favorite::where('user_id', $user->id)
                         ->where('book_id', $request->book_id)
                         ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Book is already in your favorites!'
            ], 400);
        }
        
        Favorite::create([
            'user_id' => $user->id,
            'book_id' => $request->book_id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Book added to favorites!'
        ]);
    }
    
    // Hapus dari favorites (AJAX)
    public function destroy($id)
    {
        $user = Auth::user();
        
        $favorite = Favorite::where('id', $id)
                           ->where('user_id', $user->id)
                           ->first();
        
        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Favorite not found!'
            ], 404);
        }
        
        $favorite->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Removed from favorites!'
        ]);
    }
}