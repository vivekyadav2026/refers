@extends('layouts.app')
@section('title', 'Explore Premium Services — VivekTech Partner Network')
@section('content')

<div class="bg-slate-50 min-h-screen pt-24 pb-24">
    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-blue-100/80 border border-blue-200 text-blue-700 text-xs font-black px-4 py-2 rounded-full mb-4 shadow-sm uppercase tracking-wider">
            <i data-lucide="grid-3x3" class="w-4 h-4 text-blue-600"></i> Service Marketplace
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 mb-4 tracking-tight">Explore Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700">Premium Catalog</span></h1>
        <p class="text-base sm:text-lg text-slate-500 max-w-2xl mx-auto font-semibold leading-relaxed">High-ticket digital solutions built by expert engineers and creators. Purchase for your brand or invite clients to get started.</p>
    </div>

    {{-- CATEGORY FILTER PILLS --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-14">
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 pb-4 border-b border-slate-200/80">
            <a href="{{ route('services.index') }}" class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-black tracking-wider uppercase transition-all duration-300 {{ !request('category') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30 -translate-y-0.5' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100 hover:text-slate-900 shadow-sm' }}">
                🔥 All Categories
            </a>
            @foreach($allCategories as $cat)
            <a href="{{ route('services.index', ['category' => $cat]) }}" class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-black tracking-wider uppercase transition-all duration-300 {{ request('category') === $cat ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30 -translate-y-0.5' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100 hover:text-slate-900 shadow-sm' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- SERVICES GRID --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($servicesByCategory->flatten(1) as $svc)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-200 transition-all duration-300 p-8 flex flex-col justify-between group relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500 -z-10"></div>
                @if($svc->is_popular)
                <div class="absolute top-4 right-4 bg-gradient-to-r from-orange-400 to-amber-500 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md">🔥 Hot</div>
                @endif

                <div>
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center border border-blue-200/60 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                            @if($svc->banner_image)
                                <img src="{{ asset('storage/' . $svc->banner_image) }}" alt="{{ $svc->name }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="{{ $svc->icon ?? 'box' }}" class="w-8 h-8 text-blue-600"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-[11px] font-extrabold uppercase tracking-widest text-blue-600 mb-1 block">{{ $svc->category }}</span>
                            <h2 class="text-xl font-black text-slate-900 mb-2 leading-tight group-hover:text-blue-600 transition-colors">{{ $svc->name }}</h2>
                        </div>
                    </div>

                    <p class="text-sm font-semibold text-slate-500 mb-6 leading-relaxed line-clamp-3">{{ $svc->short_description }}</p>

                    @if(is_array($svc->features) && count($svc->features) > 0)
                    <div class="mb-6 pt-6 border-t border-slate-100">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Key Features</div>
                        <ul class="space-y-2.5 font-semibold text-xs text-slate-600">
                            @foreach(array_slice($svc->features, 0, 4) as $f)
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                    <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                                </span>
                                <span class="truncate">{{ $f }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <div>
                    @auth
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-6 flex items-center justify-between">
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Client Price</div>
                            <div class="text-2xl font-black text-slate-900">₹{{ number_format($svc->min_price) }}</div>
                        </div>
                    </div>
                    @else
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-6 text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-blue-600 hover:text-blue-700">
                            <i data-lucide="lock" class="w-4 h-4"></i> Login to Unlock Price
                        </a>
                    </div>
                    @endauth

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('services.show', $svc->slug) }}" class="w-full text-center py-3 rounded-xl text-xs font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-md shadow-blue-600/25 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-1.5">
                            View Details <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="w-full text-center py-3 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-all shadow-xs flex items-center justify-center gap-1.5">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5 text-blue-600"></i> Talk to Expert
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-16 text-center shadow-sm">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i data-lucide="search" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">No services found in this category</h3>
                <p class="text-slate-500 mb-6 font-medium">Try selecting a different category or clearing your filter.</p>
                <a href="{{ route('services.index') }}" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition-colors">View All Services</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- BOTTOM ASSISTANCE CARD --}}
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-gradient-to-br from-slate-900 to-blue-950 rounded-3xl p-12 text-white text-center shadow-2xl relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>
            <h3 class="text-3xl font-black mb-4 tracking-tight">Need a custom digital solution?</h3>
            <p class="text-slate-300 font-semibold mb-8 max-w-xl mx-auto leading-relaxed">Can't find exactly what your client needs? Our technical team can build bespoke enterprise software tailored to specific requirements.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-slate-900 text-sm font-extrabold rounded-2xl hover:bg-blue-50 transition-all shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                    <i data-lucide="phone-call" class="w-4 h-4 text-blue-600"></i> Schedule Discovery Call
                </a>
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white/10 text-white border border-white/20 text-sm font-bold rounded-2xl hover:bg-white/20 transition-all backdrop-blur-md flex items-center gap-2">
                    Join Partner Network
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
