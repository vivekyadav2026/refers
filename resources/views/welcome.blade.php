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
</style>

<!-- Top Header -->
<header class="flex items-center justify-between px-5 py-4 bg-white sticky top-0 z-50">
    <div class="flex flex-col">
        <span class="text-3xl font-black text-indigo-800 leading-none tracking-tighter">SK</span>
        <span class="text-[10px] font-bold text-slate-900 uppercase tracking-widest leading-none mt-1">Solutions</span>
    </div>
    <div class="relative">
        <i data-lucide="bell" class="w-6 h-6 text-slate-700"></i>
        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
    </div>
</header>

<!-- Hero Section -->
<section class="px-5 pt-8 pb-10 bg-gradient-to-br from-purple-50 via-white to-fuchsia-50 rounded-b-[40px] relative overflow-hidden">
    <!-- Glow effect -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 left-0 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

    <div class="relative z-10">
        <h1 class="text-[40px] sm:text-5xl font-black text-slate-900 leading-[1.1] tracking-tight mb-4">
            GROW YOUR <br>
            <span class="text-indigo-800">BUSINESS</span> <span class="script-font text-indigo-700 font-normal ml-1">Online</span>
        </h1>
        
        <h2 class="text-[15px] font-bold text-slate-800 mb-3 tracking-tight">Smart Solutions. Better Results. More Growth.</h2>
        
        <p class="text-[11px] text-slate-600 leading-relaxed font-medium mb-8 max-w-[280px]">
            SK Solutions is a Digital Growth Partner dedicated to helping businesses build a strong online presence and achieve measurable results through innovative strategies, creative designs and performance-driven solutions.
        </p>

        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 bg-indigo-800 text-white px-6 py-3.5 rounded-xl font-bold text-sm shadow-[0_8px_20px_rgba(55,48,163,0.3)] hover:bg-indigo-900 transition-all active:scale-95">
            Explore Services <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>

        <!-- Hero Mockup Image -->
        <div class="mt-10 relative flex justify-center">
            <img src="{{ asset('storage/banners/hero_mockup.png') }}" alt="SK Solutions Dashboard" class="w-full max-w-sm drop-shadow-2xl object-contain h-[280px]">
        </div>
        
        <!-- Pagination dots -->
        <div class="flex justify-center gap-1.5 mt-6">
            <div class="w-2 h-2 rounded-full bg-indigo-800"></div>
            <div class="w-2 h-2 rounded-full bg-slate-200"></div>
            <div class="w-2 h-2 rounded-full bg-slate-200"></div>
        </div>
    </div>
</section>

<!-- OUR SERVICES -->
<section class="px-5 py-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-tight">OUR SERVICES</h3>
        <a href="{{ route('services.index') }}" class="text-[11px] font-bold text-indigo-800 flex items-center gap-1">
            View All <i data-lucide="arrow-right" class="w-3 h-3"></i>
        </a>
    </div>

    <div class="grid grid-cols-3 gap-0 border border-slate-100 rounded-[24px] overflow-hidden bg-white shadow-sm">
        
        <!-- E-commerce -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-r border-b border-slate-100 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 text-indigo-800 flex items-center justify-center">
                <i data-lucide="shopping-cart" class="w-7 h-7 group-hover:scale-110 transition-transform"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">E-commerce Website Design & Development</span>
        </a>

        <!-- Informative Website -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-b border-slate-100 border-r flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 text-slate-800 flex items-center justify-center">
                <i data-lucide="layout-template" class="w-7 h-7 group-hover:scale-110 transition-transform"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">Informative Website Design & Development</span>
        </a>

        <!-- Facebook Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-b border-slate-100 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 text-[#1877F2] flex items-center justify-center">
                <i data-lucide="facebook" class="w-7 h-7 group-hover:scale-110 transition-transform" fill="currentColor" stroke="none"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">Facebook Ads</span>
        </a>

        <!-- Instagram Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-b border-r border-slate-100 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 flex items-center justify-center">
                <!-- IG Gradient Icon -->
                <svg class="w-7 h-7 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="url(#ig-grad)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <defs>
                        <linearGradient id="ig-grad" x1="2" y1="2" x2="22" y2="22">
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
            <span class="text-[9px] font-bold text-slate-800 leading-tight">Instagram Ads</span>
        </a>

        <!-- Google Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-r border-b border-slate-100 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 flex items-center justify-center">
                <svg class="w-7 h-7 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.766 12.2764C23.766 11.4607 23.6999 10.6406 23.5588 9.83807H12.24V14.4591H18.7217C18.4528 15.9494 17.5885 17.2678 16.323 18.1056V21.1039H20.19C22.4608 19.0139 23.766 15.9274 23.766 12.2764Z" fill="#4285F4"/>
                    <path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3276 18.1056C15.2543 18.8378 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/>
                    <path d="M5.50253 14.3003C5.00047 12.8099 5.00047 11.1961 5.50253 9.70575V6.61481H1.51649C-0.18551 10.0056 -0.18551 14.0004 1.51649 17.3912L5.50253 14.3003Z" fill="#FBBC05"/>
                    <path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.08427 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/>
                </svg>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">Google Ads</span>
        </a>

        <!-- YouTube Ads -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-b border-slate-100 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 text-[#FF0000] flex items-center justify-center">
                <i data-lucide="youtube" class="w-7 h-7 group-hover:scale-110 transition-transform" fill="currentColor" stroke="none"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">YouTube Ads</span>
        </a>

        <!-- SEO -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-r border-slate-100 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 text-indigo-800 flex items-center justify-center">
                <i data-lucide="search" class="w-7 h-7 group-hover:scale-110 transition-transform" stroke-width="3"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">SEO (Search Engine Optimization)</span>
        </a>

        <!-- Reels & Video -->
        <a href="{{ route('services.index') }}" class="service-card p-4 border-r border-slate-100 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 text-indigo-800 flex items-center justify-center">
                <i data-lucide="clapperboard" class="w-7 h-7 group-hover:scale-110 transition-transform" stroke-width="2.5" fill="currentColor" stroke="white"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">Reels & Video Editing</span>
        </a>

        <!-- Mobile App -->
        <a href="{{ route('services.index') }}" class="service-card p-4 flex flex-col items-center text-center group hover:bg-slate-50">
            <div class="w-10 h-10 mb-2 text-indigo-800 flex items-center justify-center">
                <i data-lucide="smartphone" class="w-7 h-7 group-hover:scale-110 transition-transform" stroke-width="2.5"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">Mobile App Development</span>
        </a>
        
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="px-5 py-6 mb-24">
    <h3 class="text-[13px] font-black text-slate-900 mb-6 tracking-tight">Why Choose SK Solutions</h3>
    
    <div class="flex justify-between items-start">
        <div class="flex flex-col items-center text-center w-[23%]">
            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center mb-2 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="users" class="w-5 h-5 text-indigo-800" fill="currentColor" stroke="none"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-700 leading-tight">Trusted by<br>Thousands</span>
        </div>
        <div class="flex flex-col items-center text-center w-[23%]">
            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center mb-2 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="shield-check" class="w-5 h-5 text-indigo-800" fill="currentColor" stroke="white"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-700 leading-tight">Secure &<br>Reliable</span>
        </div>
        <div class="flex flex-col items-center text-center w-[23%]">
            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center mb-2 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="trending-up" class="w-5 h-5 text-indigo-800" stroke-width="3"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-700 leading-tight">Grow Your<br>Business</span>
        </div>
        <div class="flex flex-col items-center text-center w-[23%]">
            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center mb-2 shadow-[inset_0_1px_2px_rgba(0,0,0,0.05)]">
                <i data-lucide="headphones" class="w-5 h-5 text-indigo-800"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-700 leading-tight">Dedicated<br>Support</span>
        </div>
    </div>
</section>

<!-- Fixed Bottom Navigation (Public) -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 flex items-center justify-around z-50 bottom-nav shadow-[0_-5px_20px_rgba(0,0,0,0.03)] pb-2 pt-1">
    <a href="{{ url('/') }}" class="flex flex-col items-center py-2 gap-1 w-full text-indigo-800">
        <i data-lucide="home" class="w-5 h-5" fill="currentColor" stroke="currentColor"></i>
        <span class="text-[10px] font-bold">Home</span>
    </a>
    <a href="{{ route('services.index') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400">
        <i data-lucide="grid-3x3" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Services</span>
    </a>
    <a href="{{ route('login') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400">
        <i data-lucide="file-text" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Orders</span>
    </a>
    <a href="{{ route('contact') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400">
        <i data-lucide="headphones" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Support</span>
    </a>
    <a href="{{ route('login') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400">
        <i data-lucide="user" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Profile</span>
    </a>
</nav>

@endsection
