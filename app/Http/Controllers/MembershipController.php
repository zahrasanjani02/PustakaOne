<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipRenewal;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MembershipController extends Controller
{
public function index()
    {
        $user = Auth::user();
        $returnCol = 'actual_return_date'; // Sesuaikan nama kolom DB kamu

        if ($user->role === 'admin') {
            // ================= ADMIN VIEW =================
            // (Bagian ini tidak berubah, tetap seperti sebelumnya)
            
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

            return view('membership.membership', compact('stats', 'members'));

        } else {
            // ================= MEMBER VIEW =================
            
            // 1. Total Buku Dipinjam (Seumur Hidup)
            $borrowedBooks = Borrowing::where('user_id', $user->id)->count();
            
            // 2. Buku yang Sedang Dipinjam (Active)
            $activeBorrowings = Borrowing::where('user_id', $user->id)
                                        ->whereNull($returnCol)
                                        ->count();
            
            // 3. HITUNG TOTAL DENDA (Fixed + Running) - PERBAIKAN DISINI
            
            // A. Denda dari buku yang sudah kembali (Closed)
            $closedFines = Borrowing::where('user_id', $user->id)
                                   ->whereNotNull($returnCol)
                                   ->where('fine_amount', '>', 0)
                                   ->where(function($q) {
                                       $q->where('is_fine_paid', false)
                                         ->orWhereNull('is_fine_paid');
                                   })
                                   ->sum('fine_amount');

            // B. Denda dari buku yang masih dipinjam tapi telat (Active Running)
            $activeOverdue = Borrowing::where('user_id', $user->id)
                                      ->whereNull($returnCol)
                                      ->where('due_date', '<', now())
                                      ->get();

            $runningFines = 0;
            foreach ($activeOverdue as $borrowing) {
                // Hitung hari: Bulat (ceil) dan Positif (abs)
                $days = ceil(abs(now()->diffInDays($borrowing->due_date, false)));
                $runningFines += ($days * 1000); // Rp 1.000 per hari
            }

            // Total Gabungan
            $totalUnpaidFines = $closedFines + $runningFines;

            $stats = [
                'borrowedBooks' => $borrowedBooks,
                'activeBorrowings' => $activeBorrowings,
                'unpaidFines' => $totalUnpaidFines, // Gunakan hasil hitungan baru
            ];

            return view('membership.membership', compact('stats'));
        }
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        // View form untuk tambah member baru
        return view('membership.create');
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'membership_start' => 'nullable|date',
            'membership_end' => 'nullable|date|after_or_equal:membership_start',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            // Perbaikan: Pastikan format tanggal benar
            'membership_start' => $request->membership_start ? Carbon::parse($request->membership_start)->format('Y-m-d') : null,
            'membership_end' => $request->membership_end ? Carbon::parse($request->membership_end)->format('Y-m-d') : null,
            'role' => 'member',
        ]);

        return redirect()->route('membership.index')->with('success', 'Member baru berhasil ditambahkan!');
    }


    /**
     * Show the form for editing the specified member.
     */
    public function edit(User $membership) // Menggunakan $membership karena route resource mengikat ke User Model
    {
        return view('membership.edit', compact('membership'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, User $membership)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($membership->id)],
            'phone' => 'nullable|string|max:20',
            'membership_start' => 'nullable|date',
            'membership_end' => 'nullable|date|after_or_equal:membership_start',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'phone');
        
        // Perbaikan: Parsing tanggal sebelum update
        $data['membership_start'] = $request->membership_start ? Carbon::parse($request->membership_start)->format('Y-m-d') : null;
        $data['membership_end'] = $request->membership_end ? Carbon::parse($request->membership_end)->format('Y-m-d') : null;
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $membership->update($data);

        return redirect()->route('membership.index')->with('success', 'Data member berhasil diperbarui!');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(User $membership)
    {
        $membership->delete();

        return redirect()->route('membership.index')->with('success', 'Member berhasil dihapus!');
    }

    public function renewForm()
    {
        return view('membership.renew');
    }

        public function renewProcess(Request $request)
    {
        // 1. Validasi (Hapus validasi file)
        $request->validate([
            'duration' => 'required|in:30,180,365',
            'payment_method' => 'required', // Tangkap metode pembayaran
        ]);

        // 2. Set Harga
        $prices = [
            30 => 50000,
            180 => 250000,
            365 => 450000,
        ];
        $amount = $prices[$request->duration];
        
        // Buat Order ID Unik
        $orderId = 'MEM-' . time() . '-' . Auth::id();

        // 3. Simpan ke Database (Awal)
        $renewal = MembershipRenewal::create([
            'user_id' => Auth::id(),
            'order_id' => $orderId,
            'duration_days' => $request->duration,
            'amount' => $amount,
            'payment_status' => 'pending', 
            // Kolom snap_token nanti diupdate
        ]);

        // 4. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 5. Tentukan Payment Channel Midtrans
        // Mapping input user ke kode teknis Midtrans
        $enabledPayments = [];
        if ($request->payment_method == 'qris') {
            $enabledPayments = ['gopay', 'qris']; // QRIS support gopay/ovo/dana
        } elseif ($request->payment_method == 'bri') {
            $enabledPayments = ['bri_epay', 'bank_transfer'];
        } elseif ($request->payment_method == 'bni') {
            $enabledPayments = ['bni_va', 'bank_transfer'];
        } elseif ($request->payment_method == 'echannel') {
            $enabledPayments = ['echannel']; // Mandiri Bill
        } else {
            $enabledPayments = ['gopay', 'bank_transfer', 'echannel']; // Default semua
        }
    }

}