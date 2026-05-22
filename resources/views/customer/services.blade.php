@extends('layouts.app')
@section('title', 'Explore Services — Customer Portal')
@section('sidebar')<!-- enable sidebar -->@endsection
@section('content')
<div class="py-4 sm:py-6">

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
    <div>
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-black px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
            <i data-lucide="grid-3x3" class="w-3.5 h-3.5"></i> Service Catalog
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
            Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Premium Services</span>
        </h1>
        <p class="text-slate-500 font-medium mt-1 text-sm">Browse, add to cart, and order any digital service directly.</p>
    </div>
    <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 text-xs font-black uppercase tracking-wider hover:border-blue-300 hover:text-blue-600 shadow-sm transition-all hover:-translate-y-0.5 w-full sm:w-auto justify-center">
        <i data-lucide="shopping-cart" class="w-4 h-4"></i> View Cart ({{ auth()->user()->cartItems->count() }})
    </a>
</div>

{{-- Category Filter Pills --}}
<div class="flex gap-2 mb-8 overflow-x-auto pb-3 -mx-4 px-4 sm:mx-0 sm:px-0 sm:pb-0 sm:flex-wrap whitespace-nowrap scrollbar-none">
    <a href="{{ route('customer.services') }}"
       class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 shrink-0 {{ !$selectedCategory ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-600' }}">
        🔥 All
    </a>
    @foreach($allCategories as $cat)
    <a href="{{ route('customer.services', ['category' => $cat]) }}"
       class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 shrink-0 {{ $selectedCategory === $cat ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-600' }}">
        {{ $cat }}
    </a>
    @endforeach
</div>

{{-- Services Grid --}}
@php
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

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-5 mb-10">
    @forelse($servicesByCategory->flatten(1) as $svc)
    @php
        $match = $findPremiumMatch($svc->name);
        $icon = $svc->icon ?: ($match ? $match['icon'] : 'layout-grid');
        $icon_color = $match ? $match['icon_color'] : 'text-slate-500';
        $bg = $match ? $match['bg'] : 'from-slate-50 to-slate-100';
    @endphp
    <a href="{{ route('services.show', $svc->slug) }}" class="service-card bg-white flex flex-col items-center justify-center group hover:bg-indigo-50/30 transition-all duration-300 min-h-[180px] sm:min-h-[220px] p-4 sm:p-6 text-center rounded-2xl shadow-md hover:shadow-xl hover:shadow-indigo-500/10 border border-slate-100/50 hover:-translate-y-1 relative">
        @if($svc->is_popular)
        <div class="absolute top-2 right-2 sm:top-3 sm:right-3 z-10 bg-gradient-to-r from-orange-400 to-amber-500 text-white text-[8px] sm:text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full shadow-md shadow-orange-500/25">🔥</div>
        @endif
        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br {{ $bg }} flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-white/50">
            <i data-lucide="{{ $icon }}" class="w-6 h-6 sm:w-8 sm:h-8 {{ $icon_color }}"></i>
        </div>
        <span class="text-[9px] sm:text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">{{ $svc->category }}</span>
        <span class="text-xs sm:text-sm font-bold text-slate-800 leading-tight line-clamp-2">{{ $svc->name }}</span>
        <p class="text-[10px] sm:text-[11px] text-slate-500 mt-2 line-clamp-2 leading-relaxed hidden sm:block">{{ $svc->short_description }}</p>
        <span class="text-[10px] sm:text-xs font-bold text-indigo-600 mt-2">₹{{ number_format($svc->min_price ?? 0, 0) }}</span>
    </a>
    @empty
    <div class="col-span-full bg-white rounded-3xl border border-dashed border-slate-200 p-16 text-center">
        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-slate-200">
            <i data-lucide="search" class="w-8 h-8 text-slate-300"></i>
        </div>
        <h3 class="text-lg font-black text-slate-900 mb-2">No services in this category</h3>
        <p class="text-slate-500 text-sm mb-6 font-medium">Try a different category filter.</p>
        <a href="{{ route('customer.services') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-black uppercase tracking-wider hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
            View All Services
        </a>
    </div>
    @endforelse
</div>

</div>
@endsection
