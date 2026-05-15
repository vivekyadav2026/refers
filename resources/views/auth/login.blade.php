@extends('layouts.app')

@section('title', 'Login — SK Solutions')

@push('styles')
<style>
    /* ── Page Background ── */
    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        padding: 2rem 1rem;
        position: relative;
        overflow: hidden;
    }
    .login-page::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(ellipse at center, rgba(99,102,241,0.08) 0%, transparent 60%);
        pointer-events: none;
    }

    /* ── Card ── */
    .login-card {
        background: rgba(255,255,255,0.04);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 1.25rem;
        padding: 2.5rem 2rem;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        position: relative;
        z-index: 1;
    }

    /* ── Logo / Header ── */
    .login-logo {
        text-align: center;
        margin-bottom: 1.75rem;
    }
    .login-logo .brand-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        margin-bottom: 0.75rem;
        box-shadow: 0 8px 24px rgba(99,102,241,0.4);
    }
    .login-logo .brand-icon svg { color: #fff; }
    .login-logo h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0 0 0.25rem;
    }
    .login-logo p {
        font-size: 0.85rem;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Tabs ── */
    .tab-group {
        display: flex;
        background: rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 4px;
        margin-bottom: 1.75rem;
        border: 1px solid rgba(255,255,255,0.07);
    }
    .tab-btn {
        flex: 1;
        padding: 0.6rem 0.75rem;
        border: none;
        border-radius: 0.6rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        background: transparent;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
    .tab-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(99,102,241,0.35);
    }
    .tab-btn:not(.active):hover { color: #cbd5e1; }

    /* ── Form Panels ── */
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── Labels & Inputs ── */
    .form-group { margin-bottom: 1.1rem; }
    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.45rem;
    }
    .input-wrap { position: relative; }
    .input-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #475569;
        pointer-events: none;
        display: flex;
        align-items: center;
    }
    .form-input {
        width: 100%;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.6rem;
        padding: 0.7rem 0.85rem 0.7rem 2.5rem;
        color: #f1f5f9;
        font-size: 0.9rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .form-input::placeholder { color: #475569; }
    .form-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        background: rgba(255,255,255,0.08);
    }
    .phone-prefix {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6366f1;
        font-size: 0.9rem;
        font-weight: 600;
        pointer-events: none;
    }
    .form-input.phone-field { padding-left: 3rem; }

    /* ── Error messages ── */
    .field-error {
        margin-top: 0.35rem;
        font-size: 0.78rem;
        color: #f87171;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* ── Alert ── */
    .alert {
        border-radius: 0.6rem;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25); color: #6ee7b7; }
    .alert-error   { background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.25);  color: #fca5a5; }
    .alert-ref     { background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.25); color: #a5b4fc; }

    /* ── Submit Button ── */
    .btn-primary {
        width: 100%;
        padding: 0.8rem 1rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border: none;
        border-radius: 0.6rem;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
        box-shadow: 0 4px 14px rgba(99,102,241,0.4);
        margin-top: 0.5rem;
        letter-spacing: 0.02em;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(99,102,241,0.5);
    }
    .btn-primary:active { transform: translateY(0); opacity: 0.9; }

    /* ── Badge under admin tab ── */
    .admin-note {
        text-align: center;
        font-size: 0.75rem;
        color: #475569;
        margin-top: 1.25rem;
    }
    .admin-note span {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.2);
        color: #fca5a5;
        border-radius: 999px;
        padding: 0.25rem 0.65rem;
        font-size: 0.72rem;
        font-weight: 600;
    }

    /* ── Divider ── */
    .divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.25rem 0;
        color: #334155;
        font-size: 0.75rem;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.07);
    }
</style>
@endpush

@section('content')
<div class="login-page">
    <div class="login-card">

        {{-- Logo --}}
        <div class="login-logo">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1>SK Solutions</h1>
            <p>Referral Management Portal</p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any() && !$errors->has('otp') && !$errors->has('phone'))
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Referral Banner --}}
        @if(request()->has('ref'))
            @php session(['ref_id' => request()->query('ref')]); @endphp
            <div class="alert alert-ref">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                You've been referred! Sign up as a Partner to continue.
            </div>
        @endif

        {{-- Tabs --}}
        <div class="tab-group" role="tablist">
            <button class="tab-btn {{ $errors->has('email') ? '' : 'active' }}"
                    id="tab-partner" role="tab"
                    onclick="switchTab('partner')">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Partner Login
            </button>
            <button class="tab-btn {{ $errors->has('email') ? 'active' : '' }}"
                    id="tab-admin" role="tab"
                    onclick="switchTab('admin')">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Admin Login
            </button>
        </div>

        {{-- ══ PARTNER PANEL ══ --}}
        <div class="tab-panel {{ $errors->has('email') ? '' : 'active' }}" id="panel-partner" role="tabpanel">
            @if($errors->has('phone'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errors->first('phone') }}
                </div>
            @endif

            <form action="{{ route('login.send_otp') }}" method="POST">
                @csrf
                @if(request()->has('ref'))
                    <input type="hidden" name="ref_id" value="{{ request()->query('ref') }}">
                @endif

                <div class="form-group">
                    <label class="form-label" for="phone">Mobile Number</label>
                    <div class="input-wrap">
                        <span class="phone-prefix">+91</span>
                        <input id="phone" name="phone" type="tel" inputmode="numeric"
                               maxlength="10" autocomplete="tel"
                               class="form-input phone-field"
                               placeholder="9876543210"
                               value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <div class="field-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" id="btn-send-otp">
                    Send OTP →
                </button>
            </form>

            <p class="admin-note" style="margin-top:1rem;color:#475569;font-size:0.78rem;text-align:center;">
                A 4-digit OTP will be sent to your mobile number.
            </p>
        </div>

        {{-- ══ ADMIN PANEL ══ --}}
        <div class="tab-panel {{ $errors->has('email') ? 'active' : '' }}" id="panel-admin" role="tabpanel">
            @if($errors->has('email'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errors->first('email') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" id="admin-login-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="admin-email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input id="admin-email" name="email" type="email" autocomplete="email"
                               class="form-input"
                               placeholder="admin@example.com"
                               value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <div class="field-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin-password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input id="admin-password" name="password" type="password" autocomplete="current-password"
                               class="form-input"
                               placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <div class="field-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" id="btn-admin-login">
                    Sign In as Admin →
                </button>
            </form>

            <div class="admin-note">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Admin access only
                </span>
            </div>
        </div>

    </div><!-- /.login-card -->
</div><!-- /.login-page -->

<script>
    function switchTab(tab) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        document.getElementById('panel-' + tab).classList.add('active');
    }
</script>
@endsection
