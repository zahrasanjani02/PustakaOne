<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // ADMIN DASHBOARD DATA
            
            $totalBooks = Book::count();
            $totalMembers = User::where('role', 'member')->count();
            $activeBorrowings = Borrowing::whereNull('actual_return_date')->count();
            $unpaidFines = Borrowing::where('is_fine_paid', false)
                                   ->where('fine_amount', '>', 0)
                                   ->sum('fine_amount');

            // Recent borrowings
            $recentBorrowings = Borrowing::with(['user', 'book'])
                                        ->latest()
                                        ->take(5)
                                        ->get();

            // Overdue borrowings
            $overdueBorrowings = Borrowing::with(['user', 'book'])
                                         ->whereNull('actual_return_date')
                                         ->where('due_date', '<', now())
                                         ->orderBy('due_date', 'asc')
                                         ->take(5)
                                         ->get();

            // Pending return requests
            $pendingReturns = Borrowing::with(['user', 'book'])
                                      ->where('status', 'pending')
                                      ->whereNull('actual_return_date')
                                      ->count();

            $stats = [
                'totalBooks' => $totalBooks,
                'totalMembers' => $totalMembers,
                'activeBorrowings' => $activeBorrowings,
                'unpaidFines' => $unpaidFines,
            ];

            return view('dashboard', compact(
                'stats', 
                'recentBorrowings', 
                'overdueBorrowings',
                'pendingReturns'
            ));

        } else {
            // MEMBER DASHBOARD DATA
            
            $currentlyBorrowed = Borrowing::where('user_id', $user->id)
                                         ->whereNull('actual_return_date')
                                         ->count();

            $totalBorrowed = Borrowing::where('user_id', $user->id)->count();

            $unpaidFines = Borrowing::where('user_id', $user->id)
                                   ->where('is_fine_paid', false)
                                   ->where('fine_amount', '>', 0)
                                   ->sum('fine_amount');

            // My active borrowings
            $myBorrowings = Borrowing::with('book')
                                    ->where('user_id', $user->id)
                                    ->whereNull('actual_return_date')
                                    ->get();

            // Overdue check
            $overdueCount = Borrowing::where('user_id', $user->id)
                                    ->whereNull('actual_return_date')
                                    ->where('due_date', '<', now())
                                    ->count();

            // Popular books (for recommendations)
            $popularBooks = Book::where('available_copies', '>', 0)
                              ->take(6)
                              ->get();

            // My Favorite Books
$myFavorites = Favorite::with('book')
->where('user_id', $user->id)
->latest()
->take(6)  // ← Ambil 6 buku favorit
->get();

        
            $stats = [
                'currentlyBorrowed' => $currentlyBorrowed,
                'totalBorrowed' => $totalBorrowed,
                'unpaidFines' => $unpaidFines,
                'overdueCount' => $overdueCount,
                'totalFavorites' => $myFavorites->count(),
            ];

            return view('dashboard', compact(
                'stats',
                'myBorrowings',
                'myFavorites',
                'popularBooks'
            ));
        }
    }
}