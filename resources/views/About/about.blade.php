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

    .form-input:focus, .form-textarea:focus, .form-select:focus {
        outline: none;
        border-color: #6D9773;
        box-shadow: 0 0 0 4px rgba(109, 151, 115, 0.1);
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
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 1.5rem;
        align-items: center;
        transition: all 0.3s ease;
    }

    .value-item:hover {
        border-color: #6D9773;
        box-shadow: 0 4px 15px rgba(109, 151, 115, 0.15);
    }

    .value-icon-box {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .value-content {
        flex: 1;
    }

    .value-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .value-description {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .form-grid {
            grid-template-columns: 1fr;
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

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn-preview, .btn-save {
            width: 100%;
        }

        .tabs-header {
            overflow-x: auto;
            padding: 0 0.5rem;
        }

        .tab-item {
            padding: 1rem 1.5rem;
            white-space: nowrap;
        }

        .tab-content {
            padding: 1rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .value-item {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .value-icon-box {
            margin: 0 auto;
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
        <a href="#aboutus.edit" style="text-decoration: none; color: #FFBA00; font-weight: 600; font-size: 0.95rem; border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;">About Us</a>
        <a href="{{ route('readspace') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">ReadSpace</a>
        <a href="{{ route('reservation') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Reservation</a>
        <a href="{{ route('finedesk') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">FineDesk</a>
        <a href="{{ route('membership') }}" style="text-decoration: none; color: #FFFFFF; font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='#FFFFFF'">Membership</a>
    </div>

    <div class="search-box">
        <input type="text" placeholder="Cari di About Us...">
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
        <h1 class="page-title">Edit About Us Page</h1>
        <div class="header-actions">
            <button class="btn-preview" onclick="alert('Preview functionality')">👁️ Preview</button>
            <button class="btn-save" onclick="alert('Changes saved!')">💾 Save Changes</button>
        </div>
    </div>

    <!-- Tabs Container -->
    <div class="tabs-container">
        <div class="tabs-header">
            <div class="tab-item active" onclick="switchTab('general')">📝 General Info</div>
            <div class="tab-item" onclick="switchTab('values')">⭐ Our Values</div>
            <div class="tab-item" onclick="switchTab('contact')">📞 Contact Info</div>
        </div>

        <!-- TAB 1: GENERAL INFO -->
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
                            <textarea class="form-textarea" placeholder="Write a brief introduction (1-2 paragraphs)">PustakaOne is a modern digital library platform dedicated to providing seamless access to knowledge and literature. Founded in 2020, we strive to bridge the gap between traditional library services and cutting-edge technology.</textarea>
                            <span class="form-hint">This will appear on the main About Us section (max 500 characters)</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Full Description</label>
                            <textarea class="form-textarea" style="min-height: 250px;" placeholder="Write a comprehensive description">Our mission is to revolutionize how people access and engage with books and educational resources. With over 50,000 titles and growing, we serve a community of passionate readers and learners.

We believe in the power of knowledge to transform lives. Through innovative features like virtual reading spaces, intelligent book recommendations, and seamless reservation systems, we're making literature more accessible than ever before.</textarea>
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
                        <div class="image-upload-area" onclick="document.getElementById('heroImage').click()">
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">Click to upload or drag and drop</div>
                            <div class="upload-hint">Recommended size: 1920x800px (JPG, PNG)</div>
                        </div>
                        <input type="file" id="heroImage" style="display: none;" accept="image/*">
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
                            <input type="number" class="form-input" value="50000" placeholder="e.g., 50000">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Active Members</label>
                            <input type="number" class="form-input" value="12500" placeholder="e.g., 12500">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Books Borrowed (Total)</label>
                            <input type="number" class="form-input" value="250000" placeholder="e.g., 250000">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Years of Service</label>
                            <input type="number" class="form-input" value="4" placeholder="e.g., 4">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: OUR VALUES -->
            <div class="tab-pane" id="values">
                <div class="form-section">
                    <h3 class="section-title">
                        <span class="section-icon">⭐</span>
                        Core Values & Mission
                    </h3>

                    <div class="form-grid single">
                        <div class="form-group">
                            <label class="form-label">Mission Statement</label>
                            <textarea class="form-textarea" placeholder="Enter your library's mission statement">To democratize access to knowledge and foster a love of reading by providing innovative library services that meet the evolving needs of our diverse community.</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Vision Statement</label>
                            <textarea class="form-textarea" placeholder="Enter your library's vision">To be the leading digital library platform that inspires lifelong learning and connects people with the transformative power of literature.</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">
                        <span class="section-icon">💎</span>
                        Core Values
                    </h3>
                    
                    <div class="values-list">
                        <!-- Value 1 -->
                        <div class="value-item">
                            <div class="value-icon-box">📚</div>
                            <div class="value-content">
                                <div class="value-title">Knowledge Access</div>
                                <div class="value-description">We believe everyone deserves equal access to quality information and educational resources, regardless of their background or location.</div>
                            </div>
                            <div class="team-actions">
                                <button class="btn-icon-small edit" title="Edit">✏️</button>
                                <button class="btn-icon-small delete" title="Delete">🗑️</button>
                            </div>
                        </div>

                        <!-- Value 2 -->
                        <div class="value-item">
                            <div class="value-icon-box">🚀</div>
                            <div class="value-content">
                                <div class="value-title">Innovation</div>
                                <div class="value-description">We continuously embrace new technologies and methods to enhance the library experience and stay ahead of changing user needs.</div>
                            </div>
                            <div class="team-actions">
                                <button class="btn-icon-small edit" title="Edit">✏️</button>
                                <button class="btn-icon-small delete" title="Delete">🗑️</button>
                            </div>
                        </div>

                        <!-- Value 3 -->
                        <div class="value-item">
                            <div class="value-icon-box">🤝</div>
                            <div class="value-content">
                                <div class="value-title">Community Focus</div>
                                <div class="value-description">We foster a vibrant community of readers and learners, creating spaces for connection, collaboration, and shared discovery.</div>
                            </div>
                            <div class="team-actions">
                                <button class="btn-icon-small edit" title="Edit">✏️</button>
                                <button class="btn-icon-small delete" title="Delete">🗑️</button>
                            </div>
                        </div>

                        <!-- Value 4 -->
                        <div class="value-item">
                            <div class="value-icon-box">✨</div>
                            <div class="value-content">
                                <div class="value-title">Excellence</div>
                                <div class="value-description">We are committed to providing exceptional service, carefully curated collections, and reliable support to every member.</div>
                            </div>
                            <div class="team-actions">
                                <button class="btn-icon-small edit" title="Edit">✏️</button>
                                <button class="btn-icon-small delete" title="Delete">🗑️</button>
                            </div>
                        </div>

                        <!-- Value 5 -->
                        <div class="value-item">
                            <div class="value-icon-box">🌱</div>
                            <div class="value-content">
                                <div class="value-title">Sustainability</div>
                                <div class="value-description">We promote sustainable practices through digital solutions, reducing environmental impact while expanding access to resources.</div>
                            </div>
                            <div class="team-actions">
                                <button class="btn-icon-small edit" title="Edit">✏️</button>
                                <button class="btn-icon-small delete" title="Delete">🗑️</button>
                            </div>
                        </div>
                    </div>

                    <button class="btn-add-member" onclick="alert('Add new value form')">➕ Add New Value</button>
                </div>
            </div>

            <!-- TAB 4: CONTACT INFO -->
            <div class="tab-pane" id="contact">
                <div class="form-section">
                    <h3 class="section-title">
                        <span class="section-icon">📍</span>
                        Location & Address
                    </h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Street Address <span class="required">*</span></label>
                            <input type="text" class="form-input" value="Jl. Pendidikan No. 123" placeholder="Enter street address">
                        </div>
                        <div class="form-group">
                            <label class="form-label">City <span class="required">*</span></label>
                            <input type="text" class="form-input" value="Jakarta" placeholder="Enter city">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Province/State</label>
                            <input type="text" class="form-input" value="DKI Jakarta" placeholder="Enter province">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-input" value="12345" placeholder="Enter postal code">
                        </div>
                    </div>
                    <div class="form-grid single">
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-input" value="Indonesia" placeholder="Enter country">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Google Maps Embed URL</label>
                            <input type="text" class="form-input" placeholder="Paste Google Maps embed URL here">
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
                            <label class="form-label">Phone Number <span class="required">*</span></label>
                            <input type="tel" class="form-input" value="+62 21 1234 5678" placeholder="+62 xxx xxxx xxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">WhatsApp Number</label>
                            <input type="tel" class="form-input" value="+62 812 3456 7890" placeholder="+62 8xx xxxx xxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" class="form-input" value="info@pustakaone.com" placeholder="email@domain.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Support Email</label>
                            <input type="email" class="form-input" value="support@pustakaone.com" placeholder="support@domain.com">
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
                            <label class="form-label">Monday - Friday</label>
                            <input type="text" class="form-input" value="08:00 - 20:00" placeholder="e.g., 08:00 - 20:00">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Saturday</label>
                            <input type="text" class="form-input" value="09:00 - 17:00" placeholder="e.g., 09:00 - 17:00">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sunday</label>
                            <input type="text" class="form-input" value="10:00 - 16:00" placeholder="e.g., 10:00 - 16:00">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Public Holidays</label>
                            <input type="text" class="form-input" value="Closed" placeholder="e.g., Closed">
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
                            <input type="url" class="form-input" value="https://facebook.com/pustakaone" placeholder="https://facebook.com/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Instagram</label>
                            <input type="url" class="form-input" value="https://instagram.com/pustakaone" placeholder="https://instagram.com/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Twitter (X)</label>
                            <input type="url" class="form-input" value="https://twitter.com/pustakaone" placeholder="https://twitter.com/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" class="form-input" value="https://linkedin.com/company/pustakaone" placeholder="https://linkedin.com/company/name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">YouTube</label>
                            <input type="url" class="form-input" placeholder="https://youtube.com/@username">
                        </div>
                        <div class="form-group">
                            <label class="form-label">TikTok</label>
                            <input type="url" class="form-input" placeholder="https://tiktok.com/@username">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tab panes
    const panes = document.querySelectorAll('.tab-pane');
    panes.forEach(pane => pane.classList.remove('active'));
    
    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.tab-item');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Show selected tab pane
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
}

// Image upload preview
document.getElementById('heroImage')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const uploadArea = document.querySelector('.image-upload-area');
            uploadArea.innerHTML = `
                <img src="${e.target.result}" class="image-preview" alt="Preview">
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
</script>

@endsection