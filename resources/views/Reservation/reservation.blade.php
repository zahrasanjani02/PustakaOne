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

    .stat-card.active {
        border-left-color: #6D9773;
    }

    .stat-card.overdue {
        border-left-color: #E74C3C;
    }

    .stat-card.returned {
        border-left-color: #3498DB;
    }

    .stat-card.total {
        border-left-color: #BB8A52;
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

    /* ===== BORROWING CARDS (untuk member) ===== */
    .borrowings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .borrowing-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .borrowing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .borrowing-book-cover {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #0C3B2E, #6D9773);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        overflow: hidden;
    }

    .borrowing-book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .borrowing-info {
        padding: 1.5rem;
    }

    .borrowing-book-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .borrowing-book-author {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .borrowing-dates {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #F8F9FA;
        border-radius: 8px;
    }

    .borrowing-date-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
    }

    .borrowing-date-label {
        color: #666;
    }

    .borrowing-date-value {
        font-weight: 600;
        color: #0C3B2E;
    }

    .borrowing-date-value.overdue {
        color: #E74C3C;
    }

    .btn-return {
        width: 100%;
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.75rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-return:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(109, 151, 115, 0.3);
    }

    .btn-return:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
    }

    /* ===== TABLE (untuk admin) ===== */
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

    .badge-active {
        background: #D5F4E6;
        color: #27AE60;
    }

    .badge-overdue {
        background: #FADBD8;
        color: #E74C3C;
    }

    .badge-returned {
        background: #D6EAF8;
        color: #3498DB;
    }

    .badge-requested {
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
    }

    .btn-mark-returned {
        background: #D5F4E6;
        color: #27AE60;
    }

    .btn-mark-returned:hover {
        background: #A3E9C5;
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

    .empty-state-action {
        margin-top: 1.5rem;
    }

    .btn-browse {
        background: linear-gradient(135deg, #BB8A52, #6D9773);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        display: inline-block;
    }

    .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(109, 151, 115, 0.3);
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

        .borrowings-grid {
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
            <h1 class="page-title">Borrowing Management</h1>
            <p class="page-subtitle">Kelola peminjaman buku dari semua member</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card active">
                <div class="stat-icon">📚</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['activeBorrowings'] ?? 0 }}</div>
                    <div class="stat-label">Active Borrowings</div>
                </div>
            </div>

            <div class="stat-card overdue">
                <div class="stat-icon">⚠️</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['overdue'] ?? 0 }}</div>
                    <div class="stat-label">Overdue</div>
                </div>
            </div>

            <div class="stat-card returned">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['returnedToday'] ?? 0 }}</div>
                    <div class="stat-label">Returned Today</div>
                </div>
            </div>

            <div class="stat-card total">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['totalBorrowed'] ?? 0 }}</div>
                    <div class="stat-label">Total History</div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('active')">📚 Active ({{ $allBorrowings->total() }})</button>
            <button class="tab-btn" onclick="switchTab('overdue')">⚠️ Overdue ({{ $overdueBorrowings->count() }})</button>
            <button class="tab-btn" onclick="switchTab('history')">✅ History ({{ $history->count() }})</button>
        </div>

        <!-- TAB: ACTIVE -->
        <div id="active" class="tab-content active">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Active Borrowings</div>
                </div>
                @if($allBorrowings->count() > 0)
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Member</th>
                            <th>Book Title</th>
                            <th>Borrowed Date</th>
                            <th>Due Date</th>
                            <th>Days Left</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($allBorrowings as $borrowing)
                        <tr>
                            <td><strong>{{ $borrowing->user->name }}</strong><br><small>{{ $borrowing->user->email }}</small></td>
                            <td><strong>{{ $borrowing->book->title }}</strong><br><small>by {{ $borrowing->book->author }}</small></td>
                            <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                            <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                            <td>
                                @php
                                    $daysLeft = now()->diffInDays($borrowing->due_date, false);
                                @endphp
                                @if($daysLeft < 0)
                                    <span style="color: #E74C3C; font-weight: 600;">{{ abs($daysLeft) }} days overdue</span>
                                @else
                                    <span style="color: #27AE60; font-weight: 600;">{{ $daysLeft }} days</span>
                                @endif
                            </td>
                            <td>
                                @if($borrowing->status === 'return_requested')
                                    <span class="badge badge-requested">Return Requested</span>
                                @elseif($borrowing->due_date < now())
                                    <span class="badge badge-overdue">Overdue</span>
                                @else
                                    <span class="badge badge-active">Active</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-action btn-mark-returned" onclick="markReturned({{ $borrowing->id }}, '{{ $borrowing->book->title }}')">
                                    ✓ Mark Returned
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="margin-top: 1.5rem;">
                    {{ $allBorrowings->links() }}
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📚</div>
                    <div class="empty-state-text">No active borrowings at the moment</div>
                </div>
                @endif
            </div>
        </div>

        <!-- TAB: OVERDUE -->
        <div id="overdue" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Overdue Borrowings</div>
                </div>
                @if($overdueBorrowings->count() > 0)
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Member</th>
                            <th>Book Title</th>
                            <th>Due Date</th>
                            <th>Days Overdue</th>
                            <th>Estimated Fine</th>
                            <th>Action</th>
                        </tr>
                        @foreach($overdueBorrowings as $borrowing)
                        <tr>
                            <td><strong>{{ $borrowing->user->name }}</strong><br><small>{{ $borrowing->user->email }}</small></td>
                            <td><strong>{{ $borrowing->book->title }}</strong></td>
                            <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                            <td style="color: #E74C3C; font-weight: 600;">{{ now()->diffInDays($borrowing->due_date) }} days</td>
                            <td style="color: #E74C3C; font-weight: 600;">Rp {{ number_format(now()->diffInDays($borrowing->due_date) * 1000) }}</td>
                            <td>
                                <button class="btn-action btn-mark-returned" onclick="markReturned({{ $borrowing->id }}, '{{ $borrowing->book->title }}')">
                                    ✓ Mark Returned
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <div class="empty-state-text">No overdue borrowings. Great!</div>
                </div>
                @endif
            </div>
        </div>

        <!-- TAB: HISTORY -->
        <div id="history" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Return History</div>
                </div>
                @if($history->count() > 0)
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Member</th>
                            <th>Book Title</th>
                            <th>Borrowed</th>
                            <th>Returned</th>
                            <th>Duration</th>
                            <th>Fine</th>
                        </tr>
                        @foreach($history as $borrowing)
                        <tr>
                            <td><strong>{{ $borrowing->user->name }}</strong></td>
                            <td><strong>{{ $borrowing->book->title }}</strong></td>
                            <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                            <td>{{ $borrowing->actual_return_date->format('d M Y') }}</td>
                            <td>{{ $borrowing->borrowed_at->diffInDays($borrowing->actual_return_date) }} days</td>
                            <td>
                                @if($borrowing->fine_amount > 0)
                                    <span style="color: #E74C3C; font-weight: 600;">Rp {{ number_format($borrowing->fine_amount) }}</span>
                                @else
                                    <span style="color: #27AE60;">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📖</div>
                    <div class="empty-state-text">No return history yet</div>
                </div>
                @endif
            </div>
        </div>

    @else
        {{-- ========== MEMBER VIEW ========== --}}
        
        <div class="page-header">
            <h1 class="page-title">My Borrowings</h1>
            <p class="page-subtitle">Kelola buku yang sedang Anda pinjam</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card active">
                <div class="stat-icon">📖</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['currentBorrowed'] ?? 0 }}</div>
                    <div class="stat-label">Currently Borrowed</div>
                </div>
            </div>

            <div class="stat-card overdue">
                <div class="stat-icon">⚠️</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['overdue'] ?? 0 }}</div>
                    <div class="stat-label">Overdue Books</div>
                </div>
            </div>

            <div class="stat-card total">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['totalBorrowed'] ?? 0 }}</div>
                    <div class="stat-label">Total Borrowed</div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('current')">📚 Current ({{ $myActiveBorrowings->count() }})</button>
            <button class="tab-btn" onclick="switchTab('myhistory')">✅ History ({{ $myHistory->count() }})</button>
        </div>

        <!-- TAB: CURRENT BORROWINGS -->
        <div id="current" class="tab-content active">
            @if($myActiveBorrowings->count() > 0)
            <div class="borrowings-grid">
                @foreach($myActiveBorrowings as $borrowing)
                <div class="borrowing-card">
                    <div class="borrowing-book-cover">
                        @if($borrowing->book->cover_image)
                            <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}">
                        @else
                            {{ $borrowing->book->getCategoryEmoji() }}
                        @endif
                    </div>
                    <div class="borrowing-info">
                        <div class="borrowing-book-title">{{ $borrowing->book->title }}</div>
                        <div class="borrowing-book-author">by {{ $borrowing->book->author }}</div>

                        @if($borrowing->status === 'return_requested')
                            <div style="background: #FFF3CD; color: #856404; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem; text-align: center; font-weight: 600; font-size: 0.85rem;">
                                ⏳ Return request submitted. Please bring the book to the library.
                            </div>
                        @endif

                        <div class="borrowing-dates">
                            <div class="borrowing-date-item">
                                <span class="borrowing-date-label">Borrowed:</span>
                                <span class="borrowing-date-value">{{ $borrowing->borrowed_at->format('d M Y') }}</span>
                            </div>
                            <div class="borrowing-date-item">
                                <span class="borrowing-date-label">Due Date:</span>
                                <span class="borrowing-date-value {{ $borrowing->due_date < now() ? 'overdue' : '' }}">
                                    {{ $borrowing->due_date->format('d M Y') }}
                                    @if($borrowing->due_date < now())
                                        ({{ now()->diffInDays($borrowing->due_date) }} days overdue)
                                    @endif
                                </span>
                            </div>
                            @if($borrowing->due_date < now())
                            <div class="borrowing-date-item">
                                <span class="borrowing-date-label">Estimated Fine:</span>
                                <span class="borrowing-date-value overdue">
                                    Rp {{ number_format(now()->diffInDays($borrowing->due_date) * 1000) }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <button 
                            class="btn-return" 
                            onclick="requestReturn({{ $borrowing->id }})"
                            {{ $borrowing->status === 'return_requested' ? 'disabled' : '' }}>
                            {{ $borrowing->status === 'return_requested' ? '⏳ Return Requested' : '📤 Request Return' }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="card">
                <div class="empty-state">
                    <div class="empty-state-icon">📚</div>
                    <div class="empty-state-text">You don't have any borrowed books at the moment</div>
                    <div class="empty-state-action">
                        <a href="{{ route('readspace') }}" class="btn-browse">Browse Books</a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- TAB: HISTORY -->
        <div id="myhistory" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Borrowing History</div>
                </div>
                @if($myHistory->count() > 0)
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Book Title</th>
                            <th>Borrowed</th>
                            <th>Returned</th>
                            <th>Duration</th>
                            <th>Fine</th>
                        </tr>
                        @foreach($myHistory as $borrowing)
                        <tr>
                            <td><strong>{{ $borrowing->book->title }}</strong><br><small>by {{ $borrowing->book->author }}</small></td>
                            <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                            <td>{{ $borrowing->actual_return_date->format('d M Y') }}</td>
                            <td>{{ $borrowing->borrowed_at->diffInDays($borrowing->actual_return_date) }} days</td>
                            <td>
                                @if($borrowing->fine_amount > 0)
                                    <span style="color: #E74C3C; font-weight: 600;">Rp {{ number_format($borrowing->fine_amount) }}</span>
                                @else
                                    <span style="color: #27AE60; font-weight: 600;">No Fine</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📖</div>
                    <div class="empty-state-text">No borrowing history yet</div>
                </div>
                @endif
            </div>
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

// ===== MEMBER FUNCTIONS =====
@if(auth()->user()->role === 'member')
function requestReturn(borrowingId) {
    if (!confirm('Request to return this book? Please bring the book to the library after confirming.')) {
        return;
    }

    fetch(`/reservation/request-return/${borrowingId}`, {
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
        alert('An error occurred. Please try again.');
    });
}
@endif

// ===== ADMIN FUNCTIONS =====
@if(auth()->user()->role === 'admin')
function markReturned(borrowingId, bookTitle) {
    if (!confirm(`Mark "${bookTitle}" as returned?`)) {
        return;
    }

    fetch(`/reservation/mark-returned/${borrowingId}`, {
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
        alert('An error occurred. Please try again.');
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