@extends('layouts.app')
@section('title', 'Our Services — VivekTech Partner Network')
@section('content')

<div class="bg-white">
    {{-- HEADER --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 to-blue-950 pt-20 pb-24 text-center">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(99,102,241,0.2),_transparent_70%)]"></div>
        <div class="relative max-w-3xl mx-auto px-4">
            <h1 class="text-5xl font-black text-white mb-4 tracking-tight">Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">Services</span></h1>
            <p class="text-lg text-slate-300 max-w-xl mx-auto">Premium digital services for businesses. Bring a client, we deliver, you earn up to 30% commission.</p>
        </div>
    </div>

    {{-- SERVICES GRID --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 pb-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($servicesByCategory->flatten(1) as $svc)
            <div class="group relative bg-white rounded-2xl border border-slate-200 hover:border-blue-300 hover:shadow-2xl shadow-sm transition-all duration-300 hover:-translate-y-2 flex flex-col">
                @if($svc->is_popular)
                <div class="absolute -top-3 left-6 bg-gradient-to-r from-orange-400 to-amber-400 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md">⭐ Most Popular</div>
                @endif

                <div class="p-6 flex-1">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-100 text-blue-600 flex items-center justify-center mb-5 group-hover:from-blue-600 group-hover:to-indigo-600 group-hover:text-white transition-all">
                        <i data-lucide="{{ $svc->icon ?? 'box' }}" class="w-6 h-6"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-wider text-blue-500 mb-1">{{ $svc->category }}</div>
                    <h2 class="text-lg font-black text-slate-900 mb-2">{{ $svc->name }}</h2>
                    <p class="text-sm text-slate-500 mb-4 leading-relaxed">{{ $svc->short_description }}</p>

                    <ul class="space-y-2 mb-6">
                        @foreach(array_slice($svc->features ?? [], 0, 4) as $f)
                        <li class="flex items-start gap-2 text-xs text-slate-600">
                            <span class="w-4 h-4 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-2.5 h-2.5 text-emerald-600"></i>
                            </span>
                            {{ $f }}
                        </li>
                        @endforeach
                    </ul>

                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-3xl font-black text-slate-900">₹{{ number_format($svc->min_price) }}</span>
                        <span class="text-slate-400 text-sm font-medium">starting</span>
                    </div>

                    <div class="text-center text-xs text-emerald-700 font-bold bg-emerald-50 rounded-xl px-3 py-2 mb-4 border border-emerald-100">
                        🎯 You earn ₹{{ number_format($svc->min_price * 0.2) }}–₹{{ number_format($svc->min_price * 0.30) }} commission
                    </div>
                </div>

                <div class="p-5 pt-0 flex flex-col gap-2">
                    <a href="{{ route('services.show', $svc->slug) }}" class="w-full text-center py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-md shadow-blue-600/20 transition-all hover:-translate-y-0.5">
                        Get This Service
                    </a>
                    <a href="{{ route('contact') }}" class="w-full text-center py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-600 transition-all">
                        Talk to Expert
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-24 text-slate-400">No services found.</div>
            @endforelse
        </div>
    </div>

    {{-- BOTTOM CTA --}}
    <div class="bg-slate-50 border-t border-slate-200 py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h3 class="text-3xl font-black text-slate-900 mb-4">Not sure which service to recommend?</h3>
            <p class="text-slate-500 mb-8">Talk to our expert team. We'll help you identify the right service for your client and maximize your commission.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
                    <i data-lucide="message-circle" class="w-5 h-5"></i> Talk to Expert
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-bold text-slate-700 bg-white border-2 border-slate-200 hover:border-blue-300 hover:text-blue-600 transition-all">
                    Start Earning Free
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
