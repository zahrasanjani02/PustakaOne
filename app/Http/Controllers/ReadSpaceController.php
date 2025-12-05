<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadSpaceController extends Controller
{
    // Menampilkan katalog buku
    public function index(Request $request)
    {
        $query = Book::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Untuk admin: pagination 20 items
        // Untuk member: pagination 12 items
        $perPage = Auth::check() && Auth::user()->role === 'admin' ? 20 : 12;
        $books = $query->paginate($perPage);
        
        $categories = Book::distinct()->pluck('category')->filter();
        
        // Data tambahan untuk admin
        $stats = [];
        if (Auth::check() && Auth::user()->role === 'admin') {
            $stats = [
                'totalBooks' => Book::count(),
                'totalAvailable' => Book::sum('available_copies'),
                'totalBorrowed' => Borrowing::whereNull('returned_at')->count(),
                'lowStock' => Book::where('available_copies', '<=', 2)->where('available_copies', '>', 0)->count()
            ];
        }

        return view('ReadSpace.readspace', compact('books', 'categories', 'stats'));
    }

    // Menampilkan detail buku
    public function show($id)
    {
        $book = Book::findOrFail($id);
        
        // Check apakah user sudah login dan buku ini difavoritkan
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = $book->isFavoritedBy(Auth::id());
        }

        return view('ReadSpace.book-detail', compact('book', 'isFavorited'));
    }

    // Toggle favorite (tambah/hapus dari favorite)
    public function toggleFavorite(Request $request, $bookId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $book = Book::findOrFail($bookId);
        $userId = Auth::id();

        // Check apakah sudah difavoritkan
        $favorite = Favorite::where('user_id', $userId)
                           ->where('book_id', $bookId)
                           ->first();

        if ($favorite) {
            // Hapus dari favorite
            $favorite->delete();
            return response()->json([
                'success' => true,
                'isFavorited' => false,
                'message' => 'Buku dihapus dari favorit'
            ]);
        } else {
            // Tambah ke favorite
            Favorite::create([
                'user_id' => $userId,
                'book_id' => $bookId
            ]);
            return response()->json([
                'success' => true,
                'isFavorited' => true,
                'message' => 'Buku ditambahkan ke favorit'
            ]);
        }
    }

    // Menampilkan daftar buku favorit user
    public function favorites()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $favorites = Auth::user()->favorites()->with('book')->latest()->get();
        
        return view('ReadSpace.favorites', compact('favorites'));
    }

    // ========== METHOD BARU: BORROW BOOK ==========
    public function borrowBook(Request $request, $bookId)
    {
        // Validasi: User harus login
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        // Validasi 1: Cek apakah buku tersedia
        if ($book->available_copies <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Buku ini sedang tidak tersedia'
            ], 400);
        }

        // Validasi 2: Cek apakah user sudah pinjam buku yang sama dan belum dikembalikan
        $existingBorrowing = Borrowing::where('user_id', $user->id)
                                      ->where('book_id', $bookId)
                                      ->whereNull('returned_at')
                                      ->first();

        if ($existingBorrowing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah meminjam buku ini dan belum mengembalikannya'
            ], 400);
        }

        // Validasi 3: Cek apakah user sudah meminjam lebih dari 3 buku (limit)
        $activeBorrowings = Borrowing::where('user_id', $user->id)
                                     ->whereNull('returned_at')
                                     ->count();

        if ($activeBorrowings >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mencapai batas maksimal peminjaman (3 buku)'
            ], 400);
        }

        // Proses peminjaman
        // Proses peminjaman
try {
    // Buat record borrowing baru
    $borrowing = Borrowing::create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'borrowed_at' => now(),
        'due_date' => now()->addDays(14)->toDateString(), // ← TAMBAHKAN ->toDateString()
        'status' => 'active' // ← GANTI dari 'borrowed' ke 'active' (sesuai enum di migration)
    ]);

    // Kurangi available_copies
    $book->decrement('available_copies');

    return response()->json([
        'success' => true,
        'message' => 'Buku berhasil dipinjam! Harap kembalikan dalam 14 hari.',
        'borrowing' => $borrowing
    ]);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Terjadi kesalahan saat meminjam buku: ' . $e->getMessage()
    ], 500);
}
    }
}