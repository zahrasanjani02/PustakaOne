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

    /* ===== HERO SECTION ===== */
    .hero-section {
        background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%);
        color: white;
        padding: 5rem 5%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,122.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        opacity: 0.5;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 900px;
        margin: 0 auto;
    }

    .hero-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero-tagline {
        font-size: 1.3rem;
        font-weight: 300;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .hero-description {
        font-size: 1.1rem;
        line-height: 1.8;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    /* ===== STATISTICS ===== */
    .stats-section {
        background: white;
        padding: 4rem 5%;
        margin-top: -3rem;
        position: relative;
        z-index: 2;
    }

    .stats-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .stat-box {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #F8F9FA, #FFFFFF);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(12, 59, 46, 0.15);
    }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.95rem;
        color: #666;
        font-weight: 500;
    }

    /* ===== CONTENT SECTIONS ===== */
    .content-section {
        padding: 4rem 5%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0C3B2E;
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.8;
    }

    /* ===== MISSION & VISION ===== */
    .mission-vision-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .mission-box, .vision-box {
        background: white;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .mission-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
    }

    .vision-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
    }

    .box-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .box-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 1rem;
    }

    .box-text {
        font-size: 1rem;
        color: #666;
        line-height: 1.8;
    }

    /* ===== VALUES SECTION ===== */
    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .value-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        text-align: center;
    }

    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(12, 59, 46, 0.15);
    }

    .value-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
    }

    .value-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 1rem;
    }

    .value-description {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.7;
    }

    /* ===== CONTACT SECTION ===== */
    .contact-section {
        background: linear-gradient(135deg, #0C3B2E, #1a5a48);
        color: white;
        padding: 4rem 5%;
    }

    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 3rem;
    }

    .contact-box {
        background: rgba(255, 255, 255, 0.1);
        padding: 2rem;
        border-radius: 16px;
        backdrop-filter: blur(10px);
    }

    .contact-box-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .contact-box-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .contact-box-content {
        font-size: 1rem;
        line-height: 1.8;
        opacity: 0.9;
    }

    .contact-box-content a {
        color: #FFBA00;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-box-content a:hover {
        color: #FFD666;
    }

    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .social-link {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-link:hover {
        background: #FFBA00;
        transform: translateY(-4px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-tagline {
            font-size: 1.1rem;
        }

        .hero-description {
            font-size: 0.95rem;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .section-title {
            font-size: 2rem;
        }

        .mission-vision-container {
            grid-template-columns: 1fr;
        }

        .values-grid {
            grid-template-columns: 1fr;
        }

        .contact-container {
            grid-template-columns: 1fr;
        }
    }
</style>

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

<!-- HERO SECTION -->
<div class="hero-section">
    <div class="hero-content">
        
    @auth
            @if(Auth::user()->isAdmin()) 
                <div style="margin-bottom: 2rem;">
                    <a href="{{ route('about.edit') }}" 
                       style="
                           background-color: #FFBA00; 
                           color: #0C3B2E; 
                           padding: 0.8rem 1.5rem; 
                           border-radius: 50px; 
                           text-decoration: none; 
                           font-weight: 700; 
                           font-size: 0.9rem;
                           box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                           display: inline-flex;
                           align-items: center;
                           gap: 0.5rem;
                           transition: transform 0.3s ease;
                       "
                       onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(255, 186, 0, 0.4)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.2)'"
                    >
                        ✏️ Edit Halaman Ini
                    </a>
                </div>
            @endif
        @endauth
    
    <div class="hero-icon">📚</div>
        <h1 class="hero-title">{{ $data['library_name'] }}</h1>
        <p class="hero-tagline">{{ $data['tagline'] }}</p>
        <p class="hero-description">{{ $data['short_description'] }}</p>
    </div>
</div>

<!-- STATISTICS SECTION -->
<div class="stats-section">
    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-icon">📚</div>
            <div class="stat-number">{{ number_format($data['statistics']['total_books']) }}+</div>
            <div class="stat-label">Books Available</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">👥</div>
            <div class="stat-number">{{ number_format($data['statistics']['active_members']) }}+</div>
            <div class="stat-label">Active Members</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">📖</div>
            <div class="stat-number">{{ number_format($data['statistics']['books_borrowed']) }}+</div>
            <div class="stat-label">Books Borrowed</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">⭐</div>
            <div class="stat-number">{{ $data['statistics']['years_of_service'] }}+</div>
            <div class="stat-label">Years of Service</div>
        </div>
    </div>
</div>

<!-- MISSION & VISION -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Our Mission & Vision</h2>
        <p class="section-subtitle">Guiding principles that drive everything we do</p>
    </div>

    <div class="mission-vision-container">
        <div class="mission-box">
            <div class="box-icon">🎯</div>
            <h3 class="box-title">Mission</h3>
            <p class="box-text">{{ $data['mission'] }}</p>
        </div>

        <div class="vision-box">
            <div class="box-icon">🔭</div>
            <h3 class="box-title">Vision</h3>
            <p class="box-text">{{ $data['vision'] }}</p>
        </div>
    </div>
</div>

<!-- CORE VALUES -->
<div class="content-section" style="background: #F8F9FA;">
    <div class="section-header">
        <h2 class="section-title">Our Core Values</h2>
        <p class="section-subtitle">The values that define who we are and how we serve our community</p>
    </div>

    <div class="values-grid">
        @foreach($data['values'] as $value)
        <div class="value-card">
            <div class="value-icon">{{ $value['icon'] }}</div>
            <h3 class="value-title">{{ $value['title'] }}</h3>
            <p class="value-description">{{ $value['description'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<!-- FOOTER -->
<footer style="background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%); color: white; padding: 3rem 5% 1.5rem; margin-top: 4rem;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <!-- Footer Main Content -->
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 3rem; padding-bottom: 2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.2); margin-bottom: 2rem;">
            
            <!-- About Section -->
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; font-size: 1.3rem; font-weight: 700;">
                    <span>📚</span>
                    <span>PustakaOne</span>
                </div>
                <p style="font-size: 0.9rem; line-height: 1.7; opacity: 0.9; margin-bottom: 1.5rem;">
                    {{ $data['tagline'] }}. Your trusted digital library platform providing seamless access to knowledge and literature.
                </p>
                <div style="display: flex; gap: 0.8rem;">
                    <a href="{{ $data['social_media']['facebook'] }}" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">📘</a>
                    <a href="{{ $data['social_media']['instagram'] }}" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">📷</a>
                    <a href="{{ $data['social_media']['twitter'] }}" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">🐦</a>
                    <a href="{{ $data['social_media']['linkedin'] }}" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">💼</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: #FFBA00;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('about') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">About Us</a>
                    </li>
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('readspace') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Browse Books</a>
                    </li>
                    @auth
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('reservation') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">My Reservations</a>
                    </li>
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('membership.index') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Membership</a>
                    </li>
                    @else
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('login') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Login</a>
                    </li>
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('register') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Register</a>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: #FFBA00;">Contact</h4>
                <div style="font-size: 0.9rem; line-height: 1.8; opacity: 0.9;">
                    <p style="margin-bottom: 0.8rem;">📍 {{ $data['contact']['address'] }}</p>
                    <p style="margin-bottom: 0.8rem;">📞 <a href="tel:{{ $data['contact']['phone'] }}" style="color: white; text-decoration: none;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='white'">{{ $data['contact']['phone'] }}</a></p>
                    <p style="margin-bottom: 0.8rem;">✉️ <a href="mailto:{{ $data['contact']['email'] }}" style="color: white; text-decoration: none;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='white'">{{ $data['contact']['email'] }}</a></p>
                </div>
            </div>

            <!-- Operating Hours -->
            <div>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: #FFBA00;">Hours</h4>
                <div style="font-size: 0.9rem; line-height: 1.8; opacity: 0.9;">
                    <p style="margin-bottom: 0.5rem;">{{ $data['operating_hours']['weekdays'] }}</p>
                    <p style="margin-bottom: 0.5rem;">{{ $data['operating_hours']['saturday'] }}</p>
                    <p style="margin-bottom: 0.5rem;">{{ $data['operating_hours']['sunday'] }}</p>
                    <p style="margin-bottom: 0.5rem;">{{ $data['operating_hours']['holidays'] }}</p>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div style="text-align: center; font-size: 0.9rem; opacity: 0.8;">
            <p>&copy; {{ date('Y') }} PustakaOne. All rights reserved. | Built with ❤️ for book lovers</p>
        </div>
    </div>
</footer>

<style>
@media (max-width: 768px) {
    footer > div > div:first-child {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
}
</style>

@endsection