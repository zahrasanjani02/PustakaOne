<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PustakaOne - Discover Your Next Great Read</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAFAFA;
            color: #0C3B2E;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 12px rgba(12, 59, 46, 0.08);
            padding: 1.2rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            cursor: pointer;
        }

        .navbar-brand .logo-icon {
            font-size: 1.8rem;
        }

        .navbar-brand .logo-text {
            font-weight: 700;
            font-size: 1.3rem;
            color: #0C3B2E;
            letter-spacing: -0.5px;
        }

        .navbar-links {
            display: flex;
            list-style: none;
            gap: 3rem;
            margin: 0;
        }

        .navbar-links li a {
            text-decoration: none;
            color: #0C3B2E;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-links li a:hover {
            color: #6D9773;
        }

        .navbar-links li a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #6D9773, #FFBA00);
            transition: width 0.3s ease;
        }

        .navbar-links li a:hover::after {
            width: 100%;
        }

        .navbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-login {
            border: 2px solid #6D9773;
            color: #6D9773;
            padding: 0.65rem 1.4rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .btn-login:hover {
            background-color: #6D9773;
            color: white;
            transform: translateY(-2px);
        }

        .btn-start {
            background: linear-gradient(135deg, #6D9773, #0C3B2E);
            color: white;
            padding: 0.65rem 1.6rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(109, 151, 115, 0.3);
            border: none;
            cursor: pointer;
        }

        .btn-start:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(109, 151, 115, 0.4);
        }

        /* ===== HERO SECTION ===== */

        .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 20px;
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 4rem;
            padding: 5rem 5%;
            background: linear-gradient(135deg, #ffffff 0%, #F8F9F8 100%);
            min-height: 90vh;
        }

        .hero-content {
            animation: slideInLeft 0.8s ease;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            color: #0C3B2E;
            margin-bottom: 1.2rem;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, #FFBA00, #BB8A52);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 2rem;
            line-height: 1.6;
            font-weight: 400;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #E0E0E0;
            border-radius: 12px;
            overflow: hidden;
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
            padding: 1rem 1.2rem;
            width: 100%;
            font-size: 0.95rem;
            background: transparent;
        }

        .search-box input::placeholder {
            color: #999;
        }

        .search-box button {
            background: linear-gradient(135deg, #6D9773, #0C3B2E);
            color: white;
            border: none;
            padding: 1rem 1.4rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .search-box button:hover {
            transform: translateX(2px);
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6D9773, #0C3B2E);
            color: white;
            padding: 0.85rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(109, 151, 115, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(109, 151, 115, 0.4);
        }

        .btn-secondary {
            border: 2px solid #BB8A52;
            color: #BB8A52;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #BB8A52;
            color: white;
            transform: translateY(-3px);
        }

        .hero-image {
            animation: slideInRight 0.8s ease;
            position: relative;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hero-image-wrapper {
            position: relative;
            width: 100%;
            height: 500px;
            background: linear-gradient(135deg, rgba(109, 151, 115, 0.1), rgba(255, 186, 0, 0.1));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .hero-image-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(255, 186, 0, 0.2), rgba(109, 151, 115, 0.2));
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .hero-image-content {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 100%;
            max-width: 700px;
            height: 420px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 20px;
            background-color: #FAFAFA;
        }

        /* ===== FEATURES SECTION ===== */
        .features {
            padding: 6rem 5%;
            background-color: #FAFAFA;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0C3B2E;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .section-header p {
            font-size: 1.1rem;
            color: #666;
            max-width: 500px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            border-color: #6D9773;
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0C3B2E;
            margin-bottom: 0.8rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* ===== BENEFITS SECTION ===== */
        .benefits {
            padding: 6rem 5%;
            background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%);
            color: white;
        }

        .benefits .section-header h2,
        .benefits .section-header p {
            color: white;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .benefit-item {
            display: flex;
            gap: 1.2rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(8px);
        }

        .benefit-icon {
            font-size: 2rem;
            min-width: 50px;
            text-align: center;
        }

        .benefit-content h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .benefit-content p {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.5;
        }

        /* ===== STATS SECTION ===== */
        .stats {
            padding: 4rem 5%;
            background-color: #FAFAFA;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0C3B2E, #6D9773);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: #666;
            font-size: 1rem;
            font-weight: 500;
        }

        /* ===== CTA SECTION ===== */
        .cta-section {
            padding: 6rem 5%;
            background: linear-gradient(135deg, #BB8A52 0%, #FFBA00 100%);
            text-align: center;
            color: white;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .cta-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.95;
        }

        .cta-buttons-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-white {
            background: white;
            color: #BB8A52;
            padding: 0.85rem 2.2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* ===== FOOTER ===== */
        .footer {
            background-color: #0C3B2E;
            color: white;
            padding: 3rem 5%;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.95rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 3%;
            }

            .navbar-links {
                display: none;
            }

            .hero {
                grid-template-columns: 1fr;
                padding: 3rem 5%;
                min-height: auto;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .search-box {
                flex-direction: column;
            }

            .hero-image-wrapper {
                height: 350px;
            }

            .hero-image-content {
                font-size: 80px;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .features-grid,
            .benefits-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .cta-section h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-brand">
            <span class="logo-icon">📚</span>
            <span class="logo-text">PustakaOne</span>
        </div>
        <ul class="navbar-links">
            <li><a href="{{ route('about') }}" >About Us</a></li>
            <li><a href="/login">ReadSpace</a></li>
            <li><a href="/login">Reservation</a></li>
        </ul>
        <div class="navbar-actions">
            <a href="/login" class="btn-login">Masuk</a>
            <a href="/login" class="btn-start">Coba Gratis</a>  
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-content">
            <h1>PustakaOne — <span class="highlight"> Tumbuhkan Budaya Membaca di Era Digital.</span></h1>
            <p>Read. Reserve. Repeat.</p>

            <div class="search-box">
                <input type="text" placeholder="Cari buku, penulis, atau kategori...">
                <button>Cari</button>
            </div>

            <div class="cta-buttons">
                <button class="btn-primary">Mulai Sekarang</button>
                <button class="btn-secondary">Pelajari Lebih Lanjut</button>
            </div>
        </div>
        <div class="hero-image-content">
            <img src="{{ asset('images/landingPage.png') }}" alt="Book Illustration" class="hero-img">
        </div>

    </section>

    <!-- FEATURES SECTION -->
    <section class="features" id="features">
        <div class="section-header">
            <h2>Fitur Unggulan</h2>
            <p>Nikmati pengalaman manajemen perpustakaan yang modern dan efisien</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>Katalog Pintar & Rekomendasi Cerdas</h3>
                <p>Temukan bacaan yang tepat hanya dengan satu klik.
                    PustakaOne menghadirkan ribuan judul buku dengan pencarian cerdas dan sistem rekomendasi AI yang
                    mempelajari minatmu — dari novel hingga jurnal ilmiah.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🔖</div>
                <h3>Reservasi Instan & Notifikasi Real-Time</h3>
                <p>Cukup klik Reservasi, dan sistem kami akan mengatur antrean otomatis serta memberi tahu kamu saat
                    buku siap dibaca.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Pelacakan Peminjaman Super Detail</h3>
                <p>Selalu tahu status bukumu — sedang dipinjam, dikembalikan, atau jatuh tempo.
                    Semua tercatat otomatis dengan tampilan yang transparan dan mudah dipahami.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💻</div>
                <h3>Akses Buku Digital Tanpa Batas</h3>
                <p>Baca kapan saja, di mana saja.
                    Nikmati pengalaman membaca langsung dari platform kami — tanpa ribet download, dengan fitur
                    highlight, mode malam, dan pembatas halaman otomatis.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🧠</div>
                <h3>Statistik & Insight Membaca</h3>
                <p>Temukan data unik tentang kebiasaan bacamu — dari genre favorit sampai waktu baca terbanyak.
                    Fitur ini membantu kamu (dan pustakawan) memahami pola membaca untuk pengalaman yang lebih personal.
                </p>
            </div>
        </div>
    </section>

    <!-- BENEFITS SECTION -->
    <section class="benefits" id="benefits">
        <div class="section-header">
            <h2>Keuntungan Menggunakan PustakaOne</h2>
            <p>Solusi lengkap untuk perpustakaan digital dan fisik Anda</p>
        </div>

        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon">⏱️</div>
                <div class="benefit-content">
                    <h4>Hemat Waktu</h4>
                    <p>Otomatisasi proses peminjaman dan pengembalian untuk efisiensi maksimal.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">🔒</div>
                <div class="benefit-content">
                    <h4>Aman & Terpercaya</h4>
                    <p>Enkripsi data tingkat enterprise untuk melindungi informasi member Anda.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">📈</div>
                <div class="benefit-content">
                    <h4>Laporan Terperinci</h4>
                    <p>Analytics mendalam tentang peminjaman, popularitas buku, dan tren member.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">🚀</div>
                <div class="benefit-content">
                    <h4>Skalabilitas</h4>
                    <p>Sistem yang dapat tumbuh bersama perpustakaan Anda, dari kecil hingga besar.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">📱</div>
                <div class="benefit-content">
                    <h4>Mobile Friendly</h4>
                    <p>Akses penuh dari perangkat mobile untuk kemudahan di mana saja, kapan saja.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">💬</div>
                <div class="benefit-content">
                    <h4>Support 24/7</h4>
                    <p>Tim support siap membantu Anda kapan saja untuk memastikan operasional lancar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS SECTION -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>10K+</h3>
                <p>Buku Tersedia</p>
            </div>
            <div class="stat-item">
                <h3>5K+</h3>
                <p>Member Aktif</p>
            </div>
            <div class="stat-item">
                <h3>98%</h3>
                <p>Kepuasan Pengguna</p>
            </div>
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Dukungan Tersedia</p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <h2>Siap Mengubah Cara Anda Mengelola Perpustakaan?</h2>
        <p>Bergabunglah dengan ribuan perpustakaan yang telah mempercayai PustakaOne untuk mengelola koleksi mereka.</p>
        <div class="cta-buttons-group">
            <a href="#" class="btn-white">Mulai Sekarang</a>
            <a href="#" class="btn-white">Demo Gratis</a>
        </div>
    </section>
</body>

<x-footer/>

</html>