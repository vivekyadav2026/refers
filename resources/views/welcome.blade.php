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
    transition: all 0.2s ease;
}
.service-card:active {
    transform: scale(0.96);
}

.bottom-nav {
    padding-bottom: env(safe-area-inset-bottom);
}
</style><!-- Top Header -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100/80 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex flex-col items-start select-none">
            <span class="text-3xl font-black text-indigo-800 leading-none tracking-tighter">SK</span>
            <span class="text-[10px] font-bold text-slate-900 uppercase tracking-widest leading-none mt-1">Solutions</span>
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
<section class="px-4 sm:px-6 lg:px-8 py-6 md:py-10 bg-white">
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
            <div class="relative overflow-hidden rounded-[24px] sm:rounded-[32px] min-h-[170px] xs:min-h-[220px] sm:min-h-[300px] md:min-h-[360px] lg:min-h-[480px] bg-gradient-to-br from-indigo-50 via-purple-50 to-fuchsia-50 shadow-sm border border-purple-100/50">
                
                <!-- Glow elements -->
                <div class="absolute -top-10 -right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>

                <!-- Sliding Track -->
                <div class="flex w-full transition-transform duration-500 ease-out" :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                    
                    <!-- Slide 1: Grow Your Business -->
                    <div class="w-full shrink-0 px-3 py-4 xs:px-5 xs:py-6 sm:px-10 sm:py-12 lg:p-16 flex flex-row items-center justify-between gap-2 sm:gap-6 lg:gap-10">
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
                            <div class="relative w-full max-w-[120px] xs:max-w-[160px] sm:max-w-[240px] md:max-w-[300px] lg:max-w-[440px] h-[100px] xs:h-[130px] sm:h-[180px] md:h-[220px] lg:h-[320px] flex justify-center items-center">
                                <img src="{{ asset('storage/banners/hero_mockup.png') }}" alt="Dashboard Mockup" class="w-full h-full object-contain drop-shadow-2xl">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Dynamic Social Ads -->
                    <div class="w-full shrink-0 px-3 py-4 xs:px-5 xs:py-6 sm:px-10 sm:py-12 lg:p-16 flex flex-row items-center justify-between gap-2 sm:gap-6 lg:gap-10">
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
                            <div class="relative w-full max-w-[120px] xs:max-w-[160px] sm:max-w-[240px] md:max-w-[300px] lg:max-w-[440px] h-[100px] xs:h-[130px] sm:h-[180px] md:h-[220px] lg:h-[320px] flex justify-center items-center">
                                <img src="{{ asset('storage/banners/srv_fb.png') }}" alt="Social Media Ads" class="w-full h-full object-contain drop-shadow-2xl">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Web & App Dev -->
                    <div class="w-full shrink-0 px-3 py-4 xs:px-5 xs:py-6 sm:px-10 sm:py-12 lg:p-16 flex flex-row items-center justify-between gap-2 sm:gap-6 lg:gap-10">
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
                            <div class="relative w-full max-w-[120px] xs:max-w-[160px] sm:max-w-[240px] md:max-w-[300px] lg:max-w-[440px] h-[100px] xs:h-[130px] sm:h-[180px] md:h-[220px] lg:h-[320px] flex justify-center items-center">
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
        <h3 class="text-sm sm:text-base md:text-lg font-black text-slate-900 uppercase tracking-tight">OUR SERVICES</h3>
        <a href="{{ route('services.index') }}" class="text-[11px] sm:text-xs md:text-sm font-bold text-indigo-850 hover:text-indigo-900 transition-colors flex items-center gap-1 group">
            View All <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
        </a>
    </div>

    <!-- Responsive Grid utilizing gap-px structure for a beautiful border layout -->
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-px bg-slate-150 bg-slate-200 rounded-[24px] overflow-hidden shadow-sm border border-slate-200">
        
        <!-- E-commerce -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 text-indigo-800 flex items-center justify-center">
                <i data-lucide="shopping-cart" class="w-7 h-7 group-hover:scale-110 transition-transform duration-350"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">E-commerce Website Design & Development</span>
        </a>

        <!-- Informative Website -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 text-slate-850 text-slate-700 flex items-center justify-center">
                <i data-lucide="layout-template" class="w-7 h-7 group-hover:scale-110 transition-transform duration-350"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">Informative Website Design & Development</span>
        </a>

        <!-- Facebook Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 text-[#1877F2] flex items-center justify-center">
                <i data-lucide="facebook" class="w-7 h-7 group-hover:scale-110 transition-transform duration-350" fill="currentColor" stroke="none"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">Facebook Ads</span>
        </a>

        <!-- Instagram Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 flex items-center justify-center">
                <svg class="w-7 h-7 group-hover:scale-110 transition-transform duration-350" viewBox="0 0 24 24" fill="none" stroke="url(#ig-grad-home)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <defs>
                        <linearGradient id="ig-grad-home" x1="2" y1="2" x2="22" y2="22">
                            <stop offset="0%" stop-color="#f58529" />
                            <stop offset="50%" stop-color="#dd2a7b" />
                            <stop offset="100%" stop-color="#8134af" />
                        </linearGradient>
                    </defs>
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">Instagram Ads</span>
        </a>

        <!-- Google Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 flex items-center justify-center">
                <svg class="w-7 h-7 group-hover:scale-110 transition-transform duration-350" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.766 12.2764C23.766 11.4607 23.6999 10.6406 23.5588 9.83807H12.24V14.4591H18.7217C18.4528 15.9494 17.5885 17.2678 16.323 18.1056V21.1039H20.19C22.4608 19.0139 23.766 15.9274 23.766 12.2764Z" fill="#4285F4"/>
                    <path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3276 18.1056C15.2543 18.8378 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/>
                    <path d="M5.50253 14.3003C5.00047 12.8099 5.00047 11.1961 5.50253 9.70575V6.61481H1.51649C-0.18551 10.0056 -0.18551 14.0004 1.51649 17.3912L5.50253 14.3003Z" fill="#FBBC05"/>
                    <path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.08427 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/>
                </svg>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">Google Ads</span>
        </a>

        <!-- YouTube Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 text-[#FF0000] flex items-center justify-center">
                <i data-lucide="youtube" class="w-7 h-7 group-hover:scale-110 transition-transform duration-350" fill="currentColor" stroke="none"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">YouTube Ads</span>
        </a>

        <!-- SEO -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 text-indigo-850 text-indigo-800 flex items-center justify-center">
                <i data-lucide="search" class="w-7 h-7 group-hover:scale-110 transition-transform duration-350" stroke-width="3"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">SEO (Search Engine Optimization)</span>
        </a>

        <!-- Reels & Video -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 text-indigo-850 text-indigo-850 flex items-center justify-center">
                <i data-lucide="clapperboard" class="w-7 h-7 group-hover:scale-110 transition-transform duration-350" stroke-width="2.5" fill="currentColor" stroke="white"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">Reels & Video Editing</span>
        </a>

        <!-- Mobile App -->
        <a href="{{ route('services.index') }}" class="service-card p-3 sm:p-5 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[115px] sm:min-h-[145px]">
            <div class="w-10 h-10 mb-2 text-indigo-850 text-indigo-800 flex items-center justify-center">
                <i data-lucide="smartphone" class="w-7 h-7 group-hover:scale-110 transition-transform duration-350" stroke-width="2.5"></i>
            </div>
            <span class="text-[9px] sm:text-[11px] md:text-xs font-bold text-slate-800 leading-tight">Mobile App Development</span>
        </a>
        
    </div>
</section>

<!-- WHY CHOOSE US -->
<section id="why-choose-us" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16 mb-16 lg:mb-8 scroll-mt-20">
    <h3 class="text-xs sm:text-sm md:text-base font-black text-slate-900 mb-6 md:mb-10 tracking-tight uppercase">Why Choose SK Solutions</h3>
    
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
    <a href="{{ route('login') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="file-text" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Orders</span>
    </a>
    <a href="{{ route('contact') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="headphones" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Support</span>
    </a>
    <a href="{{ route('login') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="user" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Profile</span>
    </a>
</nav>

@endsection
