@extends('layouts.app')

@section('content')
<style>
    body { background-color: #F5F7FA; font-family: 'Poppins', sans-serif; }
    
    .container { 
        max-width: 900px; 
        margin: 2rem auto; 
        padding: 0 1rem; 
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        color: #0C3B2E;
        font-size: 1.8rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back {
        text-decoration: none;
        color: #666;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: 0.3s;
        background: white;
        border: 1px solid #E0E0E0;
    }
    .btn-back:hover { 
        color: #0C3B2E; 
        border-color: #0C3B2E;
        background: #F0F7F4;
    }

    /* Form Styles */
    .form-section-title {
        color: #BB8A52;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #F0F2F5;
        margin-top: 1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group { margin-bottom: 1.5rem; }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-family: inherit;
        transition: all 0.3s;
    }

    .form-input:focus {
        border-color: #6D9773;
        outline: none;
        box-shadow: 0 0 0 4px rgba(109, 151, 115, 0.1);
    }

    /* ===== BUTTON ACTIONS (BARU) ===== */
    .form-actions {
        display: grid;
        grid-template-columns: 1fr 2fr; /* Tombol Cancel 1 bagian, Save 2 bagian */
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(12, 59, 46, 0.3);
    }

    .btn-cancel {
        background: white;
        color: #C62828; /* Warna Merah */
        border: 2px solid #FFEBEE;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cancel:hover {
        background: #FFEBEE;
        border-color: #C62828;
    }

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-actions { grid-template-columns: 1fr; } /* Stack tombol di HP */
    }
</style>

<x-navbar/>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">➕ Add New Member</h1>
        <a href="{{ route('membership.index') }}" class="btn-back">← Back to Membership Management</a>
    </div>

    <div class="form-card">
        {{-- Tampilkan Error Validasi --}}
        @if ($errors->any())
            <div style="background: #FADBD8; color: #C62828; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <ul style="margin-left: 1.5rem; margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('membership.store') }}" method="POST">
            @csrf

            <!-- ACCOUNT DETAILS -->
            <div class="form-section-title">👤 Account Details</div>
            
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="Enter email address" required>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Min. 8 characters" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Retype password" required>
                </div>
            </div>

            <!-- MEMBERSHIP DETAILS -->
            <div class="form-section-title">📅 Membership Details</div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="e.g. 08123456789">
                </div>
                
                {{-- BAGIAN TANGGAL --}}
                <div class="form-group">
                    <label class="form-label">Join Date</label>
                    <input type="date" name="membership_start" class="form-input" 
                           value="{{ old('membership_start', date('Y-m-d')) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Membership Expiry Date</label>
                <input type="date" name="membership_end" class="form-input" 
                       value="{{ old('membership_end', date('Y-m-d', strtotime('+1 year'))) }}">
                <small style="color: #888; display: block; margin-top: 0.5rem;">Default: 1 year from today.</small>
            </div>

            <!-- TOMBOL ACTION (SAVE & CANCEL) -->
            <div class="form-actions">
                <a href="{{ route('membership.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Save New Member</button>
            </div>

        </form>
    </div>
</div>

<x-footer/> 
@endsection