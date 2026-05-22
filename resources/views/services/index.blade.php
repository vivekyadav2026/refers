@extends('layouts.app')
@section('title', 'Services — SKSolutions Digital Agency')
@section('hide_nav_footer', true)

@section('content')

<style>
/* Add the font from the design */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700;900&family=Style+Script&display=swap');

body {
    background-color: #ffffff;
    font-family: 'Outfit', sans-serif;
    -webkit-tap-highlight-color: transparent;
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

@php
  // Mapping of exact service names to our newly generated 3D images and specific colors.
  // If a new service is added in the admin panel, it will fall back to a default.
  $premiumMapping = [
      'E-commerce Website Design & Development' => [
          'img' => asset('storage/banners/srv_ecommerce.png'),
          'bg' => 'from-indigo-50 to-purple-50',
          'icon_color' => 'text-indigo-700',
          'icon' => 'shopping-cart'
      ],
      'Informative Website Design & Development' => [
          'img' => asset('storage/banners/srv_web.png'),
          'bg' => 'from-blue-50 to-indigo-50',
          'icon_color' => 'text-blue-700',
          'icon' => 'layout-template'
      ],
      'Facebook Ads' => [
          'img' => asset('storage/banners/srv_fb.png'),
          'bg' => 'from-blue-50 to-blue-100',
          'icon_color' => 'text-[#1877F2]',
          'icon' => 'facebook'
      ],
      'Instagram Ads' => [
          'img' => asset('storage/banners/srv_ig.png'),
          'bg' => 'from-pink-50 to-rose-100',
          'icon_color' => 'text-pink-600',
          'icon' => 'instagram'
      ],
      'Google Ads' => [
          'img' => asset('storage/banners/srv_google.png'),
          'bg' => 'from-green-50 to-emerald-100',
          'icon_color' => 'text-green-600',
          'icon' => 'bar-chart'
      ],
      'YouTube Ads' => [
          'img' => asset('storage/banners/srv_yt.png'),
          'bg' => 'from-red-50 to-rose-100',
          'icon_color' => 'text-red-600',
          'icon' => 'youtube'
      ],
      'SEO (Search Engine Optimization)' => [
          'img' => asset('storage/banners/srv_seo.png'),
          'bg' => 'from-purple-50 to-fuchsia-100',
          'icon_color' => 'text-purple-700',
          'icon' => 'search'
      ],
      'Reels & Video Editing' => [
          'img' => asset('storage/banners/srv_reels.png'),
          'bg' => 'from-fuchsia-50 to-pink-100',
          'icon_color' => 'text-fuchsia-700',
          'icon' => 'clapperboard'
      ],
      'Mobile App Development' => [
          'img' => asset('storage/banners/srv_app.png'),
          'bg' => 'from-blue-50 to-cyan-100',
          'icon_color' => 'text-blue-700',
          'icon' => 'smartphone'
      ],
  ];

  $allSvcs = $servicesByCategory->flatten(1);
@endphp

<div class="px-5 py-6 pb-28">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($allSvcs as $svc)
        @php
            $match = $premiumMapping[$svc->name] ?? null;
            $bg = $match ? $match['bg'] : 'from-slate-50 to-gray-100';
            $img = $match ? $match['img'] : ($svc->banner_image ? asset('storage/'.$svc->banner_image) : asset('storage/banners/srv_web.png'));
            $icon = $match ? $match['icon'] : 'box';
            $icon_color = $match ? $match['icon_color'] : 'text-slate-700';
        @endphp
        
        <a href="{{ route('services.show', $svc->slug) }}" class="block bg-gradient-to-br {{ $bg }} rounded-[32px] p-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            
            <div class="flex flex-col sm:flex-row items-center justify-between h-full relative z-10 gap-6">
                <!-- Left Content -->
                <div class="w-full sm:w-[55%] flex flex-col items-start text-left">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mb-4 shadow-sm">
                        @if($icon == 'instagram')
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="url(#ig-grad-svc-{{$loop->index}})" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <defs>
                                    <linearGradient id="ig-grad-svc-{{$loop->index}}" x1="2" y1="2" x2="22" y2="22">
                                        <stop offset="0%" stop-color="#f58529" />
                                        <stop offset="50%" stop-color="#dd2a7b" />
                                        <stop offset="100%" stop-color="#8134af" />
                                    </linearGradient>
                                </defs>
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        @elseif($icon == 'facebook' || $icon == 'youtube')
                            <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $icon_color }}" fill="currentColor" stroke="none"></i>
                        @else
                            <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $icon_color }}" stroke-width="2.5"></i>
                        @endif
                    </div>
                    
                    <h3 class="text-[22px] sm:text-2xl font-black text-slate-900 mb-2 leading-tight tracking-tight pr-4">
                        {!! str_replace(' & ', '<br>& ', $svc->name) !!}
                    </h3>
                    <p class="text-[13px] text-slate-700 font-medium leading-relaxed max-w-[280px]">
                        {{ $svc->short_description ?? 'Powerful, secure and user-friendly digital solutions.' }}
                    </p>
                </div>

                <!-- Right Image -->
                <div class="w-full sm:w-[45%] flex justify-center sm:justify-end mt-4 sm:mt-0">
                    <img src="{{ $img }}" alt="{{ $svc->name }}" class="w-full max-w-[220px] drop-shadow-2xl group-hover:scale-105 transition-transform duration-500 object-contain">
                </div>
            </div>
        </a>
        @endforeach

        <!-- Static Final Card: Why Choose SKSolutions -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-[32px] p-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="flex flex-col sm:flex-row items-center justify-between h-full relative z-10 gap-6">
                <!-- Left Content -->
                <div class="w-full sm:w-[60%] flex flex-col items-start text-left">
                    <h3 class="text-2xl font-black text-slate-900 mb-4 leading-tight tracking-tight">
                        Why Choose<br>SK Solutions?
                    </h3>
                    
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-800">
                            <i data-lucide="users" class="w-4 h-4 text-orange-500"></i> Experienced Team
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-800">
                            <i data-lucide="award" class="w-4 h-4 text-orange-500"></i> Quality Solutions
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-800">
                            <i data-lucide="clock" class="w-4 h-4 text-orange-500"></i> Timely Delivery
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-800">
                            <i data-lucide="tag" class="w-4 h-4 text-orange-500"></i> Affordable Pricing
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-800">
                            <i data-lucide="headphones" class="w-4 h-4 text-orange-500"></i> Dedicated Support
                        </li>
                    </ul>
                </div>

                <!-- Right Image (Target abstract) -->
                <div class="w-full sm:w-[40%] flex justify-center sm:justify-end mt-4 sm:mt-0 opacity-80 group-hover:opacity-100 transition-opacity">
                    <!-- We use a large SVG icon to represent the target graphic -->
                    <svg class="w-32 h-32 text-orange-500 group-hover:scale-110 transition-transform duration-500 drop-shadow-xl" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
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

<!-- Fixed Bottom Navigation (Public) -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 flex items-center justify-around z-50 bottom-nav shadow-[0_-5px_20px_rgba(0,0,0,0.03)] pb-2 pt-1">
    <a href="{{ url('/') }}" class="flex flex-col items-center py-2 gap-1 w-full text-slate-400">
        <i data-lucide="home" class="w-5 h-5"></i>
        <span class="text-[10px] font-bold">Home</span>
    </a>
    <a href="{{ route('services.index') }}" class="flex flex-col items-center py-2 gap-1 w-full text-indigo-800">
        <i data-lucide="grid-3x3" class="w-5 h-5" fill="currentColor" stroke="currentColor"></i>
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
