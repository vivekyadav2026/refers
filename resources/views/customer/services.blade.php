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
<div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5 mb-10">
    @forelse($servicesByCategory->flatten(1) as $svc)
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group relative">

        {{-- Popular badge --}}
        @if($svc->is_popular)
        <div class="absolute top-3 right-3 z-10 bg-gradient-to-r from-orange-400 to-amber-500 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full shadow-md shadow-orange-500/25">🔥 Popular</div>
        @endif

        {{-- Service image / icon --}}
        <div class="h-28 sm:h-40 w-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center overflow-hidden relative">
            @if($svc->banner_image)
                <img src="{{ asset('storage/' . $svc->banner_image) }}" alt="{{ $svc->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            @else
                <i data-lucide="{{ $svc->icon ?? 'box' }}" class="w-10 h-10 sm:w-14 sm:h-14 text-blue-400 group-hover:scale-110 transition-transform duration-500"></i>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            {{-- Category overlay --}}
            <div class="absolute bottom-2 left-2">
                <span class="bg-white/90 backdrop-blur-sm text-blue-700 text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border border-blue-100 shadow-sm hidden sm:inline-block">{{ $svc->category }}</span>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-4 sm:p-5 flex-1 flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-widest text-blue-500 mb-1 block sm:hidden">{{ $svc->category }}</span>
            <h2 class="font-black text-xs sm:text-base text-slate-900 mb-1 sm:mb-1.5 leading-snug group-hover:text-blue-600 transition-colors">{{ $svc->name }}</h2>
            <p class="text-[11px] sm:text-xs text-slate-500 line-clamp-2 mb-3 flex-1 leading-relaxed hidden sm:block">{{ $svc->short_description }}</p>

            {{-- Features (desktop only) --}}
            @if(is_array($svc->features) && count($svc->features) > 0)
            <ul class="space-y-1.5 mb-4 hidden sm:block">
                @foreach(array_slice($svc->features, 0, 3) as $f)
                <li class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                    <span class="w-4 h-4 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 border border-emerald-200">
                        <i data-lucide="check" class="w-2.5 h-2.5 text-emerald-600"></i>
                    </span>
                    {{ $f }}
                </li>
                @endforeach
            </ul>
            @endif

            {{-- Price & Delivery --}}
            <div class="flex items-center justify-between mb-3 bg-gradient-to-r from-slate-50 to-blue-50/50 rounded-xl sm:rounded-2xl px-2.5 sm:px-4 py-2 sm:py-3 border border-slate-100">
                <div>
                    <div class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">From</div>
                    <div class="text-base sm:text-xl font-black text-slate-900">₹{{ number_format($svc->min_price) }}</div>
                </div>
                @if($svc->delivery_timeline)
                <div class="text-right hidden sm:block">
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Delivery</div>
                    <div class="text-xs font-black text-slate-700 flex items-center gap-1 justify-end">
                        <i data-lucide="clock" class="w-3 h-3 text-indigo-400"></i> {{ $svc->delivery_timeline }}
                    </div>
                </div>
                @endif
            </div>

            {{-- CTAs --}}
            <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                <a href="{{ route('services.show', $svc->slug) }}"
                   class="py-2 sm:py-2.5 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black text-center text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-sm shadow-blue-600/20 transition-all active:scale-95 uppercase tracking-wider">
                    View
                </a>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $svc->id }}">
                    <button type="submit"
                            class="w-full py-2 sm:py-2.5 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black text-slate-700 bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all active:scale-95 flex items-center justify-center gap-1 uppercase tracking-wider">
                        <i data-lucide="shopping-cart" class="w-3 h-3 sm:w-3.5 sm:h-3.5"></i> <span class="hidden sm:inline">Add</span><span class="sm:hidden">+</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
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
