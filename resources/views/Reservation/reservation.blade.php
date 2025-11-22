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

    /* ===== TABS ===== */
    .tabs-container {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid #E8EAED;
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

    .stat-card.waiting {
        border-left-color: #BB8A52;
    }

    .stat-card.ready {
        border-left-color: #6D9773;
    }

    .stat-card.expired {
        border-left-color: #E74C3C;
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

    .badge-waiting {
        background: #FFF3CD;
        color: #856404;
    }

    .badge-ready {
        background: #D5F4E6;
        color: #27AE60;
    }

    .badge-expired {
        background: #FADBD8;
        color: #E74C3C;
    }

    .badge-claimed {
        background: #D6EAF8;
        color: #0C3B2E;
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

    .btn-approve {
        background: #D5F4E6;
        color: #27AE60;
    }

    .btn-approve:hover {
        background: #A3E9C5;
    }

    .btn-reject {
        background: #FADBD8;
        color: #E74C3C;
    }

    .btn-reject:hover {
        background: #F5B7B1;
    }

    .btn-mark-ready {
        background: #D6EAF8;
        color: #0C3B2E;
    }

    .btn-mark-ready:hover {
        background: #AED6F1;
    }

    .btn-claim {
        background: #E8F4F8;
        color: #6D9773;
    }

    .btn-claim:hover {
        background: #D0E8F2;
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

        .navbar-links {
            display: none;
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
    }
</style>

<!-- NAVBAR -->
<div class="navbar">
    <a href="{{ route(name: 'dashboard') }}" class="navbar-brand">
        <span>📚</span>
        <span class="logo-text">PustakaOne</span>
</a>

    <div style="display: flex; gap: 3rem; list-style: none;">
        <a href="{{ route('about') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">About Us</a>
        <a href="{{ route('readspace') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">ReadSpace</a>
        <a href="{{ route('reservation') }}" style="text-decoration: none; color: #FFBA00; font-weight: 600; font-size: 0.95rem; border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;">Reservation</a>
        <a href="{{ route('finedesk') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">FineDesk</a>
        <a href="{{ route('membership') }}"style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Membership</a>
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

<!-- CONTENT -->
<div class="content">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title"> Reservation Management</h1>
        <p class="page-subtitle">Kelola reservasi buku dari member Anda</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card waiting">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <div class="stat-value">18</div>
                <div class="stat-label">Menunggu Tersedia</div>
            </div>
        </div>

        <div class="stat-card ready">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <div class="stat-value">7</div>
                <div class="stat-label">Siap Diambil</div>
            </div>
        </div>

        <div class="stat-card expired">
            <div class="stat-icon">⚠️</div>
            <div class="stat-content">
                <div class="stat-value">3</div>
                <div class="stat-label">Kadaluwarsa</div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('waiting')">⏳ Menunggu Tersedia (18)</button>
        <button class="tab-btn" onclick="switchTab('ready')">✅ Siap Diambil (7)</button>
        <button class="tab-btn" onclick="switchTab('claimed')">📦 Diambil (45)</button>
        <button class="tab-btn" onclick="switchTab('expired')">⚠️ Kadaluwarsa (3)</button>
    </div>

    <!-- TAB: WAITING -->
    <div id="waiting" class="tab-content active">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Reservasi Menunggu Buku Tersedia</div>
                <button class="btn-small">Refresh</button>
            </div>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Buku</th>
                        <th>Dipesan Sejak</th>
                        <th>Posisi Antrian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td><strong>Thoriq Ibrahim</strong></td>
                        <td>Clean Code</td>
                        <td>5 Jan 2025</td>
                        <td>1st</td>
                        <td><span class="badge badge-waiting">Waiting</span></td>
                        <td>
                            <button class="btn-action btn-mark-ready">Mark Ready</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Rafa Afra</strong></td>
                        <td>Clean Code</td>
                        <td>8 Jan 2025</td>
                        <td>2nd</td>
                        <td><span class="badge badge-waiting">Waiting</span></td>
                        <td>
                            <button class="btn-action btn-mark-ready">Mark Ready</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ilham Maulana</strong></td>
                        <td>Design Patterns</td>
                        <td>3 Jan 2025</td>
                        <td>1st</td>
                        <td><span class="badge badge-waiting">Waiting</span></td>
                        <td>
                            <button class="btn-action btn-mark-ready">Mark Ready</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: READY -->
    <div id="ready" class="tab-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Buku Siap Diambil (Batas Pengambilan 3 Hari)</div>
                <button class="btn-small">Refresh</button>
            </div>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Buku</th>
                        <th>Siap Sejak</th>
                        <th>Batas Pengambilan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td><strong>Dwi Putra</strong></td>
                        <td>The Pragmatic Programmer</td>
                        <td>10 Jan 2025</td>
                        <td><span class="badge badge-ready">Hari Ini</span></td>
                        <td><span class="badge badge-ready">Ready</span></td>
                        <td>
                            <button class="btn-action btn-claim">Claim</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Fadil Efdika</strong></td>
                        <td>Refactoring</td>
                        <td>9 Jan 2025</td>
                        <td><span class="badge badge-expired">Besok!</span></td>
                        <td><span class="badge badge-ready">Ready</span></td>
                        <td>
                            <button class="btn-action btn-claim">Claim</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Novi Fitri</strong></td>
                        <td>Code Complete</td>
                        <td>8 Jan 2025</td>
                        <td><span class="badge badge-expired">Expired</span></td>
                        <td><span class="badge badge-ready">Ready</span></td>
                        <td>
                            <button class="btn-action btn-claim">Claim</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: CLAIMED -->
    <div id="claimed" class="tab-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Reservasi yang Telah Diambil</div>
                <button class="btn-small">Refresh</button>
            </div>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Buku</th>
                        <th>Diambil Tanggal</th>
                        <th>Tanggal Klaim</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td><strong>Tariq Rahman</strong></td>
                        <td>Java Programming</td>
                        <td>5 Jan 2025</td>
                        <td>6 Jan 2025</td>
                        <td><span class="badge badge-claimed">Claimed</span></td>
                    </tr>
                    <tr>
                        <td><strong>Lisa Maarif</strong></td>
                        <td>Python Cookbook</td>
                        <td>3 Jan 2025</td>
                        <td>4 Jan 2025</td>
                        <td><span class="badge badge-claimed">Claimed</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: EXPIRED -->
    <div id="expired" class="tab-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Reservasi Kadaluarsa</div>
                <button class="btn-small">Refresh</button>
            </div>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Buku</th>
                        <th>Ready Sejak</th>
                        <th>Batas Akhir</th>
                        <th>Hari Telat</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td><strong>Bae Kajol</strong></td>
                        <td>Algorithms</td>
                        <td>7 Jan 2025</td>
                        <td>10 Jan 2025</td>
                        <td>3 hari</td>
                        <td><span class="badge badge-expired">Expired</span></td>
                    </tr>
                    <tr>
                        <td><strong>Alif Muzahid</strong></td>
                        <td>Database Design</td>
                        <td>6 Jan 2025</td>
                        <td>9 Jan 2025</td>
                        <td>4 hari</td>
                        <td><span class="badge badge-expired">Expired</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tabs
        const tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => tab.classList.remove('active'));

        // Remove active class from all buttons
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Show selected tab
        document.getElementById(tabName).classList.add('active');

        // Add active class to clicked button
        event.target.classList.add('active');
    }
</script>

@endsection