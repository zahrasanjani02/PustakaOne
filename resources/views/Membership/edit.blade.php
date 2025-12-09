@extends('layouts.app')

@section('content')
<style>
    body { background-color: #F5F7FA; font-family: 'Poppins', sans-serif; }
    
    .main-wrapper {
        min-height: calc(100vh - 300px);
        padding: 2rem 1rem;
    }

    .container-edit { 
        max-width: 850px; 
        margin: 0 auto; 
    }

    /* HEADER */
    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        color: #0C3B2E;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
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

    /* FORM CARD */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 3rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid #EBEBEB;
    }

    .form-section-title {
        color: #BB8A52;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid #F5F7FA;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1rem;
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
        padding: 0.9rem 1rem;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.95rem;
        transition: all 0.3s;
        color: #333;
    }

    .form-input:focus {
        border-color: #6D9773;
        outline: none;
        box-shadow: 0 0 0 4px rgba(109, 151, 115, 0.1);
    }

    .form-input[readonly] {
        background-color: #F9FAFB;
        cursor: not-allowed;
    }

    .warning-text {
        color: #E74C3C;
        font-size: 0.8rem;
        margin-top: 0.4rem;
        font-style: italic;
    }

    /* --- NEW BUTTON STYLES (UPDATED) --- */
    .form-actions {
        display: flex;
        gap: 1rem; /* Jarak antar tombol */
        margin-top: 2rem;
    }

    /* Tombol Discard */
    .btn-discard {
        flex: 1; /* Mengambil 1 bagian space */
        background-color: #F3F4F6;
        color: #6B7280;
        border: 1px solid #E5E7EB;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-discard:hover {
        background-color: #E5E7EB;
        color: #374151;
        border-color: #D1D5DB;
    }

    /* Tombol Submit */
    .btn-submit {
        flex: 2; /* Mengambil 2 bagian space (lebih lebar dari discard) */
        background: linear-gradient(135deg, #0C3B2E, #1a5a48);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(12, 59, 46, 0.2);
        /* Hapus margin-top lama karena sudah di handle container */
        margin-top: 0; 
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(12, 59, 46, 0.3);
    }

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
        .edit-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        /* Agar di HP tombol jadi atas bawah */
        .form-actions { flex-direction: column-reverse; } 
    }
</style>

<x-navbar/>

<div class="main-wrapper">
    <div class="container-edit">
        <div class="edit-header">
            <h1 class="page-title">Edit Member: {{ $membership->name }}</h1>
            <a href="{{ route('membership.index') }}" class="btn-back">
                <span>←</span> Back to Membership Management
            </a>
        </div>

        <div class="form-card">
            {{-- Error Handling --}}
            @if ($errors->any())
                <div style="background: #FADBD8; color: #C62828; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <ul style="margin-left: 1.5rem; margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('membership.update', $membership->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- ACCOUNT DETAILS -->
                <div class="form-section-title">👤 Account Details</div>
                
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $membership->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $membership->email) }}" required>
                    <div class="warning-text">Warning: Changing email will affect user login credentials.</div>
                </div>

                <!-- MEMBERSHIP DETAILS -->
                <div class="form-section-title">📅 Membership Details</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $membership->phone) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Join Date</label>
                        <input type="date" name="membership_start" class="form-input" 
                               value="{{ old('membership_start', $membership->membership_start ? \Carbon\Carbon::parse($membership->membership_start)->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Membership Expiry Date</label>
                    <input type="date" name="membership_end" class="form-input" 
                           value="{{ old('membership_end', $membership->membership_end ? \Carbon\Carbon::parse($membership->membership_end)->format('Y-m-d') : '') }}">
                </div>

                <!-- PASSWORD CHANGE -->
                <div class="form-section-title">🔒 Change Password (Optional)</div>
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                    Leave blank if you don't want to change the password.
                </p>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-input" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm New Password">
                    </div>
                </div>

                <!-- BUTTON ACTIONS -->
                <div class="form-actions">
                    <!-- Tombol Discard (Kembali ke index) -->
                    <a href="{{ route('membership.index') }}" class="btn-discard">Discard</a>
                    
                    <!-- Tombol Submit -->
                    <button type="submit" class="btn-submit">Update Member Details</button>
                </div>

            </form>
        </div>
    </div>
</div>

<x-footer/> 
@endsection