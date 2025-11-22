<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'member')->count();
        $activeBorrowings = Borrowing::where('status', 'active')->count();
        $unpaidFines = 2450000; // Rp 2.45M - dari database nanti

        // Get overdue books
        $overdueBooks = Borrowing::where('status', 'overdue')
            ->with('member', 'book')
            ->limit(5)
            ->get();

        // Get pending requests
        $pendingRequests = [
            ['type' => 'Permintaan Peminjaman', 'count' => 12, 'status' => 'pending'],
            ['type' => 'Registrasi Member', 'count' => 8, 'status' => 'pending'],
            ['type' => 'Reservasi Ready', 'count' => 5, 'status' => 'action'],
        ];

        return view('dashboard', [
            'totalBooks' => $totalBooks,
            'totalMembers' => $totalMembers,
            'activeBorrowings' => $activeBorrowings,
            'unpaidFines' => $unpaidFines,
            'overdueBooks' => $overdueBooks,
            'pendingRequests' => $pendingRequests,
        ]);
    }
}