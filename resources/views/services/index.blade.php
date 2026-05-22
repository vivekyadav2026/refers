@extends('layouts.app')
@section('title', 'Services — SKSolutions Digital Agency')
@section('hide_nav_footer', true)

@section('content')

<style>
/* Add the font from the design */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700;900&family=Style+Script&display=swap');

body {
    background-color: #fafafa;
    font-family: 'Outfit', sans-serif;
    -webkit-tap-highlight-color: transparent;
}

.bottom-nav {
    padding-bottom: env(safe-area-inset-bottom);
}
</style>

<!-- Responsive Sticky Top Header -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100/80 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 select-none">
            <img src="{{ asset('logo.jpg') }}" alt="SK Solutions Logo" class="h-12 sm:h-14 w-auto rounded-xl object-contain shadow-sm border border-slate-100 bg-white">
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ route('landing') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('landing') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('services.*') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Services</a>
            <a href="{{ route('landing') }}#why-choose-us" class="text-sm font-bold text-slate-600 hover:text-indigo-800 transition-colors">Why Choose Us</a>
            <a href="{{ route('contact') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('contact') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Contact</a>
        </nav>

        <!-- Right Actions -->
        <div class="flex items-center gap-4">
            <!-- Notification Bell with Alpine Dropdown -->
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
                             <div class="text-[10px] text-slate-500 truncate mt-0.5">{{ $user->email ?: $user->phone }}</div>
                         </div>
                         <div class="py-1.5">
                             <a href="{{ $dashUrl }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-indigo-800 transition-colors">
                                 <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                             </a>
                             <form method="POST" action="{{ route('logout') }}" class="w-full m-0">
                                 @csrf
                                 <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-650 hover:bg-red-50 hover:text-red-700 transition-colors text-left border-none bg-transparent cursor-pointer">
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

<!-- Services Hero Header -->
<section class="px-4 sm:px-6 lg:px-8 py-12 md:py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto text-center flex flex-col items-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 text-[10px] font-bold tracking-wider uppercase mb-4">
            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Discover Services
        </span>
        <h1 class="text-3.5xl sm:text-5xl font-black text-slate-900 leading-tight tracking-tight mb-4 select-none">
            Tailored Digital <span class="text-indigo-800">Services</span>
        </h1>
        <p class="text-xs sm:text-sm md:text-base text-slate-500 max-w-xl leading-relaxed font-semibold">
            Explore our bespoke web development, performance marketing, and creative production services customized to skyrocket your brand.
        </p>
    </div>
</section>

@php
  // Define mapping of name substrings to custom generated 3D images and specific theme styling.
  $premiumMappingRules = [
      'e-commerce' => [
          'img' => asset('storage/banners/srv_ecommerce.png'),
          'bg' => 'from-indigo-50 to-purple-50',
          'icon_color' => 'text-indigo-700',
          'icon' => 'shopping-cart'
      ],
      'web' => [
          'img' => asset('storage/banners/srv_web.png'),
          'bg' => 'from-blue-50 to-indigo-50',
          'icon_color' => 'text-blue-700',
          'icon' => 'layout-template'
      ],
      'app' => [
          'img' => asset('storage/banners/srv_app.png'),
          'bg' => 'from-sky-50 to-indigo-100',
          'icon_color' => 'text-sky-750 text-indigo-800',
          'icon' => 'smartphone'
      ],
      'facebook' => [
          'img' => asset('storage/banners/srv_fb.png'),
          'bg' => 'from-blue-50 to-blue-100',
          'icon_color' => 'text-[#1877F2]',
          'icon' => 'facebook'
      ],
      'instagram' => [
          'img' => asset('storage/banners/srv_ig.png'),
          'bg' => 'from-pink-50 to-rose-100',
          'icon_color' => 'text-pink-600',
          'icon' => 'instagram'
      ],
      'google' => [
          'img' => asset('storage/banners/srv_google.png'),
          'bg' => 'from-green-50 to-emerald-100',
          'icon_color' => 'text-green-600',
          'icon' => 'bar-chart'
      ],
      'youtube' => [
          'img' => asset('storage/banners/srv_yt.png'),
          'bg' => 'from-red-50 to-rose-100',
          'icon_color' => 'text-red-600',
          'icon' => 'youtube'
      ],
      'seo' => [
          'img' => asset('storage/banners/srv_seo.png'),
          'bg' => 'from-purple-50 to-fuchsia-100',
          'icon_color' => 'text-purple-700',
          'icon' => 'search'
      ],
      'video' => [
          'img' => asset('storage/banners/srv_reels.png'),
          'bg' => 'from-fuchsia-50 to-pink-100',
          'icon_color' => 'text-fuchsia-700',
          'icon' => 'clapperboard'
      ],
      'reels' => [
          'img' => asset('storage/banners/srv_reels.png'),
          'bg' => 'from-fuchsia-50 to-pink-100',
          'icon_color' => 'text-fuchsia-700',
          'icon' => 'clapperboard'
      ],
      'ui/ux' => [
          'img' => asset('storage/banners/srv_web.png'),
          'bg' => 'from-amber-50 to-orange-100',
          'icon_color' => 'text-orange-700',
          'icon' => 'palette'
      ],
      'figma' => [
          'img' => asset('storage/banners/srv_web.png'),
          'bg' => 'from-amber-50 to-orange-100',
          'icon_color' => 'text-orange-700',
          'icon' => 'palette'
      ],
      'chatbot' => [
          'img' => asset('storage/banners/srv_web.png'),
          'bg' => 'from-violet-50 to-indigo-100',
          'icon_color' => 'text-violet-700',
          'icon' => 'message-square'
      ],
      'ai' => [
          'img' => asset('storage/banners/srv_web.png'),
          'bg' => 'from-violet-50 to-indigo-100',
          'icon_color' => 'text-violet-755 text-violet-700',
          'icon' => 'cpu'
      ]
  ];

  $findPremiumMatch = function ($serviceName) use ($premiumMappingRules) {
      $lowerName = strtolower($serviceName);
      foreach ($premiumMappingRules as $key => $mapping) {
          if (str_contains($lowerName, $key)) {
              return $mapping;
          }
      }
      return null;
  };

  $categoryIcons = [
      'Web Development' => 'layout-template',
      'App Development' => 'smartphone',
      'Digital Marketing' => 'trending-up',
      'Video Editing' => 'clapperboard',
      'Design & Branding' => 'palette',
      'AI & Automation' => 'cpu',
  ];

  $allSvcs = $servicesByCategory->flatten(1);
@endphp

<!-- Category Selector Tabs -->
<div class="mt-8 mb-10 max-w-7xl mx-auto px-4">
    <!-- Horizontal Scroll wrapper for Mobile, centered flex for Desktop -->
    <div class="flex items-center gap-3 overflow-x-auto pb-4 scrollbar-hide -mx-4 px-4 sm:mx-0 sm:px-0 sm:justify-center">
        <!-- "All Services" Tab -->
        <a href="{{ route('services.index') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm shrink-0 border transition-all duration-300 {{ !$selectedCategory ? 'bg-indigo-800 border-indigo-800 text-white shadow-lg shadow-indigo-800/20' : 'bg-white border-slate-200 text-slate-600 hover:text-indigo-800 hover:border-indigo-100 shadow-sm' }}">
            <i data-lucide="grid-3x3" class="w-4 h-4"></i>
            <span>All Services</span>
        </a>
        
        <!-- Loop categories -->
        @foreach($allCategories as $cat)
        @php
            $catIcon = $categoryIcons[$cat] ?? 'box';
            $isActive = $selectedCategory === $cat;
        @endphp
        <a href="{{ route('services.index', ['category' => $cat]) }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm shrink-0 border transition-all duration-300 {{ $isActive ? 'bg-indigo-800 border-indigo-800 text-white shadow-lg shadow-indigo-800/20' : 'bg-white border-slate-200 text-slate-600 hover:text-indigo-800 hover:border-indigo-100 shadow-sm' }}">
            <i data-lucide="{{ $catIcon }}" class="w-4 h-4"></i>
            <span>{{ $cat }}</span>
        </a>
        @endforeach
    </div>
</div>

<!-- Services Grid Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-28 lg:pb-16">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-5 bg-transparent pb-4 px-1">
        
        @foreach($allSvcs as $svc)
        @php
            $match = $findPremiumMatch($svc->name);
            $dbIcon = $svc->icon && $svc->icon !== 'box' ? $svc->icon : null;
            $icon = $dbIcon ?? ($match ? $match['icon'] : 'layout-grid');
            $bg = $match ? $match['bg'] : 'from-slate-50 to-slate-100';
            $icon_color = $match ? $match['icon_color'] : 'text-slate-500';
        @endphp
        
        <a href="{{ route('services.show', $svc->slug) }}" class="service-card bg-white flex flex-col items-center justify-center group hover:bg-indigo-50/30 transition-all duration-300 min-h-[180px] sm:min-h-[220px] p-4 sm:p-6 text-center rounded-2xl shadow-md hover:shadow-xl hover:shadow-indigo-500/10 border border-slate-100/50 hover:-translate-y-1">
            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br {{ $bg }} flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-white/50">
                <i data-lucide="{{ $icon }}" class="w-6 h-6 sm:w-8 sm:h-8 {{ $icon_color }}"></i>
            </div>
            <span class="text-xs sm:text-sm font-bold text-slate-800 leading-tight line-clamp-2">{{ $svc->name }}</span>
            <p class="text-[10px] sm:text-[11px] text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $svc->short_description }}</p>
            @auth
                <span class="text-[10px] sm:text-xs font-bold text-indigo-600 mt-2">₹{{ number_format($svc->min_price ?? 0, 0) }}</span>
            @else
                <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 mt-2 flex items-center gap-1"><i data-lucide="lock" class="w-2.5 h-2.5"></i> Login for Pricing</span>
            @endauth
        </a>
        @endforeach

        @if($allSvcs->isEmpty())
            <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-slate-50 rounded-[32px] border border-slate-200 border-dashed">
                <i data-lucide="folder-open" class="w-12 h-12 text-slate-400 mb-4 animate-bounce"></i>
                <p class="text-slate-800 font-bold text-lg">No services found</p>
                <p class="text-slate-500 text-sm mt-1">Try selecting a different category or check back later.</p>
            </div>
        @endif

        <!-- Mobile "Why Choose SK Solutions?" Card -->
        <a href="{{ route('landing') }}#why-choose-us" class="service-card p-3 bg-white flex flex-col items-center justify-center text-center group hover:bg-indigo-50/20 transition-all duration-300 min-h-[125px] sm:hidden rounded-2xl shadow-md border border-slate-100/50">
            <div class="w-10 h-10 mb-2 text-orange-600 flex items-center justify-center bg-orange-50 rounded-full group-hover:bg-orange-100 transition-colors">
                <i data-lucide="help-circle" class="w-6 h-6 group-hover:scale-110 transition-transform duration-350" stroke-width="2.5"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-800 leading-tight">Why Choose SK Solutions?</span>
        </a>

        <!-- Desktop/Tablet Final Card: Why Choose SKSolutions -->
        <div class="hidden sm:block bg-gradient-to-br from-amber-50 to-orange-100 rounded-[32px] p-6 sm:p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300 border border-orange-200/50">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/20 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>

            <div class="flex flex-col justify-between h-full relative z-10">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center shadow-md shadow-orange-100">
                            <i data-lucide="help-circle" class="w-6 h-6 text-orange-600" stroke-width="2.5"></i>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-white/70 backdrop-blur-sm border border-orange-100 text-orange-800 text-[10px] font-bold tracking-wider uppercase">
                            Core Values
                        </span>
                    </div>
                    
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 mb-4 leading-tight tracking-tight">
                        Why Choose SK Solutions?
                    </h3>
                    
                    <ul class="space-y-3.5 mb-6">
                        <li class="flex items-center gap-3 text-xs font-bold text-slate-800">
                            <div class="w-5 h-5 rounded-full bg-orange-500/10 flex items-center justify-center shrink-0">
                                <i data-lucide="users" class="w-3 h-3 text-orange-600"></i>
                            </div>
                            Experienced Team
                        </li>
                        <li class="flex items-center gap-3 text-xs font-bold text-slate-800">
                            <div class="w-5 h-5 rounded-full bg-orange-500/10 flex items-center justify-center shrink-0">
                                <i data-lucide="award" class="w-3 h-3 text-orange-660 text-orange-600"></i>
                            </div>
                            Quality Solutions
                        </li>
                        <li class="flex items-center gap-3 text-xs font-bold text-slate-800">
                            <div class="w-5 h-5 rounded-full bg-orange-500/10 flex items-center justify-center shrink-0">
                                <i data-lucide="clock" class="w-3 h-3 text-orange-660 text-orange-600"></i>
                            </div>
                            Timely Delivery
                        </li>
                        <li class="flex items-center gap-3 text-xs font-bold text-slate-800">
                            <div class="w-5 h-5 rounded-full bg-orange-500/10 flex items-center justify-center shrink-0">
                                <i data-lucide="headphones" class="w-3 h-3 text-orange-660 text-orange-600"></i>
                            </div>
                            Dedicated Support
                        </li>
                    </ul>
                </div>

                <div class="flex items-end justify-between mt-auto gap-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-orange-500 uppercase tracking-widest leading-none">Your Success</span>
                        <span class="text-sm font-black text-slate-900 mt-1">Is Our Priority</span>
                    </div>
                    
                    <div class="w-[120px] h-[100px] flex items-center justify-end relative opacity-85 group-hover:opacity-100 transition-opacity">
                        <svg class="w-20 h-20 text-orange-500 group-hover:scale-110 transition-all duration-500 drop-shadow-xl" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="m22 2-7.5 7.5"></path>
                            <path d="M22 2v6"></path>
                            <path d="M22 2h-6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Desktop Footer (hidden on mobile/tablet, visible on desktop) -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- Fixed Bottom Navigation (Public Mobile Only) -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 flex items-center justify-around z-50 bottom-nav shadow-[0_-5px_20px_rgba(0,0,0,0.03)] pb-2 pt-1">
    <a href="{{ url('/') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400 hover:text-indigo-800 transition-colors">
        <i data-lucide="home" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Home</span>
    </a>
    <a href="{{ route('services.index') }}" class="flex flex-col items-center py-2 gap-1 w-full text-indigo-800">
        <i data-lucide="grid-3x3" class="w-5 h-5" fill="currentColor" stroke="currentColor"></i>
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
