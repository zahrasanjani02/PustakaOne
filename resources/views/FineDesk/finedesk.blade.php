@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #F5F7FA;
        color: #333;
    }

    /* ===== CONTENT ===== */
    .content {
        padding: 2rem 5%;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        min-height: calc(100vh - 70px);
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #666;
        font-size: 0.95rem;
    }

    /* ===== STATS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 5px solid;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-card.unpaid {
        border-left-color: #E74C3C;
    }

    .stat-card.paid {
        border-left-color: #6D9773;
    }

    .stat-card.collection {
        border-left-color: #BB8A52;
    }

    .stat-card.active {
        border-left-color: #F39C12;
    }

    .stat-icon {
        font-size: 2rem;
        min-width: 50px;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0C3B2E;
        margin-bottom: 0.2rem;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
    }

    /* ===== CARDS ===== */
    .card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #E8EAED;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #0C3B2E;
    }

    /* ===== ALERT BOX (untuk member) ===== */
    .alert-box {
        background: #FFF3CD;
        border-left: 5px solid #F39C12;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .alert-box-title {
        font-weight: 700;
        color: #856404;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .alert-box-text {
        color: #856404;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /* ===== FINE CARDS (untuk member) ===== */
    .fines-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .fine-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 5px solid;
    }

    .fine-card.unpaid {
        border-left-color: #E74C3C;
    }

    .fine-card.paid {
        border-left-color: #6D9773;
    }

    .fine-card.active {
        border-left-color: #F39C12;
    }

    .fine-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .fine-card-header {
        background: #F8F9FA;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #E8EAED;
    }

    .fine-card-title {
        font-weight: 700;
        color: #0C3B2E;
        font-size: 1rem;
        margin-bottom: 0.3rem;
    }

    .fine-card-author {
        font-size: 0.85rem;
        color: #666;
    }

    .fine-card-body {
        padding: 1.5rem;
    }

    .fine-detail-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .fine-detail-label {
        color: #666;
    }

    .fine-detail-value {
        font-weight: 600;
        color: #0C3B2E;
    }

    .fine-detail-value.overdue {
        color: #E74C3C;
    }

    .fine-amount-box {
        background: #FFF3CD;
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
        margin-top: 1rem;
    }

    .fine-amount-label {
        font-size: 0.8rem;
        color: #856404;
        margin-bottom: 0.3rem;
    }

    .fine-amount-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #E74C3C;
    }

    .fine-paid-box {
        background: #D5F4E6;
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
        margin-top: 1rem;
    }

    .fine-paid-label {
        font-size: 0.8rem;
        color: #27AE60;
        margin-bottom: 0.3rem;
    }

    .fine-paid-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #27AE60;
    }

    /* ===== TABLE ===== */
    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #F5F7FA;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #0C3B2E;
        border-bottom: 2px solid #E8EAED;
        font-size: 0.9rem;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #E8EAED;
    }

    tr:hover {
        background: #F9FAFB;
    }

    .badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-unpaid {
        background: #FADBD8;
        color: #E74C3C;
    }

    .badge-paid {
        background: #D5F4E6;
        color: #27AE60;
    }

    .badge-active {
        background: #FFF3CD;
        color: #856404;
    }

    /* ===== BUTTONS ===== */
    .btn-action {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: 0.3s ease;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        margin-right: 0.5rem;
    }

    .btn-mark-paid {
        background: #D5F4E6;
        color: #27AE60;
    }

    .btn-mark-paid:hover {
        background: #A3E9C5;
    }

    .btn-view {
        background: #D6EAF8;
        color: #0C3B2E;
    }

    .btn-view:hover {
        background: #AED6F1;
    }

    /* ===== TABS ===== */
    .tabs-container {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid #E8EAED;
        overflow-x: auto;
    }

    .tab-btn {
        padding: 1rem 1.5rem;
        background: none;
        border: none;
        color: #666;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        font-family: 'Poppins', sans-serif;
        white-space: nowrap;
    }

    .tab-btn:hover {
        color: #0C3B2E;
    }

    .tab-btn.active {
        color: #0C3B2E;
        border-bottom-color: #6D9773;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #999;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-state-text {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .navbar {
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            max-width: 250px;
            margin: 0;
        }

        .content {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .fines-grid {
            grid-template-columns: 1fr;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        table {
            font-size: 0.85rem;
        }

        td, th {
            padding: 0.75rem 0.5rem;
        }

        .tabs-container {
            flex-wrap: nowrap;
            overflow-x: scroll;
        }
    }
</style>

<!-- NAVBAR -->
<x-navbar/>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(event) {
    const menu = document.getElementById('userMenu');
    const profile = document.querySelector('.user-profile');
    
    if (profile && !profile.contains(event.target)) {
        menu.style.display = 'none';
    }
});
</script>

<!-- CONTENT -->
<div class="content">
    @if(auth()->user()->role === 'admin')
        {{-- ========== ADMIN VIEW ========== --}}
        
        <div class="page-header">
            <h1 class="page-title">FineDesk Management</h1>
            <p class="page-subtitle">Kelola, pantau, dan proses denda peminjaman buku</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card unpaid">
                <div class="stat-icon">⏳</div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($stats['totalUnpaid'] ?? 0) }}</div>
                    <div class="stat-label">Denda Belum Dibayar</div>
                </div>
            </div>

            <div class="stat-card paid">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($stats['totalCollected'] ?? 0) }}</div>
                    <div class="stat-label">Total Denda Terkumpul</div>
                </div>
            </div>

            <div class="stat-card collection">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['membersWithFines'] ?? 0 }} Member</div>
                    <div class="stat-label">Memiliki Denda</div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('unpaid')">⏳ Belum Dibayar ({{ $unpaidFines->total() }})</button>
            <button class="tab-btn" onclick="switchTab('active')">⚠️ Overdue Aktif ({{ $activeFines->count() }})</button>
            <button class="tab-btn" onclick="switchTab('history')">✅ Riwayat ({{ $paymentHistory->count() }})</button>
        </div>

        <!-- TAB: UNPAID FINES -->
        <div id="unpaid" class="tab-content active">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">📋 Denda Belum Dibayar</div>
                </div>
                @if($unpaidFines->count() > 0)
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Member</th>
                            <th>Buku</th>
                            <th>Due Date</th>
                            <th>Returned</th>
                            <th>Days Overdue</th>
                            <th>Denda</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        @foreach($unpaidFines as $fine)
                        <tr>
                            <td><strong>{{ $fine->user->name }}</strong><br><small>{{ $fine->user->email }}</small></td>
                            <td><strong>{{ $fine->book->title }}</strong><br><small>by {{ $fine->book->author }}</small></td>
                            <td>{{ $fine->due_date->format('d M Y') }}</td>
                            <td>{{ $fine->actual_return_date ? $fine->actual_return_date->format('d M Y') : '-' }}</td>
                            <td style="color: #E74C3C; font-weight: 600;">
                                {{ $fine->actual_return_date ? $fine->actual_return_date->diffInDays($fine->due_date) : now()->diffInDays($fine->due_date) }} days
                            </td>
                            <td><strong style="color: #E74C3C;">Rp {{ number_format($fine->fine_amount) }}</strong></td>
                            <td><span class="badge badge-unpaid">Unpaid</span></td>
                            <td>
                                <button class="btn-action btn-mark-paid" onclick="markPaid({{ $fine->id }}, '{{ $fine->user->name }}')">
                                    ✓ Mark Paid
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="margin-top: 1.5rem;">
                    {{ $unpaidFines->links() }}
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <div class="empty-state-text">No unpaid fines. Great!</div>
                </div>
                @endif
            </div>
        </div>

        <!-- TAB: ACTIVE FINES (Overdue tapi belum dikembalikan) -->
        <div id="active" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">⚠️ Denda Aktif (Belum Dikembalikan)</div>
                </div>
                @if($activeFines->count() > 0)
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Member</th>
                            <th>Buku</th>
                            <th>Due Date</th>
                            <th>Days Overdue</th>
                            <th>Est. Denda</th>
                            <th>Status</th>
                        </tr>
                        @foreach($activeFines as $fine)
                        @php
                            $daysOverdue = now()->diffInDays($fine->due_date);
                            $estimatedFine = $daysOverdue * 1000;
                        @endphp
                        <tr>
                            <td><strong>{{ $fine->user->name }}</strong><br><small>{{ $fine->user->email }}</small></td>
                            <td><strong>{{ $fine->book->title }}</strong></td>
                            <td>{{ $fine->due_date->format('d M Y') }}</td>
                            <td style="color: #E74C3C; font-weight: 600;">{{ $daysOverdue }} days</td>
                            <td><strong style="color: #E74C3C;">Rp {{ number_format($estimatedFine) }}</strong></td>
                            <td><span class="badge badge-active">Still Borrowed</span></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <div class="empty-state-text">No active overdue borrowings</div>
                </div>
                @endif
            </div>
        </div>

        <!-- TAB: PAYMENT HISTORY -->
        <div id="history" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">✅ Riwayat Pembayaran Denda</div>
                </div>
                @if($paymentHistory->count() > 0)
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Member</th>
                            <th>Buku</th>
                            <th>Due Date</th>
                            <th>Returned</th>
                            <th>Days Overdue</th>
                            <th>Denda</th>
                            <th>Status</th>
                        </tr>
                        @foreach($paymentHistory as $fine)
                        <tr>
                            <td><strong>{{ $fine->user->name }}</strong></td>
                            <td><strong>{{ $fine->book->title }}</strong></td>
                            <td>{{ $fine->due_date->format('d M Y') }}</td>
                            <td>{{ $fine->actual_return_date->format('d M Y') }}</td>
                            <td>{{ $fine->actual_return_date->diffInDays($fine->due_date) }} days</td>
                            <td><strong style="color: #27AE60;">Rp {{ number_format($fine->fine_amount) }}</strong></td>
                            <td><span class="badge badge-paid">Paid</span></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <div class="empty-state-text">No payment history yet</div>
                </div>
                @endif
            </div>
        </div>

    @else
        {{-- ========== MEMBER VIEW ========== --}}
        
        <div class="page-header">
            <h1 class="page-title">My Fines</h1>
            <p class="page-subtitle">Kelola denda peminjaman buku Anda</p>
        </div>

        @if($myUnpaidFines->count() > 0)
        <div class="alert-box">
            <div class="alert-box-title">⚠️ Anda Memiliki Denda yang Belum Dibayar</div>
            <div class="alert-box-text">
                Total denda: <strong>Rp {{ number_format($stats['totalUnpaid']) }}</strong><br>
                Harap segera lunasi denda Anda untuk dapat meminjam buku kembali.<br>
                Hubungi pustakawan untuk melakukan pembayaran.
            </div>
        </div>
        @endif

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card unpaid">
                <div class="stat-icon">⏳</div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($stats['totalUnpaid'] ?? 0) }}</div>
                    <div class="stat-label">Denda Belum Dibayar</div>
                </div>
            </div>

            <div class="stat-card paid">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($stats['totalPaid'] ?? 0) }}</div>
                    <div class="stat-label">Total Denda Dibayar</div>
                </div>
            </div>

            <div class="stat-card active">
                <div class="stat-icon">⚠️</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['activeFines'] ?? 0 }}</div>
                    <div class="stat-label">Buku Overdue Aktif</div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('myunpaid')">⏳ Belum Dibayar ({{ $myUnpaidFines->count() }})</button>
            <button class="tab-btn" onclick="switchTab('myactive')">⚠️ Overdue Aktif ({{ $myActiveFines->count() }})</button>
            <button class="tab-btn" onclick="switchTab('mypaid')">✅ Sudah Dibayar ({{ $myPaidFines->count() }})</button>
        </div>

        <!-- TAB: MY UNPAID -->
        <div id="myunpaid" class="tab-content active">
            @if($myUnpaidFines->count() > 0)
            <div class="fines-grid">
                @foreach($myUnpaidFines as $fine)
                <div class="fine-card unpaid">
                    <div class="fine-card-header">
                        <div class="fine-card-title">{{ $fine->book->title }}</div>
                        <div class="fine-card-author">by {{ $fine->book->author }}</div>
                    </div>
                    <div class="fine-card-body">
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Due Date:</span>
                            <span class="fine-detail-value">{{ $fine->due_date->format('d M Y') }}</span>
                        </div>
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Returned:</span>
                            <span class="fine-detail-value">{{ $fine->actual_return_date->format('d M Y') }}</span>
                        </div>
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Days Overdue:</span>
                            <span class="fine-detail-value overdue">{{ $fine->actual_return_date->diffInDays($fine->due_date) }} days</span>
                        </div>
                        <div class="fine-amount-box">
                            <div class="fine-amount-label">Jumlah Denda</div>
                            <div class="fine-amount-value">Rp {{ number_format($fine->fine_amount) }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="card">
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <div class="empty-state-text">Tidak ada denda yang belum dibayar</div>
                </div>
            </div>
            @endif
        </div>

        <!-- TAB: MY ACTIVE OVERDUE -->
        <div id="myactive" class="tab-content">
            @if($myActiveFines->count() > 0)
            <div class="fines-grid">
                @foreach($myActiveFines as $fine)
                @php
                    $daysOverdue = now()->diffInDays($fine->due_date);
                    $estimatedFine = $daysOverdue * 1000;
                @endphp
                <div class="fine-card active">
                    <div class="fine-card-header">
                        <div class="fine-card-title">{{ $fine->book->title }}</div>
                        <div class="fine-card-author">by {{ $fine->book->author }}</div>
                    </div>
                    <div class="fine-card-body">
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Borrowed:</span>
                            <span class="fine-detail-value">{{ $fine->borrowed_at->format('d M Y') }}</span>
                        </div>
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Due Date:</span>
                            <span class="fine-detail-value">{{ $fine->due_date->format('d M Y') }}</span>
                        </div>
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Days Overdue:</span>
                            <span class="fine-detail-value overdue">{{ $daysOverdue }} days</span>
                        </div>
                        <div class="fine-amount-box">
                            <div class="fine-amount-label">Estimasi Denda (jika dikembalikan hari ini)</div>
                            <div class="fine-amount-value">Rp {{ number_format($estimatedFine) }}</div>
                        </div>
                        <div style="margin-top: 1rem; padding: 0.75rem; background: #FFF3CD; border-radius: 6px; text-align: center; font-size: 0.85rem; color: #856404;">
                            ⚠️ Harap segera kembalikan buku ini
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="card">
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <div class="empty-state-text">Tidak ada buku yang overdue</div>
                </div>
            </div>
            @endif
        </div>

        <!-- TAB: MY PAID -->
        <div id="mypaid" class="tab-content">
            @if($myPaidFines->count() > 0)
            <div class="fines-grid">
                @foreach($myPaidFines as $fine)
                <div class="fine-card paid">
                    <div class="fine-card-header">
                        <div class="fine-card-title">{{ $fine->book->title }}</div>
                        <div class="fine-card-author">by {{ $fine->book->author }}</div>
                    </div>
                    <div class="fine-card-body">
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Due Date:</span>
                            <span class="fine-detail-value">{{ $fine->due_date->format('d M Y') }}</span>
                        </div>
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Returned:</span>
                            <span class="fine-detail-value">{{ $fine->actual_return_date->format('d M Y') }}</span>
                        </div>
                        <div class="fine-detail-item">
                            <span class="fine-detail-label">Days Overdue:</span>
                            <span class="fine-detail-value">{{ $fine->actual_return_date->diffInDays($fine->due_date) }} days</span>
                        </div>
                        <div class="fine-paid-box">
                            <div class="fine-paid-label">✓ Denda Telah Dibayar</div>
                            <div class="fine-paid-value">Rp {{ number_format($fine->fine_amount) }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="card">
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <div class="empty-state-text">Belum ada riwayat pembayaran denda</div>
                </div>
            </div>
            @endif
        </div>
    @endif
</div>

<script>
// Tab switching
function switchTab(tabName) {
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.classList.remove('active'));

    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}

// ===== ADMIN FUNCTIONS =====
@if(auth()->user()->role === 'admin')
function markPaid(borrowingId, memberName) {
    if (!confirm(`Mark fine as paid for ${memberName}?`)) {
        return;
    }

    fetch(`/finedesk/mark-paid/${borrowingId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'error');
    });
}
@endif

// Toast Notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? '#0C3B2E' : type === 'error' ? '#C62828' : '#0C3B2E';
    
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}
</style>

<x-footer/>

@endsection