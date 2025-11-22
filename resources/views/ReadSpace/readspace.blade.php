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

    /* ===== MAIN LAYOUT ===== */
    .main-container {
        display: grid;
        grid-template-columns: 1fr;
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
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .content-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0C3B2E;
    }

    .filter-dropdown {
        padding: 0.65rem 1.2rem;
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #6D9773;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-dropdown:hover {
        border-color: #6D9773;
        box-shadow: 0 2px 8px rgba(109, 151, 115, 0.15);
    }

    /* ===== BOOKS GRID ===== */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .book-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .book-cover {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #0C3B2E, #6D9773);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        overflow: hidden;
        position: relative;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-info {
        padding: 1.5rem;
    }

    .book-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .book-author {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.8rem;
    }

    .book-description {
        font-size: 0.85rem;
        color: #888;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.8rem;
    }

    .btn-read-more {
        background: linear-gradient(135deg, #BB8A52, #6D9773);
        color: white;
        border: none;
        padding: 0.65rem 1.2rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        flex: 1;
    }

    .btn-read-more:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(109, 151, 115, 0.3);
    }

    .book-actions-icons {
        display: flex;
        gap: 0.8rem;
    }

    .action-icon {
        width: 36px;
        height: 36px;
        border: 2px solid #E0E0E0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .action-icon:hover {
        border-color: #6D9773;
        background: #F0F2F5;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .main-container {
            grid-template-columns: 1fr;
        }

        .sidebar {
            display: none;
        }

        .content {
            padding: 1rem;
        }

        .content-title {
            font-size: 1.4rem;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .navbar {
            gap: 1rem;
        }

        .navbar-links {
            display: none;
        }

        .search-box {
            max-width: 250px;
            margin: 0;
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
        <a href="{{ route('about') }}"  style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">About Us</a>
        <a href="{{ route('readspace') }}" style="text-decoration: none; color: #FFBA00; font-weight: 600; font-size: 0.95rem; border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;">ReadSpace</a>
        <a href="{{ route('reservation') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Reservation</a>
        <a href="{{ route('finedesk') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">FineDesk</a>
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

<!-- MAIN CONTAINER -->
<div class="main-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-title">📚 Menu</div>

        <div class="sidebar-title">📂 Book Types</div>
        <ul class="sidebar-categories">
            <li><a href="#">Biography</a></li>
            <li><a href="#">Kids</a></li>
            <li><a href="#">Sports</a></li>
            <li><a href="#">Technology</a></li>
            <li><a href="#">Fiction</a></li>
            <li><a href="#">Self-Help</a></li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">
        <div class="content-header">
            <h1 class="content-title">Books Gallery</h1>
            <select class="filter-dropdown">
                <option>All Categories</option>
                <option>Biography</option>
                <option>Fiction</option>
                <option>Technology</option>
                <option>Self-Help</option>
            </select>
        </div>

        <!-- BOOKS GRID -->
        <div class="books-grid">
            <!-- Book 1 -->
            <div class="book-card">
                <div class="book-cover">📚</div>
                <div class="book-info">
                    <div class="book-title">The Snowball: Warren Buffett</div>
                    <div class="book-author">Warren Buffett</div>
                    <div class="book-description">Born in Nebraska in 1930. Warren Buffett demonstrated keen business abilities at a young age.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book 2 -->
            <div class="book-card">
                <div class="book-cover">🎨</div>
                <div class="book-info">
                    <div class="book-title">Gandhi: True experiment</div>
                    <div class="book-author">M. K. Gandhi</div>
                    <div class="book-description">Born and raised in a Hindu merchant caste family in coastal Gujarat, India, and trained in law.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book 3 -->
            <div class="book-card">
                <div class="book-cover">📖</div>
                <div class="book-info">
                    <div class="book-title">Charlotte's Web</div>
                    <div class="book-author">E. B. White</div>
                    <div class="book-description">Charlotte's Web is a children's novel by American author E. B. White and illustrated by Garth Williams.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book 4 -->
            <div class="book-card">
                <div class="book-cover">🏏</div>
                <div class="book-info">
                    <div class="book-title">The Dhoni Touch</div>
                    <div class="book-author">Mahendra Singh Dhoni</div>
                    <div class="book-description">For over a decade, Mahendra Singh Dhoni has captivated the world of cricket and over a billion Indians.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book 5 -->
            <div class="book-card">
                <div class="book-cover">⛰️</div>
                <div class="book-info">
                    <div class="book-title">Sky Runner</div>
                    <div class="book-author">Emelie Forsberg</div>
                    <div class="book-description">Emelie Forsberg is a renown Sky runner recognised worldwide for her incredible strength, endurance.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book 6 -->
            <div class="book-card">
                <div class="book-cover">👨</div>
                <div class="book-info">
                    <div class="book-title">Nelson Mandela</div>
                    <div class="book-author">Nelson Mandela</div>
                    <div class="book-description">Nelson Rolihlahla Mandela (18 July 1918 – 5 December 2013) was a South African politician and activist.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Book 7 -->
            <div class="book-card">
                <div class="book-cover">👨</div>
                <div class="book-info">
                    <div class="book-title">Nelson Mandela</div>
                    <div class="book-author">Nelson Mandela</div>
                    <div class="book-description">Nelson Rolihlahla Mandela (18 July 1918 – 5 December 2013) was a South African politician and activist.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Book 8 -->
            <div class="book-card">
                <div class="book-cover">👨</div>
                <div class="book-info">
                    <div class="book-title">Nelson Mandela</div>
                    <div class="book-author">Nelson Mandela</div>
                    <div class="book-description">Nelson Rolihlahla Mandela (18 July 1918 – 5 December 2013) was a South African politician and activist.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Book 9 -->
            <div class="book-card">
                <div class="book-cover">👨</div>
                <div class="book-info">
                    <div class="book-title">Nelson Mandela</div>
                    <div class="book-author">Nelson Mandela</div>
                    <div class="book-description">Nelson Rolihlahla Mandela (18 July 1918 – 5 December 2013) was a South African politician and activist.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Book 10 -->
            <div class="book-card">
                <div class="book-cover">👨</div>
                <div class="book-info">
                    <div class="book-title">Nelson Mandela</div>
                    <div class="book-author">Nelson Mandela</div>
                    <div class="book-description">Nelson Rolihlahla Mandela (18 July 1918 – 5 December 2013) was a South African politician and activist.</div>
                    <div class="book-actions">
                        <button class="btn-read-more">Read More</button>
                        <div class="book-actions-icons">
                            <div class="action-icon">❤️</div>
                            <div class="action-icon">📤</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection