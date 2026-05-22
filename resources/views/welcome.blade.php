@extends('layouts.app')
@section('title', 'SKSolutions — Premium Digital Agency')
@section('hide_nav_footer', true) <!-- Hide default nav to build the exact mobile UI -->

@section('content')
<style>
/* Add the font from the design */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700;900&family=Style+Script&display=swap');

body {
    background-color: #fafafa;
    font-family: 'Outfit', sans-serif;
    -webkit-tap-highlight-color: transparent;
}

.script-font {
    font-family: 'Style Script', cursive;
    font-size: 1.4em;
    line-height: 0.5;
}
.service-card {
    transition: background-color 0.2s ease;
}

.bottom-nav {
    padding-bottom: env(safe-area-inset-bottom);
}
</style><!-- Top Header -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100/80 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 select-none">
            <img src="{{ asset('logo.jpg') }}" alt="SK Solutions Logo" class="h-10 w-auto rounded-xl object-contain shadow-sm border border-slate-100">
        </a>

        <!-- Desktop Navigation Menu (hidden on mobile/tablet) -->
        <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ route('landing') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('landing') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('services.*') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Services</a>
            <a href="#why-choose-us" class="text-sm font-bold text-slate-600 hover:text-indigo-800 transition-colors">Why Choose Us</a>
            <a href="{{ route('contact') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('contact') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Contact</a>
        </nav>

        <!-- Right actions -->
        <div class="flex items-center gap-4">
            <!-- Notification bell -->
            <div class="relative" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
                <button type="button" @click="notifOpen = !notifOpen" class="p-2 text-slate-700 hover:text-indigo-800 transition-colors relative focus:outline-none rounded-full hover:bg-slate-100">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                </button>
                
                <!-- Notification Dropdown Panel -->
                <div x-show="notifOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-100 z-50 overflow-hidden" 
                     style="display:none">
                     <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                         <span class="text-sm font-black text-slate-800">Notifications</span>
                         <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-[10px] font-black">2 new</span>
                     </div>
                     <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-50">
                         <div class="p-4 hover:bg-slate-50 transition-colors flex items-start gap-3">
                             <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 shrink-0">
                                 <i data-lucide="sparkles" class="w-4 h-4"></i>
                             </div>
                             <div>
                                 <div class="text-xs font-bold text-slate-900">Welcome to SK Solutions!</div>
                                 <div class="text-[10px] text-slate-500 mt-0.5">Explore our premium digital agency services and scale your business today.</div>
                                 <div class="text-[9px] text-slate-400 mt-1">Just now</div>
                             </div>
                         </div>
                         <div class="p-4 hover:bg-slate-50 transition-colors flex items-start gap-3">
                             <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800 shrink-0">
                                 <i data-lucide="tag" class="w-4 h-4"></i>
                             </div>
                             <div>
                                 <div class="text-xs font-bold text-slate-900">Special Offer!</div>
                                 <div class="text-[10px] text-slate-500 mt-0.5">Get 15% off on your first mobile app development project. Use code: APPS15.</div>
                                 <div class="text-[9px] text-slate-400 mt-1">2 hours ago</div>
                             </div>
                         </div>
                     </div>
                </div>
            </div>

            @auth
                <!-- User Profile Dropdown -->
                @php
                    $user = auth()->user();
                    $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(array_filter(explode(' ', trim($user->name))), 0, 2))));
                    $dashUrl = match($user->role) {
                        'admin' => route('admin.dashboard'),
                        'partner' => route('partner.dashboard'),
                        default => route('customer.dashboard'),
                    };
                @endphp
                <div class="relative" x-data="{ profileOpen: false }" @click.away="profileOpen = false">
                    <button type="button" @click="profileOpen = !profileOpen" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-bold text-xs sm:text-sm flex items-center justify-center transition-colors focus:outline-none ring-2 ring-indigo-50/50 hover:ring-indigo-100">
                        {{ $initials }}
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="profileOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden" 
                         style="display:none">
                         <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                             <div class="text-xs font-bold text-slate-800 truncate">{{ $user->name }}</div>
                             <div class="text-[10px] text-slate-500 truncate mt-0.5">{{ $user->email }}</div>
                         </div>
                         <div class="py-1.5">
                             <a href="{{ $dashUrl }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-indigo-800 transition-colors">
                                 <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                             </a>
                             <form method="POST" action="{{ route('logout') }}" class="w-full m-0">
                                 @csrf
                                 <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors text-left border-none bg-transparent cursor-pointer">
                                     <i data-lucide="log-out" class="w-4 h-4"></i> Log Out
                                 </button>
                             </form>
                         </div>
                    </div>
                </div>
            @endauth

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

<!-- Hero Section / Slider -->
<section class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto">
        <!-- Interactive Carousel using Alpine.js -->
        <div x-data="{ 
            activeSlide: 0,
            slidesCount: 3,
            autoPlay() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
                }, 6000);
            }
        }" x-init="autoPlay()" class="relative">
            <!-- Slide Wrapper -->
            <div class="relative overflow-hidden rounded-[24px] sm:rounded-[32px] min-h-[220px] xs:min-h-[280px] sm:min-h-[380px] md:min-h-[460px] lg:min-h-[580px] bg-gradient-to-br from-indigo-50 via-purple-50 to-fuchsia-50 shadow-sm border border-purple-100/50">
                
                <!-- Glow elements -->
                <div class="absolute -top-10 -right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>

                <!-- Navigation Buttons (Chevron Next & Prev) -->
                <!-- Prev Button -->
                <button @click="activeSlide = (activeSlide - 1 + slidesCount) % slidesCount" class="absolute left-2.5 sm:left-5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-white/75 backdrop-blur-md border border-slate-200/50 flex items-center justify-center text-slate-700 hover:bg-white hover:text-indigo-850 hover:shadow-[0_4px_12px_rgba(0,0,0,0.1)] transition-all hover:scale-105 active:scale-95 shadow-sm focus:outline-none select-none">
                    <i class="w-4 h-4 sm:w-6 sm:h-6 text-slate-655 text-slate-600" data-lucide="chevron-left"></i>
                </button>
                
                <!-- Next Button -->
                <button @click="activeSlide = (activeSlide + 1) % slidesCount" class="absolute right-2.5 sm:right-5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-white/75 backdrop-blur-md border border-slate-200/50 flex items-center justify-center text-slate-700 hover:bg-white hover:text-indigo-850 hover:shadow-[0_4px_12px_rgba(0,0,0,0.1)] transition-all hover:scale-105 active:scale-95 shadow-sm focus:outline-none select-none">
                    <i class="w-4 h-4 sm:w-6 sm:h-6 text-slate-655 text-slate-600" data-lucide="chevron-right"></i>
                </button>

                <!-- Sliding Track -->
                <div class="flex w-full transition-transform duration-500 ease-out" :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                    
                    <!-- Slide 1: Grow Your Business -->
                    <div class="w-full shrink-0 px-4 py-6 xs:px-6 xs:py-8 sm:px-12 sm:py-16 lg:px-20 lg:py-24 flex flex-row items-center justify-between gap-2 sm:gap-6 lg:gap-10">
                        <!-- Left Column -->
                        <div class="w-[58%] lg:flex-1 text-left flex flex-col items-start z-10">
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-[8px] sm:text-[10px] font-bold tracking-wider uppercase mb-1.5 sm:mb-4">
                                <i data-lucide="sparkles" class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5"></i> DIGITAL PARTNER
                            </span>
                            <h1 class="text-[14px]/[16px] xs:text-[20px]/[22px] sm:text-3xl md:text-4xl lg:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight mb-1 sm:mb-4 select-none">
                                GROW YOUR <br>
                                <span class="text-indigo-850">BUSINESS</span> <span class="script-font text-indigo-700 font-normal ml-1 text-[13px] xs:text-[18px] sm:text-2xl lg:text-4xl">Online</span>
                            </h1>
                            <h2 class="text-[8px] sm:text-sm font-bold text-slate-800 mb-1 sm:mb-3 tracking-tight">Smart Solutions. Better Results.</h2>
                            <p class="text-[7.5px] xs:text-[8.5px] sm:text-xs text-slate-600 leading-normal sm:leading-relaxed font-medium mb-2 sm:mb-8 max-w-[420px] line-clamp-3 sm:line-clamp-none">
                                SK Solutions is a Digital Growth Partner dedicated to helping businesses build a strong online presence and achieve measurable results.
                            </p>
                            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1 bg-indigo-800 hover:bg-indigo-900 text-white px-2 py-1 xs:px-3 xs:py-1.5 sm:px-6 sm:py-3.5 rounded-md sm:rounded-xl font-bold text-[8px] xs:text-[9px] sm:text-sm shadow-[0_4px_10px_rgba(55,48,163,0.3)] transition-all hover:scale-105 active:scale-95 group">
                                Explore <i data-lucide="arrow-right" class="w-2.5 h-2.5 sm:w-4 sm:h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                        
                        <!-- Right Column (Mockup) -->
                        <div class="w-[42%] lg:flex-1 flex justify-center lg:justify-end z-10 relative mt-0">
                            <div class="relative w-full max-w-[150px] xs:max-w-[190px] sm:max-w-[290px] md:max-w-[360px] lg:max-w-[540px] h-[125px] xs:h-[160px] sm:h-[230px] md:h-[280px] lg:h-[400px] flex justify-center items-center">
                                <img src="{{ asset('storage/banners/hero_mockup.png') }}" alt="Dashboard Mockup" class="w-full h-full object-contain drop-shadow-2xl">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Dynamic Social Ads -->
                    <div class="w-full shrink-0 px-4 py-6 xs:px-6 xs:py-8 sm:px-12 sm:py-16 lg:px-20 lg:py-24 flex flex-row items-center justify-between gap-2 sm:gap-6 lg:gap-10">
                        <!-- Left Column -->
                        <div class="w-[58%] lg:flex-1 text-left flex flex-col items-start z-10">
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-purple-100 text-purple-800 text-[8px] sm:text-[10px] font-bold tracking-wider uppercase mb-1.5 sm:mb-4">
                                <i data-lucide="trending-up" class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5"></i> MARKETING
                            </span>
                            <h1 class="text-[14px]/[16px] xs:text-[20px]/[22px] sm:text-3xl md:text-4xl lg:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight mb-1 sm:mb-4 select-none">
                                TARGETED <br>
                                <span class="text-indigo-850">CAMPAIGNS</span> <span class="script-font text-indigo-700 font-normal ml-1 text-[13px] xs:text-[18px] sm:text-2xl lg:text-4xl">Delivered</span>
                            </h1>
                            <h2 class="text-[8px] sm:text-sm font-bold text-slate-800 mb-1 sm:mb-3 tracking-tight">Reach the Right Audience. Maximize ROI.</h2>
                            <p class="text-[7.5px] xs:text-[8.5px] sm:text-xs text-slate-600 leading-normal sm:leading-relaxed font-medium mb-2 sm:mb-8 max-w-[420px] line-clamp-3 sm:line-clamp-none">
                                Scale your brand using data-driven Facebook, Instagram, Google, and YouTube ads designed to capture attention and convert visitors.
                            </p>
                            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1 bg-indigo-800 hover:bg-indigo-900 text-white px-2 py-1 xs:px-3 xs:py-1.5 sm:px-6 sm:py-3.5 rounded-md sm:rounded-xl font-bold text-[8px] xs:text-[9px] sm:text-sm shadow-[0_4px_10px_rgba(55,48,163,0.3)] transition-all hover:scale-105 active:scale-95 group">
                                Ads Services <i data-lucide="arrow-right" class="w-2.5 h-2.5 sm:w-4 sm:h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                        
                        <!-- Right Column (Mockup) -->
                        <div class="w-[42%] lg:flex-1 flex justify-center lg:justify-end z-10 relative mt-0">
                            <div class="relative w-full max-w-[150px] xs:max-w-[190px] sm:max-w-[290px] md:max-w-[360px] lg:max-w-[540px] h-[125px] xs:h-[160px] sm:h-[230px] md:h-[280px] lg:h-[400px] flex justify-center items-center">
                                <img src="{{ asset('storage/banners/srv_fb.png') }}" alt="Social Media Ads" class="w-full h-full object-contain drop-shadow-2xl">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Web & App Dev -->
                    <div class="w-full shrink-0 px-4 py-6 xs:px-6 xs:py-8 sm:px-12 sm:py-16 lg:px-20 lg:py-24 flex flex-row items-center justify-between gap-2 sm:gap-6 lg:gap-10">
                        <!-- Left Column -->
                        <div class="w-[58%] lg:flex-1 text-left flex flex-col items-start z-10">
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-fuchsia-100 text-fuchsia-800 text-[8px] sm:text-[10px] font-bold tracking-wider uppercase mb-1.5 sm:mb-4">
                                <i data-lucide="code" class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5"></i> WEB SOLUTIONS
                            </span>
                            <h1 class="text-[14px]/[16px] xs:text-[20px]/[22px] sm:text-3xl md:text-4xl lg:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight mb-1 sm:mb-4 select-none">
                                PREMIUM <br>
                                <span class="text-indigo-850">WEBSITES</span> <span class="script-font text-indigo-700 font-normal ml-1 text-[13px] xs:text-[18px] sm:text-2xl lg:text-4xl">Built</span>
                            </h1>
                            <h2 class="text-[8px] sm:text-sm font-bold text-slate-800 mb-1 sm:mb-3 tracking-tight">Stunning Designs. High Speed.</h2>
                            <p class="text-[7.5px] xs:text-[8.5px] sm:text-xs text-slate-600 leading-normal sm:leading-relaxed font-medium mb-2 sm:mb-8 max-w-[420px] line-clamp-3 sm:line-clamp-none">
                                Get premium custom e-commerce stores, informative corporate websites, and mobile applications built with cutting-edge tools to secure your market lead.
                            </p>
                            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1 bg-indigo-800 hover:bg-indigo-900 text-white px-2 py-1 xs:px-3 xs:py-1.5 sm:px-6 sm:py-3.5 rounded-md sm:rounded-xl font-bold text-[8px] xs:text-[9px] sm:text-sm shadow-[0_4px_10px_rgba(55,48,163,0.3)] transition-all hover:scale-105 active:scale-95 group">
                                Web Services <i data-lucide="arrow-right" class="w-2.5 h-2.5 sm:w-4 sm:h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                        
                        <!-- Right Column (Mockup) -->
                        <div class="w-[42%] lg:flex-1 flex justify-center lg:justify-end z-10 relative mt-0">
                            <div class="relative w-full max-w-[150px] xs:max-w-[190px] sm:max-w-[290px] md:max-w-[360px] lg:max-w-[540px] h-[125px] xs:h-[160px] sm:h-[230px] md:h-[280px] lg:h-[400px] flex justify-center items-center">
                                <img src="{{ asset('storage/banners/srv_ecommerce.png') }}" alt="Web Development" class="w-full h-full object-contain drop-shadow-2xl">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Slide Dots Indicator -->
            <div class="flex justify-center gap-2 mt-6">
                <button @click="activeSlide = 0" class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none" :class="activeSlide === 0 ? 'bg-indigo-800 w-6' : 'bg-slate-200 hover:bg-slate-350'"></button>
                <button @click="activeSlide = 1" class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none" :class="activeSlide === 1 ? 'bg-indigo-800 w-6' : 'bg-slate-200 hover:bg-slate-350'"></button>
                <button @click="activeSlide = 2" class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none" :class="activeSlide === 2 ? 'bg-indigo-800 w-6' : 'bg-slate-200 hover:bg-slate-350'"></button>
            </div>
        </div>
    </div>
</section>

<!-- OUR SERVICES -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="flex items-center justify-between mb-6 md:mb-10">
        <h3 class="text-sm sm:text-base md:text-lg font-black text-slate-900  tracking-tight">Our  Services</h3>
        <a href="{{ route('services.index') }}" class="text-[11px] sm:text-xs md:text-sm font-bold text-indigo-850 hover:text-indigo-900 transition-colors flex items-center gap-1 group">
            View All <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
        </a>
    </div>

    @php
        $getServiceRoute = function($keyword, $fallbackSlug = null) use ($servicesByCategory) {
            $services = $servicesByCategory->flatten(1);
            $match = $services->first(function($svc) use ($keyword) {
                return str_contains(strtolower($svc->name), strtolower($keyword)) || 
                       str_contains(strtolower($svc->slug), strtolower($keyword)) ||
                       str_contains(strtolower($svc->category), strtolower($keyword));
            });
            if ($match) {
                return route('services.show', $match->slug);
            }
            if ($fallbackSlug) {
                $fallbackMatch = $services->firstWhere('slug', $fallbackSlug);
                if ($fallbackMatch) {
                    return route('services.show', $fallbackMatch->slug);
                }
            }
            return route('services.index');
        };

        // Helper to find premium match for services that don't have user banners
        $findPremiumMatch = function($name) {
            $nameLower = strtolower($name);
            $mapping = [
                'web' => [
                    'bg' => 'from-indigo-50 to-purple-100/40',
                    'img' => asset('storage/banners/srv_web.png'),
                    'icon' => 'globe',
                    'icon_color' => 'text-indigo-600'
                ],
                'app' => [
                    'bg' => 'from-rose-50 to-pink-100/40',
                    'img' => asset('storage/banners/srv_app.png'),
                    'icon' => 'smartphone',
                    'icon_color' => 'text-rose-600'
                ],
                'video' => [
                    'bg' => 'from-amber-50 to-orange-100/40',
                    'img' => asset('storage/banners/srv_video.png'),
                    'icon' => 'video',
                    'icon_color' => 'text-amber-600'
                ],
                'graphics' => [
                    'bg' => 'from-emerald-50 to-teal-100/40',
                    'img' => asset('storage/banners/srv_graphics.png'),
                    'icon' => 'palette',
                    'icon_color' => 'text-emerald-600'
                ],
                'seo' => [
                    'bg' => 'from-sky-50 to-blue-100/40',
                    'img' => asset('storage/banners/srv_seo.png'),
                    'icon' => 'search',
                    'icon_color' => 'text-sky-600'
                ],
                'marketing' => [
                    'bg' => 'from-violet-50 to-purple-100/40',
                    'img' => asset('storage/banners/srv_marketing.png'),
                    'icon' => 'megaphones',
                    'icon_color' => 'text-violet-600'
                ]
            ];
            
            foreach ($mapping as $key => $data) {
                if (str_contains($nameLower, $key)) {
                    return $data;
                }
            }
            return null;
        };
    @endphp

    <!-- Responsive Grid utilizing gap-px structure for a beautiful border layout -->
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-px bg-slate-200 rounded-[24px] overflow-hidden shadow-sm border border-slate-200">
        
        @foreach($servicesByCategory->flatten(1) as $svc)
        @php
            $match = $findPremiumMatch($svc->name);
            $icon = $match ? $match['icon'] : 'layout-grid';
            $icon_color = $match ? $match['icon_color'] : 'text-slate-500';
            $bg = $match ? $match['bg'] : 'from-slate-50 to-slate-100';
        @endphp
        <a href="{{ route('services.show', $svc->slug) }}" class="service-card bg-white flex flex-col items-center justify-center group hover:bg-indigo-50/30 transition-all duration-300 overflow-hidden min-h-[120px] sm:min-h-[150px] p-3 sm:p-4 text-center">
            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br {{ $bg }} flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-white/50">
                <i data-lucide="{{ $icon }}" class="w-5 h-5 sm:w-7 sm:h-7 {{ $icon_color }}"></i>
            </div>
            <span class="text-[9.5px] sm:text-xs font-bold text-slate-800 leading-tight line-clamp-2">{{ $svc->name }}</span>
        </a>
        @endforeach
        
    </div>
</section>

<!-- WHY CHOOSE US -->
<section id="why-choose-us" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16 lg:mb-8 scroll-mt-20">
    <h3 class="text-xs sm:text-sm md:text-base font-black text-slate-900 mb-6 md:mb-10 tracking-tight ">Why Choose SK Solutions</h3>
    
    <!-- Mobile/Tablet Layout: row of 4 icons. Desktop Layout: Full SaaS detail cards. -->
    <div class="grid grid-cols-4 lg:grid-cols-4 gap-2 sm:gap-4 lg:gap-8">
        
        <!-- Trusted by Thousands -->
        <div class="flex flex-col items-center text-center p-1.5 sm:p-3 lg:p-8 bg-transparent lg:bg-white lg:border lg:border-slate-100 lg:rounded-[24px] lg:shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full bg-indigo-50 flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform duration-300 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="users" class="w-5 h-5 lg:w-6 lg:h-6 text-indigo-800" fill="currentColor" stroke="none"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] lg:text-lg font-black text-slate-850 text-slate-800 leading-tight">Trusted by Thousands</span>
            <p class="hidden lg:block text-xs text-slate-500 mt-3 font-semibold leading-relaxed">Over 10,000+ businesses globally trust us to deliver high conversion rates, modern designs, and secure setups.</p>
        </div>

        <!-- Secure & Reliable -->
        <div class="flex flex-col items-center text-center p-1.5 sm:p-3 lg:p-8 bg-transparent lg:bg-white lg:border lg:border-slate-100 lg:rounded-[24px] lg:shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full bg-indigo-50 flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform duration-300 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="shield-check" class="w-5 h-5 lg:w-6 lg:h-6 text-indigo-800" fill="currentColor" stroke="white"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] lg:text-lg font-black text-slate-850 text-slate-800 leading-tight">Secure & Reliable</span>
            <p class="hidden lg:block text-xs text-slate-500 mt-3 font-semibold leading-relaxed">Enterprise-grade security standards and stable hosting guarantees to keep your systems running smoothly 24/7.</p>
        </div>

        <!-- Grow Your Business -->
        <div class="flex flex-col items-center text-center p-1.5 sm:p-3 lg:p-8 bg-transparent lg:bg-white lg:border lg:border-slate-100 lg:rounded-[24px] lg:shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full bg-indigo-50 flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform duration-300 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="trending-up" class="w-5 h-5 lg:w-6 lg:h-6 text-indigo-800" stroke-width="3"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] lg:text-lg font-black text-slate-850 text-slate-800 leading-tight">Grow Your Business</span>
            <p class="hidden lg:block text-xs text-slate-500 mt-3 font-semibold leading-relaxed">Targeted digital marketing campaigns and sales funnels custom-tailored to skyrocket your conversion metrics.</p>
        </div>

        <!-- Dedicated Support -->
        <div class="flex flex-col items-center text-center p-1.5 sm:p-3 lg:p-8 bg-transparent lg:bg-white lg:border lg:border-slate-100 lg:rounded-[24px] lg:shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full bg-indigo-50 flex items-center justify-center mb-2 lg:mb-5 group-hover:scale-110 transition-transform duration-300 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="headphones" class="w-5 h-5 lg:w-6 lg:h-6 text-indigo-800"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] lg:text-lg font-black text-slate-850 text-slate-800 leading-tight">Dedicated Support</span>
            <p class="hidden lg:block text-xs text-slate-500 mt-3 font-semibold leading-relaxed">Our support managers are online around the clock to assist you with active setups, reviews, and modifications.</p>
        </div>
    </div>
</section>

<!-- Desktop Footer (hidden on mobile, visible on desktop) -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- Fixed Bottom Navigation (Public Mobile Only) -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 flex items-center justify-around z-50 bottom-nav shadow-[0_-5px_20px_rgba(0,0,0,0.03)] pb-2 pt-1">
    <a href="{{ url('/') }}" class="flex flex-col items-center py-2 gap-1 w-full text-indigo-800">
        <i data-lucide="home" class="w-5 h-5" fill="currentColor" stroke="currentColor"></i>
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
        <i data-lucide="headphones" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Support</span>
    </a>
    <a href="{{ auth()->check() ? url('/dashboard') : route('login') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="user" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">{{ auth()->check() ? 'Dashboard' : 'Profile' }}</span>
    </a>
</nav>

@endsection
