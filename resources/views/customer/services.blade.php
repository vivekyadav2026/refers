@extends('layouts.app')
@section('title', 'Explore Services — Customer Portal')
@section('sidebar')<!-- enable sidebar -->@endsection
@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full mb-4">
        <i data-lucide="grid-3x3" class="w-3.5 h-3.5"></i> Service Catalog
    </div>
    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
        Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Premium Services</span>
    </h1>
    <p class="text-slate-500 font-medium mt-1 text-sm">Browse, add to cart, and order any digital service directly.</p>
</div>

{{-- Category Filter Pills --}}
<div class="flex flex-wrap gap-2 mb-8">
    <a href="{{ route('customer.services') }}"
       class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200
              {{ !$selectedCategory ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-600' }}">
        🔥 All
    </a>
    @foreach($allCategories as $cat)
    <a href="{{ route('customer.services', ['category' => $cat]) }}"
       class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200
              {{ $selectedCategory === $cat ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-600' }}">
        {{ $cat }}
    </a>
    @endforeach
</div>

{{-- Services Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
    @forelse($servicesByCategory->flatten(1) as $svc)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group relative">

        {{-- Popular badge --}}
        @if($svc->is_popular)
        <div class="absolute top-3 right-3 z-10 bg-gradient-to-r from-orange-400 to-amber-500 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full shadow">🔥 Popular</div>
        @endif

        {{-- Service image / icon --}}
        <div class="h-36 w-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center overflow-hidden relative">
            @if($svc->banner_image)
                <img src="{{ asset('storage/' . $svc->banner_image) }}" alt="{{ $svc->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            @else
                <i data-lucide="{{ $svc->icon ?? 'box' }}" class="w-12 h-12 text-blue-500 group-hover:scale-110 transition-transform duration-500"></i>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
        </div>

        {{-- Body --}}
        <div class="p-5 flex-1 flex flex-col">
            <span class="text-[10px] font-black uppercase tracking-widest text-blue-500 mb-1">{{ $svc->category }}</span>
            <h2 class="font-black text-base text-slate-900 mb-1 leading-tight group-hover:text-blue-600 transition-colors">{{ $svc->name }}</h2>
            <p class="text-xs text-slate-500 line-clamp-2 mb-4 flex-1">{{ $svc->short_description }}</p>

            {{-- Features --}}
            @if(is_array($svc->features) && count($svc->features) > 0)
            <ul class="space-y-1.5 mb-4">
                @foreach(array_slice($svc->features, 0, 3) as $f)
                <li class="flex items-center gap-2 text-xs text-slate-600">
                    <span class="w-4 h-4 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <i data-lucide="check" class="w-2.5 h-2.5 text-emerald-600"></i>
                    </span>
                    {{ $f }}
                </li>
                @endforeach
            </ul>
            @endif

            {{-- Price & Actions --}}
            <div class="flex items-center justify-between mb-4 bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Starting at</div>
                    <div class="text-xl font-black text-slate-900">₹{{ number_format($svc->min_price) }}</div>
                </div>
                @if($svc->delivery_timeline)
                <div class="text-right">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Delivery</div>
                    <div class="text-xs font-bold text-slate-700">{{ $svc->delivery_timeline }}</div>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('services.show', $svc->slug) }}"
                   class="py-2.5 rounded-xl text-xs font-black text-center text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-sm shadow-blue-600/20 transition-all active:scale-95">
                    View Details
                </a>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $svc->id }}">
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-xs font-black text-slate-700 bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 transition-all active:scale-95 flex items-center justify-center gap-1">
                        <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i> Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-2xl border border-dashed border-slate-200 p-16 text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="search" class="w-8 h-8 text-slate-400"></i>
        </div>
        <h3 class="text-lg font-black text-slate-900 mb-2">No services in this category</h3>
        <p class="text-slate-500 text-sm mb-6">Try a different category filter.</p>
        <a href="{{ route('customer.services') }}" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors">View All Services</a>
    </div>
    @endforelse
</div>

@endsection
