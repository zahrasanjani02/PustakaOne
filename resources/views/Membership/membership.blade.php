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

    /* ===== NAVBAR TOP ===== */
    .navbar {
        background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%);
        box-shadow: 0 2px 12px rgba(12, 59, 46, 0.15);
        padding: 1.2rem 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        transition: all 0.3s ease;
        gap: 2rem;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        cursor: pointer;
    }

    .navbar-brand span:first-child {
        font-size: 1.5rem;
    }

    .navbar-brand .logo-text {
        font-weight: 700;
        font-size: 1.3rem;
        color: white;
        letter-spacing: -0.5px;
    }

    .navbar-links {
        display: flex;
        list-style: none;
        gap: 3rem;
        margin: 0;
        flex: 1;
    }

    .navbar-links li a {
        text-decoration: none;
        color: white;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        position: relative;
        padding: 0.5rem 0;
    }

    .navbar-links li a:hover {
        color: #FFBA00;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        overflow: hidden;
        flex: 1;
        max-width: 450px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .search-box:focus-within {
        border-color: #6D9773;
        box-shadow: 0 6px 20px rgba(109, 151, 115, 0.2);
    }

    .search-box input {
        border: none;
        outline: none;
        padding: 0.7rem 1rem;
        width: 100%;
        font-size: 0.9rem;
        background: transparent;
        font-family: 'Poppins', sans-serif;
    }

    .search-box button {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.7rem 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .notification-icon {
        position: relative;
        font-size: 1.3rem;
        cursor: pointer;
        transition: 0.3s ease;
        color: white;
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #FFBA00;
        color: #0C3B2E;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        cursor: pointer;
        transition: 0.3s ease;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
    }

    .user-profile:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
        color: #0C3B2E;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
    }

    .user-role {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }

    /* ===== MAIN CONTENT ===== */
    .content {
        padding: 2rem 5%;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0C3B2E;
    }

    .btn-add-member {
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        color: white;
        border: none;
        padding: 0.8rem 1.8rem;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 15px rgba(187, 138, 82, 0.3);
    }

    .btn-add-member:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(187, 138, 82, 0.4);
    }

    /* ===== STATS CARDS ===== */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
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
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
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
    }

    .stat-icon.primary {
        background: linear-gradient(135deg, rgba(109, 151, 115, 0.15), rgba(12, 59, 46, 0.15));
    }

    .stat-icon.warning {
        background: linear-gradient(135deg, rgba(255, 186, 0, 0.15), rgba(187, 138, 82, 0.15));
    }

    .stat-icon.success {
        background: linear-gradient(135deg, rgba(52, 211, 153, 0.15), rgba(16, 185, 129, 0.15));
    }

    .stat-icon.danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.15));
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

    /* ===== FILTERS & ACTIONS ===== */
    .filter-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .filter-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex: 1;
        min-width: 200px;
    }

    .filter-label {
        font-size: 0.85rem;
        color: #666;
        font-weight: 600;
    }

    .filter-input, .filter-select {
        padding: 0.7rem 1rem;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: #6D9773;
        box-shadow: 0 0 0 3px rgba(109, 151, 115, 0.1);
    }

    .btn-filter {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        align-self: flex-end;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(109, 151, 115, 0.3);
    }

    /* ===== MEMBERS TABLE ===== */
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

    .table-actions {
        display: flex;
        gap: 0.8rem;
    }

    .btn-export {
        background: white;
        color: #6D9773;
        border: 2px solid #6D9773;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        background: #6D9773;
        color: white;
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
        letter-spacing: 0.5px;
    }

    td {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #F0F2F5;
        font-size: 0.9rem;
        color: #333;
    }

    tbody tr {
        transition: all 0.3s ease;
    }

    tbody tr:hover {
        background: #F8F9FA;
    }

    .member-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .member-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
        color: white;
    }

    .member-details {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .member-name {
        font-weight: 600;
        color: #0C3B2E;
    }

    .member-id {
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

    .status-badge.pending {
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
        font-size: 1rem;
    }

    .btn-icon.edit {
        background: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
    }

    .btn-icon.edit:hover {
        background: #3B82F6;
        color: white;
        transform: translateY(-2px);
    }

    .btn-icon.delete {
        background: rgba(239, 68, 68, 0.1);
        color: #EF4444;
    }

    .btn-icon.delete:hover {
        background: #EF4444;
        color: white;
        transform: translateY(-2px);
    }

    .btn-icon.view {
        background: rgba(109, 151, 115, 0.1);
        color: #6D9773;
    }

    .btn-icon.view:hover {
        background: #6D9773;
        color: white;
        transform: translateY(-2px);
    }

    /* ===== PAGINATION ===== */
    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-top: 2px solid #F0F2F5;
    }

    .pagination-info {
        font-size: 0.9rem;
        color: #666;
    }

    .pagination-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .page-btn {
        padding: 0.5rem 1rem;
        border: 2px solid #E0E0E0;
        background: white;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #666;
    }

    .page-btn:hover {
        border-color: #6D9773;
        color: #6D9773;
    }

    .page-btn.active {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border-color: transparent;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .content {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .filter-row {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            min-width: 800px;
        }

        .pagination {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<!-- NAVBAR -->
<div class="navbar">
    <a href="{{ route('dashboard') }}" class="navbar-brand">
        <span>📚</span>
        <span class="logo-text">PustakaOne</span>
    </a>

    <div style="display: flex; gap: 3rem; list-style: none;">
        <a href="{{ route('about') }}"  style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">About Us</a>
        <a href="{{ route('readspace') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">ReadSpace</a>
        <a href="{{ route('reservation') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Reservation</a>
        <a href="{{ route('finedesk') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">FineDesk</a>
        <a href="{{ route('membership') }}" style="text-decoration: none; color: #FFBA00; font-weight: 600; font-size: 0.95rem; border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;">Membership</a>
    </div>

    <div class="search-box">
        <input type="text" placeholder="Cari member berdasarkan nama atau ID...">
        <button type="submit">🔍</button>
    </div>

    <div class="navbar-actions">
        <div class="notification-icon">
            🔔
            <span class="notification-badge">5</span>
        </div>

        <div class="user-profile">
            <div class="user-avatar">ZS</div>
            <div class="user-info">
                <div class="user-name">Zahra Sanjani</div>
                <div class="user-role">Admin</div>
            </div>
            <span style="color: white; font-size: 0.7rem;">▼</span>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="content">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Membership Management</h1>
        <button class="btn-add-member" onclick="alert('Form Add New Member')">
            ➕ Add New Member
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
    <div class="stat-card">
    <div class="stat-icon primary">👥</div>
    <div class="stat-header">
        <div class="stat-label">Total Members</div>
    </div>
    <div class="stat-value">1,245</div>
    <div class="stat-change positive">↑ 12% from last month</div>
</div>


        <div class="stat-card">
            <div class="stat-icon success">✓</div>
            <div class="stat-header">
                <div class="stat-label">Active Members</div>
            </div>
            <div class="stat-value">1,180</div>
            <div class="stat-change positive">↑ 8% from last month</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon warning">⏳</div>
            <div class="stat-header">
                <div class="stat-label">Expiring Soon</div>
            </div>
            <div class="stat-value">42</div>
            <div class="stat-change negative">Within 30 days</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon danger">⚠️</div>
            <div class="stat-header">
                <div class="stat-label">Inactive Members</div>
            </div>
            <div class="stat-value">65</div>
            <div class="stat-change negative">↓ 3% from last month</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Search Member</label>
                <input type="text" class="filter-input" placeholder="Name or Member ID...">
            </div>

            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Pending</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Membership Type</label>
                <select class="filter-select">
                    <option>All Types</option>
                    <option>Standard</option>
                    <option>Premium</option>
                    <option>VIP</option>
                </select>
            </div>

            <button class="btn-filter">🔍 Filter</button>
        </div>
    </div>

    <!-- Members Table -->
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Members List</h2>
            <div class="table-actions">
                <button class="btn-export">📥 Export CSV</button>
                <button class="btn-export">📄 Export PDF</button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Member ID</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Join Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">AS</div>
                            <div class="member-details">
                                <span class="member-name">Ahmad Surya</span>
                                <span class="member-id">Books Borrowed: 5</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB001</td>
                    <td>ahmad.surya@email.com</td>
                    <td><strong>Premium</strong></td>
                    <td>Jan 15, 2024</td>
                    <td>Jan 15, 2025</td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">DP</div>
                            <div class="member-details">
                                <span class="member-name">Dina Permata</span>
                                <span class="member-id">Books Borrowed: 3</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB002</td>
                    <td>dina.permata@email.com</td>
                    <td><strong>Standard</strong></td>
                    <td>Feb 20, 2024</td>
                    <td>Feb 20, 2025</td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">RK</div>
                            <div class="member-details">
                                <span class="member-name">Rudi Kusuma</span>
                                <span class="member-id">Books Borrowed: 0</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB003</td>
                    <td>rudi.kusuma@email.com</td>
                    <td><strong>VIP</strong></td>
                    <td>Mar 10, 2024</td>
                    <td>Mar 10, 2025</td>
                    <td><span class="status-badge pending">Pending</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">SL</div>
                            <div class="member-details">
                                <span class="member-name">Siti Lestari</span>
                                <span class="member-id">Books Borrowed: 12</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB004</td>
                    <td>siti.lestari@email.com</td>
                    <td><strong>Premium</strong></td>
                    <td>Apr 05, 2023</td>
                    <td>Apr 05, 2024</td>
                    <td><span class="status-badge inactive">Inactive</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">BW</div>
                            <div class="member-details">
                                <span class="member-name">Budi Winarno</span>
                                <span class="member-id">Books Borrowed: 7</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB005</td>
                    <td>budi.winarno@email.com</td>
                    <td><strong>Standard</strong></td>
                    <td>May 12, 2024</td>
                    <td>May 12, 2025</td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">FA</div>
                            <div class="member-details">
                                <span class="member-name">Fitri Amalia</span>
                                <span class="member-id">Books Borrowed: 4</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB006</td>
                    <td>fitri.amalia@email.com</td>
                    <td><strong>Premium</strong></td>
                    <td>Jun 18, 2024</td>
                    <td>Jun 18, 2025</td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">HN</div>
                            <div class="member-details">
                                <span class="member-name">Hendra Nugroho</span>
                                <span class="member-id">Books Borrowed: 2</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB007</td>
                    <td>hendra.nugroho@email.com</td>
                    <td><strong>VIP</strong></td>
                    <td>Jul 22, 2024</td>
                    <td>Jul 22, 2025</td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">LP</div>
                            <div class="member-details">
                                <span class="member-name">Lina Puspita</span>
                                <span class="member-id">Books Borrowed: 9</span>
                            </div>
                        </div>
                    </td>
                    <td>#MB008</td>
                    <td>lina.puspita@email.com</td>
                    <td><strong>Standard</strong></td>
                    <td>Aug 30, 2024</td>
                    <td>Aug 30, 2025</td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon view" title="View Details">👁️</button>
                            <button class="btn-icon edit" title="Edit">✏️</button>
                            <button class="btn-icon delete" title="Delete">🗑️</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <div class="pagination-info">
                Showing 1 to 8 of 1,245 members
            </div>
            <div class="pagination-buttons">
                <button class="page-btn">« Previous</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">...</button>
                <button class="page-btn">156</button>
                <button class="page-btn">Next »</button>
            </div>
        </div>
    </div>
</div>

@endsection