<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\Borrowing; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReadSpaceController extends Controller
{
    // ==========================================
    // PUBLIC / SHARED FEATURES (INDEX & SHOW)
    // ==========================================

    // Menampilkan katalog buku
    public function index(Request $request)
    {
        $query = Book::query();

        // 1. Search Logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // 2. Category Filter
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Pagination: Admin dapat 20 item, Member 12 item
        $perPage = Auth::check() && Auth::user()->role === 'admin' ? 20 : 12;
        $books = $query->paginate($perPage);
        
        $categories = Book::distinct()->pluck('category')->filter();
        
        // 3. STATISTIK ADMIN
        $stats = [];
        if (Auth::check() && Auth::user()->role === 'admin') {
            
            $activeBorrowingsCount = Borrowing::where('status', 'active')->count();

            // --- LOGIKA LOW STOCK BARU (1/3 dari Total) ---
            // Kita ambil semua buku yang stoknya ada (lebih dari 0)
            // Lalu kita filter satu per satu menggunakan PHP
            $lowStockCount = Book::where('available_copies', '>', 0)
                ->get(['total_copies', 'available_copies']) // Ambil kolom yg butuh aja biar ringan
                ->filter(function ($book) {
                    // Rumus: Ambang batas = Total dibagi 3, dibulatkan ke atas (ceil)
                    $threshold = ceil($book->total_copies / 3);
                    
                    // Jika stok tersedia <= ambang batas, maka Low Stock
                    return $book->available_copies <= $threshold;
                })
                ->count();

            $stats = [
                'totalBooks' => Book::count(),
                'totalAvailable' => Book::sum('available_copies'),
                'totalBorrowed' => $activeBorrowingsCount,
                'lowStock' => $lowStockCount // <--- Masukkan hasil hitungan di sini
            ];
        }

        return view('ReadSpace.readspace', compact('books', 'categories', 'stats'));
    }

    // Menampilkan detail buku
    public function show($id)
    {
        $book = Book::findOrFail($id);
        
        // Cek apakah user sudah memfavoritkan buku ini
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = $book->isFavoritedBy(Auth::id());
        }

        return view('ReadSpace.book-detail', compact('book', 'isFavorited'));
    }

    // ==========================================
    // MEMBER FEATURES (FAVORITE & BORROW)
    // ==========================================

    // Toggle favorite (tambah/hapus)
    public function toggleFavorite(Request $request, $bookId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $book = Book::findOrFail($bookId);
        $userId = Auth::id();

        $favorite = Favorite::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['success' => true, 'isFavorited' => false, 'message' => 'Buku dihapus dari favorit']);
        } else {
            Favorite::create(['user_id' => $userId, 'book_id' => $bookId]);
            return response()->json(['success' => true, 'isFavorited' => true, 'message' => 'Buku ditambahkan ke favorit']);
        }
    }

    // Menampilkan halaman favorit
    public function favorites()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $favorites = Auth::user()->favorites()->with('book')->latest()->get();
        return view('ReadSpace.favorites', compact('favorites'));
    }

    // Proses Peminjaman Buku
public function borrowBook(Request $request, $bookId)
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        // --- PERBAIKAN LOGIKA MEMBERSHIP ---
        
        // Member dianggap AKTIF hanya jika:
        // 1. Kolom membership_end TIDAK KOSONG (NotNull)
        // 2. DAN Tanggalnya masih berlaku (Greater than or Equal to Today)
        $isMembershipActive = $user->membership_end && \Carbon\Carbon::parse($user->membership_end)->endOfDay()->gte(now());

        if ($isMembershipActive) {
            // KONDISI MEMBER AKTIF
            $maxBooks = 3;
            $loanDuration = 14; 
            $statusLabel = "Membership Active";
        } else {
            // KONDISI MEMBER EXPIRED / BELUM JOIN (NULL)
            $maxBooks = 1;
            $loanDuration = 7; 
            $statusLabel = "Membership Expired/Inactive";
        }

        // --- VALIDASI ---

        // Validasi 1: Stok habis
        if ($book->available_copies <= 0) {
            return response()->json(['success' => false, 'message' => 'Buku ini sedang tidak tersedia'], 400);
        }

        // Validasi 2: Sudah pinjam buku yang sama
        $existingBorrowing = Borrowing::where('user_id', $user->id)
                                      ->where('book_id', $bookId)
                                      ->whereNull('actual_return_date') // atau status != returned
                                      ->first();

        if ($existingBorrowing) {
            return response()->json(['success' => false, 'message' => 'Anda sudah meminjam buku ini.'], 400);
        }

        // Validasi 3: Cek Limit Jumlah Buku
        $activeBorrowingsCount = Borrowing::where('user_id', $user->id)
                                     ->whereNull('actual_return_date')
                                     ->count();

        if ($activeBorrowingsCount >= $maxBooks) {
            return response()->json([
                'success' => false, 
                'message' => "Gagal! Status: {$statusLabel}. Batas pinjam hanya {$maxBooks} buku. Harap kembalikan buku lain atau perbarui membership."
            ], 400);
        }

        try {
            // --- PROSES PINJAM ---
            Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'due_date' => now()->addDays($loanDuration)->toDateString(),
                'status' => 'active',
                'extension_count' => 0
            ]);

            $book->decrement('available_copies');

            return response()->json([
                'success' => true,
                'message' => "Berhasil! Durasi pinjam: {$loanDuration} hari ({$statusLabel})."
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // ==========================================
    // ADMIN FEATURES (CREATE, EDIT, UPDATE, DELETE)
    // ==========================================

    // 1. Tampilkan Halaman Tambah Buku (CREATE)
    public function create()
    {
        $categories = ['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography', 'Technology', 'Children', 'Horror', 'Romance', 'Sports'];
        return view('ReadSpace.create', compact('categories'));
    }

    // 2. Proses Simpan Buku Baru (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'total_copies' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'isbn' => 'nullable|string',
            'publisher' => 'nullable|string',
            'published_year' => 'nullable|integer',
            'language' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $data = $request->except(['cover_image', '_token']);

        // Untuk buku baru, available copies = total copies
        $data['available_copies'] = $request->total_copies;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('book_covers', 'public');
        }

        Book::create($data);

        return redirect()->route('readspace')->with('success', 'New book added successfully!');
    }

    // 3. Tampilkan Halaman Edit (EDIT)
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = ['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography', 'Technology', 'Children', 'Horror', 'Romance', 'Sports'];

        return view('ReadSpace.edit', compact('book', 'categories'));
    }

    // 4. Proses Update Data (UPDATE)
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'total_copies' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['cover_image', '_token', '_method']);

        // Logika update stok: Hitung dulu yang sedang dipinjam
        $borrowedCount = $book->total_copies - $book->available_copies;
        
        // Stok tersedia baru = Total stok baru - jumlah yang dipinjam
        $data['available_copies'] = $request->total_copies - $borrowedCount;

        // Validasi agar stok tidak minus
        if ($data['available_copies'] < 0) {
            return back()->withErrors(['total_copies' => 'Total copies cannot be less than borrowed books (' . $borrowedCount . ').']);
        }

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('book_covers', 'public');
        }

        $book->update($data);

        return redirect()->route('readspace')->with('success', 'Book updated successfully!');
    }

    // 5. Proses Delete Buku (DESTROY)
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return response()->json(['success' => true, 'message' => 'Book deleted successfully']);
    }
}