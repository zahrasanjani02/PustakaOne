<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Nama kolom tanggal kembali di database kamu
        // Sesuaikan jika menggunakan 'returned_at' atau 'actual_return_date'
        // Berdasarkan kode kamu terakhir, kamu pakai 'actual_return_date'
        $returnCol = 'actual_return_date'; 

        if ($user->role === 'admin') {
            // ================= ADMIN DASHBOARD =================
            
            // 1. Basic Stats
            $totalBooks = Book::count();
            $totalMembers = User::where('role', 'member')->count();
            $activeBorrowings = Borrowing::whereNull($returnCol)->count();

            // 2. Hitung Total Denda (Closed + Active)
            
            // A. Denda dari buku yang SUDAH dikembalikan (Closed)
            $unpaidClosed = Borrowing::whereNotNull($returnCol)
                                   ->where('fine_amount', '>', 0)
                                   ->where(function($q) {
                                       $q->where('is_fine_paid', false)
                                         ->orWhereNull('is_fine_paid');
                                   })
                                   ->sum('fine_amount');

            // B. Denda dari buku yang MASIH dipinjam tapi Telat (Active Running)
            $activeOverdue = Borrowing::whereNull($returnCol)
                                      ->where('due_date', '<', now())
                                      ->get();
            
            $activeFineTotal = 0;
            foreach($activeOverdue as $borrowing) {
                // Hitung selisih hari (Bulat & Positif)
                $days = ceil(abs(now()->diffInDays($borrowing->due_date, false)));
                $activeFineTotal += ($days * 1000); // Rp 1.000 per hari
            }

            // Total Gabungan
            $totalUnpaidFines = $unpaidClosed + $activeFineTotal;

            // 3. Data Tables
            $recentBorrowings = Borrowing::with(['user', 'book'])->latest()->take(5)->get();
            
            // Data overdue untuk tabel (Pakai data yang sama dengan perhitungan di atas)
            $overdueBorrowings = $activeOverdue->take(5); 

            $pendingReturns = Borrowing::where('status', 'return_requested')->count();

            $stats = [
                'totalBooks' => $totalBooks,
                'totalMembers' => $totalMembers,
                'activeBorrowings' => $activeBorrowings,
                'unpaidFines' => $totalUnpaidFines, // Angka ini sekarang sudah benar
            ];

            return view('Dashboard', compact(
                'stats', 
                'recentBorrowings', 
                'overdueBorrowings',
                'pendingReturns'
            ));

        } else {
            // ================= MEMBER DASHBOARD =================
            
            // 1. Peminjaman Saya
            $currentlyBorrowed = Borrowing::where('user_id', $user->id)
                                         ->whereNull($returnCol)
                                         ->count();

            $totalBorrowed = Borrowing::where('user_id', $user->id)->count();

            // 2. Hitung Denda Saya (Closed + Active)
            
            // A. Closed
            $myUnpaidClosed = Borrowing::where('user_id', $user->id)
                                   ->whereNotNull($returnCol)
                                   ->where('fine_amount', '>', 0)
                                   ->where(function($q) {
                                       $q->where('is_fine_paid', false)
                                         ->orWhereNull('is_fine_paid');
                                   })
                                   ->sum('fine_amount');

            // B. Active
            $myActiveOverdue = Borrowing::where('user_id', $user->id)
                                    ->whereNull($returnCol)
                                    ->where('due_date', '<', now())
                                    ->get();

            $myActiveFineTotal = 0;
            foreach($myActiveOverdue as $borrowing) {
                $days = ceil(abs(now()->diffInDays($borrowing->due_date, false)));
                $myActiveFineTotal += ($days * 1000);
            }

            // 3. Data Lain
            $myBorrowings = Borrowing::with('book')
                                    ->where('user_id', $user->id)
                                    ->whereNull($returnCol)
                                    ->get();

            $popularBooks = Book::where('available_copies', '>', 0)
                              ->inRandomOrder()
                              ->take(10)
                              ->get();

            $myFavorites = Favorite::with('book')
                                   ->where('user_id', $user->id)
                                   ->latest()
                                   ->take(6)
                                   ->get();
        
            $stats = [
                'currentlyBorrowed' => $currentlyBorrowed,
                'totalBorrowed' => $totalBorrowed,
                'unpaidFines' => $myUnpaidClosed + $myActiveFineTotal, // Update total denda
                'overdueCount' => $myActiveOverdue->count(),
                'totalFavorites' => Favorite::where('user_id', $user->id)->count(),
            ];

            return view('Dashboard', compact(
                'stats',
                'myBorrowings',
                'myFavorites',
                'popularBooks'
            ));
        }
    }
}