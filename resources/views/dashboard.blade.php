<!-- SIDEBAR -->
<aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="#" class="active"><span class="menu-icon">📊</span> Dashboard</a></li>
            <li><a href="#"><span class="menu-icon">📚</span> Manajemen Buku</a></li>
            <li><a href="#"><span class="menu-icon">👥</span> Manajemen Member</a></li>
            <li><a href="#"><span class="menu-icon">📤</span> Peminjaman</a></li>
            <li><a href="#"><span class="menu-icon">💰</span> Denda & Bayar</a></li>
            <li><a href="#"><span class="menu-icon">📈</span> Laporan</a></li>
            <li><a href="#"><span class="menu-icon">⚙️</span> Pengaturan</a></li>
        </ul>
    </aside>@extends('layouts.app')

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

    .navbar-links li a::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 0;
        height: 2px;
        background: #FFBA00;
        transition: width 0.3s ease;
    }

    .navbar-links li a:hover::after {
        width: 100%;
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

    .search-box input::placeholder {
        color: #999;
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

    .search-box button:hover {
        transform: translateX(2px);
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

    .notification-icon:hover {
        transform: scale(1.1);
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

    /* ===== MAIN LAYOUT ===== */
    .main-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
        min-height: calc(100vh - 70px);
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        display: none;
    }

    /* ===== CONTENT ===== */
    .content {
        padding: 2rem;
        overflow-y: auto;
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

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.8rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 5px solid;
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-card.blue {
        border-left-color: #0C3B2E;
    }

    .stat-card.green {
        border-left-color: #6D9773;
    }

    .stat-card.orange {
        border-left-color: #BB8A52;
    }

    .stat-card.gold {
        border-left-color: #FFBA00;
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
        font-size: 1.8rem;
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

    .alert-icon {
        font-size: 1.3rem;
        min-width: 30px;
    }

    /* ===== CARDS ===== */
    .card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
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

    .btn-small {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.3s ease;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
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
    .dropdown-arrow {
    font-size: 0.7rem;
    color: #FFFFFF;
    margin-top: -17px; /* sesuaikan 3px–6px kalau mau */
    display: flex;
    align-items: center;
}


    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .main-layout {
            grid-template-columns: 1fr;
        }

        .sidebar {
            display: none;
        }

        .navbar-menu {
            display: none;
        }

        .navbar-search {
            display: none;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .content {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }
    }
</style>

<!-- NAVBAR -->
<div class="navbar">
<a href="{{ route(name: 'dashboard') }}" class="navbar-brand">
        <span>📚</span>
        <span class="logo-text">PustakaOne</span>
</a>

    <div style="display: flex; gap: 3rem; list-style: none;">
        <a href="#about" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">About Us</a>
        <a href="{{ route('readspace') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 600; font-size: 0.95rem; padding-bottom: 0.25rem;">ReadSpace</a>
        <a href="{{ route('reservation') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Reservation</a>
        <a href="{{ route('finedesk') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">FineDesk</a>
        <a href="#membership" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Membership</a>
    </div>

    <div class="search-box">
        <input type="text" placeholder="Cari buku, penulis, atau ISBN...">
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

<div class="main-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="#" class="active"><span class="menu-icon">📊</span> Dashboard</a></li>
            <li><a href="#"><span class="menu-icon">📚</span> Manajemen Buku</a></li>
            <li><a href="#"><span class="menu-icon">👥</span> Manajemen Member</a></li>
            <li><a href="#"><span class="menu-icon">📤</span> Peminjaman</a></li>
            <li><a href="#"><span class="menu-icon">💰</span> Denda & Bayar</a></li>
            <li><a href="#"><span class="menu-icon">📈</span> Laporan</a></li>
            <li><a href="#"><span class="menu-icon">⚙️</span> Pengaturan</a></li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Dashboard Admin</h1>
            <p class="page-subtitle">Selamat datang kembali! Berikut ringkasan sistem library Anda.</p>
        </div>

        <!-- Alert -->
        <div class="alert">
            <span class="alert-icon">⚠️</span>
            <div>
                <strong>Perhatian:</strong> Ada 28 buku yang telat lebih dari 10 hari. Silakan hubungi members untuk pengembalian.
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <!-- Total Buku -->
            <div class="stat-card blue">
                <div class="stat-icon">📚</div>
                <div class="stat-content">
                    <div class="stat-value">667</div>
                    <div class="stat-label">Total Buku</div>
                    <div class="stat-change">↑ 12 buku baru bulan ini</div>
                </div>
            </div>

            <!-- Total Member -->
            <div class="stat-card green">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <div class="stat-value">1,205</div>
                    <div class="stat-label">Total Member</div>
                    <div class="stat-change">↑ 45 member baru bulan ini</div>
                </div>
            </div>

            <!-- Peminjaman Aktif -->
            <div class="stat-card orange">
                <div class="stat-icon">📤</div>
                <div class="stat-content">
                    <div class="stat-value">487</div>
                    <div class="stat-label">Peminjaman Aktif</div>
                    <div class="stat-change">↑ 23 sejak kemarin</div>
                </div>
            </div>

            <!-- Denda Belum Dibayar -->
            <div class="stat-card gold">
                <div class="stat-icon">💰</div>
                <div class="stat-content">
                    <div class="stat-value">Rp 2.33Jt</div>
                    <div class="stat-label">Denda Belum Dibayar</div>
                    <div class="stat-change negative">↑ 340K denda baru</div>
                </div>
            </div>
        </div>

        <!-- Cards Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <!-- Overdue Books -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Denda Telat Pengembalian</div>
                    <button class="btn-small">Lihat Semua</button>
                </div>
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Member</th>
                            <th>Buku</th>
                            <th>Telat</th>
                            <th>Denda</th>
                        </tr>
                        <tr>
                            <td>Rafa Afra</td>
                            <td>Bumi Tere Liye</td>
                            <td><span class="badge badge-danger">5 hari</span></td>
                            <td>Rp 25.000</td>
                        </tr>
                        <tr>
                            <td>Siti Nur A.</td>
                            <td>Filosofi Teras</td>
                            <td><span class="badge badge-danger">3 hari</span></td>
                            <td>Rp 15.000</td>
                        </tr>
                        <tr>
                            <td>Rudi Hartono</td>
                            <td>Java Programming</td>
                            <td><span class="badge badge-warning">1 hari</span></td>
                            <td>Rp 5.000</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Menunggu Persetujuan</div>
                    <button class="btn-small">Lihat Semua</button>
                </div>
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            <td>Permintaan Reservasi</td>
                            <td><strong>12</strong></td>
                            <td><span class="badge" style="background: #D6EAF8; color: #0C3B2E;">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Registrasi Member</td>
                            <td><strong>8</strong></td>
                            <td><span class="badge" style="background: #D6EAF8; color: #0C3B2E;">Pending</span></td>
                        </tr>
                        <tr>
                            <td> Reservasi Ready</td>
                            <td><strong>5</strong></td>
                            <td><span class="badge badge-warning">Action Needed</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection