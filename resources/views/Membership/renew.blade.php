@extends('layouts.app')

@section('content')
<style>
    body { background-color: #F5F7FA; font-family: 'Poppins', sans-serif; }
    .container { max-width: 900px; margin: 3rem auto; padding: 0 1rem; }
    
    .card {
        background: white; border-radius: 16px; padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    .page-title { color: #0C3B2E; font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem; }
    .page-subtitle { color: #666; margin-bottom: 2rem; }

    .form-group { margin-bottom: 2rem; }
    .form-label { display: block; font-weight: 600; color: #0C3B2E; margin-bottom: 1rem; font-size: 1.1rem; }
    
    /* STYLE PAKET DURASI (Grid Kotak) */
    .package-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;
    }
    .package-option {
        display: block; position: relative; cursor: pointer;
    }
    .package-option input { position: absolute; opacity: 0; }
    .package-box {
        border: 2px solid #E0E0E0; border-radius: 12px; padding: 1.5rem; text-align: center;
        transition: all 0.3s; height: 100%; display: flex; flex-direction: column; justify-content: center;
    }
    .package-option input:checked + .package-box {
        border-color: #0C3B2E; background: #E8F5E9; box-shadow: 0 4px 12px rgba(12, 59, 46, 0.1);
    }
    .pkg-name { font-size: 1rem; font-weight: 600; color: #555; display: block; margin-bottom: 0.5rem; }
    .pkg-price { font-size: 1.2rem; font-weight: 800; color: #0C3B2E; display: block; }

    /* STYLE METODE PEMBAYARAN (List ke Bawah) */
    .payment-grid {
        display: grid; 
        grid-template-columns: 1fr; /* 1 Kolom Full ke samping */
        gap: 0.8rem;
    }
    .payment-option {
        display: block; position: relative; cursor: pointer;
    }
    .payment-option input { position: absolute; opacity: 0; }
    
    .payment-box {
        border: 2px solid #E0E0E0; 
        border-radius: 12px; 
        padding: 1rem 1.5rem; 
        text-align: left;
        transition: all 0.3s; 
        
        /* Flexbox Baris */
        display: flex; 
        flex-direction: row; 
        align-items: center; 
        justify-content: flex-start;
        gap: 1.5rem; /* Jarak icon ke teks */
        
        height: auto;
        background: white;
    }
    
    .payment-option input:checked + .payment-box {
        border-color: #BB8A52; background: #FFF8E1; box-shadow: 0 4px 12px rgba(187, 138, 82, 0.2);
    }
    
    .payment-icon { 
        font-size: 1.8rem; 
        margin-bottom: 0; 
        width: 40px; /* Lebar tetap agar teks rata */
        text-align: center;
    }
    
    .payment-name { 
        font-size: 1rem; font-weight: 600; color: #333; 
    }

    .btn-submit {
        background: linear-gradient(135deg, #BB8A52, #FFBA00); color: white; border: none;
        padding: 1rem; width: 100%; border-radius: 12px; font-weight: 700; font-size: 1.1rem;
        cursor: pointer; transition: 0.3s; margin-top: 1rem;
        box-shadow: 0 4px 15px rgba(187, 138, 82, 0.3);
    }
    .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(187, 138, 82, 0.5); }
</style>

<x-navbar/>

<div class="container">
    <div class="card">
        <h1 class="page-title">🚀 Perpanjang Membership</h1>
        <p class="page-subtitle">Pilih paket durasi dan metode pembayaran favoritmu.</p>

        <form action="{{ route('membership.renewProcess') }}" method="POST">
            @csrf

            <!-- 1. PILIH DURASI -->
            <div class="form-group">
                <label class="form-label">1. Pilih Paket Durasi</label>
                <div class="package-grid">
                    <label class="package-option">
                        <input type="radio" name="duration" value="30" checked>
                        <div class="package-box">
                            <span class="pkg-name">1 Bulan</span>
                            <span class="pkg-price">Rp 50.000</span>
                        </div>
                    </label>

                    <label class="package-option">
                        <input type="radio" name="duration" value="180">
                        <div class="package-box">
                            <span class="pkg-name">6 Bulan</span>
                            <span class="pkg-price">Rp 250.000</span>
                        </div>
                    </label>

                    <label class="package-option">
                        <input type="radio" name="duration" value="365">
                        <div class="package-box">
                            <span class="pkg-name">1 Tahun</span>
                            <span class="pkg-price">Rp 450.000</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 2. PILIH METODE PEMBAYARAN -->
            <div class="form-group">
                <label class="form-label">2. Pilih Metode Pembayaran</label>
                <div class="payment-grid">
                    <!-- QRIS (OVO, Gopay, Dana) -->
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="qris" checked>
                        <div class="payment-box">
                            <div class="payment-icon">📱</div>
                            <div class="payment-name">QRIS / E-Wallet (Gopay, OVO, Dana)</div>
                        </div>
                    </label>

                    <!-- Mandiri -->
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="echannel">
                        <div class="payment-box">
                            <div class="payment-icon">🏦</div>
                            <div class="payment-name">Mandiri Virtual Account</div>
                        </div>
                    </label>

                    <!-- BRI -->
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="bri">
                        <div class="payment-box">
                            <div class="payment-icon">💳</div>
                            <div class="payment-name">BRI Virtual Account</div>
                        </div>
                    </label>

                    <!-- BNI -->
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="bni">
                        <div class="payment-box">
                            <div class="payment-icon">🏧</div>
                            <div class="payment-name">BNI Virtual Account</div>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-submit">Bayar Sekarang</button>
            <a href="{{ route('membership.index') }}" style="display: block; text-align: center; margin-top: 1.5rem; color: #666; text-decoration: none; font-weight: 500;">Batalkan</a>
        </form>
    </div>
</div>
@endsection