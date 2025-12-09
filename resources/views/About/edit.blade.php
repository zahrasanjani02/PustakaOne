@extends('layouts.app')

@section('content')
@php
    // Normalisasi $about (safeguard)
    $about = $about ?? (object)['opening_hours' => [], 'social_links' => [], 'values' => []];

    // Normalisasi opening hours
    $openingHours = $about->opening_hours ?? [];
    $openingHours = is_array($openingHours) ? $openingHours : (is_string($openingHours) ? json_decode($openingHours, true) : []);
    
    // Normalisasi social links
    $socialLinks = $about->social_links ?? [];
    $socialLinks = is_array($socialLinks) ? $socialLinks : (is_string($socialLinks) ? json_decode($socialLinks, true) : []);

    // Normalisasi core values
    $coreValues = $about->values ?? [];
@endphp

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

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-preview {
        background: white;
        color: #6D9773;
        border: 2px solid #6D9773;
        padding: 0.8rem 1.8rem;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-preview:hover {
        background: #6D9773;
        color: white;
        transform: translateY(-2px);
    }

    .btn-save {
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

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(187, 138, 82, 0.4);
    }

    /* ===== TABS ===== */
    .tabs-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .tabs-header {
        display: flex;
        border-bottom: 2px solid #F0F2F5;
        padding: 0 1.5rem;
    }

    .tab-item {
        padding: 1.2rem 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        bottom: -2px;
    }

    .tab-item:hover {
        color: #6D9773;
    }

    .tab-item.active {
        color: #0C3B2E;
        border-bottom-color: #FFBA00;
    }

    .tab-content {
        padding: 2rem;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== FORM SECTIONS ===== */
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, rgba(109, 151, 115, 0.15), rgba(12, 59, 46, 0.15));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-grid.single {
        grid-template-columns: 1fr;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0C3B2E;
    }

    .form-label .required {
        color: #EF4444;
    }

    .form-input, .form-textarea, .form-select {
        padding: 0.9rem 1.2rem;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        background: white;
    }


    .value-item.editing .form-input:not([disabled]), 
    .value-item.editing .form-textarea:not([disabled]) {
        border-color: #6D9773 !important;
        box-shadow: 0 0 0 4px rgba(109, 151, 115, 0.1) !important;
    }


    .form-input[readonly], .form-textarea[readonly],
    .form-input:disabled, .form-textarea:disabled {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding-left: 0.2rem; 
        resize: none;
        cursor: default;
    }

    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #888;
        font-style: italic;
    }

    /* ===== IMAGE UPLOAD ===== */
    .image-upload-area {
        border: 3px dashed #E0E0E0;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #F8F9FA;
    }

    .image-upload-area:hover {
        border-color: #6D9773;
        background: rgba(109, 151, 115, 0.05);
    }

    .image-upload-area.has-image {
        padding: 1rem;
        border-style: solid;
    }

    .upload-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .upload-text {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        font-size: 0.8rem;
        color: #888;
    }

    .image-preview {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .btn-remove-image {
        background: #EF4444;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-remove-image:hover {
        background: #DC2626;
        transform: translateY(-2px);
    }

    /* ===== VALUES SECTION ===== */
    .values-list {
        display: grid;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .value-item {
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;                    /* horizontal layout */
        gap: 1rem;
        align-items: center;              /* center vertically */
        position: relative;
        transition: all 0.3s ease;
    }

    .value-item:hover {
        border-color: #6D9773;
        box-shadow: 0 4px 15px rgba(109, 151, 115, 0.15);
    }

    /* Highlight saat sedang editing (border hijau + latar halus) */
    .value-item.editing {
        border-color: #6D9773 !important;
        background: rgba(109,151,115,0.04);
        box-shadow: 0 8px 25px rgba(109,151,115,0.07);
    }

    /* Positioning and actions */
    .team-actions {
        position: absolute;
        top: 12px;
        right: 12px;
        display: flex;
        gap: 0.5rem;
        z-index: 10;
    }
    .team-actions button {
        background: #F0F0F0;
        border: 1px solid #E0E0E0;
        border-radius: 6px;
        padding: 0.4rem;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .team-actions button:hover {
        background: #EAEAEA;
    }

    /* Ensuring the value icon box is properly sized and aligned */
    /* Ensure proper sizing and centering of the icon */
    .value-icon-box {
        width: 80px; /* Increase width to give more space for the icon */
        height: 80px; /* Increase height to maintain a square aspect ratio */
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem; /* Increase icon size */
        flex: 0 0 80px; /* Prevent stretching */
        transition: all 0.3s ease;
        overflow: hidden; /* Prevent content overflow */
    }

    /* Adjust the input field inside the icon box */
    .value-item .icon-input {
        color: white !important;
        font-size: 2rem; /* Make the icon larger */
        text-align: center;
        border: none;
        padding: 0.5rem;
        background: transparent;
        width: 100%;
        height: 100%;
        margin: 0;
        box-shadow: none;
        resize: none;
        display: flex;
        align-items: center;
        justify-content: center; /* Ensure the icon stays centered */
    }

    /* Ensure icon box style when the value item is readonly */
    .value-item[readonly] .value-icon-box {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        box-shadow: none;
        padding: 0;
    }

    .value-item[readonly] .value-icon-box .icon-input {
        pointer-events: none;
        background-color: transparent;
        padding: 0;
        margin: 0;
    }

    /* Title + description side-by-side */
    .value-content {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        width: 100%;
    }
    .value-content .form-group.title { flex: 0 0 35%; }
    .value-content .form-group.desc  { flex: 1 1 auto; }

    /* Adjust form-group spacing inside value-content */
    .value-content .form-group { margin-bottom: 0; }

    /* Responsive: stack vertically on small screens */
    @media (max-width: 768px) {
        .value-item {
            flex-direction: column;
            align-items: stretch;
        }
        .value-content {
            flex-direction: column;
        }
        .team-actions {
            position: absolute;
            top: 12px;
            right: 12px;
        }
    }

    /* Make Title inputs in values have nicer padding / height even when readonly */
    .value-content .form-group.title .form-input,
    .value-content .form-group.title .form-input[readonly] {
        padding: 0.9rem 1.2rem !important;
        min-height: 48px;
        border-radius: 10px;
        line-height: 1.4;
        background: white !important;         /* keep visible box */
        border: 2px solid #E0E0E0 !important; /* visible outline */
        box-sizing: border-box;
    }

    /* If you want the description to match spacing too */
    .value-content .form-group.desc .form-textarea,
    .value-content .form-group.desc .form-textarea[readonly] {
        padding: 0.9rem 1.2rem !important;
    }

    /* ===== Override: tampilkan kotak (border) untuk title & description walau readonly ===== */
    .values-list .value-item .form-input[readonly],
    .values-list .value-item .form-textarea[readonly] {
        border: 2px solid #E0E0E0 !important;
        background: white !important;
        padding: 0.9rem 1.2rem !important;
        border-radius: 10px;
        box-sizing: border-box;
    }

    /* ===== Ketika item sedang editing: fokus hijau tipis (hilangkan outline hitam) ===== */
    .value-item.editing .form-input:not([disabled]):focus,
    .value-item.editing .form-textarea:not([disabled]):focus {
        outline: none !important;
        border-color: #6D9773 !important; /* hijau */
        box-shadow: 0 0 0 2px rgba(109,151,115,0.12) !important; /* tipis */
    }


    /* FORCE: hilangkan outline/focus hitam pada inputs di values, pakai hijau tipis */
    .values-list .value-item .form-input:focus,
    .values-list .value-item .form-textarea:focus,
    .values-list .value-item .form-input:focus-visible,
    .values-list .value-item .form-textarea:focus-visible {
        outline: none !important;
        border-color: #557f5cff !important; /* hijau */
        box-shadow: 0 0 0 2px rgba(71, 190, 89, 0.12) !important;
    }

    /* Pastikan readonly title + desc tetap memiliki kotak */
    .values-list .value-item .form-input[readonly],
    .values-list .value-item .form-textarea[readonly] {
        border: 2px solid #E0E0E0 !important;
        background: white !important;
        border-radius: 10px;
        padding: 0.9rem 1.2rem !important;
        box-sizing: border-box;
    }

    /* Hilangkan outline hitam saat tombol edit/fokus (opsional) */
    .values-list .btn-icon-small:focus { outline: none !important; box-shadow: none !important; }

    /* Pastikan ikon saat editing juga hijau ring tipis */
    .values-list .value-item.editing .value-icon-box {
        background: linear-gradient(135deg, #6D9773, #0C3B2E) !important;
        box-shadow: 0 0 0 2px rgba(109,151,115,0.12) !important;
    }

    .form-group.google-map .form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.9rem; 
    font-weight: 600;
    color: #0C3B2E;
    }

    .form-group.google-map .form-input {
        padding: 0.9rem 1.2rem !important; 
        min-height: 54px;
        border-radius: 10px;
        border: 2px solid #E0E0E0;
        background: white;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.15s ease;
    }

    .form-group.google-map .form-input:focus {
        outline: none;
        border-color: #6D9773;
        box-shadow: 0 0 0 4px rgba(109, 151, 115, 0.1); 
    }

    .form-group.google-map .form-hint {
        display: block;
        margin-top: 0.45rem;
        color: #7A857B;
        font-size: 0.85rem;
        font-style: italic;
        line-height: 1.35;
    }
</style>

@php
    // Normalisasi $about (safeguard)
    $about = $about ?? (object)['opening_hours' => [], 'social_links' => [], 'values' => []];

    // Normalisasi opening hours
    $openingHours = $about->opening_hours ?? [];
    $openingHours = is_array($openingHours) ? $openingHours : (is_string($openingHours) ? json_decode($openingHours, true) : []);
    
    // Normalisasi social links
    $socialLinks = $about->social_links ?? [];
    $socialLinks = is_array($socialLinks) ? $socialLinks : (is_string($socialLinks) ? json_decode($socialLinks, true) : []);

    // Normalisasi core values
    $coreValues = $about->values ?? [];
@endphp

<div class="navbar">
    <a href="{{ route('dashboard') }}" class="navbar-brand">
        <span>📚</span>
        <span class="logo-text">PustakaOne</span>
    </a>

    <div style="display: flex; gap: 3rem; list-style: none;">
        <a href="#aboutus.edit" style="text-decoration: none; color: #FFBA00; font-weight: 600; font-size: 0.95rem; border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;">About Us</a>
        <a href="{{ route('readspace') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">ReadSpace</a>
        <a href="{{ route('reservation') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Reservation</a>
        <a href="{{ route('finedesk') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">FineDesk</a>
        <a href="{{ route('membership.index') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Membership</a>
    </div>

    <div class="search-box">
        <input 
            type="text" 
            id="searchInput" 
            placeholder="Cari di About Us..." 
            onkeyup="performSearch()" 
        >
        <button type="submit" onclick="performSearch()">🔍</button>
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

<div class="content">
    <form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ALERT VALIDASI & SUCCESS --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-left: 1.2rem;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="page-header">
            <h1 class="page-title">Edit About Us Page</h1>
            <div class="header-actions">
                <a href="{{ route('about') }}" target="_blank" class="btn-preview">👁️ Preview</a>
                <button type="submit" class="btn-save">💾 Save Changes</button>
            </div>
        </div>

        <div class="tabs-container">
            <div class="tabs-header">
                <div class="tab-item active" onclick="switchTab(event, 'general')">📝 General Info</div>
                <div class="tab-item" onclick="switchTab(event, 'values')">⭐ Our Values</div>
                <div class="tab-item" onclick="switchTab(event, 'contact')">📞 Contact Info</div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">🏢</span>
                            Library Information
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Library Name <span class="required">*</span></label>
                                <input type="text" class="form-input" value="PustakaOne Digital Library" placeholder="Enter library name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Established Year</label>
                                <input type="number" class="form-input" value="2020" placeholder="e.g., 2020">
                            </div>
                        </div>
                        <div class="form-grid single">
                            <div class="form-group">
                                <label class="form-label">Tagline/Slogan</label>
                                <input type="text" class="form-input" value="Your Gateway to Knowledge" placeholder="Enter a catchy tagline">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">📖</span>
                            About Description
                        </h3>
                        <div class="form-grid single">
                            <div class="form-group">
                                <label class="form-label">Short Description <span class="required">*</span></label>
                                <textarea
                                    name="short_description"
                                    class="form-textarea"
                                    placeholder="Write a brief introduction (1-2 paragraphs)"
                                    required
                                >{{ old('short_description', $about->short_description ?? '') }}</textarea>
                                <span class="form-hint">This will appear on the main About Us section (max 500 characters)</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Full Description</label>
                                <textarea
                                    name="full_description"
                                    class="form-textarea"
                                    style="min-height: 250px;"
                                    placeholder="Write a comprehensive description"
                                >{{ old('full_description', $about->full_description ?? '') }}</textarea>
                                <span class="form-hint">Detailed information about your library's history, mission, and services</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">🖼️</span>
                            Hero Image
                        </h3>
                        <div class="form-group">
                            <label class="form-label">Upload Hero Image</label>

                            {{-- Preview dari DB kalau ada --}}
                            @if ($about->hero_image ?? null)
                                <div style="margin-bottom: 1rem;">
                                    <img src="{{ asset('storage/'.$about->hero_image) }}" alt="Hero Image" class="image-preview">
                                </div>
                            @endif

                            <div class="image-upload-area" onclick="document.getElementById('heroImage').click()">
                                <div class="upload-icon">📷</div>
                                <div class="upload-text">Click to upload or drag and drop</div>
                                <div class="upload-hint">Recommended size: 1920x800px (JPG, PNG)</div>
                            </div>
                            <input type="file" id="heroImage" name="hero_image" style="display: none;" accept="image/*">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">📊</span>
                            Statistics
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Total Books</label>
                                <input
                                    type="number"
                                    name="total_books"
                                    class="form-input"
                                    value="{{ old('total_books', $about->total_books ?? '') }}"
                                    placeholder="e.g., 50000"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label">Active Members</label>
                                <input
                                    type="number"
                                    name="active_members"
                                    class="form-input"
                                    value="{{ old('active_members', $about->active_members ?? '') }}"
                                    placeholder="e.g., 12500"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label">Books Borrowed (Total)</label>
                                <input
                                    type="number"
                                    name="books_borrowed_total"
                                    class="form-input"
                                    value="{{ old('books_borrowed_total', $about->books_borrowed_total ?? '') }}"
                                    placeholder="e.g., 250000"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label">Years of Service</label>
                                <input
                                    type="number"
                                    name="years_of_service"
                                    class="form-input"
                                    value="{{ old('years_of_service', $about->years_of_service ?? '') }}"
                                    placeholder="e.g., 4"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="values">
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">⭐</span>
                            Core Values & Mission
                        </h3>

                        <div class="form-grid single">
                            <div class="form-group">
                                <label class="form-label">Mission Statement</label>
                                <textarea
                                    name="mission_statement"
                                    class="form-textarea"
                                    placeholder="Enter your library's mission statement"
                                >{{ old('mission_statement', $about->mission_statement ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Vision Statement</label>
                                <textarea
                                    name="vision_statement"
                                    class="form-textarea"
                                    placeholder="Enter your library's vision"
                                >{{ old('vision_statement', $about->vision_statement ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">💎</span>
                            Core Values
                        </h3>
                        <div class="values-list">
                            @foreach($coreValues as $index => $value)
                            <div class="value-item" data-index="{{ $index }}">
                                <div class="value-icon-box" style="padding: 0;">
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                                        <input 
                                            type="text" 
                                            name="values[{{ $index }}][icon]" 
                                            class="form-input icon-input" 
                                            value="{{ old('values.'.$index.'.icon', $value['icon'] ?? '📚') }}" 
                                            disabled="disabled" style="text-align: center; border: none; padding: 0.5rem; background: transparent; font-size: 1.8rem; width: 100%; height: 100%; color: white; margin: 0; box-shadow: none;"
                                        />
                                    </div>
                                </div>

                                <div class="value-content">
                                    <div class="form-group title">
                                        <label class="form-label" style="margin-bottom: 0.2rem;">Value Title</label>
                                        <input type="text" name="values[{{ $index }}][title]" class="form-input" readonly value="{{ old('values.'.$index.'.title', $value['title'] ?? '') }}" placeholder="Enter Value Title" />
                                    </div>
                                    <div class="form-group desc">
                                        <label class="form-label" style="margin-bottom: 0.2rem;">Value Description</label>
                                        <textarea name="values[{{ $index }}][description]" class="form-textarea" readonly style="min-height: 80px; padding: 0.75rem;">{{ old('values.'.$index.'.description', $value['description'] ?? '') }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="team-actions">
                                    <button type="button" class="btn-icon-small edit" title="Edit" onclick="toggleEditMode(this)">✏️</button>
                                    <button type="button" class="btn-icon-small delete" title="Delete" onclick="deleteValue(this)">🗑️</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn-add-member" onclick="addNewValue()">➕ Add New Value</button>
                    </div>
                </div>

            <div class="tab-pane" id="contact">
                <div class="form-section">
                    <h3 class="section-title">
                        <span class="section-icon">📍</span>
                        Location & Address
                    </h3>
                    
                    {{-- BLOK 1: Alamat (Grid 2 kolom: Street, City, Province, Postal, Country) --}}
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="contact_address" class="form-input" value="{{ old('contact_address', $about->contact_address ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="contact_city" class="form-input" value="{{ old('contact_city', $about->contact_city ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Province/State</label>
                            <input type="text" name="contact_province" class="form-input" value="{{ old('contact_province', $about->contact_province ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="contact_postal" class="form-input" value="{{ old('contact_postal', $about->contact_postal ?? '') }}">
                        </div>
                        
                        {{-- FIX: Country harus berada di dalam form-grid utama --}}
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="contact_country" class="form-input" value="{{ old('contact_country', $about->contact_country ?? '') }}">
                        </div>
                    </div>

                    {{-- BLOK 2: Google Maps Embed URL (Grid 1 kolom, full width) --}}
                    <div class="form-grid single" style="margin-top: 1.5rem;"> 
                        <div class="form-group google-map">
                            <label class="form-label">Google Maps Embed URL</label>
                            <input
                                type="text"
                                name="map_embed"
                                class="form-input"
                                placeholder="Paste Google Maps embed URL here"
                                value="{{ old('map_embed', $about->map_embed ?? '') }}"
                            >
                            <span class="form-hint">Get the embed URL from Google Maps → Share → Embed a map</span>
                        </div>
                    </div>
                        </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">📞</span>
                            Contact Details
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="contact_phone" class="form-input" value="{{ old('contact_phone', $about->contact_phone ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">WhatsApp</label>
                                <input type="tel" name="contact_whatsapp" class="form-input" value="{{ old('contact_whatsapp', $about->contact_whatsapp ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="contact_email" class="form-input" value="{{ old('contact_email', $about->contact_email ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Support Email</label>
                                <input type="email" name="support_email" class="form-input" value="{{ old('support_email', $about->support_email ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">🕐</span>
                            Operating Hours
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Mon - Fri</label>
                                <input type="text" name="opening_hours[mon_fri]" class="form-input" value="{{ old('opening_hours.mon_fri', $openingHours['mon_fri'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Saturday</label>
                                <input type="text" name="opening_hours[sat]" class="form-input" value="{{ old('opening_hours.sat', $openingHours['sat'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sunday</label>
                                <input type="text" name="opening_hours[sun]" class="form-input" value="{{ old('opening_hours.sun', $openingHours['sun'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Public Holidays</label>
                                <input type="text" name="opening_hours[public_holidays]" class="form-input" value="{{ old('opening_hours.public_holidays', $openingHours['public_holidays'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">🌐</span>
                            Social Media
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Facebook</label>
                                <input type="url" name="social[facebook]" class="form-input" value="{{ old('social.facebook', $socialLinks['facebook'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Instagram</label>
                                <input type="url" name="social[instagram]" class="form-input" value="{{ old('social.instagram', $socialLinks['instagram'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Twitter</label>
                                <input type="url" name="social[twitter]" class="form-input" value="{{ old('social.twitter', $socialLinks['twitter'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">LinkedIn</label>
                                <input type="url" name="social[linkedin]" class="form-input" value="{{ old('social.linkedin', $socialLinks['linkedin'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">YouTube</label>
                                <input type="url" name="social[youtube]" class="form-input" value="{{ old('social.youtube', $socialLinks['youtube'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">TikTok</label>
                                <input type="url" name="social[tiktok]" class="form-input" value="{{ old('social.tiktok', $socialLinks['tiktok'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </form>
</div> 

<script>
function switchTab(e, tabName) {
    // Hide all tab panes
    const panes = document.querySelectorAll('.tab-pane');
    panes.forEach(pane => pane.classList.remove('active'));
    
    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.tab-item');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Show selected tab pane
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    e.target.classList.add('active');
}

// Image upload preview
document.getElementById('heroImage')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const uploadArea = document.querySelector('.image-upload-area');
            uploadArea.innerHTML = `
                <img src="${ev.target.result}" class="image-preview" alt="Preview">
                <button class="btn-remove-image" onclick="removeImage(event)">🗑️ Remove Image</button>
            `;
            uploadArea.classList.add('has-image');
        };
        reader.readAsDataURL(file);
    }
});

function removeImage(event) {
    event.stopPropagation();
    const uploadArea = document.querySelector('.image-upload-area');
    uploadArea.innerHTML = `
        <div class="upload-icon">📷</div>
        <div class="upload-text">Click to upload or drag and drop</div>
        <div class="upload-hint">Recommended size: 1920x800px (JPG, PNG)</div>
    `;
    uploadArea.classList.remove('has-image');
    document.getElementById('heroImage').value = '';
}

/// Toggle between editing and locked state
function toggleEditMode(buttonElement) {
    const valueItem = buttonElement.closest('.value-item');
    if (!valueItem) return;

    const isEditing = valueItem.classList.contains('editing');

    if (isEditing) {
        // Lock the item (readonly)
        setLockedState(valueItem);
    } else {
        // Unlock the item for editing
        setEditingState(valueItem);
        const titleInput = valueItem.querySelector('input[name*="[title]"]');
        if (titleInput) titleInput.focus();  
    }
}

// Set the item to locked (readonly) state
function setLockedState(valueItem) {
    valueItem.classList.remove('editing');
    const editableFields = valueItem.querySelectorAll('input, textarea');
    editableFields.forEach(field => field.setAttribute('readonly', 'readonly'));
    
    // Adjust icon and box color to indicate locked state
    const iconBox = valueItem.querySelector('.value-icon-box');
    if (iconBox) {
        iconBox.style.background = 'linear-gradient(135deg, #BB8A52, #FFBA00)'; 
        iconBox.style.boxShadow = 'none';
    }

    const editBtn = valueItem.querySelector('.btn-icon-small.edit');
    if (editBtn) {
        editBtn.innerHTML = '✏️';  // Change to edit icon
        editBtn.title = 'Edit';
    }
}

// Set the item to editable state
function setEditingState(valueItem) {
    valueItem.classList.add('editing');
    const editableFields = valueItem.querySelectorAll('input, textarea');
    editableFields.forEach(field => field.removeAttribute('readonly'));

    // Change icon box color and style
    const iconBox = valueItem.querySelector('.value-icon-box');
    if (iconBox) {
        iconBox.style.background = 'linear-gradient(135deg, #6D9773, #0C3B2E)'; 
        iconBox.style.boxShadow = '0 0 0 3px rgba(255, 186, 0, 0.35)';
    }

    const editBtn = valueItem.querySelector('.btn-icon-small.edit');
    if (editBtn) {
        editBtn.innerHTML = '🔒';  // Change to lock icon
        editBtn.title = 'Finish Editing';
    }
}

// Add new core value item
function addNewValue() {
    const list = document.querySelector('.values-list');
    const newIndex = list.children.length;  // Get new index for the new value item
    
    list.insertAdjacentHTML('beforeend', getNewValueTemplate(newIndex));

    const newItem = list.lastElementChild;
    const editButton = newItem.querySelector('.btn-icon-small.edit');
    
    // Activate editing state for new item
    setEditingState(newItem);
    
    const titleInput = newItem.querySelector('input[name*="[title]"]');
    if (titleInput) titleInput.focus();  // Focus on the title input for new value
}

// Template for new value item
function getNewValueTemplate(index) {
    return `
    <div class="value-item editing new-item" data-index="${index}">
        <div class="value-icon-box" style="padding: 0;">
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                <input 
                    type="text" 
                    name="values[${index}][icon]" 
                    class="form-input icon-input" 
                    value="💡" 
                    placeholder="Icon Emoji"
                    style="text-align: center; border: none; padding: 0.5rem; background: transparent; font-size: 1.8rem; width: 100%; height: 100%; color: white; margin: 0; box-shadow: none;"
                />
            </div>
        </div>
        <div class="value-content">
            <div class="form-group title">
                <label class="form-label" style="margin-bottom: 0.2rem;">Value Title</label>
                <input type="text" name="values[${index}][title]" class="form-input" value="" placeholder="Enter Value Title" />
            </div>
            <div class="form-group desc">
                <label class="form-label" style="margin-bottom: 0.2rem;">Value Description</label>
                <textarea name="values[${index}][description]" class="form-textarea" style="min-height: 80px; padding: 0.75rem;" placeholder="Enter Description"></textarea>
            </div>
        </div>
        <div class="team-actions">
            <button type="button" class="btn-icon-small edit" title="Edit" onclick="toggleEditMode(this)">✏️</button>
            <button type="button" class="btn-icon-small delete" title="Delete" onclick="deleteValue(this)">🗑️</button>
        </div>
    </div>`;
}

// Delete core value item
function deleteValue(buttonElement) {
    const valueItem = buttonElement.closest('.value-item');
    if (confirm('Are you sure you want to delete this value?')) {
        valueItem.remove();  // Remove the item
    }
}

// Initialize items in locked state on page load
document.addEventListener('DOMContentLoaded', () => {
    const existingItems = document.querySelectorAll('.values-list .value-item');
    existingItems.forEach(item => {
        setLockedState(item);  // Lock all existing items on page load
    });
});


function performSearch() {
    let query = document.getElementById("searchInput").value; // Mendapatkan query pencarian
    if (query.trim() !== "") {
        // Mengirim permintaan AJAX ke server dengan query pencarian
        fetch(`/search-about-us?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Menangani data (misalnya, memperbarui halaman dengan hasil pencarian)
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
    }
}

function displaySearchResults(data) {
    const resultsContainer = document.getElementById("searchResultsContainer");
    resultsContainer.innerHTML = ''; // Mengosongkan hasil yang ada

    if (data.length === 0) {
        resultsContainer.innerHTML = "<p>Tidak ada hasil yang ditemukan.</p>";
    } else {
        const ul = document.createElement('ul');  // Membuat elemen <ul> untuk hasil pencarian
        data.forEach(item => {
            const li = document.createElement('li');  // Membuat elemen <li> untuk setiap hasil pencarian
            li.textContent = item.title;  // Menampilkan judul hasil pencarian (sesuaikan dengan field dari server)
            ul.appendChild(li);
        });
        resultsContainer.appendChild(ul);  // Menambahkan <ul> dengan hasil pencarian ke dalam kontainer
    }
}

</script>
@endsection