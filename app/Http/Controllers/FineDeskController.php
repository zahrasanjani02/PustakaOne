<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FineDeskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // ADMIN VIEW: Semua denda
            
            // Hitung statistik
            $totalUnpaid = Borrowing::whereNotNull('actual_return_date')
                                   ->where('fine_amount', '>', 0)
                                   ->where('is_fine_paid', false)
                                   ->sum('fine_amount');

            $totalCollected = Borrowing::whereNotNull('actual_return_date')
                                      ->where('fine_amount', '>', 0)
                                      ->where('is_fine_paid', true)
                                      ->sum('fine_amount');

            $membersWithFines = Borrowing::whereNotNull('actual_return_date')
                                        ->where('fine_amount', '>', 0)
                                        ->distinct('user_id')
                                        ->count('user_id');

            // Denda belum dibayar
            $unpaidFines = Borrowing::with(['user', 'book'])
                                   ->whereNotNull('actual_return_date')
                                   ->where('fine_amount', '>', 0)
                                   ->where('is_fine_paid', false)
                                   ->latest()
                                   ->paginate(20);

            // Riwayat pembayaran
            $paymentHistory = Borrowing::with(['user', 'book'])
                                      ->whereNotNull('actual_return_date')
                                      ->where('fine_amount', '>', 0)
                                      ->where('is_fine_paid', true)
                                      ->latest()
                                      ->take(20)
                                      ->get();

            // Denda yang masih aktif (buku belum dikembalikan tapi sudah overdue)
            $activeFines = Borrowing::with(['user', 'book'])
                                   ->whereNull('actual_return_date')
                                   ->where('due_date', '<', now())
                                   ->latest()
                                   ->get();

            $stats = [
                'totalUnpaid' => $totalUnpaid,
                'totalCollected' => $totalCollected,
                'membersWithFines' => $membersWithFines,
            ];

            return view('FineDesk.finedesk', compact('stats', 'unpaidFines', 'paymentHistory', 'activeFines'));
        } else {
            // MEMBER VIEW: Hanya denda sendiri
            
            $myUnpaidFines = Borrowing::with('book')
                                     ->where('user_id', $user->id)
                                     ->whereNotNull('actual_return_date')
                                     ->where('fine_amount', '>', 0)
                                     ->where('is_fine_paid', false)
                                     ->latest()
                                     ->get();

            $myPaidFines = Borrowing::with('book')
                                   ->where('user_id', $user->id)
                                   ->whereNotNull('actual_return_date')
                                   ->where('fine_amount', '>', 0)
                                   ->where('is_fine_paid', true)
                                   ->latest()
                                   ->get();

            $myActiveFines = Borrowing::with('book')
                                     ->where('user_id', $user->id)
                                     ->whereNull('actual_return_date')
                                     ->where('due_date', '<', now())
                                     ->latest()
                                     ->get();

            $stats = [
                'totalUnpaid' => $myUnpaidFines->sum('fine_amount'),
                'totalPaid' => $myPaidFines->sum('fine_amount'),
                'activeFines' => $myActiveFines->count(),
            ];

            return view('FineDesk.finedesk', compact('stats', 'myUnpaidFines', 'myPaidFines', 'myActiveFines'));
        }
    }

    // Mark fine as paid (admin only)
    public function markPaid(Request $request, $borrowingId)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $borrowing = Borrowing::findOrFail($borrowingId);

        if ($borrowing->is_fine_paid) {
            return response()->json([
                'success' => false,
                'message' => 'Fine already paid'
            ], 400);
        }

        try {
            $borrowing->update([
                'is_fine_paid' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Fine marked as paid successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}