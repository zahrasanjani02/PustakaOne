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

    /* ===== WELCOME CARD (MEMBER) ===== */
    .welcome-card {
        background: linear-gradient(135deg, #0C3B2E, #1a5a48);
        color: white;
        padding: 2.5rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(12, 59, 46, 0.3);
    }

    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .welcome-text h2 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .welcome-text p {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .welcome-stats {
        display: flex;
        gap: 2rem;
    }

    .welcome-stat-item {
        text-align: center;
    }

    .welcome-stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #FFBA00;
    }

    .welcome-stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* ===== ALERT ===== */
    .alert {
        background: #FFF3CD;
        color: #856404;
        padding: 1rem 1.5rem;
        border-left: 4px solid #FFBA00;
        border-radius: 8px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert.danger {
        background: #FADBD8;
        color: #C62828;
        border-left-color: #E74C3C;
    }

    .alert-icon {
        font-size: 1.3rem;
    }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.8rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 5px solid;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-card.primary {
        border-left-color: #0C3B2E;
    }

    .stat-card.success {
        border-left-color: #6D9773;
    }

    .stat-card.warning {
        border-left-color: #BB8A52;
    }

    .stat-card.danger {
        border-left-color: #E74C3C;
    }

    .stat-icon {
        font-size: 2.5rem;
        min-width: 60px;
        text-align: center;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #0C3B2E;
        margin-bottom: 0.3rem;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .stat-change {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6D9773;
    }

    .stat-change.negative {
        color: #E74C3C;
    }

    /* ===== CARDS ===== */
    .card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #F0F2F5;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0C3B2E;
    }

    .btn-small {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.3s ease;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
    }

    .btn-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(12, 59, 46, 0.2);
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
        background: #F8F9FA;
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
        font-size: 0.9rem;
    }

    tbody tr:hover {
        background: #F9FAFB;
    }

    .badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-success {
        background: #D5F4E6;
        color: #6D9773;
    }

    .badge-warning {
        background: #FFF3CD;
        color: #856404;
    }

    .badge-danger {
        background: #FADBD8;
        color: #E74C3C;
    }

    .badge-info {
        background: #D6EAF8;
        color: #0C3B2E;
    }

    /* ===== BORROWING CARDS (MEMBER) ===== */
    .borrowing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .borrowing-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #6D9773;
        transition: all 0.3s ease;
    }

    .borrowing-card.overdue {
        border-left-color: #E74C3C;
    }

    .borrowing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .borrowing-book-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .borrowing-detail {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.3rem;
    }

    .days-left {
        font-weight: 700;
        color: #6D9773;
    }

    .days-left.overdue {
        color: #E74C3C;
    }

    /* ===== BOOK RECOMMENDATIONS (MEMBER) ===== */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .book-card-small {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .book-card-small:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .book-cover-small {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #0C3B2E, #6D9773);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }

    .book-info-small {
        padding: 1rem;
    }

    .book-title-small {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.3rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .book-author-small {
        font-size: 0.8rem;
        color: #666;
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .action-btn {
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #333;
    }

    .action-btn:hover {
        border-color: #6D9773;
        background: #F8F9FA;
        transform: translateY(-4px);
    }

    .action-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .action-label {
        font-weight: 600;
        color: #0C3B2E;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .content {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .welcome-content {
            flex-direction: column;
            gap: 1.5rem;
        }

        .welcome-stats {
            width: 100%;
            justify-content: space-around;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .borrowing-grid {
            grid-template-columns: 1fr;
        }

        .books-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- NAVBAR -->
<x-navbar/>

<!-- CONTENT -->
<div class="content">
    @if(auth()->user()->role === 'admin')
        {{-- ========== ADMIN DASHBOARD ========== --}}
        
        <div class="page-header">
            <h1 class="page-title">🎯 Admin Dashboard</h1>
            <p class="page-subtitle">Welcome back! Here's your library system overview.</p>
        </div>

        <!-- Alert (if any overdue) -->
        @if(isset($overdueBorrowings) && $overdueBorrowings->count() > 0)
        <div class="alert danger">
            <span class="alert-icon">⚠️</span>
            <div>
                <strong>Attention:</strong> There are {{ $overdueBorrowings->count() }} overdue books. Please contact members for returns.
            </div>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon">📚</div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($stats['totalBooks']) }}</div>
                    <div class="stat-label">Total Books</div>
                    <div class="stat-change">In library collection</div>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($stats['totalMembers']) }}</div>
                    <div class="stat-label">Total Members</div>
                    <div class="stat-change">Registered users</div>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-icon">📖</div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($stats['activeBorrowings']) }}</div>
                    <div class="stat-label">Active Borrowings</div>
                    <div class="stat-change">Currently borrowed</div>
                </div>
            </div>

            <div class="stat-card danger">
                <div class="stat-icon">💰</div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($stats['unpaidFines']) }}</div>
                    <div class="stat-label">Unpaid Fines</div>
                    <div class="stat-change negative">Outstanding</div>
                </div>
            </div>
        </div>

        <!-- Cards Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <!-- Overdue Books -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">📅 Overdue Books</div>
                    <a href="{{ route('reservation') }}" class="btn-small">View All</a>
                </div>
                @if(isset($overdueBorrowings) && $overdueBorrowings->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Book</th>
                                <th>Days Overdue</th>
                                <th>Fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overdueBorrowings as $borrowing)
                            @php
                                $daysOverdue = now()->diffInDays($borrowing->due_date);
                                $fine = $daysOverdue * 1000;
                            @endphp
                            <tr>
                                <td>{{ $borrowing->user->name }}</td>
                                <td>{{ $borrowing->book->title }}</td>
                                <td><span class="badge badge-danger">{{ $daysOverdue }} days</span></td>
                                <td>Rp {{ number_format($fine) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p style="text-align: center; color: #666; padding: 2rem;">No overdue books! 🎉</p>
                @endif
            </div>

            <!-- Recent Borrowings -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">📚 Recent Borrowings</div>
                    <a href="{{ route('reservation') }}" class="btn-small">View All</a>
                </div>
                @if(isset($recentBorrowings) && $recentBorrowings->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Book</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBorrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->user->name }}</td>
                                <td>{{ $borrowing->book->title }}</td>
                                <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                <td>
                                    @if($borrowing->actual_return_date)
                                        <span class="badge badge-success">Returned</span>
                                    @elseif($borrowing->due_date < now())
                                        <span class="badge badge-danger">Overdue</span>
                                    @else
                                        <span class="badge badge-info">Active</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p style="text-align: center; color: #666; padding: 2rem;">No recent borrowings</p>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">⚡ Quick Actions</div>
            </div>
            <div class="quick-actions">
                <a href="{{ route('readspace') }}" class="action-btn">
                    <div class="action-icon">📚</div>
                    <div class="action-label">Manage Books</div>
                </a>
                <a href="{{ route('membership') }}" class="action-btn">
                    <div class="action-icon">👥</div>
                    <div class="action-label">Manage Members</div>
                </a>
                <a href="{{ route('reservation') }}" class="action-btn">
                    <div class="action-icon">📖</div>
                    <div class="action-label">View Borrowings</div>
                </a>
                <a href="{{ route('finedesk') }}" class="action-btn">
                    <div class="action-icon">💰</div>
                    <div class="action-label">Manage Fines</div>
                </a>
            </div>
        </div>

    @else
        {{-- ========== MEMBER DASHBOARD ========== --}}
        
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h2>👋 Welcome back, {{ auth()->user()->name }}!</h2>
                    <p>Ready to explore new books today?</p>
                </div>
                <div class="welcome-stats">
                    <div class="welcome-stat-item">
                        <div class="welcome-stat-value">{{ $stats['currentlyBorrowed'] }}</div>
                        <div class="welcome-stat-label">Currently Borrowed</div>
                    </div>
                    <div class="welcome-stat-item">
                        <div class="welcome-stat-value">{{ $stats['totalBorrowed'] }}</div>
                        <div class="welcome-stat-label">Total Borrowed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert (if overdue or fines) -->
        @if($stats['overdueCount'] > 0)
        <div class="alert danger">
            <span class="alert-icon">⚠️</span>
            <div>
                <strong>Attention!</strong> You have {{ $stats['overdueCount'] }} overdue book(s). Please return them to avoid additional fines.
            </div>
        </div>
        @elseif($stats['unpaidFines'] > 0)
        <div class="alert">
            <span class="alert-icon">💰</span>
            <div>
                You have <strong>Rp {{ number_format($stats['unpaidFines']) }}</strong> in unpaid fines. Please pay at the library desk.
            </div>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon">📖</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['currentlyBorrowed'] }}</div>
                    <div class="stat-label">Currently Borrowed</div>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon">📚</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['totalBorrowed'] }}</div>
                    <div class="stat-label">Total Borrowed</div>
                </div>
            </div>

            <div class="stat-card warning">
        <div class="stat-icon">❤️</div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['totalFavorites'] }}</div>
            <div class="stat-label">Favorite Books</div>
        </div>
    </div>

            <div class="stat-card danger">
                <div class="stat-icon">💰</div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($stats['unpaidFines']) }}</div>
                    <div class="stat-label">Unpaid Fines</div>
                </div>
            </div>
        </div>

        <!-- My Active Borrowings -->
        @if(isset($myBorrowings) && $myBorrowings->count() > 0)
        <div class="card">
            <div class="card-header">
                <div class="card-title">📖 My Active Borrowings</div>
                <a href="{{ route('reservation') }}" class="btn-small">View All</a>
            </div>
            <div class="borrowing-grid">
                @foreach($myBorrowings as $borrowing)
                @php
                    $daysLeft = now()->diffInDays($borrowing->due_date, false);
                    $isOverdue = $daysLeft < 0;
                @endphp
                <div class="borrowing-card {{ $isOverdue ? 'overdue' : '' }}">
                    <div class="borrowing-book-title">{{ $borrowing->book->title }}</div>
                    <div class="borrowing-detail">📅 Borrowed: {{ $borrowing->borrowed_at->format('d M Y') }}</div>
                    <div class="borrowing-detail">⏰ Due Date: {{ $borrowing->due_date->format('d M Y') }}</div>
                    <div class="borrowing-detail">
                        @if($isOverdue)
                            <span class="days-left overdue">⚠️ Overdue by {{ abs($daysLeft) }} days</span>
                        @else
                            <span class="days-left">✓ {{ $daysLeft }} days left</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- My Favorite Books  -->
<div class="card">
    <div class="card-header">
        <div class="card-title">❤️ My Favorite Books</div>
        <a href="{{ route('favorites') }}" class="btn-small">View All</a>
    </div>
    
    @if(isset($myFavorites) && $myFavorites->count() > 0)
        <!-- Has Favorites -->
        <div class="books-grid">
            @foreach($myFavorites as $favorite)
            <div class="book-card-small" onclick="window.location='{{ route('readspace') }}'">
                <div class="book-cover-small" style="position: relative;">
                    📖
                    <span style="position: absolute; top: 0.5rem; right: 0.5rem; font-size: 1.5rem;">⭐</span>
                </div>
                <div class="book-info-small">
                    <div class="book-title-small">{{ $favorite->book->title }}</div>
                    <div class="book-author-small">{{ $favorite->book->author }}</div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 3rem 2rem; color: #666;">
            <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;">❤️</div>
            <h3 style="font-size: 1.2rem; color: #0C3B2E; margin-bottom: 0.5rem;">No Favorite Books Yet</h3>
            <p style="font-size: 0.9rem; margin-bottom: 1.5rem;">Start adding books to your favorites!</p>
            <a href="{{ route('readspace') }}" style="display: inline-block; background: linear-gradient(135deg, #BB8A52, #FFBA00); color: white; padding: 0.7rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">Browse Books</a>
        </div>
    @endif
</div>


        <!-- Browse Books -->
        @if(isset($popularBooks) && $popularBooks->count() > 0)
        <div class="card">
            <div class="card-header">
                <div class="card-title">🔥 Available Books</div>
                <a href="{{ route('readspace') }}" class="btn-small">Browse All</a>
            </div>
            <div class="books-grid">
                @foreach($popularBooks as $book)
                <div class="book-card-small" onclick="window.location='{{ route('readspace') }}'">
                    <div class="book-cover-small">📖</div>
                    <div class="book-info-small">
                        <div class="book-title-small">{{ $book->title }}</div>
                        <div class="book-author-small">{{ $book->author }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">⚡ Quick Actions</div>
            </div>
            <div class="quick-actions">
                <a href="{{ route('readspace') }}" class="action-btn">
                    <div class="action-icon">📚</div>
                    <div class="action-label">Browse Books</div>
                </a>
                <a href="{{ route('reservation') }}" class="action-btn">
                    <div class="action-icon">📖</div>
                    <div class="action-label">My Borrowings</div>
                </a>
                <a href="{{ route('finedesk') }}" class="action-btn">
                    <div class="action-icon">💰</div>
                    <div class="action-label">My Fines</div>
                </a>
                <a href="{{ route('membership') }}" class="action-btn">
                    <div class="action-icon">👤</div>
                    <div class="action-label">My Membership</div>
                </a>
            </div>
        </div>
    @endif
</div>

<x-footer/>

@endsection