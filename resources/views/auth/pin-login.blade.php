@extends('layouts.app')

@section('title', 'Enter PIN — SKSolutions')
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
        margin-bottom: 2rem;
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
    .form-input {
        width: 100%;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.6rem;
        padding: 0.8rem 1rem;
        color: #f1f5f9;
        font-size: 1.5rem;
        letter-spacing: 0.5em;
        text-align: center;
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

    /* ── Eye Icon for PIN Toggle ── */
    .pin-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        cursor: pointer;
        transition: color 0.15s;
    }
    .pin-toggle:hover { color: #f1f5f9; }

    /* ── Error messages ── */
    .field-error {
        margin-top: 0.35rem;
        font-size: 0.78rem;
        color: #f87171;
        display: flex;
        align-items: center;
        justify-content: center;
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1>Enter Security PIN</h1>
            <p>Welcome back! Enter your 4-digit PIN for <br><span class="text-white font-mono font-bold">+91 ******{{ substr($phone, -4) }}</span></p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('phone') || $errors->first() && !$errors->has('email') && !$errors->has('password'))
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.pin.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="phone" value="{{ $phone }}">

            <div class="form-group">
                <label class="form-label" for="pin">Security PIN</label>
                <div class="input-wrap">
                    <input id="pin" name="pin" type="password" inputmode="numeric"
                           maxlength="4" autocomplete="one-time-code"
                           class="form-input"
                           placeholder="••••" required autofocus>
                    <span class="pin-toggle" onclick="togglePinVisibility()">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </span>
                </div>
                @error('pin')
                    <div class="field-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                Verify & Login →
            </button>
        </form>

        {{-- Forgot PIN Fallback (Triggers OTP send with force_otp=1) --}}
        <form id="otp-fallback-form" action="{{ route('login.send_otp') }}" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="phone" value="{{ $phone }}">
            <input type="hidden" name="login_as" value="{{ $loginAs }}">
            <input type="hidden" name="force_otp" value="1">
        </form>

        <div style="margin-top:1.5rem; display:flex; align-items:center; justify-content:between; border-top:1px solid rgba(255,255,255,0.08); padding-top:1.2rem;">
            <a href="#" onclick="event.preventDefault(); document.getElementById('otp-fallback-form').submit();" style="font-size:0.8rem; color:#8b5cf6; text-decoration:none; font-weight:600; transition:color 0.15s;" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#8b5cf6'">
                Login with OTP instead
            </a>

            <a href="{{ $loginAs === 'partner' ? route('partner.login') : route('login') }}" style="font-size:0.8rem; color:#64748b; text-decoration:none; font-weight:500; transition:color 0.15s;" onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#64748b'">
                Change Number
            </a>
        </div>

    </div><!-- /.login-card -->
    </div>
</div><!-- /.login-page -->

<!-- Desktop Footer (hidden on mobile/tablet) -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- No mobile bottom nav for PIN login -->
<script>
    function togglePinVisibility() {
        const pinField = document.getElementById('pin');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (pinField.type === 'password') {
            pinField.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            pinField.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
@endsection
