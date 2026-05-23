@extends('layouts.app')
@section('title', 'Explore Services — Customer Portal')
@section('sidebar')<!-- enable sidebar -->@endsection
@section('content')

<style>
/* ── Fonts ──────────────────────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap');

/* ── Base ───────────────────────────────────────────────── */
body {
    background: #f8f8fb;
    font-family: 'Outfit', sans-serif;
    -webkit-tap-highlight-color: transparent;
}

/* ── Service card ───────────────────────────────────────── */
.svc-card {
    background: #fff;
    border: 1px solid #ede9fe;
    border-radius: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 18px 10px;
    text-align: center;
    box-shadow: 0 2px 12px rgba(109,40,217,0.07);
    transition: all 0.22s ease;
    cursor: pointer;
    text-decoration: none;
    min-height: 140px;
}
@media (min-width: 640px) {
    .svc-card { border-radius: 18px; gap: 10px; padding: 22px 12px; min-height: 185px; }
}
.svc-card:hover {
    box-shadow: 0 8px 28px rgba(109,40,217,0.14);
    transform: translateY(-3px);
    border-color: #c4b5fd;
}

.svc-icon-wrap {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    flex-shrink: 0;
}
@media (min-width: 640px) { .svc-icon-wrap { width: 56px; height: 56px; border-radius: 14px; } }

.svc-label {
    font-size: 0.68rem;
    font-weight: 800;
    color: #1e1b4b;
    line-height: 1.3;
}
@media (min-width: 640px) { .svc-label { font-size: 0.82rem; } }

/* ── Services grid ──────────────────────────────────────── */
.services-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
@media (min-width: 480px)  { .services-grid { grid-template-columns: repeat(3, 1fr); gap: 14px; } }
@media (min-width: 768px)  { .services-grid { grid-template-columns: repeat(4, 1fr); gap: 16px; } }
@media (min-width: 1024px) { .services-grid { grid-template-columns: repeat(5, 1fr); gap: 18px; } }

.brand-icon { width: 36px; height: 36px; }
@media (min-width: 640px) { .brand-icon { width: 42px; height: 42px; } }
</style>

<div class="py-4 sm:py-6" style="font-family: 'Outfit', sans-serif;">

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
    <div>
        <div class="inline-flex items-center gap-2 bg-violet-100 border border-violet-200 text-violet-800 text-xs font-black px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Service Catalog
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
            Explore <span class="text-violet-700">Premium Services</span>
        </h1>
        <p class="text-slate-500 font-semibold mt-1 text-sm">Browse, add to cart, and order any digital service directly.</p>
    </div>
    <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 text-xs font-black uppercase tracking-wider hover:border-violet-300 hover:text-violet-700 shadow-sm transition-all hover:-translate-y-0.5 w-full sm:w-auto justify-center text-decoration-none">
        <svg class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        View Cart ({{ auth()->user()->cartItems->count() }})
    </a>
</div>

{{-- Category Filter Pills --}}
<div class="flex gap-2 mb-8 overflow-x-auto pb-3 -mx-4 px-4 sm:mx-0 sm:px-0 sm:pb-0 sm:flex-wrap whitespace-nowrap scrollbar-none">
    <a href="{{ route('customer.services') }}"
       class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 shrink-0 text-decoration-none {{ !$selectedCategory ? 'bg-violet-700 text-white shadow-lg shadow-violet-700/25' : 'bg-white text-gray-600 border border-violet-100 hover:border-violet-300 hover:text-violet-700' }}">
        🔥 All
    </a>
    @foreach($allCategories as $cat)
    <a href="{{ route('customer.services', ['category' => $cat]) }}"
       class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 shrink-0 text-decoration-none {{ $selectedCategory === $cat ? 'bg-violet-700 text-white shadow-lg shadow-violet-700/25' : 'bg-white text-gray-600 border border-violet-100 hover:border-violet-300 hover:text-violet-700' }}">
        {{ $cat }}
    </a>
    @endforeach
</div>

{{-- Services Grid --}}
<div class="services-grid mb-10">
    @forelse($servicesByCategory->flatten(1) as $svc)
    @php
        $lowerName = strtolower($svc->name);
        $lowerSlug = strtolower($svc->slug);
        
        $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
        $isBrandIcon = false;
        
        if (str_contains($lowerName, 'e-commerce') || str_contains($lowerSlug, 'ecommerce')) {
            $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
            $svg = '
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'informative') || str_contains($lowerSlug, 'informative')) {
            $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
            $svg = '
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <rect x="2" y="3" width="20" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 11h6"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'facebook')) {
            $bg = 'linear-gradient(135deg, #e8f4fe, #dbeafe)';
            $isBrandIcon = true;
            $svg = '
                <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                    <circle cx="20" cy="20" r="20" fill="#1877F2"/>
                    <path d="M27.5 20H22.5V17.5C22.5 16.67 23.17 16.25 24 16.25H27V12.5H24C21.24 12.5 19 14.74 19 17.5V20H16V24H19V32.5H22.5V24H26L27.5 20Z" fill="white"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'instagram')) {
            $bg = 'linear-gradient(135deg, #fde8f4, #fce7f3)';
            $isBrandIcon = true;
            $svg = '
                <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                    <defs>
                        <radialGradient id="ig1" cx="30%" cy="107%" r="150%"><stop offset="0%" stop-color="#ffd600"/><stop offset="50%" stop-color="#ff6a00"/><stop offset="100%" stop-color="#ee0979"/></radialGradient>
                        <radialGradient id="ig2" cx="5%" cy="100%" r="60%"><stop offset="0%" stop-color="#a855f7"/><stop offset="100%" stop-color="transparent"/></radialGradient>
                    </defs>
                    <rect width="40" height="40" rx="10" fill="url(#ig1)"/>
                    <rect width="40" height="40" rx="10" fill="url(#ig2)"/>
                    <rect x="10" y="10" width="20" height="20" rx="5" stroke="white" stroke-width="2.2" fill="none"/>
                    <circle cx="20" cy="20" r="5.5" stroke="white" stroke-width="2.2" fill="none"/>
                    <circle cx="27" cy="13" r="1.5" fill="white"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'google')) {
            $bg = 'linear-gradient(135deg, #f0fdf4, #dcfce7)';
            $isBrandIcon = true;
            $svg = '
                <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                    <path d="M20 5L32 27H8L20 5Z" fill="#4285F4"/>
                    <circle cx="32" cy="27" r="6" fill="#FBBC05"/>
                    <circle cx="8" cy="27" r="6" fill="#34A853"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'youtube')) {
            $bg = 'linear-gradient(135deg, #fef2f2, #fee2e2)';
            $isBrandIcon = true;
            $svg = '
                <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                    <rect width="40" height="40" rx="10" fill="#FF0000"/>
                    <path d="M30.5 14.8C30.3 13.9 29.6 13.2 28.7 13C26.7 12.5 20 12.5 20 12.5C20 12.5 13.3 12.5 11.3 13C10.4 13.2 9.7 13.9 9.5 14.8C9 16.8 9 21 9 21C9 21 9 25.2 9.5 27.2C9.7 28.1 10.4 28.8 11.3 29C13.3 29.5 20 29.5 20 29.5C20 29.5 26.7 29.5 28.7 29C29.6 28.8 30.3 28.1 30.5 27.2C31 25.2 31 21 31 21C31 21 31 16.8 30.5 14.8Z" fill="white"/>
                    <path d="M17.5 24.5V17.5L23.5 21L17.5 24.5Z" fill="#FF0000"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'seo') || str_contains($lowerSlug, 'seo')) {
            $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
            $svg = '
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'video') || str_contains($lowerName, 'reels') || str_contains($lowerName, 'edit')) {
            $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
            $svg = '
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
            ';
        } elseif (str_contains($lowerName, 'app') || str_contains($lowerName, 'mobile') || str_contains($lowerSlug, 'app')) {
            $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
            $svg = '
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/>
                </svg>
            ';
        } else {
            $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
            $svg = '
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            ';
        }
    @endphp
    
    <a href="{{ route('services.show', $svc->slug) }}" class="svc-card relative text-decoration-none">
        @if($svc->is_popular)
            <div class="absolute top-2 right-2 sm:top-3 sm:right-3 z-10 bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white text-[8px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full shadow-md shadow-violet-500/25">🔥</div>
        @endif
        
        <div class="svc-icon-wrap" style="background: {{ $bg }}">
            {!! $svg !!}
        </div>
        
        <span class="text-[9px] font-black text-violet-600 uppercase tracking-widest mb-1">{{ $svc->category ?? 'Service' }}</span>
        <span class="svc-label">{{ $svc->name }}</span>
        <p class="text-[9px] sm:text-[10px] text-gray-500 mt-1 line-clamp-2 leading-relaxed font-semibold">{{ $svc->short_description }}</p>
        <span class="text-[10px] sm:text-xs font-black text-violet-700 mt-2">₹{{ number_format($svc->min_price ?? 0, 0) }}</span>
    </a>
    @empty
    <div class="col-span-full bg-white rounded-3xl border border-dashed border-violet-200 p-16 text-center">
        <div class="w-14 h-14 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-violet-100 shadow-inner">
            <svg class="w-6 h-6 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
        <h3 class="text-base font-black text-gray-900 mb-2">No services in this category</h3>
        <p class="text-gray-500 text-xs mb-6 font-semibold">Try a different category filter.</p>
        <a href="{{ route('customer.services') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-2xl bg-violet-700 text-white text-xs font-black uppercase tracking-wider hover:bg-violet-800 shadow-lg shadow-violet-600/20 transition-all hover:-translate-y-0.5 text-decoration-none">
            View All Services
        </a>
    </div>
    @endforelse
</div>

</div>
@endsection
