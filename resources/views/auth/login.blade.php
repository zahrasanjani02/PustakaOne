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
        background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
    }

    .login-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 900px;
        width: 100%;
        min-height: 600px;
    }

    /* ===== LEFT SIDE (Branding) ===== */
    .login-brand {
        background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%);
        color: white;
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        gap: 1.5rem;
    }

    .brand-icon {
        font-size: 5rem;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .brand-text h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -1px;
    }

    .brand-text p {
        font-size: 1rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .brand-features {
        margin-top: 2rem;
        text-align: left;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .brand-feature {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .feature-icon {
        font-size: 1.5rem;
        min-width: 30px;
    }

    .feature-text {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* ===== RIGHT SIDE (Form) ===== */
    .login-form-section {
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-header {
        margin-bottom: 2rem;
    }

    .form-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .form-header p {
        color: #666;
        font-size: 0.95rem;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: #0C3B2E;
        font-size: 0.95rem;
    }

    .form-group input {
        padding: 0.85rem 1rem;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        font-size: 0.95rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-group input:focus {
        border-color: #6D9773;
        background: #f9f9f9;
        box-shadow: 0 0 0 3px rgba(109, 151, 115, 0.1);
    }

    .form-group input::placeholder {
        color: #999;
    }

    .form-error {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0.5rem 0;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #6D9773;
    }

    .checkbox-wrapper label {
        font-size: 0.9rem;
        color: #666;
        cursor: pointer;
        margin: 0;
        font-weight: 400;
    }

    .forgot-password {
        text-decoration: none;
        color: #6D9773;
        font-weight: 500;
        font-size: 0.9rem;
        transition: 0.3s ease;
    }

    .forgot-password:hover {
        color: #0C3B2E;
        text-decoration: underline;
    }

    .btn-login {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        padding: 0.95rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(109, 151, 115, 0.3);
        font-family: 'Poppins', sans-serif;
        margin-top: 1rem;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(109, 151, 115, 0.4);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1.5rem 0;
        color: #999;
        font-size: 0.9rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #E0E0E0;
    }

    .social-login {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .btn-social {
        padding: 0.75rem;
        border: 2px solid #E0E0E0;
        background: white;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-social:hover {
        border-color: #6D9773;
        background: #f9f9f9;
    }

    .signup-link {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.95rem;
        color: #666;
    }

    .signup-link a {
        color: #6D9773;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .signup-link a:hover {
        color: #0C3B2E;
        text-decoration: underline;
    }

    /* ===== MESSAGES ===== */
    .alert {
        padding: 0.75rem 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        animation: slideDown 0.3s ease;
        border-left: 4px solid;
    }

    .alert-danger {
        background: #fadbd8;
        color: #c0392b;
        border-left-color: #e74c3c;
    }

    .alert-success {
        background: #d5f4e6;
        color: #27ae60;
        border-left-color: #27ae60;
    }

    .alert ul {
        margin: 0.5rem 0 0 1.5rem;
        padding: 0;
    }

    .alert li {
        margin: 0.3rem 0;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .login-container {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .login-brand {
            display: none;
        }

        .login-form-section {
            padding: 2rem 1.5rem;
        }

        .form-header h1 {
            font-size: 1.5rem;
        }

        .social-login {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="login-container">
    <!-- LEFT SIDE - BRANDING -->
    <div class="login-brand">
        <div class="brand-icon">📚</div>
        <div class="brand-text">
            <h2>PustakaOne</h2>
            <p>Manajemen Perpustakaan Modern</p>
        </div>

        <div class="brand-features">
            <div class="brand-feature">
                <span class="feature-icon">✨</span>
                <span class="feature-text">Kelola koleksi dengan mudah</span>
            </div>
            <div class="brand-feature">
                <span class="feature-icon">🔖</span>
                <span class="feature-text">Reservasi buku instan</span>
            </div>
            <div class="brand-feature">
                <span class="feature-icon">📊</span>
                <span class="feature-text">Tracking peminjaman real-time</span>
            </div>
            <div class="brand-feature">
                <span class="feature-icon">🔒</span>
                <span class="feature-text">Data aman & terlindungi</span>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE - LOGIN FORM -->
    <div class="login-form-section">
        <div class="form-header">
            <h1>Selamat Datang Kembali</h1>
            <p>Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- Error Messages dari Session -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>❌ Login Gagal:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email Input -->
            <div class="form-group">
                <label for="email">Email atau Username</label>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    placeholder="Masukkan email atau username Anda"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan password Anda"
                    required
                >
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember & Forgot Password -->
            <div class="form-options">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Ingat saya</label>
                </div>
                <a href="#" class="forgot-password" onclick="alert('Fitur akan datang segera')">Lupa password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <!-- Divider -->
        <div class="divider">atau</div>

        <!-- Social Login -->
        <div class="social-login">
            <button class="btn-social" onclick="socialLogin('google')" type="button">
                <span>🔵</span> Google
            </button>
            <button class="btn-social" onclick="socialLogin('github')" type="button">
                <span>⚫</span> GitHub
            </button>
        </div>

        <!-- Sign Up Link -->
        <div class="signup-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>
</div>

<script>
    function socialLogin(platform) {
        alert(`${platform} login akan diimplementasikan`);
    }
</script>
@endsection