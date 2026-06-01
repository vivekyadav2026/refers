@extends('layouts.app')
@section('title', 'SK Solutions — Grow Your Business Online')
@section('hide_nav_footer', true)

@section('content')
<style>
/* ── Fonts ──────────────────────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

/* ── Base ───────────────────────────────────────────────── */
body {
    background: #f8f8fb;
    font-family: 'Poppins', sans-serif;
    -webkit-tap-highlight-color: transparent;
}

/* Force Poppins globally on this page */
html, body, p, div, span, h1, h2, h3, h4, h5, h6, a, button, input, select, textarea, label {
    font-family: 'Poppins', sans-serif !important;
}

/* ── Script font for "Online" ───────────────────────────── */
.cursive-online {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.6rem;
    line-height: 1;
    color: #6d28d9;
    display: block;
    margin-top: 2px;
}
@media (min-width: 480px)  { .cursive-online { font-size: 1.8rem; } }
@media (min-width: 640px)  { .cursive-online { font-size: 2rem; } }
@media (min-width: 1024px) { .cursive-online { font-size: 2.4rem; } }

/* ── Hero gradient card ─────────────────────────────────── */
.hero-card {
    background: linear-gradient(145deg, #ede9fe 0%, #ddd6fe 30%, #c4b5fd 60%, #a78bfa 100%);
    border-radius: 22px;
    overflow: hidden;
    position: relative;
}

/* ── Floating orbs in hero ──────────────────────────────── */
.hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.4;
    pointer-events: none;
}

/* ── Hero device mockup ─────────────────────────────────── */
.device-wrapper {
    position: relative;
    display: none;            /* hidden on mobile */
    align-items: flex-end;
    justify-content: center;
}
@media (min-width: 480px) { .device-wrapper { display: flex; } }

/* ── Laptop SVG mockup ──────────────────────────────────── */
/* Hidden on mobile, shown sm+ */
.laptop-mockup {
    width: 170px;
    filter: drop-shadow(0 14px 28px rgba(109,40,217,0.30));
    display: none;
}
@media (min-width: 480px)  { .laptop-mockup { display: block; width: 190px; } }
@media (min-width: 640px)  { .laptop-mockup { width: 230px; } }
@media (min-width: 1024px) { .laptop-mockup { width: 310px; } }

.phone-mockup {
    width: 56px;
    position: absolute;
    bottom: 0;
    left: -10px;
    filter: drop-shadow(0 8px 16px rgba(109,40,217,0.30));
    display: none;
}
@media (min-width: 480px)  { .phone-mockup { display: block; width: 68px; } }
@media (min-width: 640px)  { .phone-mockup { width: 80px; left: -14px; } }
@media (min-width: 1024px) { .phone-mockup { width: 108px; left: -20px; } }

/* Device wrapper hidden on mobile */
.device-wrapper { display: none; }
@media (min-width: 480px) { .device-wrapper { display: flex; } }

/* ── Floating icon pills ────────────────────────────────── */
.float-icon {
    position: absolute;
    background: white;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 20px rgba(109,40,217,0.25);
    animation: floatBounce 3s ease-in-out infinite;
}
.float-icon:nth-child(2) { animation-delay: 0.8s; }
.float-icon:nth-child(3) { animation-delay: 1.6s; }

@keyframes floatBounce {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-6px); }
}

/* Hide floating icons on very small screens */
.float-icon { display: none; }
@media (min-width: 480px) { .float-icon { display: flex; } }

/* ── CTA button ─────────────────────────────────────────── */
.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #5b21b6;
    color: #fff;
    font-weight: 700;
    font-size: 0.75rem;
    padding: 9px 16px;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(91,33,182,0.4);
    transition: all 0.22s ease;
    text-decoration: none;
}
@media (min-width: 640px) {
    .btn-cta { font-size: 0.82rem; padding: 11px 22px; gap: 8px; }
}
.btn-cta:hover {
    background: #4c1d95;
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(91,33,182,0.45);
}

/* ── Carousel dots ──────────────────────────────────────── */
.dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #c4b5fd;
    transition: all 0.3s;
}
.dot.active {
    width: 22px;
    border-radius: 4px;
    background: #7c3aed;
}

/* ── Section headers ────────────────────────────────────── */
.section-title {
    font-size: 0.8rem;
    font-weight: 900;
    letter-spacing: 0.05em;
    color: #1e1b4b;
    /* text-transform: uppercase; */
}
@media (min-width: 640px)  { .section-title { font-size: 0.95rem; } }
@media (min-width: 1024px) { .section-title { font-size: 1.15rem; } }

/* ── Service card ───────────────────────────────────────── */
.svc-card {
    background: #fff;
    border: none !important;
    border-radius: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 8px;
    text-align: center;
    box-shadow: var(--shadow-sm);
    transition: all 0.22s ease;
    cursor: pointer;
    text-decoration: none;
    min-height: 100px;
    outline: none !important;
    -webkit-tap-highlight-color: transparent;
}
@media (min-width: 640px) {
    .svc-card { border-radius: 18px; gap: 10px; padding: 18px 10px; min-height: 120px; }
}
.svc-card:hover, .svc-card:focus, .svc-card:active {
    box-shadow: var(--shadow-md);
    transform: translateY(-3px);
    outline: none !important;
    background: #fff !important;
}

.svc-icon-wrap {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    flex-shrink: 0;
}
@media (min-width: 640px) { .svc-icon-wrap { width: 56px; height: 56px; border-radius: 14px; } }

.svc-label {
    font-size: 0.62rem;
    font-weight: 700;
    color: #1e1b4b;
    line-height: 1.3;
}
@media (min-width: 640px) { .svc-label { font-size: 0.75rem; } }

/* ── Services grid ──────────────────────────────────────── */
.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}
@media (min-width: 640px)  { .services-grid { gap: 16px; } }
@media (min-width: 1024px) { .services-grid { grid-template-columns: repeat(5, 1fr); gap: 18px; } }

/* ── Why choose cards ───────────────────────────────────── */
.why-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}
@media (min-width: 640px) { .why-row { gap: 16px; } }
@media (min-width: 1024px) {
    .why-row { gap: 24px; }
}

.why-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 6px;
}
@media (min-width: 1024px) {
    .why-card {
        background: #fff;
        border-radius: 20px;
        padding: 28px 16px;
        box-shadow: var(--shadow-sm);
    }
}

.why-icon-wrap {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
@media (min-width: 1024px) { .why-icon-wrap { width: 56px; height: 56px; margin-bottom: 8px; } }

.why-label {
    font-size: 0.6rem;
    font-weight: 800;
    color: #1e1b4b;
    line-height: 1.3;
}
@media (min-width: 640px) { .why-label { font-size: 0.72rem; } }
@media (min-width: 1024px) { .why-label { font-size: 1rem; } }

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

/* ── Page wrapper (bottom nav spacing on mobile) ─────────── */
.page-content {
    padding-bottom: 0;
}
@media (min-width: 1024px) { .page-content { padding-bottom: 0; } }

/* ── Dashboard screen inside laptop ─────────────────────── */
.dash-screen {
    background: linear-gradient(160deg, #1e1b4b 0%, #3730a3 100%);
    border-radius: 6px 6px 0 0;
    padding: 8px;
    color: white;
    font-family: 'Poppins', sans-serif;
    font-size: 5px;
}
@media (min-width: 640px)  { .dash-screen { font-size: 6px; padding: 10px; } }
@media (min-width: 1024px) { .dash-screen { font-size: 7px; padding: 12px; border-radius: 8px 8px 0 0; } }

.stat-pill {
    background: rgba(255,255,255,0.12);
    border-radius: 4px;
    padding: 4px 6px;
    text-align: center;
    flex: 1;
}

/* ── Analytics chart bars ────────────────────────────────── */
.bar-chart {
    display: flex;
    align-items: flex-end;
    gap: 3px;
    height: 30px;
    margin-top: 6px;
}
@media (min-width: 1024px) { .bar-chart { height: 38px; } }

.bar {
    flex: 1;
    border-radius: 2px 2px 0 0;
    background: rgba(167,139,250,0.6);
}
.bar.active { background: #a78bfa; }

/* ── Hero floating icons specific sizes ──────────────────── */
.fi-cart  { width: 28px; height: 28px; top: 10px; right: 8px; }
.fi-gear  { width: 26px; height: 26px; bottom: 36px; right: 2px; }
.fi-chart { width: 24px; height: 24px; top: 34px; right: -6px; }

@media (min-width: 640px) {
    .fi-cart  { width: 34px; height: 34px; top: 12px; right: 10px; }
    .fi-gear  { width: 30px; height: 30px; bottom: 44px; right: 4px; }
    .fi-chart { width: 28px; height: 28px; top: 42px; right: -8px; }
}
@media (min-width: 1024px) {
    .fi-cart  { width: 42px; height: 42px; top: 18px; right: 14px; }
    .fi-gear  { width: 38px; height: 38px; bottom: 60px; right: 6px; }
    .fi-chart { width: 36px; height: 36px; top: 52px; right: -10px; }
}

/* ── FB/IG/YT brand icons (SVG inline) ───────────────────── */
.brand-icon { width: 36px; height: 36px; }
@media (min-width: 640px) { .brand-icon { width: 42px; height: 42px; } }
</style>

<div class="page-content">

<!-- ═══════════════════════════════════════════════════════
     TOP HEADER
════════════════════════════════════════════════════════ -->
<header class="sk-header">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 select-none shrink-0">
            <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-12 sm:h-12 w-auto object-contain">
        </a>

        <!-- Search Bar (Desktop & Mobile) -->
        <form action="{{ route('services.index') }}" method="GET" class="flex items-center flex-1 max-w-[220px] sm:max-w-xs relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." style="background-color: #ffffff !important;" class="w-full bg-white text-[11px] sm:text-xs font-normal text-gray-800 placeholder-gray-400 placeholder:font-normal pl-10 sm:pl-11 pr-2 sm:pr-3 py-1.5 sm:py-2 rounded-full border border-gray-200/80 focus:border-violet-500 outline-none transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 absolute left-3.5 sm:left-4 pointer-events-none" style="margin-left: 10px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>

        <!-- Desktop nav links -->
        <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ url('/') }}"           class="text-sm font-bold text-violet-700">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Services</a>
            <a href="#why-choose-us"           class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Why Us</a>
            <a href="{{ route('contact') }}"   class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Contact</a>
        </nav>

        <!-- Right side actions -->
        <div class="flex items-center gap-3">

            <!-- Notification bell -->
            @auth
            @php $unread = auth()->user()->unreadNotifications->take(10); @endphp
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="relative p-2 rounded-full hover:bg-violet-50 transition-colors" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($unread->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
                    @endif
                </button>

                <!-- Dropdown -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-violet-100 z-50 overflow-hidden"
                     style="display:none">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-black text-gray-800">Notifications</span>
                        @if($unread->count() > 0)
                        <span class="text-[10px] font-bold bg-violet-100 text-violet-700 px-2 py-0.5 rounded-full">{{ $unread->count() }} new</span>
                        @endif
                    </div>
                    <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                        @forelse($unread as $notif)
                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left p-3 flex gap-3 hover:bg-gray-50 transition-colors bg-transparent border-0 cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[11px] font-bold text-gray-800 truncate">{{ $notif->data['title'] ?? 'Notification' }}</p>
                                    <p class="text-[10px] text-gray-500 mt-0.5 line-clamp-2 leading-relaxed">{{ $notif->data['message'] ?? '' }}</p>
                                    <p class="text-[9px] text-gray-400 mt-1 font-medium">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            </button>
                        </form>
                        @empty
                        <div class="p-6 text-center">
                            <p class="text-xs font-bold text-slate-500">All caught up!</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">No new notifications</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @else
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="relative p-2 rounded-full hover:bg-violet-50 transition-colors" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>
                <div x-show="open" class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-violet-100 z-50 overflow-hidden" style="display:none">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-black text-gray-800">Notifications</span>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-xs font-bold text-gray-500">Log in to view notifications</p>
                    </div>
                </div>
            </div>
            @endauth

            @if(auth('admin')->check() || auth('partner')->check() || auth('customer')->check())
                <!-- User avatar -->
                @php
            $u = auth()->user();
                    $ini = strtoupper(implode('', array_map(fn($w)=>mb_substr($w,0,1), array_slice(array_filter(explode(' ',trim($u->name))),0,2))));
                    $dashUrl = match($u->role){ 'admin'=>route('admin.dashboard'),'partner'=>route('partner.dashboard'),default=>route('customer.dashboard')};
                @endphp
                <div class="relative" x-data="{ pOpen:false }" @click.away="pOpen=false">
                    <button @click="pOpen=!pOpen" class="w-9 h-9 rounded-full bg-violet-100 text-violet-700 font-black text-xs flex items-center justify-center ring-2 ring-violet-50 hover:ring-violet-200 transition-all">{{ $ini }}</button>
                    <div x-show="pOpen" x-transition class="absolute right-0 mt-2 w-44 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden" style="display:none">
                        <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/60">
                            <p class="text-xs font-bold text-gray-800 truncate">{{ $u->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate mt-0.5">{{ $u->email ?: $u->phone }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ $dashUrl }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-violet-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-50 transition-colors text-left bg-transparent border-0 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Desktop login / explore -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Log in</a>
                    <!-- <a href="{{ route('services.index') }}" class="btn-cta">Explore Services <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a> -->
                </div>
            @endif
        </div>
    </div>
</header>


<!-- ═══════════════════════════════════════════════════════
     HERO BANNER (5-Slide Image Carousel)
════════════════════════════════════════════════════════ -->
<section class="px-3 sm:px-5 lg:px-8 pt-4 sm:pt-6 bg-white">
    <div class="max-w-5xl mx-auto">
        <!-- Interactive Carousel using Alpine.js -->
        <div x-data="{ 
            activeSlide: 0,
            slidesCount: {{ $banners->count() ?: 1 }},
            autoPlay() {
                if (this.slidesCount > 1) {
                    setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
                    }, 4000);
                }
            }
        }" x-init="autoPlay()" class="relative group">
            
            @if($banners->count() > 1)
            <!-- Navigation Buttons (Chevron Next & Prev) -->
            <button @click="activeSlide = (activeSlide - 1 + slidesCount) % slidesCount" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/70 backdrop-blur-md border border-white/80 flex items-center justify-center text-slate-800 hover:bg-white hover:shadow-lg transition-all focus:outline-none opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="activeSlide = (activeSlide + 1) % slidesCount" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/70 backdrop-blur-md border border-white/80 flex items-center justify-center text-slate-800 hover:bg-white hover:shadow-lg transition-all focus:outline-none opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            @endif

            <!-- Slide Wrapper -->
            <div class="relative overflow-hidden rounded-[16px] sm:rounded-[22px] shadow-sm border border-slate-100 aspect-[16/9] bg-slate-50">
                <!-- Sliding Track -->
                <div class="flex w-full h-full transition-transform duration-700 ease-in-out" :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                    @forelse($banners as $banner)
                    <!-- Slide -->
                    <div class="w-full h-full shrink-0">
                        @if($banner->link)
                            <a href="{{ $banner->link }}" target="_blank">
                                <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover" alt="{{ $banner->title ?? 'Banner' }}">
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover" alt="{{ $banner->title ?? 'Banner' }}">
                        @endif
                    </div>
                    @empty
                    <!-- Fallback slide -->
                    <div class="w-full h-full shrink-0 flex items-center justify-center bg-gray-100">
                        <span class="text-gray-400 font-medium">No banners available</span>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Slide Dots Indicator -->
            <div x-show="slidesCount > 1" class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 flex justify-center gap-1.5 sm:gap-2 z-20">
                <template x-for="i in slidesCount">
                    <button @click="activeSlide = i - 1" class="h-1.5 sm:h-2 rounded-full transition-all duration-300 focus:outline-none backdrop-blur-sm shadow-sm" :class="activeSlide === i - 1 ? 'bg-violet-600 w-4 sm:w-6' : 'bg-slate-300/80 hover:bg-slate-450 w-1.5 sm:w-2'"></button>
                </template>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════
     OUR SERVICES
════════════════════════════════════════════════════════ -->
<section class="px-3 sm:px-5 lg:px-8 py-5 sm:py-8 lg:py-12 bg-slate-50">
    <div class="max-w-5xl mx-auto">

        @php
            $getServiceRoute = function($keyword, $fallbackSlug = null) use ($servicesByCategory) {
                $services = $servicesByCategory->flatten(1);
                $match = $services->first(function($svc) use ($keyword) {
                    return str_contains(strtolower($svc->name), strtolower($keyword))
                        || str_contains(strtolower($svc->slug), strtolower($keyword))
                        || str_contains(strtolower($svc->category), strtolower($keyword));
                });
                if ($match) return route('services.show', $match->slug);
                if ($fallbackSlug) {
                    $fallbackMatch = $services->firstWhere('slug', $fallbackSlug);
                    if ($fallbackMatch) return route('services.show', $fallbackMatch->slug);
                }
                return route('services.index');
            };
        @endphp

        <!-- Header row -->
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h2 class="section-title">Our Services</h2>
            <a href="{{ route('services.index') }}" class="flex items-center gap-1 text-[11px] sm:text-xs font-bold text-violet-600 hover:text-violet-800 transition-colors group">
                View All
                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Services grid -->
        <div class="services-grid">
            @php
                $allServices = $services;
            @endphp
            @foreach($allServices->take(8) as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="svc-card">
                <div class="svc-icon-wrap {{ $service->banner_image ? 'overflow-hidden' : '' }}" style="{{ $service->banner_image ? 'background: transparent;' : '' }}">
                    @if($service->banner_image)
                        <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                    @elseif($service->icon)
                        <i data-lucide="{{ $service->icon }}" class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600"></i>
                    @else
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    @endif
                </div>
                <span class="svc-label">{{ $service->name }}</span>
            </a>
            @endforeach
            <a href="{{ route('services.index') }}" class="svc-card">
                <div class="svc-icon-wrap">
                    <i data-lucide="grid-3x3" class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600"></i>
                </div>
                <span class="svc-label">And More</span>
            </a>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════
     WHY CHOOSE US
════════════════════════════════════════════════════════ -->
<section id="why-choose-us" class="px-3 sm:px-5 lg:px-8 pt-5 pb-24 sm:pt-8 sm:pb-24 lg:py-12 mb-0 scroll-mt-20" style="background:#f8f8fb;">
    <div class="max-w-5xl mx-auto">
        <h2 class="section-title mb-4 sm:mb-6  normal-case">Why Choose SK Solutions</h2>
        <div class="why-row">
            <!-- Trusted by Thousands -->
            <div class="why-card group">
                <div class="why-icon-wrap group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-violet-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="why-label">Trusted by Thousands</span>
                <p class="hidden lg:block text-xs text-gray-500 mt-1 font-medium leading-relaxed">Over 10,000+ businesses globally trust us to deliver high conversion rates, modern designs, and secure setups.</p>
            </div>

            <!-- Secure & Reliable -->
            <div class="why-card group">
                <div class="why-icon-wrap group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-violet-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="why-label">Secure &amp; Reliable</span>
                <p class="hidden lg:block text-xs text-gray-500 mt-1 font-medium leading-relaxed">Enterprise-grade security standards and stable hosting guarantees to keep your systems running 24/7.</p>
            </div>

            <!-- Experience Team -->
            <div class="why-card group">
                <div class="why-icon-wrap group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-violet-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2m10 0V6a3 3 0 00-6 0v2m6 0H9m3 4v4m-2-2h4"/>
                    </svg>
                </div>
                <span class="why-label">Client-Focused Service</span>
                    <p class="hidden lg:block text-xs text-gray-500 mt-1 font-medium leading-relaxed">
                    We prioritize client satisfaction by providing personalized solutions, transparent communication, and reliable support.
                </p>
                <!-- <span class="why-label">Dedicated Support</span>
                <p class="hidden lg:block text-xs text-gray-500 mt-1 font-medium leading-relaxed">Our support managers are online around the clock to assist you with active setups, reviews, and modifications.</p> -->
            </div>

            <!-- Experienced Team -->
            <div class="why-card group">
                <div class="why-icon-wrap group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-violet-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="why-label">Experienced Team</span>
                <p class="hidden lg:block text-xs text-gray-500 mt-1 font-medium leading-relaxed">Our team of experts brings years of experience in delivering high-quality, modern, and scalable digital solutions tailored to your unique needs.</p>
            </div>


        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════
     DESKTOP FOOTER (hidden on mobile)
════════════════════════════════════════════════════════ -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

</div><!-- /page-content -->


<!-- ═══════════════════════════════════════════════════════
     FIXED BOTTOM NAV (mobile only)
════════════════════════════════════════════════════════ -->
<nav class="bottom-nav-bar lg:hidden">

    <a href="{{ url('/') }}" class="nav-item active" id="nav-home">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
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

    @if(auth('admin')->check() || auth('partner')->check() || auth('customer')->check())
        @php
            $u = auth()->user();
            $ordersUrl = match($u->role){
                'admin' => route('admin.dashboard'),
                'partner' => route('partner.orders'),
                default => route('customer.orders'),
            };
        @endphp
        <a href="{{ $ordersUrl }}" class="nav-item" id="nav-orders">
    @else
        <a href="{{ route('login') }}" class="nav-item" id="nav-orders">
    @endif
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

