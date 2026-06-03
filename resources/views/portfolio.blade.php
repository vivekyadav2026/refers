@extends('layouts.app')
@section('title', 'Our Portfolio — SKSolutions')
@section('hide_nav_footer', true)

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

body {
    background-color: #fafafa;
    font-family: 'Poppins', sans-serif;
    -webkit-tap-highlight-color: transparent;
}

/* Force Poppins globally on this page */
html, body, p, div, span, h1, h2, h3, h4, h5, h6, a, button, input, select, textarea, label {
    font-family: 'Poppins', sans-serif !important;
}
.bottom-nav {
    padding-bottom: env(safe-area-inset-bottom);
}
</style>

<!-- Responsive Sticky Top Header -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100/80 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 select-none shrink-0">
            <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-12 sm:h-14 w-auto rounded-xl object-contain shadow-sm border border-slate-100 bg-white">
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ route('landing') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('landing') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('services.*') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Services</a>
            <a href="{{ route('landing') }}#why-choose-us" class="text-sm font-bold text-slate-600 hover:text-indigo-800 transition-colors">Why Choose Us</a>
            <a href="{{ route('contact') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('contact') ? 'text-indigo-850' : 'text-slate-600 hover:text-indigo-800' }}">Contact</a>
        </nav>

        <!-- Right Actions -->
        <div class="flex items-center gap-4">
            <!-- Desktop CTA Button -->
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    @php
                        $dashUrl = match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'partner' => route('partner.dashboard'),
                            default => route('customer.dashboard'),
                        };
                    @endphp
                    <a href="{{ $dashUrl }}" class="inline-flex items-center gap-2 bg-indigo-800 text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:bg-indigo-900 transition-all hover:-translate-y-0.5 active:translate-y-0">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-800 transition-colors px-3 py-2">Log in</a>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 bg-indigo-800 text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:bg-indigo-900 transition-all hover:-translate-y-0.5 active:translate-y-0">
                        Explore Services <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

<div class="bg-slate-50 min-h-screen pb-24" x-data="{ activeSection: 'All' }">
    {{-- ══════ HERO ══════ --}}
    <div class="relative pt-6 pb-10 sm:pt-10 sm:pb-12 overflow-hidden bg-white border-b border-slate-100">
        {{-- Precision Grid Overlay --}}
        <div class="absolute inset-0 bg-[radial-gradient(#e2d9f3_1.2px,transparent_1.2px)] bg-[size:32px_32px] opacity-75 [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_80%,transparent_100%)] pointer-events-none z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-100 text-indigo-850 text-[10px] font-bold tracking-wider uppercase mb-5">
                <i data-lucide="briefcase" class="w-3.5 h-3.5"></i> Our Work
            </span>
            <h1 class="text-3.5xl sm:text-5xl font-black text-slate-900 mb-5 leading-tight tracking-tight">
                Our Proven <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 drop-shadow-[0_2px_10px_rgba(124,58,237,0.12)]">Portfolio</span>
            </h1>
            <p class="text-slate-500 text-xs sm:text-sm md:text-base max-w-xl mx-auto leading-relaxed font-semibold">
                Explore our successful projects across Ecommerce, Wordpress, UI/UX and custom applications. We deliver digital excellence.
            </p>
        </div>
    </div>

    {{-- ══════ PORTFOLIO CONTENT ══════ --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        
        @if($groupedPortfolios->count() > 0)
            <div class="space-y-4" x-data="{ activeCategory: null }">
                @foreach($groupedPortfolios as $categoryName => $items)
                    <div x-data="{ open: false }" class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden transition-all duration-300 hover:border-indigo-100 hover:shadow-md">
                        <!-- Accordion Header -->
                        <button @click="open = !open" 
                                class="w-full px-6 py-5 flex items-center justify-between bg-white hover:bg-slate-50/50 transition-colors text-left focus:outline-none">
                            <div class="flex items-center gap-4">
                                <span class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-655 flex items-center justify-center font-bold text-indigo-600 shrink-0">
                                    <i data-lucide="folder" class="w-5 h-5"></i>
                                </span>
                                <div>
                                    <h3 class="text-base sm:text-lg font-black text-slate-800 tracking-tight leading-none">{{ $categoryName }}</h3>
                                    <p class="text-xs text-slate-500 font-semibold mt-1.5">{{ $items->count() }} {{ Str::plural('Project', $items->count()) }}</p>
                                </div>
                            </div>
                            <!-- Chevron Icon -->
                            <span class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 transition-all duration-300"
                                  :class="open ? 'rotate-180 bg-indigo-50 text-indigo-600' : ''">
                                <i data-lucide="chevron-down" class="w-5 h-5"></i>
                            </span>
                        </button>

                        <!-- Accordion Body -->
                        <div x-show="open" 
                             style="display: none;"
                             x-transition:enter="transition ease-out duration-250"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="border-t border-slate-100 bg-slate-50/40 p-6">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($items as $portfolio)
                                    <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col justify-between transition-all hover:shadow-md hover:border-slate-200">
                                        <div class="space-y-4">
                                            <!-- Name -->
                                            <h4 class="text-base font-black text-slate-900 tracking-tight">{{ $portfolio->name }}</h4>
                                            
                                            <!-- Image (Optional) -->
                                            @if($portfolio->image)
                                                <div class="relative rounded-xl overflow-hidden bg-slate-150 aspect-video border border-slate-100">
                                                    <img src="{{ Storage::url($portfolio->image) }}" alt="{{ $portfolio->name }}" class="w-full h-full object-cover">
                                                </div>
                                            @endif

                                            <!-- YouTube Video (Optional) -->
                                            @if($portfolio->youtube_url)
                                                @php
                                                    $ytEmbed = $portfolio->youtube_url;
                                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $portfolio->youtube_url, $match)) {
                                                        $ytEmbed = "https://www.youtube.com/embed/" . $match[1];
                                                    }
                                                @endphp
                                                <div class="rounded-xl overflow-hidden border border-slate-100 aspect-video bg-black shadow-sm">
                                                    <iframe src="{{ $ytEmbed }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                </div>
                                            @endif

                                            <!-- Google Drive Video (Optional) -->
                                            @if($portfolio->google_drive_url)
                                                @php
                                                    $gdEmbed = $portfolio->google_drive_url;
                                                    if (preg_match('/file\/d\/([a-zA-Z0-9_-]+)/', $portfolio->google_drive_url, $match)) {
                                                        $gdEmbed = "https://drive.google.com/file/d/" . $match[1] . "/preview";
                                                    } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $portfolio->google_drive_url, $match)) {
                                                        $gdEmbed = "https://drive.google.com/file/d/" . $match[1] . "/preview";
                                                    }
                                                @endphp
                                                <div class="rounded-xl overflow-hidden border border-slate-100 aspect-video bg-black shadow-sm">
                                                    <iframe src="{{ $gdEmbed }}" class="w-full h-full" frameborder="0" allow="autoplay" allowfullscreen></iframe>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Website Link (Optional) -->
                                        @if($portfolio->link)
                                            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end">
                                                <a href="{{ $portfolio->link }}" target="_blank" 
                                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 hover:bg-indigo-150/70 text-indigo-700 hover:text-indigo-800 rounded-xl text-xs font-bold transition-colors">
                                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Visit Website
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-slate-400">
                    <i data-lucide="folder-open" class="w-10 h-10 text-indigo-500"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Our Portfolio is Updating</h3>
                <p class="text-sm text-slate-500 font-medium">We are currently curating our best work to display here. Check back soon!</p>
            </div>
        @endif
    </div>
</div>

<!-- Desktop Footer (hidden on mobile, visible on desktop) -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- Fixed Bottom Navigation (Public Mobile Only) -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 flex items-center justify-around z-50 bottom-nav shadow-[0_-5px_20px_rgba(0,0,0,0.03)] pb-2 pt-1">
    <a href="{{ url('/') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="home" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Home</span>
    </a>
    <a href="{{ route('services.index') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="grid-3x3" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Services</span>
    </a>
    @auth
        @php
            $ordersUrl = match(auth()->user()->role) {
                'admin' => route('admin.dashboard'),
                'partner' => route('partner.orders'),
                default => route('customer.orders'),
            };
        @endphp
        <a href="{{ $ordersUrl }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span class="text-[10px] font-bold">Orders</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span class="text-[10px] font-bold">Orders</span>
        </a>
    @endauth
    <a href="{{ route('contact') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="headphones" class="w-5 h-5" fill="currentColor" stroke="currentColor"></i>
        <span class="text-[10px] font-bold">Support</span>
    </a>
    <a href="{{ url('/portfolio') }}" class="flex flex-col items-center py-2 gap-1 w-full text-indigo-800">
        <i data-lucide="briefcase" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Portfolio</span>
    </a>
</nav>

@endsection
