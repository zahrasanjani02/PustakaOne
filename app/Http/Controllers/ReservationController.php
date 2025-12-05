<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // ADMIN VIEW
        $stats = [
            'activeBorrowings' => Borrowing::whereNull('actual_return_date')->count(), 
            'overdue' => Borrowing::whereNull('actual_return_date') 
                                 ->where('due_date', '<', now())
                                 ->count(),
            'returnedToday' => Borrowing::whereNotNull('actual_return_date') 
                                       ->whereDate('actual_return_date', today())
                                       ->count(),
            'totalBorrowed' => Borrowing::whereNotNull('actual_return_date')->count(), 
        ];

        $allBorrowings = Borrowing::with(['user', 'book'])
                                  ->whereNull('actual_return_date') 
                                  ->latest()
                                  ->paginate(20);

        $overdueBorrowings = Borrowing::with(['user', 'book'])
                                      ->whereNull('actual_return_date') 
                                      ->where('due_date', '<', now())
                                      ->latest()
                                      ->get();

        $history = Borrowing::with(['user', 'book'])
                            ->whereNotNull('actual_return_date')
                            ->latest()
                            ->take(50)
                            ->get();

        return view('Reservation.reservation', compact('stats', 'allBorrowings', 'overdueBorrowings', 'history'));
    } else {
        // MEMBER VIEW
        $myActiveBorrowings = Borrowing::with('book')
                                       ->where('user_id', $user->id)
                                       ->whereNull('actual_return_date') 
                                       ->latest()
                                       ->get();

        $myHistory = Borrowing::with('book')
                              ->where('user_id', $user->id)
                              ->whereNotNull('actual_return_date') 
                              ->latest()
                              ->take(10)
                              ->get();

        $stats = [
            'currentBorrowed' => $myActiveBorrowings->count(),
            'overdue' => $myActiveBorrowings->filter(function($b) {
                return $b->due_date < now();
            })->count(),
            'totalBorrowed' => Borrowing::where('user_id', $user->id)->count(),
        ];

        return view('Reservation.reservation', compact('myActiveBorrowings', 'myHistory', 'stats'));
    }
}

    // Request return book (untuk member)
    public function requestReturn(Request $request, $borrowingId)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Please login first'
        ], 401);
    }

    $borrowing = Borrowing::findOrFail($borrowingId);

    if ($borrowing->user_id !== Auth::id()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 403);
    }

    if ($borrowing->actual_return_date) { 
        return response()->json([
            'success' => false,
            'message' => 'Book already returned'
        ], 400);
    }

    try {
        $borrowing->update([
            'status' => 'pending' 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Return request submitted. Please return the book to the library.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}

    // Mark book as returned (untuk admin)
    public function markReturned(Request $request, $borrowingId)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 403);
    }

    $borrowing = Borrowing::with('book')->findOrFail($borrowingId);

    // Validasi: Pastikan belum dikembalikan
    if ($borrowing->actual_return_date) { 
        return response()->json([
            'success' => false,
            'message' => 'Book already returned'
        ], 400);
    }

    try {
        // Hitung denda jika overdue
        $fine = 0;
        if (now() > $borrowing->due_date) {
            $overdueDays = now()->diffInDays($borrowing->due_date);
            $fine = $overdueDays * 1000;
        }

        // Update borrowing
        $borrowing->update([
            'actual_return_date' => now()->toDateString(), 
            'status' => 'returned',
            'fine_amount' => $fine
        ]);

        // Kembalikan stok buku
        $borrowing->book->increment('available_copies');

        return response()->json([
            'success' => true,
            'message' => 'Book returned successfully' . ($fine > 0 ? '. Fine: Rp ' . number_format($fine) : ''),
            'fine' => $fine
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}
}