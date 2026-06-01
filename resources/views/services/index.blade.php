@extends('layouts.app')
@section('title', 'Services — SK Solutions')
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

.brand-icon { width: 36px; height: 36px; }
@media (min-width: 640px) { .brand-icon { width: 42px; height: 42px; } }

/* ── Premium Filter Chips ───────────────────────────────── */
.filter-container {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(243, 240, 255, 0.8);
    border-radius: 100px;
    padding: 6px;
    box-shadow: 0 4px 20px rgba(109, 40, 217, 0.04);
}

.filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 100px;
    font-size: 0.72rem;
    font-weight: 700;
    color: #4b5563;
    border: 1px solid transparent;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    cursor: pointer;
    background: transparent;
    user-select: none;
}

.filter-chip:hover {
    color: #6d28d9;
    background: rgba(109, 40, 217, 0.04);
    transform: translateY(-1px);
}

.filter-chip.active {
    color: #6d28d9;
    background: rgba(109, 40, 217, 0.08);
    border-color: rgba(109, 40, 217, 0.2);
    box-shadow: 0 4px 14px rgba(109, 40, 217, 0.06);
    font-weight: 800;
}

/* Hide scrollbar utility */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* ── Buttons ────────────────────────────────────────────── */
.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #5b21b6;
    color: #fff;
    padding: 8px 16px;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 800;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px rgba(91,33,182,0.25);
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

/* ── Page wrapper ───────────────────────────────────────── */
.page-content {
    padding-bottom: 96px;
}
@media (min-width: 1024px) { .page-content { padding-bottom: 0; } }
</style>

<div class="page-content">

<!-- ═══════════════════════════════════════════════════════
     TOP HEADER
════════════════════════════════════════════════════════ -->
<header class="sk-header">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 select-none shrink-0">
            <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-10 sm:h-12 w-auto object-contain">
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
            <a href="{{ url('/') }}"           class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold text-violet-700">Services</a>
            <a href="{{ url('/') }}#why-choose-us"           class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Why Us</a>
            <a href="{{ route('contact') }}"   class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Contact</a>
        </nav>

        <!-- Right side actions -->
        <div class="flex items-center gap-3">

            <!-- Notification bell -->
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="relative p-2 rounded-full hover:bg-violet-50 transition-colors" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
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
                        <span class="text-[10px] font-bold bg-violet-100 text-violet-700 px-2 py-0.5 rounded-full">2 new</span>
                    </div>
                    <div class="divide-y divide-gray-50">
                        <div class="p-3 flex gap-3 hover:bg-gray-50 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 3l14 9-14 9V3z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-800">Welcome to SK Solutions!</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">Scale your business with premium digital services.</p>
                                <p class="text-[9px] text-gray-400 mt-1">Just now</p>
                            </div>
                        </div>
                        <div class="p-3 flex gap-3 hover:bg-gray-50 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-800">Special Offer!</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">15% off your first mobile app. Use: <b>APPS15</b></p>
                                <p class="text-[9px] text-gray-400 mt-1">2 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @auth
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
            @endauth
        </div>
    </div>
</header>

<!-- Services Hero Header -->
<section class="px-4 sm:px-6 lg:px-8 py-10 md:py-14 bg-white border-b border-violet-50">
    <div class="max-w-5xl mx-auto text-center flex flex-col items-center">
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-violet-100 text-violet-850 text-violet-700 text-[10px] font-black tracking-wider uppercase mb-3">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg> Discover Services
        </span>
        <h1 class="text-3xl sm:text-4.5xl font-black text-gray-900 leading-tight tracking-tight mb-3 select-none">
            Tailored Digital <span class="text-violet-700">Services</span>
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 max-w-lg leading-relaxed font-semibold">
            Explore our bespoke web development, performance marketing, and creative production services customized to skyrocket your brand.
        </p>
    </div>
</section>


<!-- Category Selector Tabs -->
<div class="mt-6 mb-8 max-w-5xl mx-auto px-4">
    <!-- Centered modern floating bar -->
    <div class="filter-container flex items-center gap-2 overflow-x-auto scrollbar-hide -mx-4 px-4 sm:mx-0 sm:px-2 scroll-smooth">
        <!-- "All Services" Tab -->
        <button type="button" 
           class="filter-chip shrink-0 {{ !$selectedCategory ? 'active' : '' }}" onclick="filterServices('all', this)">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            <span>All Services</span>
        </button>
        
        <!-- Loop categories -->
        @foreach($allCategories as $cat)
        @php
            $isActive = $selectedCategory === $cat;
            
            // Render beautiful custom icons for categories
            if (str_contains(strtolower($cat), 'web')) {
                $tabSvg = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 000 20 14.5 14.5 0 000-20M2 12h20"/></svg>';
            } elseif (str_contains(strtolower($cat), 'app')) {
                $tabSvg = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>';
            } elseif (str_contains(strtolower($cat), 'marketing') || str_contains(strtolower($cat), 'ads')) {
                $tabSvg = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>';
            } elseif (str_contains(strtolower($cat), 'video') || str_contains(strtolower($cat), 'editing')) {
                $tabSvg = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>';
            } elseif (str_contains(strtolower($cat), 'design') || str_contains(strtolower($cat), 'brand')) {
                $tabSvg = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 2 12 22Z" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 6V12L16 14" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            } else {
                $tabSvg = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>';
            }
        @endphp
        <button type="button"
           class="filter-chip shrink-0 {{ $isActive ? 'active' : '' }}" onclick="filterServices('{{ addslashes($cat) }}', this)">
            {!! $tabSvg !!}
            <span>{{ $cat }}</span>
        </button>
        @endforeach
    </div>
</div>

<!-- Services Grid Section -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="services-grid">
        
        @foreach($allSvcs as $svc)
        <a href="{{ route('services.show', $svc->slug) }}" class="svc-card" data-category="{{ htmlspecialchars($svc->category) }}">
            <div class="svc-icon-wrap {{ $svc->banner_image ? 'overflow-hidden' : '' }}" style="{{ $svc->banner_image ? 'background: transparent;' : '' }}">
                @if($svc->banner_image)
                    <img src="{{ asset('storage/' . $svc->banner_image) }}" alt="{{ $svc->name }}" class="w-full h-full object-cover">
                @elseif($svc->icon)
                    <i data-lucide="{{ $svc->icon }}" class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600"></i>
                @else
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                @endif
            </div>
            <span class="svc-label">{{ $svc->name }}</span>
        </a>
        @endforeach

        @if($allSvcs->isEmpty())
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-violet-50/40 rounded-2xl border border-violet-100 border-dashed empty-state">
                <svg class="w-10 h-10 text-violet-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm0 0h18M5 17h14M9 12h6"/></svg>
                <p class="text-gray-800 font-bold text-sm">No services found</p>
                <p class="text-gray-500 text-xs mt-1">Try selecting a different category or check back later.</p>
            </div>
        @else
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-violet-50/40 rounded-2xl border border-violet-100 border-dashed empty-state" style="display:none;" id="no-services-msg">
                <svg class="w-10 h-10 text-violet-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm0 0h18M5 17h14M9 12h6"/></svg>
                <p class="text-gray-800 font-bold text-sm">No services found in this category</p>
                <p class="text-gray-500 text-xs mt-1">Try selecting a different category.</p>
            </div>
        @endif

    </div>
</div>

<!-- Desktop Footer (hidden on mobile/tablet, visible on desktop) -->
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

    <a href="{{ route('services.index') }}" class="nav-item active" id="nav-services">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/>
            <rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>
        </svg>
        Services
    </a>

    @auth
        @php
            $ordersUrl = match(auth()->user()->role) {
                'admin' => route('admin.dashboard'),
                'partner' => route('partner.orders'),
                default => route('customer.orders'),
            };
        @endphp
        <a href="{{ $ordersUrl }}" class="nav-item" id="nav-orders">
    @else
        <a href="{{ route('login') }}" class="nav-item" id="nav-orders">
    @endauth
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

    <a href="{{ auth()->check() ? url('/dashboard') : route('login') }}" class="nav-item" id="nav-profile">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ auth()->check() ? 'Dashboard' : 'Profile' }}
    </a>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category');
        if (category) {
            const btn = Array.from(document.querySelectorAll('.filter-chip')).find(el => el.getAttribute('data-filter') === category || el.textContent.trim() === category);
            if (btn) filterServices(category, btn);
        }
    });

    function filterServices(category, btn) {
        document.querySelectorAll('.filter-chip').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');

        const cards = document.querySelectorAll('.svc-card');
        let visibleCount = 0;

        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('no-services-msg');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
        }
    }
</script>

@endsection
