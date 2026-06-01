@extends('layouts.app')
@section('title', 'Explore Services — Customer Portal')
@section('sidebar')<!-- enable sidebar -->@endsection
@section('content')

<style>
/* ── Fonts ──────────────────────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

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
</style>

<div class="py-4 sm:py-6" style="font-family: 'Poppins', sans-serif;">

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
    <div>
        <div class="inline-flex items-center gap-2 bg-violet-100 border border-violet-200 text-violet-850 text-violet-700 text-xs font-black px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
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

<!-- Category Selector Tabs -->
<div class="mt-6 mb-8">
    <!-- Center-aligned floating modern selector bar -->
    <div class="filter-container flex items-center gap-2 overflow-x-auto scrollbar-hide scroll-smooth">
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
<div class="services-grid">
    @foreach($services as $svc)
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

    @if($services->isEmpty())
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-violet-50/40 rounded-2xl border border-violet-100 border-dashed empty-state">
            <svg class="w-10 h-10 text-violet-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm0 0h18M5 17h14M9 12h6"/></svg>
            <p class="text-gray-800 font-bold text-sm">No services found</p>
            <p class="text-gray-500 text-xs mt-1">Try checking back later.</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category');
        if (category) {
            const btn = Array.from(document.querySelectorAll('.filter-chip')).find(el => el.textContent.trim() === category);
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
