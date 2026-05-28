@extends('layouts.app')

@section('title', 'Admin Login — SK Solutions')
@section('hide_nav_footer', true)

@push('styles')
<style>
    /* ── Page Background ── */
    .login-page {
        min-height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        /* padding: 5.5rem 1rem 1.5rem; */
        padding-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    /* ── Bottom nav ─────────────────────────────────────────── */
    .bottom-nav-bar {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: #fff;
        border-top: 1px solid #ede9fe;
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 8px 0 max(8px, env(safe-area-inset-bottom));
        z-index: 60;
        box-shadow: 0 -4px 20px rgba(109,40,217,0.07);
    }
    @media (min-width: 1024px) { .bottom-nav-bar { display: none !important; } }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        flex: 1;
        text-decoration: none;
        color: #9ca3af;
        transition: color 0.2s;
        font-size: 0.58rem;
        font-weight: 700;
    }
    .nav-item.active, .nav-item:hover { color: #6d28d9; }

    /* ── Header ─────────────────────────────────────────────── */
    .sk-header {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid #f3f0ff;
        box-shadow: 0 1px 8px rgba(109,40,217,0.06);
    }
    .login-page::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(ellipse at center, rgba(239,68,68,0.08) 0%, transparent 60%);
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
        margin-bottom: 2rem;
    }
    .login-logo .brand-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, #ef4444, #f97316);
        margin-bottom: 0.75rem;
        box-shadow: 0 8px 24px rgba(239,68,68,0.4);
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
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.2);
        background: rgba(255,255,255,0.08);
    }

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
    .alert-error   { background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.25);  color: #fca5a5; }

    /* ── Submit Button ── */
    .btn-primary {
        width: 100%;
        padding: 0.8rem 1rem;
        background: linear-gradient(135deg, #ef4444, #f97316);
        color: #fff;
        border: none;
        border-radius: 0.6rem;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
        box-shadow: 0 4px 14px rgba(239,68,68,0.4);
        margin-top: 0.5rem;
        letter-spacing: 0.02em;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(239,68,68,0.5);
    }
    .btn-primary:active { transform: translateY(0); opacity: 0.9; }

    /* ── Badge under admin tab ── */
    .admin-note {
        text-align: center;
        font-size: 0.75rem;
        color: #475569;
        margin-top: 1.5rem;
    }
    .admin-note span {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.2);
        color: #fca5a5;
        border-radius: 999px;
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<!-- Custom Header Navbar (same as landing pages) -->
<header class="sk-header">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex shrink-0 items-center">
            <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-10 sm:h-12 w-auto object-contain">
        </a>

        <!-- Search Bar (Desktop & Mobile) -->
        <!-- <form action="{{ route('services.index') }}" method="GET" class="flex items-center flex-1 max-w-[220px] sm:max-w-xs relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="w-full bg-white text-[11px] sm:text-xs font-normal text-gray-800 placeholder-gray-400 pl-10 sm:pl-11 pr-2 sm:pr-3 py-1.5 sm:py-2 rounded-full border border-gray-200/80 focus:border-violet-500 outline-none transition-all shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 absolute left-3.5 sm:left-4 pointer-events-none" fill="none"   viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form> -->

        <!-- Desktop nav links -->
        <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ url('/') }}"           class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Services</a>
            <a href="{{ url('/') }}#why-choose-us"           class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Why Us</a>
            <a href="{{ route('contact') }}"   class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Contact</a>
        </nav>

        <!-- Right side actions -->
        <div class="flex items-center gap-3">
            @auth
                @php
                    $u = auth()->user();
                    $ini = strtoupper(implode('', array_map(fn($w)=>mb_substr($w,0,1), array_slice(array_filter(explode(' ',trim($u->name))),0,2))));
                    $dashUrl = match($u->role){ 'admin'=>route('admin.dashboard'),'partner'=>route('partner.dashboard'),default=>route('customer.dashboard')};
                @endphp
                <a href="{{ $dashUrl }}" class="hidden sm:inline-flex px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-full text-xs font-black shadow-lg shadow-violet-600/20 hover:shadow-violet-600/30 transition-all hover:-translate-y-0.5">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hidden sm:inline-flex text-xs font-black text-violet-700">Log In</a>
                <a href="{{ route('register') }}" class="hidden sm:inline-flex px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-full text-xs font-black shadow-lg shadow-violet-600/20 hover:shadow-violet-600/30 transition-all hover:-translate-y-0.5">Start Free</a>
            @endauth
        </div>
    </div>
</header>

<div class="login-page">
    <div class="flex flex-col items-center w-full max-w-[440px] z-10">
        {{-- Back to Home --}}
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold text-slate-300 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all hover:-translate-y-0.5 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" class="text-purple-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>

        <div class="login-card">

        {{-- Logo --}}
        <div class="login-logo">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1>Admin Gateway</h1>
            <p>SK Solutions Control Panel</p>
        </div>

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
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Restricted Admin Access
            </span>
        </div>

    </div><!-- /.login-card -->
    </div>
</div><!-- /.login-page -->

<!-- Desktop Footer (hidden on mobile/tablet) -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- No mobile bottom nav for Admin login -->
@endsection
