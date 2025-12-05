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
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0C3B2E;
    }

    /* ===== STATS (ADMIN) ===== */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .stat-card.primary::before {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
    }

    .stat-card.success::before {
        background: linear-gradient(135deg, #34D399, #10B981);
    }

    .stat-card.warning::before {
        background: linear-gradient(135deg, #FFBA00, #BB8A52);
    }

    .stat-card.danger::before {
        background: linear-gradient(135deg, #EF4444, #DC2626);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        opacity: 0.2;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #888;
        font-weight: 500;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.3rem;
    }

    .stat-change {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .stat-change.positive {
        color: #10B981;
    }

    .stat-change.negative {
        color: #EF4444;
    }

    /* ===== MEMBER PROFILE CARD ===== */
    .profile-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .profile-card {
        background: linear-gradient(135deg, #0C3B2E, #1a5a48);
        border-radius: 16px;
        padding: 2.5rem;
        color: white;
        box-shadow: 0 4px 20px rgba(12, 59, 46, 0.3);
    }

    .profile-header {
        display: flex;
        gap: 2rem;
        align-items: center;
        margin-bottom: 2rem;
    }

    .profile-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        color: #0C3B2E;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .profile-info-section h2 {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }

    .profile-role-badge {
        display: inline-block;
        background: rgba(255, 186, 0, 0.2);
        color: #FFBA00;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .profile-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .profile-detail-item {
        display: flex;
        flex-direction: column;
    }

    .profile-detail-label {
        font-size: 0.85rem;
        opacity: 0.8;
        margin-bottom: 0.3rem;
    }

    .profile-detail-value {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .membership-status-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .membership-status-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 1.5rem;
    }

    .membership-status-content {
        text-align: center;
    }

    .membership-days-left {
        font-size: 3rem;
        font-weight: 800;
        color: #6D9773;
        margin-bottom: 0.5rem;
    }

    .membership-days-label {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1.5rem;
    }

    .membership-expiry {
        background: #F8F9FA;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .membership-expiry-label {
        font-size: 0.8rem;
        color: #888;
    }

    .membership-expiry-date {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0C3B2E;
    }

    .btn-renew {
        width: 100%;
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        color: white;
        border: none;
        padding: 0.9rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-renew:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(187, 138, 82, 0.3);
    }

    /* ===== TABLE (ADMIN) ===== */
    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 2px solid #F0F2F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #0C3B2E;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #F8F9FA;
    }

    th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 700;
        color: #0C3B2E;
        text-transform: uppercase;
    }

    td {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #F0F2F5;
        font-size: 0.9rem;
    }

    tbody tr:hover {
        background: #F8F9FA;
    }

    .member-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .member-avatar-small {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }

    .member-details {
        display: flex;
        flex-direction: column;
    }

    .member-name {
        font-weight: 600;
        color: #0C3B2E;
    }

    .member-email {
        font-size: 0.8rem;
        color: #888;
    }

    .status-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
    }

    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
    }

    .status-badge.expiring {
        background: rgba(255, 186, 0, 0.15);
        color: #F59E0B;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-icon.view {
        background: rgba(109, 151, 115, 0.1);
        color: #6D9773;
    }

    .btn-icon.view:hover {
        background: #6D9773;
        color: white;
    }

    /* ===== BENEFITS SECTION (MEMBER) ===== */
    .benefits-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .benefits-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 1.5rem;
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .benefit-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-radius: 8px;
        background: #F8F9FA;
    }

    .benefit-icon {
        font-size: 2rem;
    }

    .benefit-content h4 {
        color: #0C3B2E;
        margin-bottom: 0.3rem;
    }

    .benefit-content p {
        font-size: 0.85rem;
        color: #666;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-detail-grid {
            grid-template-columns: 1fr;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .benefits-grid {
            grid-template-columns: 1fr;
        }

        table {
            font-size: 0.85rem;
        }

        td, th {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<!-- NAVBAR  -->
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
            <h1 class="page-title">Membership Management</h1>
        </div>

        <!-- Stats -->
        <div class="stats-container">
            <div class="stat-card primary">
                <div class="stat-header">
                    <div class="stat-label">Total Members</div>
                    <div class="stat-icon">👥</div>
                </div>
                <div class="stat-value">{{ $stats['totalMembers'] }}</div>
                <div class="stat-change positive">Registered members</div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-label">Active Members</div>
                    <div class="stat-icon">✓</div>
                </div>
                <div class="stat-value">{{ $stats['activeMembers'] }}</div>
                <div class="stat-change positive">Active membership</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-label">Expiring Soon</div>
                    <div class="stat-icon">⏳</div>
                </div>
                <div class="stat-value">{{ $stats['expiringMembers'] }}</div>
                <div class="stat-change negative">Within 30 days</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-header">
                    <div class="stat-label">Inactive Members</div>
                    <div class="stat-icon">⚠️</div>
                </div>
                <div class="stat-value">{{ $stats['inactiveMembers'] }}</div>
                <div class="stat-change negative">Expired or pending</div>
            </div>
        </div>

        <!-- Members Table -->
        <div class="table-container">
            <div class="table-header">
                <h2 class="table-title">Members List</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Phone</th>
                        <th>Join Date</th>
                        <th>Expiry Date</th>
                        <th>Books Borrowed</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>
                            <div class="member-info">
                                <div class="member-avatar-small">{{ strtoupper(substr($member->name, 0, 2)) }}</div>
                                <div class="member-details">
                                    <span class="member-name">{{ $member->name }}</span>
                                    <span class="member-email">{{ $member->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $member->phone ?? '-' }}</td>
                        <td>{{ $member->membership_start ? $member->membership_start->format('d M Y') : '-' }}</td>
                        <td>{{ $member->membership_end ? $member->membership_end->format('d M Y') : '-' }}</td>
                        <td><strong>{{ $member->borrowings_count }}</strong> books</td>
                        <td>
                            @if($member->membership_end && $member->membership_end >= now())
                                @if($member->membership_end <= now()->addDays(30))
                                    <span class="status-badge expiring">Expiring Soon</span>
                                @else
                                    <span class="status-badge active">Active</span>
                                @endif
                            @else
                                <span class="status-badge inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon view" title="View Details">👁️</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="padding: 1.5rem;">
                {{ $members->links() }}
            </div>
        </div>

    @else
        {{-- ========== MEMBER VIEW ========== --}}
        
        <div class="page-header">
            <h1 class="page-title">My Membership</h1>
        </div>

        <!-- Profile & Membership Status -->
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar-large">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div class="profile-info-section">
                        <h2>{{ auth()->user()->name }}</h2>
                        <div class="profile-role-badge">📖 Member</div>
                    </div>
                </div>

                <div class="profile-detail-grid">
                    <div class="profile-detail-item">
                        <span class="profile-detail-label">Email</span>
                        <span class="profile-detail-value">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="profile-detail-item">
                        <span class="profile-detail-label">Phone</span>
                        <span class="profile-detail-value">{{ auth()->user()->phone ?? '-' }}</span>
                    </div>
                    <div class="profile-detail-item">
                        <span class="profile-detail-label">Join Date</span>
                        <span class="profile-detail-value">{{ auth()->user()->membership_start ? auth()->user()->membership_start->format('d M Y') : '-' }}</span>
                    </div>
                    <div class="profile-detail-item">
                        <span class="profile-detail-label">Address</span>
                        <span class="profile-detail-value">{{ auth()->user()->address ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="membership-status-card">
                <h3 class="membership-status-title">Membership Status</h3>
                <div class="membership-status-content">
                    @if(auth()->user()->membership_end && auth()->user()->membership_end >= now())
                        @php
                            $daysLeft = now()->diffInDays(auth()->user()->membership_end, false);
                        @endphp
                        <div class="membership-days-left">{{ $daysLeft }}</div>
                        <div class="membership-days-label">Days Remaining</div>
                        
                        <div class="membership-expiry">
                            <div class="membership-expiry-label">Expires On</div>
                            <div class="membership-expiry-date">{{ auth()->user()->membership_end->format('d M Y') }}</div>
                        </div>

                        @if($daysLeft <= 30)
                        <div style="background: #FFF3CD; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem; color: #856404; font-size: 0.85rem;">
                            ⚠️ Your membership will expire soon!
                        </div>
                        @endif
                    @else
                        <div class="membership-days-left" style="color: #EF4444;">Expired</div>
                        <div class="membership-days-label">Please renew your membership</div>
                        
                        <div style="background: #FADBD8; padding: 1rem; border-radius: 8px; margin: 1rem 0; color: #EF4444; font-size: 0.85rem;">
                            ⚠️ Your membership is inactive. Renew now to continue borrowing books!
                        </div>
                    @endif

                    <button class="btn-renew" onclick="alert('Contact librarian to renew membership')">🔄 Renew Membership</button>
                </div>
            </div>
        </div>

        <!-- My Stats -->
        <div class="stats-container">
            <div class="stat-card primary">
                <div class="stat-header">
                    <div class="stat-label">Books Borrowed</div>
                    <div class="stat-icon">📚</div>
                </div>
                <div class="stat-value">{{ $stats['borrowedBooks'] }}</div>
                <div class="stat-change">Total borrowed</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-label">Active Borrowings</div>
                    <div class="stat-icon">📖</div>
                </div>
                <div class="stat-value">{{ $stats['activeBorrowings'] }}</div>
                <div class="stat-change">Currently borrowed</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-header">
                    <div class="stat-label">Unpaid Fines</div>
                    <div class="stat-icon">💰</div>
                </div>
                <div class="stat-value">Rp {{ number_format($stats['unpaidFines']) }}</div>
                <div class="stat-change negative">Outstanding</div>
            </div>
        </div>

        <!-- Membership Benefits -->
        <div class="benefits-section">
            <h3 class="benefits-title">🎁 Membership Benefits</h3>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-icon">📚</div>
                    <div class="benefit-content">
                        <h4>Borrow Books</h4>
                        <p>Borrow up to 3 books at a time</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">⏰</div>
                    <div class="benefit-content">
                        <h4>14 Days Period</h4>
                        <p>Enjoy 14 days borrowing period</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">💝</div>
                    <div class="benefit-content">
                        <h4>Free Membership</h4>
                        <p>No annual or monthly fees</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🔔</div>
                    <div class="benefit-content">
                        <h4>Notifications</h4>
                        <p>Get reminders for due dates</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<x-footer/>

@endsection