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

    /* ===== FILTER & ACTIONS ===== */
    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .filter-label {
        font-weight: 600;
        color: #0C3B2E;
        font-size: 0.9rem;
    }

    .filter-select {
        padding: 0.65rem 1rem;
        border: 2px solid #E0E0E0;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .filter-select:hover {
        border-color: #6D9773;
    }

    .filter-section .spacer {
        flex: 1;
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

    .badge-unpaid {
        background: #FADBD8;
        color: #E74C3C;
    }

    .badge-paid {
        background: #D5F4E6;
        color: #27AE60;
    }

    .badge-partial {
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

    .btn-edit {
        background: #D6EAF8;
        color: #0C3B2E;
    }

    .btn-edit:hover {
        background: #AED6F1;
    }

    .btn-delete {
        background: #FADBD8;
        color: #E74C3C;
    }

    .btn-delete:hover {
        background: #F5B7B1;
    }

    /* ===== MODAL ===== */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #E8EAED;
        padding-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #E0E0E0;
        border-radius: 6px;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #6D9773;
        box-shadow: 0 0 0 3px rgba(109, 151, 115, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .modal-footer {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #E8EAED;
    }

    .btn-modal {
        padding: 0.7rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-modal-primary {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
    }

    .btn-modal-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(12, 59, 46, 0.2);
    }

    .btn-modal-secondary {
        background: #E8E8E8;
        color: #333;
    }

    .btn-modal-secondary:hover {
        background: #D0D0D0;
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

        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            flex-direction: column;
            gap: 0.3rem;
        }

        .filter-select {
            width: 100%;
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

        .btn-action {
            display: block;
            width: 100%;
            margin-bottom: 0.5rem;
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
        <a href="{{ route('readspace') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">ReadSpace</a>
        <a href="{{ route('reservation') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Reservation</a>
        <a href="{{ route('finedesk') }}" style="text-decoration: none; color: #FFBA00; font-weight: 600; font-size: 0.95rem; border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;">FineDesk</a>
        <a href="{{ route('membership') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Membership</a>
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
        <h1 class="page-title">💰 FineDesk Management</h1>
        <p class="page-subtitle">Kelola, pantau, dan proses denda peminjaman buku</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card unpaid">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <div class="stat-value">Rp 2.45Jt</div>
                <div class="stat-label">Denda Belum Dibayar</div>
            </div>
        </div>

        <div class="stat-card paid">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <div class="stat-value">Rp 8.75Jt</div>
                <div class="stat-label">Total Denda Terkumpul</div>
            </div>
        </div>

        <div class="stat-card collection">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-value">45 Member</div>
                <div class="stat-label">Memiliki Denda</div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-group">
            <label class="filter-label">Status:</label>
            <select class="filter-select">
                <option>Semua</option>
                <option>Belum Dibayar</option>
                <option>Sudah Dibayar</option>
                <option>Gagal Dibayar</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Urutkan:</label>
            <select class="filter-select">
                <option>Denda Terbesar</option>
                <option>Denda Terkecil</option>
                <option>Nama Member</option>
                <option>Tanggal Tercepat</option>
            </select>
        </div>
        <div class="spacer"></div>
        <button class="btn-small">+ Tambah Denda Manual</button>
    </div>

    <!-- Outstanding Fines -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📋 Denda Belum Dibayar (28)</div>
            <button class="btn-small">Export CSV</button>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <th>Member</th>
                    <th>Buku</th>
                    <th>Tanggal Jatuh Tempo</th>
                    <th>Hari Telat</th>
                    <th>Jumlah Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <tr>
                    <td><strong>Ahmad Rizki</strong></td>
                    <td>Design Patterns</td>
                    <td>29 Jan 2025</td>
                    <td>12 hari</td>
                    <td><strong>Rp 60.000</strong></td>
                    <td><span class="badge badge-unpaid">Belum Bayar</span></td>
                    <td>
                        <button class="btn-action btn-mark-paid">Bayar</button>
                        <button class="btn-action btn-edit">Edit</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Siti Nur Azizah</strong></td>
                    <td>Clean Code</td>
                    <td>27 Jan 2025</td>
                    <td>14 hari</td>
                    <td><strong>Rp 70.000</strong></td>
                    <td><span class="badge badge-unpaid">Belum Bayar</span></td>
                    <td>
                        <button class="btn-action btn-mark-paid">Bayar</button>
                        <button class="btn-action btn-edit">Edit</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Rudi Hartono</strong></td>
                    <td>Java Programming</td>
                    <td>2 Feb 2025</td>
                    <td>9 hari</td>
                    <td><strong>Rp 45.000</strong></td>
                    <td><span class="badge badge-unpaid">Belum Bayar</span></td>
                    <td>
                        <button class="btn-action btn-mark-paid">Bayar</button>
                        <button class="btn-action btn-edit">Edit</button>
                    </td>
                </tr>
            
                <tr>
                    <td><strong>Budi Santoso</strong></td>
                    <td>Refactoring</td>
                    <td>31 Jan 2025</td>
                    <td>10 hari</td>
                    <td><strong>Rp 50.000</strong></td>
                    <td><span class="badge badge-unpaid">Belum Bayar</span></td>
                    <td>
                        <button class="btn-action btn-mark-paid">Bayar</button>
                        <button class="btn-action btn-edit">Edit</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Payment History -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">✅ Riwayat Pembayaran Denda (Terbaru)</div>
            <button class="btn-small">Lihat Semua</button>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <th>Member</th>
                    <th>Buku</th>
                    <th>Jumlah Denda</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td><strong>Nina Wijaya</strong></td>
                    <td>Code Complete</td>
                    <td>Rp 35.000</td>
                    <td>10 Feb 2025</td>
                    <td>Transfer Bank</td>
                    <td><span class="badge badge-paid">Sukses</span></td>
                </tr>
                <tr>
                    <td><strong>Yuni Sarah</strong></td>
                    <td>Bumi</td>
                    <td>Rp 35.000</td>
                    <td>12 Feb 2025</td>
                    <td>Transfer Bank</td>
                    <td><span class="badge badge-unpaid">Gagal</span></td>
                </tr>

                <tr>
                    <td><strong>Tariq Rahman</strong></td>
                    <td>Database Design</td>
                    <td>Rp 50.000</td>
                    <td>9 Feb 2025</td>
                    <td>Tunai</td>
                    <td><span class="badge badge-paid">Sukses</span></td>
                </tr>
                <tr>
                    <td><strong>Lisa Maarif</strong></td>
                    <td>Algorithms</td>
                    <td>Rp 45.000</td>
                    <td>8 Feb 2025</td>
                    <td>E-Wallet</td>
                    <td><span class="badge badge-paid">Sukses</span></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Mark as Paid -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">💳 Proses Pembayaran Denda</div>
        <div class="form-group">
            <label>Member</label>
            <input type="text" value="Ahmad Rizki" disabled>
        </div>
        <div class="form-group">
            <label>Buku</label>
            <input type="text" value="Design Patterns" disabled>
        </div>
        <div class="form-group">
            <label>Jumlah Denda (Rp)</label>
            <input type="number" value="60000" placeholder="Masukkan jumlah denda">
        </div>
        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select class="filter-select">
                <option>Pilih Metode</option>
                <option>Tunai</option>
                <option>Transfer Bank</option>
                <option>E-Wallet</option>
                <option>Kartu Kredit</option>
            </select>
        </div>
        <div class="form-group">
            <label>Catatan (Opsional)</label>
            <textarea placeholder="Tulis catatan pembayaran..."></textarea>