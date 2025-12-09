<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FineDeskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $returnColumn = 'actual_return_date'; 

        if ($user->role === 'admin') {
            // ================= ADMIN VIEW =================
            
            // 1. Denda Closed (Sudah kembali)
            $unpaidClosedFines = Borrowing::whereNotNull($returnColumn)
                                   ->where('fine_amount', '>', 0)
                                   ->where(function($q) {
                                       $q->where('is_fine_paid', false)
                                         ->orWhereNull('is_fine_paid');
                                   })
                                   ->sum('fine_amount');

            // 2. Denda Active (Masih dipinjam tapi telat)
            $activeOverdueBorrowings = Borrowing::whereNull($returnColumn)
                                       ->where('due_date', '<', now())
                                       ->get();
            
            $activeFinesTotal = 0;
            $activeOverdueUserIds = [];

            foreach ($activeOverdueBorrowings as $borrowing) {
                // PERBAIKAN DISINI: Pakai abs() agar hasilnya positif
                // logic: ceil(abs(selisih hari))
                $daysOverdue = ceil(abs(now()->diffInDays($borrowing->due_date, false))); 
                
                $fine = $daysOverdue * 1000; 
                
                $activeFinesTotal += $fine;
                $activeOverdueUserIds[] = $borrowing->user_id;
            }

            // 3. Gabungkan
            $totalUnpaid = $unpaidClosedFines + $activeFinesTotal;

            // ... (Sisa kode ke bawah sama) ...
            $totalCollected = Borrowing::where('is_fine_paid', true)->sum('fine_amount');

            $userIdsClosed = Borrowing::whereNotNull($returnColumn)
                                    ->where('fine_amount', '>', 0)
                                    ->where('is_fine_paid', false)
                                    ->pluck('user_id')
                                    ->toArray();
            
            $allDebtorIds = array_unique(array_merge($userIdsClosed, $activeOverdueUserIds));
            $membersWithFines = count($allDebtorIds);

            $unpaidFines = Borrowing::with(['user', 'book'])
                                   ->whereNotNull($returnColumn)
                                   ->where('fine_amount', '>', 0)
                                   ->where(function($q) {
                                       $q->where('is_fine_paid', false)
                                         ->orWhereNull('is_fine_paid');
                                   })
                                   ->latest()
                                   ->paginate(20);

            $paymentHistory = Borrowing::with(['user', 'book'])
                                      ->where('is_fine_paid', true)
                                      ->latest()
                                      ->take(20)
                                      ->get();

            $activeFines = Borrowing::with(['user', 'book'])
                                   ->whereNull($returnColumn)
                                   ->where('due_date', '<', now())
                                   ->get();

            $stats = [
                'totalUnpaid' => $totalUnpaid,
                'totalCollected' => $totalCollected,
                'membersWithFines' => $membersWithFines,
                'activeFines' => $activeFines->count()
            ];

            return view('FineDesk.finedesk', compact('stats', 'unpaidFines', 'paymentHistory', 'activeFines'));
        
        } else {
            // ================= MEMBER VIEW =================
            // Jangan lupa tambahkan abs() disini juga untuk member
            
            $myUnpaidFines = Borrowing::with('book')
                                     ->where('user_id', $user->id)
                                     ->whereNotNull($returnColumn)
                                     ->where('fine_amount', '>', 0)
                                     ->where('is_fine_paid', false)
                                     ->latest()
                                     ->get();

            $myActiveFines = Borrowing::with('book')
                                     ->where('user_id', $user->id)
                                     ->whereNull($returnColumn)
                                     ->where('due_date', '<', now())
                                     ->latest()
                                     ->get();

            $myRunningFineTotal = 0;
            foreach ($myActiveFines as $fine) {
                // PERBAIKAN DISINI JUGA
                $days = ceil(abs(now()->diffInDays($fine->due_date, false)));
                $myRunningFineTotal += ($days * 1000);
            }

            $myPaidFines = Borrowing::with('book')
                                   ->where('user_id', $user->id)
                                   ->where('is_fine_paid', true)
                                   ->latest()
                                   ->get();

            $stats = [
                'totalUnpaid' => $myUnpaidFines->sum('fine_amount') + $myRunningFineTotal,
                'totalPaid' => $myPaidFines->sum('fine_amount'),
                'activeFines' => $myActiveFines->count(),
            ];

            return view('FineDesk.finedesk', compact('stats', 'myUnpaidFines', 'myPaidFines', 'myActiveFines'));
        }
    }

    // Mark Paid
    public function markPaid(Request $request, $borrowingId)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $borrowing = Borrowing::findOrFail($borrowingId);

        if ($borrowing->is_fine_paid) {
            return response()->json(['success' => false, 'message' => 'Fine already paid'], 400);
        }

        $borrowing->update(['is_fine_paid' => true]);

        return response()->json(['success' => true, 'message' => 'Fine marked as paid successfully']);
    }
}