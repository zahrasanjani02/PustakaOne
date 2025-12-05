<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // ADMIN VIEW: Semua member
            
            $totalMembers = User::where('role', 'member')->count();
            $activeMembers = User::where('role', 'member')
                                ->whereNotNull('membership_end')
                                ->where('membership_end', '>=', now())
                                ->count();
            
            $expiringMembers = User::where('role', 'member')
                                  ->whereNotNull('membership_end')
                                  ->whereBetween('membership_end', [now(), now()->addDays(30)])
                                  ->count();
            
            $inactiveMembers = User::where('role', 'member')
                                  ->where(function($q) {
                                      $q->whereNull('membership_end')
                                        ->orWhere('membership_end', '<', now());
                                  })
                                  ->count();

            $members = User::where('role', 'member')
                          ->withCount('borrowings')
                          ->latest()
                          ->paginate(20);

            $stats = [
                'totalMembers' => $totalMembers,
                'activeMembers' => $activeMembers,
                'expiringMembers' => $expiringMembers,
                'inactiveMembers' => $inactiveMembers,
            ];

            return view('Membership.membership', compact('stats', 'members'));
        } else {
            // MEMBER VIEW: Info personal
            
            $borrowedBooks = Borrowing::where('user_id', $user->id)->count();
            $activeBorrowings = Borrowing::where('user_id', $user->id)
                                        ->whereNull('actual_return_date')
                                        ->count();
            
            $unpaidFines = Borrowing::where('user_id', $user->id)
                                   ->whereNotNull('actual_return_date')
                                   ->where('fine_amount', '>', 0)
                                   ->where('is_fine_paid', false)
                                   ->sum('fine_amount');

            $stats = [
                'borrowedBooks' => $borrowedBooks,
                'activeBorrowings' => $activeBorrowings,
                'unpaidFines' => $unpaidFines,
            ];

            return view('Membership.membership', compact('stats'));
        }
    }
}