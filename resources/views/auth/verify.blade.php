@extends('layouts.app')
@section('title', 'Verify OTP — SKSolutions')
@section('hide_nav_footer', true)

@push('styles')
<style>
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

<div class="min-h-0 flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950 pt-20 pb-4 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex flex-col items-center w-full max-w-md relative z-10">
        {{-- Back to Home --}}
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold text-slate-300 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all hover:-translate-y-0.5 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" class="text-purple-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>

        <div class="w-full space-y-8 bg-white/5 backdrop-blur-2xl p-10 rounded-[2.5rem] border border-white/10 shadow-2xl relative text-center">
        <div>
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-600/30">
                <i data-lucide="shield-check" class="w-8 h-8"></i>
            </div>
            <h2 class="text-3xl font-black text-white tracking-tight mb-2">Verify Your Number</h2>
            <p class="text-sm text-slate-400 font-semibold">We've sent a 4-digit verification code to <br><span class="text-white font-mono font-bold">+91 {{ $phone }}</span></p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-xs font-bold rounded-2xl">
                <i data-lucide="check-circle" class="w-4 h-4 inline mr-1"></i> {{ session('success') }}
            </div>
        @endif

        <form class="space-y-6" action="{{ route('verify.check') }}" method="POST">
            @csrf
            <input type="hidden" name="phone" value="{{ $phone }}">
            
            <div>
                <label for="otp" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Enter 4-Digit Code</label>
                <input id="otp" name="otp" type="text" inputmode="numeric" maxlength="4" required class="w-full bg-black/40 border border-white/15 rounded-2xl py-4 px-6 text-center text-3xl font-mono text-white tracking-[1em] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-inner transition-all" placeholder="••••">
                @error('otp')
                    <p class="mt-3 text-xs font-bold text-red-400 flex items-center justify-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="border-t border-white/10 pt-6 space-y-4">
                <div class="text-left">
                    <h3 class="text-sm font-bold text-slate-300">Set MPIN</h3>
                    <p class="text-xs text-slate-500">Create a 4-digit MPIN to log in instantly next time without SMS OTP.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="pin" class="block text-left text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">New MPIN</label>
                        <input id="pin" name="pin" type="password" inputmode="numeric" maxlength="4" required 
                               class="w-full bg-black/40 border border-white/15 rounded-xl py-3 px-4 text-center text-xl font-mono text-white tracking-[0.5em] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                               placeholder="••••">
                        @error('pin')
                            <p class="mt-2 text-left text-[11px] font-semibold text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="pin_confirmation" class="block text-left text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Confirm MPIN</label>
                        <input id="pin_confirmation" name="pin_confirmation" type="password" inputmode="numeric" maxlength="4" required 
                               class="w-full bg-black/40 border border-white/15 rounded-xl py-3 px-4 text-center text-xl font-mono text-white tracking-[0.5em] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                               placeholder="••••">
                        @error('pin_confirmation')
                            <p class="mt-2 text-left text-[11px] font-semibold text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl text-sm font-black tracking-wider uppercase text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-xl shadow-blue-600/30 transition-all hover:-translate-y-0.5">
                Verify & Secure Login <i data-lucide="arrow-right" class="w-4 h-4 inline ml-1.5"></i>
            </button>
        </form>
        
        <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs font-bold text-slate-400">
            <span>Didn't receive code?</span>
            <form action="{{ route('login.send_otp') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">
                <input type="hidden" name="login_as" value="{{ $loginAs ?? 'customer' }}">
                <button type="submit" class="text-blue-400 hover:text-blue-300 underline font-extrabold transition-colors">Resend Code</button>
            </form>
        </div>

        <div class="text-center">
            <a href="{{ ($loginAs ?? 'customer') === 'partner' ? route('partner.login') : route('login') }}" class="text-xs text-slate-500 hover:text-slate-300 transition-colors font-semibold"><i data-lucide="arrow-left" class="w-3 h-3 inline mr-1"></i> Change Mobile Number</a>
        </div>
        </div>
    </div>
</div>

<!-- Desktop Footer (hidden on mobile/tablet) -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- Fixed Bottom Navigation (Public Mobile Only) -->
<nav class="bottom-nav-bar lg:hidden">
    <a href="{{ url('/') }}" class="nav-item" id="nav-home">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Home
    </a>
    <a href="{{ route('services.index') }}" class="nav-item" id="nav-services">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Services
    </a>
    <a href="{{ route('login') }}" class="nav-item active" id="nav-orders">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Orders
    </a>
    <a href="{{ route('contact') }}" class="nav-item" id="nav-support">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        Support
    </a>
    <a href="{{ url('/portfolio') }}" class="nav-item" id="nav-portfolio">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Portfolio
    </a>
</nav>
@endsection
