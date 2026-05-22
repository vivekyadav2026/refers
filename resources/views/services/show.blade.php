@extends('layouts.app')
@section('title', $service->name . ' — SKSolutions Partner Network')
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

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1.05); }
    50% { transform: translateY(-8px) scale(1.07); }
}
.banner-mockup-float {
    animation: float 6s ease-in-out infinite;
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
                             <div class="text-[10px] text-slate-500 truncate mt-0.5">{{ $user->email }}</div>
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

<div x-data="{ buyNowModal: false, isProcessing: false }" 
     @processing-start.window="isProcessing = true" 
     @processing-end.window="isProcessing = false"
     class="bg-[#FAFAFA] min-h-screen relative overflow-hidden">
    
    <!-- Ambient Background Blobs -->
    <div class="absolute top-20 left-10 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[400px] right-20 w-[450px] h-[450px] bg-purple-200/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-40 left-1/4 w-[350px] h-[350px] bg-blue-200/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-28 lg:pb-16 relative z-10">
        
        {{-- BREADCRUMBS --}}
        <nav class="flex items-center gap-2.5 text-[11px] font-bold text-slate-400 mb-8 uppercase tracking-widest relative z-10">
            <a href="{{ url('/') }}" class="hover:text-indigo-800 transition-colors flex items-center gap-1.5">
                <i data-lucide="home" class="w-3.5 h-3.5"></i> Home
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <a href="{{ route('services.index') }}" class="hover:text-indigo-800 transition-colors">Services</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-indigo-800 font-extrabold">{{ $service->name }}</span>
        </nav>

        @php
            // Define mapping of name substrings to custom generated 3D images and specific theme styling.
            $premiumMappingRules = [
                'e-commerce' => [
                    'img' => asset('storage/banners/srv_ecommerce.png'),
                    'bg' => 'from-indigo-50 to-purple-50',
                    'icon' => 'shopping-cart'
                ],
                'web' => [
                    'img' => asset('storage/banners/srv_web.png'),
                    'bg' => 'from-blue-50 to-indigo-50',
                    'icon' => 'layout-template'
                ],
                'app' => [
                    'img' => asset('storage/banners/srv_app.png'),
                    'bg' => 'from-sky-50 to-indigo-100',
                    'icon' => 'smartphone'
                ],
                'facebook' => [
                    'img' => asset('storage/banners/srv_fb.png'),
                    'bg' => 'from-blue-50 to-blue-100',
                    'icon' => 'facebook'
                ],
                'instagram' => [
                    'img' => asset('storage/banners/srv_ig.png'),
                    'bg' => 'from-pink-50 to-rose-100',
                    'icon' => 'instagram'
                ],
                'google' => [
                    'img' => asset('storage/banners/srv_google.png'),
                    'bg' => 'from-green-50 to-emerald-100',
                    'icon' => 'bar-chart'
                ],
                'youtube' => [
                    'img' => asset('storage/banners/srv_yt.png'),
                    'bg' => 'from-red-50 to-rose-100',
                    'icon' => 'youtube'
                ],
                'seo' => [
                    'img' => asset('storage/banners/srv_seo.png'),
                    'bg' => 'from-purple-50 to-fuchsia-100',
                    'icon' => 'search'
                ],
                'video' => [
                    'img' => asset('storage/banners/srv_reels.png'),
                    'bg' => 'from-fuchsia-50 to-pink-100',
                    'icon' => 'clapperboard'
                ],
                'reels' => [
                    'img' => asset('storage/banners/srv_reels.png'),
                    'bg' => 'from-fuchsia-50 to-pink-100',
                    'icon' => 'clapperboard'
                ],
                'ui/ux' => [
                    'img' => asset('storage/banners/srv_web.png'),
                    'bg' => 'from-amber-50 to-orange-100',
                    'icon' => 'palette'
                ],
                'figma' => [
                    'img' => asset('storage/banners/srv_web.png'),
                    'bg' => 'from-amber-50 to-orange-100',
                    'icon' => 'palette'
                ],
                'chatbot' => [
                    'img' => asset('storage/banners/srv_web.png'),
                    'bg' => 'from-violet-50 to-indigo-100',
                    'icon' => 'message-square'
                ],
                'ai' => [
                    'img' => asset('storage/banners/srv_web.png'),
                    'bg' => 'from-violet-50 to-indigo-100',
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

            $match = $findPremiumMatch($service->name);
            $themeBg = $match ? $match['bg'] : 'from-blue-50 to-indigo-50';
            $themeImg = $match ? $match['img'] : asset('storage/banners/srv_web.png');
            $themeIcon = $match ? $match['icon'] : ($service->icon ?? 'box');
        @endphp        {{-- HERO HEADER SECTION --}}
        <div class="mb-6 max-w-4xl relative z-10">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-200/40 text-blue-700 text-[9px] font-bold uppercase tracking-wider">
                    <i data-lucide="{{ $themeIcon }}" class="w-3 h-3"></i> {{ $service->category }}
                </span>
                @if($service->is_popular)
                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-800 border border-amber-200/40 text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                    🔥 Hot Selling Service
                </span>
                @endif
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-[42px] font-black text-slate-900 tracking-tight leading-tight mb-3">
                {{ $service->name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed max-w-2xl">
                {{ $service->short_description }}
            </p>

            @auth
            <div class="flex flex-wrap items-center gap-4.5 sm:gap-6 mt-5 pt-5 border-t border-slate-200/40">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Base Client Price:</span>
                    <span class="text-lg font-black text-slate-900">₹{{ number_format($service->min_price) }}</span>
                </div>
                @if($service->delivery_timeline)
                <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Est. Delivery:</span>
                    <span class="text-xs font-bold text-indigo-750 text-indigo-700 bg-indigo-50 border border-indigo-100/60 px-2.5 py-0.5 rounded-full">{{ $service->delivery_timeline }}</span>
                </div>
                @endif
            </div>
            @else
            <div class="mt-5 pt-5 border-t border-slate-200/40">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-500 bg-slate-100 border border-slate-200/30 px-3 py-1 rounded-xl">
                    <i data-lucide="lock" class="w-3 h-3 text-slate-400"></i> Member Pricing Available After Login
                </span>
            </div>
            @endauth
        </div>

        {{-- TWO-COLUMN CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start relative z-10">
            
            {{-- LEFT COLUMN: Media, Description, Features, Requirements --}}
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">
                
                {{-- BANNER MEDIA CARD --}}
                @if($service->banner_image)
                <div class="w-full aspect-[21/9] sm:aspect-[16/7] rounded-[32px] overflow-hidden border border-slate-200/50 shadow-[0_8px_30px_rgba(0,0,0,0.015)]">
                    <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                </div>
                @else
                <!-- Fallback Banner with custom responsive layout and background mesh -->
                <div class="w-full min-h-[145px] sm:min-h-[200px] md:min-h-[240px] rounded-[32px] overflow-hidden border border-slate-200/50 shadow-[0_8px_30px_rgba(0,0,0,0.015)] bg-gradient-to-br {{ $themeBg }} flex flex-col sm:flex-row items-center justify-between p-5 sm:p-7 md:p-8 relative">
                    <!-- Dot Pattern Grid Overlay -->
                    <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] pointer-events-none opacity-80"></div>
                    <div class="absolute inset-0 bg-white/10 backdrop-blur-[1px] pointer-events-none"></div>
                    
                    <div class="relative z-10 max-w-full sm:max-w-[55%] text-center sm:text-left mb-3 sm:mb-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-600/10 border border-indigo-600/20 text-indigo-900 text-[9px] font-black uppercase tracking-wider mb-2">
                            🌟 Premium SKSolutions Asset
                        </span>
                        <h2 class="text-base sm:text-lg md:text-xl font-black text-slate-900 leading-tight tracking-tight select-none">
                            {{ $service->name }}
                        </h2>
                    </div>
                    <div class="relative z-10 w-24 h-24 sm:w-32 sm:h-32 md:w-38 md:h-38 flex items-center justify-center shrink-0">
                        <img src="{{ $themeImg }}" alt="{{ $service->name }}" class="max-w-full max-h-full drop-shadow-2xl object-contain banner-mockup-float">
                    </div>
                </div>
                @endif

                {{-- ABOUT/DESCRIPTION CARD --}}
                @if($service->description)
                <div class="bg-white rounded-[32px] p-5 sm:p-6 lg:p-7 border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.015)] relative overflow-hidden transition-all duration-300 hover:shadow-md">
                    <h3 class="text-base sm:text-lg font-black text-slate-900 mb-3 tracking-tight flex items-center gap-2">
                        <span class="w-1 h-5 bg-indigo-600 rounded-full"></span> About This Service
                    </h3>
                    <div class="prose prose-slate max-w-none text-slate-600 font-medium leading-relaxed text-xs sm:text-sm space-y-3 font-sans">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>
                @endif

                {{-- WHAT'S INCLUDED / FEATURES CARD --}}
                @if(is_array($service->features) && count($service->features) > 0)
                <div class="bg-white rounded-[32px] p-5 sm:p-6 lg:p-7 border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.015)] relative overflow-hidden transition-all duration-300 hover:shadow-md">
                    <h3 class="text-base sm:text-lg font-black text-slate-900 mb-4 tracking-tight flex items-center gap-2">
                        <span class="w-1 h-5 bg-emerald-500 rounded-full"></span> What's Included
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($service->features as $feature)
                        <div class="flex items-start gap-2.5 bg-white p-3 rounded-2xl border border-slate-100 hover:-translate-y-0.5 hover:shadow-sm hover:border-indigo-100 transition-all duration-300 group">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 shadow-sm shadow-emerald-100/50 group-hover:scale-105 transition-transform">
                                <i data-lucide="check" class="w-3.5 h-3.5" stroke-width="3"></i>
                            </div>
                            <span class="text-slate-700 font-bold text-[12px] sm:text-xs leading-snug">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- REQUIREMENTS CARD --}}
                @if($service->requirements_text)
                <div class="bg-indigo-50/10 rounded-[32px] p-5 sm:p-6 lg:p-7 border border-indigo-100/50 relative overflow-hidden transition-all duration-300 hover:shadow-sm">
                    <h3 class="text-base sm:text-lg font-black text-indigo-950 mb-2.5 tracking-tight flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 shadow-sm shadow-indigo-100/30">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        </div>
                        What We Need From You
                    </h3>
                    <div class="text-indigo-900/85 font-medium text-xs sm:text-[13px] leading-relaxed space-y-2 font-sans pl-0.5">
                        {!! nl2br(e($service->requirements_text)) !!}
                    </div>
                </div>
                @endif

            </div>

            {{-- RIGHT COLUMN: Action Forms and Packages Sidebar --}}
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">
                
                {{-- PURCHASE / LEAD CARD --}}
                <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950 rounded-[32px] p-5 sm:p-6 text-white shadow-xl border border-white/5 hover:border-indigo-500/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-36 h-36 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <h3 class="text-base sm:text-lg font-black mb-1 tracking-tight">Purchase or Refer</h3>
                    <p class="text-[10px] text-slate-400 font-medium mb-5 leading-normal">Add to cart or submit lead info to launch this project.</p>

                    @auth
                        @if(auth()->user()->isCustomer())
                        <button type="button" @click="buyNowModal = true" class="w-full py-3.5 rounded-xl text-xs font-black tracking-wide uppercase text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 mb-2 cursor-pointer">
                            <i data-lucide="zap" class="w-4 h-4"></i> Buy Now — ₹{{ number_format($service->min_price) }}
                        </button>
                        @endif

                        @if(auth()->user()->isPartner() || auth()->user()->isAdmin())
                        <div class="flex items-center gap-3 mb-4 text-[9px] text-slate-500 uppercase tracking-widest font-black">
                            <div class="h-px bg-white/10 flex-1"></div>
                            <span>Submit Lead Info</span>
                            <div class="h-px bg-white/10 flex-1"></div>
                        </div>

                        <form action="{{ route('partner.leads.store') }}" method="POST" class="space-y-3 font-sans">
                            @csrf
                            <input type="hidden" name="service_needed" value="{{ $service->name }}">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Client Full Name *</label>
                                <input type="text" name="client_name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-800 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500/35 focus:border-indigo-500 text-xs bg-slate-950/40 outline-none transition-all focus:bg-slate-950/65" placeholder="e.g. Rahul Sharma">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Client Phone Number *</label>
                                <input type="tel" name="client_phone" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-800 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500/35 focus:border-indigo-500 text-xs bg-slate-950/40 outline-none transition-all focus:bg-slate-950/65" placeholder="+91 9999999999">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Project Requirements</label>
                                <textarea name="notes" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-800 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500/35 focus:border-indigo-500 text-xs bg-slate-950/40 outline-none transition-all resize-none focus:bg-slate-950/65" placeholder="Deliverables, details..."></textarea>
                            </div>
                            <button type="submit" class="w-full py-2.5 rounded-xl text-[10px] font-black tracking-widest uppercase text-slate-900 bg-white hover:bg-slate-100 shadow-md transition-all hover:-translate-y-0.5 flex items-center justify-center gap-1.5 active:translate-y-0 cursor-pointer mt-2">
                                <i data-lucide="send" class="w-3.5 h-3.5 text-indigo-600"></i> Submit Lead
                            </button>
                        </form>
                        @endif
                    @else
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-5 text-center backdrop-blur-md mb-4">
                            <i data-lucide="lock" class="w-8 h-8 text-indigo-400 mx-auto mb-2.5"></i>
                            <h4 class="text-sm font-black text-white mb-1">Authentication Required</h4>
                            <p class="text-[10px] text-slate-400 leading-normal mb-4 font-semibold">Sign in to add this item to your cart or submit client leads.</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-1.5 w-full py-3 bg-indigo-600 text-white font-black text-[10px] uppercase tracking-wider rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5">
                                Secure Sign In
                            </a>
                        </div>
                        <a href="https://wa.me/919999999999?text=Hi, I am interested in {{ urlencode($service->name) }}" target="_blank" class="flex items-center justify-center gap-1.5 w-full py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider text-white bg-emerald-50 hover:bg-emerald-600 shadow-md shadow-emerald-500/10 transition-all hover:-translate-y-0.5 active:translate-y-0">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i> Inquire via WhatsApp
                        </a>
                    @endauth
                </div>

                {{-- SIDEBAR PACKAGES & SUPPORT --}}
                <!-- <div class="bg-white/90 backdrop-blur-md rounded-[32px] p-5 sm:p-6 border border-slate-100 shadow-[0_15px_40px_rgba(0,0,0,0.015)]">
                    <h3 class="text-base sm:text-lg font-black text-slate-900 mb-4 tracking-tight flex items-center gap-2">
                        <i data-lucide="package" class="w-4.5 h-4.5 text-indigo-600"></i> Flexible Packages
                    </h3>
                    
                    <div class="space-y-4 font-sans">
                        @auth
                            @foreach([
                                ['label'=>'Standard Start','price'=> $service->min_price,'desc'=>'Essential scope for high-quality baseline delivery','badge'=>'Popular Choice','border'=>'border-indigo-100 bg-indigo-50/25 shadow-sm'],
                                ['label'=>'Enterprise Growth','price'=> $service->min_price * 1.8,'desc'=>'Expanded deliverables with priority engineering & revisions','badge'=>'Recommended','border'=>'border-slate-100 bg-white hover:border-indigo-100/70 hover:bg-slate-50/20'],
                            ] as $pkg)
                            <div class="rounded-2xl p-3.5 border {{ $pkg['border'] }} relative transition-all duration-300 group">
                                <div class="absolute -top-2.5 right-3 px-2 py-0.5 bg-indigo-600 text-white rounded-full text-[8px] font-bold uppercase tracking-wider shadow-sm group-hover:scale-105 transition-transform">{{ $pkg['badge'] }}</div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <h4 class="font-bold text-slate-800 text-xs sm:text-sm">{{ $pkg['label'] }}</h4>
                                    <span class="text-xs sm:text-sm font-extrabold text-indigo-600">₹{{ number_format($pkg['price']) }}</span>
                                </div>
                                <p class="text-[10px] text-slate-500 font-medium leading-relaxed">{{ $pkg['desc'] }}</p>
                            </div>
                            @endforeach
                        @else
                            <div class="bg-slate-50/50 p-5 rounded-2xl border border-slate-200/50 text-center">
                                <i data-lucide="lock" class="w-6 h-6 text-slate-400 mx-auto mb-2"></i>
                                <div class="text-[10px] font-black text-slate-700 uppercase tracking-wider mb-2.5">Member Packages Locked</div>
                                <a href="{{ route('login') }}" class="inline-block px-3.5 py-2 bg-indigo-600 text-white text-[10px] font-bold rounded-lg hover:bg-indigo-700 transition-colors shadow-md shadow-indigo-600/20">Login to View Packages</a>
                            </div>
                        @endauth
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 text-center">
                        <h4 class="font-bold text-[9px] text-slate-400 uppercase tracking-widest mb-2.5">Questions about deliverables?</h4>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-100 text-slate-700 font-extrabold text-[10px] transition-colors">
                            <i data-lucide="headphones" class="w-3.5 h-3.5 text-blue-600"></i> Talk to Account Manager
                        </a>
                    </div>
                </div> -->

            </div>
        </div>

        {{-- BUY NOW MODAL --}}
        <div x-show="buyNowModal" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div x-show="buyNowModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[105] bg-slate-900/80 backdrop-blur-sm transition-opacity"></div>
            
            <div class="fixed inset-0 z-[110] w-screen overflow-y-auto">
                <div class="flex mt-10 items-end justify-center sm:items-center p-0 sm:p-4 text-center">
                    
                    <div x-show="buyNowModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-t-[32px] sm:rounded-[32px] bg-white text-left shadow-2xl transition-all w-full sm:w-full sm:max-w-lg border-t sm:border border-slate-200 mt-6 sm:mt-0" 
                         @click.away="buyNowModal = false">
                        
                        <!-- Mobile Drag Handle -->
                        <div class="w-full flex justify-center pt-3 pb-1 sm:hidden bg-slate-50">
                            <div class="w-12 h-1.5 bg-slate-300 rounded-full"></div>
                        </div>

                        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <h3 class="text-base sm:text-lg font-black text-slate-900 flex items-center gap-2" id="modal-title">
                                <i data-lucide="zap" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600"></i> Quick Checkout
                            </h3>
                            <button @click="buyNowModal = false" type="button" class="p-2 -mr-2 text-slate-400 hover:text-slate-600 transition-colors rounded-full hover:bg-slate-200/50">
                                <i data-lucide="x" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            </button>
                        </div>

                        <form id="buyNowForm" class="p-5 sm:p-6 max-h-[80vh] overflow-y-auto">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            
                            <div class="space-y-4 font-sans">
                                <div>
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Full Name *</label>
                                    @php
                                        $defaultName = auth()->check() ? 'User ' . substr(auth()->user()->phone, -4) : '';
                                        $displayName = auth()->check() && auth()->user()->name !== $defaultName ? auth()->user()->name : '';
                                    @endphp
                                    <input type="text" name="customer_name" value="{{ $displayName }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Mobile Number *</label>
                                    <input type="tel" name="customer_phone" value="{{ auth()->check() ? auth()->user()->phone : '' }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Project Requirements *</label>
                                    <textarea name="requirements" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all resize-none" placeholder="Describe your project requirements briefly..."></textarea>
                                </div>
                            </div>

                            <div class="mt-6 sm:mt-8 flex gap-3 pb-4 sm:pb-0">
                                <button type="button" @click="buyNowModal = false" class="w-1/3 py-3.5 rounded-xl text-[10px] sm:text-xs font-black tracking-wider uppercase text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" x-bind:disabled="isProcessing" class="w-2/3 py-3.5 rounded-xl text-[10px] sm:text-xs font-black tracking-wider uppercase text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all flex justify-center items-center gap-2 disabled:opacity-70">
                                    <span x-show="!isProcessing">Pay ₹{{ number_format($service->min_price) }}</span>
                                    <span x-show="isProcessing">Processing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('buyNowForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let form = this;
        let formData = new FormData(form);
        
        window.dispatchEvent(new CustomEvent('processing-start'));

        fetch('{{ route('payment.buyNow') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var options = {
                    "key": data.key,
                    "amount": data.amount * 100, 
                    "currency": "INR",
                    "name": "SKSolutions",
                    "description": "Payment for " + data.service_name,
                    "order_id": data.razorpay_order_id,
                    "handler": function (response){
                        let verifyForm = document.createElement('form');
                        verifyForm.method = 'POST';
                        verifyForm.action = '{{ route('payment.verify') }}';
                        
                        let csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        verifyForm.appendChild(csrf);

                        let orderId = document.createElement('input');
                        orderId.type = 'hidden';
                        orderId.name = 'order_id';
                        orderId.value = data.order_id;
                        verifyForm.appendChild(orderId);

                        let rzpPayId = document.createElement('input');
                        rzpPayId.type = 'hidden';
                        rzpPayId.name = 'razorpay_payment_id';
                        rzpPayId.value = response.razorpay_payment_id;
                        verifyForm.appendChild(rzpPayId);

                        let rzpOrderId = document.createElement('input');
                        rzpOrderId.type = 'hidden';
                        rzpOrderId.name = 'razorpay_order_id';
                        rzpOrderId.value = response.razorpay_order_id;
                        verifyForm.appendChild(rzpOrderId);

                        let rzpSig = document.createElement('input');
                        rzpSig.type = 'hidden';
                        rzpSig.name = 'razorpay_signature';
                        rzpSig.value = response.razorpay_signature;
                        verifyForm.appendChild(rzpSig);

                        document.body.appendChild(verifyForm);
                        verifyForm.submit();
                    },
                    "prefill": {
                        "name": data.name,
                        "email": data.email,
                        "contact": data.contact
                    },
                    "theme": {
                        "color": "#4f46e5"
                    },
                    "modal": {
                        "ondismiss": function(){
                            window.dispatchEvent(new CustomEvent('processing-end'));
                        }
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
                window.dispatchEvent(new CustomEvent('processing-end'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('A network error occurred. Please try again.');
            window.dispatchEvent(new CustomEvent('processing-end'));
        });
    });
</script>
@endpush

@endsection
