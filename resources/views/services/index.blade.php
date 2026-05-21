@extends('layouts.app')
@section('title', 'Services — SKSolutions Digital Agency')
@section('content')

<style>
.svc-card { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
.svc-card:hover { transform: translateY(-4px); box-shadow: 0 24px 48px -12px rgba(124,58,237,0.2); }
.icon-box { transition: transform 0.3s ease; }
.svc-card:hover .icon-box { transform: scale(1.1) rotate(-3deg); }
</style>

<div class="bg-[#FAFAFA] min-h-screen pb-24">

  {{-- ══════ HERO HEADER ══════ --}}
  <div class="relative pt-36 pb-20 overflow-hidden bg-slate-50/30 border-b border-slate-100">
    {{-- Precision Grid Overlay --}}
    <div class="absolute inset-0 bg-[radial-gradient(#e2d9f3_1.2px,transparent_1.2px)] bg-[size:32px_32px] opacity-75 [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_80%,transparent_100%)] pointer-events-none z-0"></div>

    {{-- Soft Ambient Glows --}}
    <div class="absolute top-[-20%] right-[-10%] w-[550px] h-[550px] rounded-full pointer-events-none z-0" style="background:radial-gradient(circle, rgba(168,85,247,0.15) 0%, transparent 70%); filter: blur(40px);"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full pointer-events-none z-0" style="background:radial-gradient(circle, rgba(124,58,237,0.12) 0%, transparent 70%); filter: blur(40px);"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
      {{-- Elegant Tech Badge --}}
      <div class="fade-up inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-purple-50 border border-purple-200 text-purple-700 text-[10px] font-black uppercase tracking-widest mb-6 shadow-sm hover:scale-105 transition-transform duration-300">
        ✦ What We Offer
      </div>
      
      {{-- Bold typographic Slate Title with Signature Gradient --}}
      <h1 class="text-4xl sm:text-6xl font-black text-slate-900 mb-6 leading-[1.05] tracking-tight">
        Services That Drive <br class="hidden sm:inline">
        <span class="animated-gradient drop-shadow-[0_2px_10px_rgba(124,58,237,0.12)]">Real Growth</span>
      </h1>
      
      <p class="text-slate-500 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
        From full-stack development to high-impact digital marketing — every service is engineered for premium ROI and delivered by seasoned professionals.
      </p>
    </div>
  </div>

  {{-- ══════ STICKY CATEGORY FILTER ══════ --}}
  <div class="sticky top-16 z-30 bg-white/80 backdrop-blur-xl border-b border-gray-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex gap-2 overflow-x-auto py-3 scrollbar-hide">
        <a href="{{ route('services.index') }}"
           class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold border transition-all
                  {{ !request('category') ? 'bg-purple-700 text-white border-purple-700 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-purple-300 hover:text-purple-700' }}">
          ✦ All Services
        </a>
        @foreach($allCategories ?? [] as $cat)
        <a href="{{ route('services.index', ['category' => $cat]) }}"
           class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold border transition-all
                  {{ request('category') === $cat ? 'bg-purple-700 text-white border-purple-700 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-purple-300 hover:text-purple-700' }}">
          {{ $cat }}
        </a>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ══════ SERVICE CARDS GRID ══════ --}}
  @php
    $palette = [
      ['gradient'=>'from-violet-500 to-purple-600', 'light'=>'bg-violet-50',  'text'=>'text-violet-600', 'border'=>'border-violet-100'],
      ['gradient'=>'from-blue-500 to-indigo-600',   'light'=>'bg-blue-50',    'text'=>'text-blue-600',   'border'=>'border-blue-100'],
      ['gradient'=>'from-rose-500 to-pink-600',     'light'=>'bg-rose-50',    'text'=>'text-rose-600',   'border'=>'border-rose-100'],
      ['gradient'=>'from-amber-400 to-orange-500',  'light'=>'bg-amber-50',   'text'=>'text-amber-600',  'border'=>'border-amber-100'],
      ['gradient'=>'from-teal-500 to-cyan-500',     'light'=>'bg-teal-50',    'text'=>'text-teal-600',   'border'=>'border-teal-100'],
      ['gradient'=>'from-fuchsia-500 to-purple-600','light'=>'bg-fuchsia-50', 'text'=>'text-fuchsia-600','border'=>'border-fuchsia-100'],
    ];
    $allSvcs = $servicesByCategory->flatten(1);
  @endphp

  <div class="max-w-6xl mx-auto px-4 py-14">
    @if($allSvcs->isEmpty())
    <div class="text-center py-24 bg-white rounded-3xl border border-gray-100">
      <div class="text-5xl mb-4">🔍</div>
      <h3 class="text-xl font-bold text-gray-900 mb-2">No services in this category</h3>
      <a href="{{ route('services.index') }}" class="mt-4 inline-block px-6 py-2.5 bg-purple-700 text-white rounded-xl font-semibold text-sm hover:bg-purple-800 transition-colors">View All</a>
    </div>
    @else
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
      @foreach($allSvcs as $idx => $svc)
      @php $p = $palette[$idx % count($palette)]; @endphp
      <a href="{{ route('services.show', $svc->slug) }}"
         class="svc-card group bg-white/95 backdrop-blur-md rounded-[32px] border border-slate-100/90 flex flex-col shadow-[0_2px_8px_-3px_rgba(0,0,0,0.04),0_10px_24px_-10px_rgba(0,0,0,0.03)] hover:shadow-[0_20px_40px_-15px_rgba(124,58,237,0.12),0_4px_12px_-5px_rgba(0,0,0,0.03)] hover:border-purple-200/60 hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden ring-1 ring-slate-900/[0.03]">
        {{-- Sliding top accent line matching specific palette gradient --}}
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r {{ $p['gradient'] }} transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left z-20"></div>

        {{-- Dynamic Dot Pattern Overlay --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

        {{-- Card Image / Gradient Header --}}
        <div class="relative h-28 sm:h-44 overflow-hidden rounded-t-[32px]">
          @if($svc->banner_image)
            <img src="{{ asset('storage/'.$svc->banner_image) }}" alt="{{ $svc->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
          @else
            <div class="w-full h-full bg-gradient-to-br {{ $p['gradient'] }} flex items-center justify-center relative">
              {{-- High premium dotted pattern --}}
              <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
              <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-lg transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                <i data-lucide="{{ $svc->icon ?? 'box' }}" class="w-8 h-8 text-white"></i>
              </div>
            </div>
          @endif

          {{-- Popular badge --}}
          @if($svc->is_popular)
          <div class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-md text-purple-300 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full shadow border border-white/10">🔥 Popular</div>
          @endif

          {{-- Category pill --}}
          <div class="absolute bottom-3 left-3">
            <span class="bg-slate-900/60 backdrop-blur-md text-white text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border border-white/10">{{ $svc->category }}</span>
          </div>
        </div>

        {{-- Content --}}
        <div class="p-3 sm:p-6 flex-1 flex flex-col">
          <h3 class="text-xs sm:text-lg font-bold text-slate-800 mb-1 sm:mb-2 group-hover:text-purple-700 transition-colors leading-snug tracking-tight line-clamp-2">{{ $svc->name }}</h3>
          <p class="text-[11px] sm:text-sm text-slate-500 leading-relaxed flex-1 line-clamp-2 font-normal hidden sm:block">{{ $svc->short_description }}</p>

          {{-- Features (desktop only) --}}
          @if(is_array($svc->features) && count($svc->features) > 0)
          <ul class="mt-4 space-y-1.5 hidden sm:block">
            @foreach(array_slice($svc->features, 0, 3) as $f)
            <li class="flex items-center gap-2 text-xs text-slate-600 font-medium">
              <svg class="w-3.5 h-3.5 text-purple-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
              <span class="truncate">{{ $f }}</span>
            </li>
            @endforeach
          </ul>
          @endif

          {{-- Price + CTA --}}
          <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
            @auth
            <div>
              <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Starting from</div>
              <div class="text-xl font-black text-slate-900">₹{{ number_format($svc->min_price) }}</div>
            </div>
            @else
            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-400">
              <i data-lucide="lock" class="w-3.5 h-3.5"></i>
              Login to view price
            </div>
            @endauth

            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 group-hover:bg-purple-700 group-hover:border-purple-700 flex items-center justify-center transition-all duration-300 shadow-sm">
              <i data-lucide="arrow-right" class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors"></i>
            </div>
          </div>
        </div>
      </a>
      @endforeach
    </div>
    @endif
  </div>

  {{-- ══════ PROCESS SECTION ══════ --}}
  <section class="py-20 px-4 bg-white border-t border-gray-100">
    <div class="max-w-5xl mx-auto">
      <div class="text-center mb-14">
        <p class="text-purple-600 font-bold text-sm uppercase tracking-widest mb-3">Our Process</p>
        <h2 class="text-3xl sm:text-4xl font-black text-gray-900">How We Deliver Excellence</h2>
      </div>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 relative">
        {{-- Connecting line (desktop) --}}
        <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-purple-100 via-purple-300 to-purple-100"></div>
        @foreach([
          ['01','Discovery','We deep-dive into your business goals, audience, and competitive landscape.','💡'],
          ['02','Strategy',  'We craft a data-driven roadmap with clear milestones and success metrics.','🗺️'],
          ['03','Execution', 'Our expert team builds, tests, and iterates at speed without sacrificing quality.','⚡'],
          ['04','Launch & Growth','We deploy, monitor, and continuously optimise for peak performance.','🚀'],
        ] as $step)
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:border-purple-200 hover:-translate-y-1 transition-all duration-300 relative group flex flex-col justify-between ring-1 ring-slate-900/5 min-h-[180px]">
          <div class="flex items-center justify-between mb-4">
            <span class="text-2xl group-hover:scale-110 transition-transform">{{ $step[3] }}</span>
            <span class="text-[10px] font-black text-purple-600 tracking-wider">Step {{ $step[0] }}</span>
          </div>
          <div>
            <h4 class="font-black text-slate-800 mb-1.5 text-sm group-hover:text-purple-700 transition-colors tracking-tight">{{ $step[1] }}</h4>
            <p class="text-xs text-slate-500 leading-relaxed font-normal">{{ $step[2] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ══════ CTA BANNER ══════ --}}
  <section class="py-16 px-4">
    <div class="max-w-4xl mx-auto bg-gradient-to-br from-purple-700 to-violet-800 rounded-3xl p-10 sm:p-14 text-center text-white relative overflow-hidden shadow-2xl shadow-purple-300/30">
      <div class="absolute top-0 right-0 w-80 h-80 opacity-20" style="background:radial-gradient(circle,#c084fc,transparent 70%);"></div>
      <h2 class="text-2xl sm:text-4xl font-black mb-4 relative z-10">Ready to Start Your Project?</h2>
      <p class="text-purple-200 mb-8 text-lg relative z-10">Get a free consultation and detailed proposal within 24 hours.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
        <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-purple-700 rounded-2xl font-bold hover:bg-purple-50 transition-all shadow-lg hover:-translate-y-0.5">
          Get Free Quote
        </a>
        <a href="https://wa.me/919999999999" target="_blank" class="px-8 py-4 bg-white/10 border border-white/20 text-white rounded-2xl font-bold hover:bg-white/20 transition-all backdrop-blur-md flex items-center justify-center gap-2">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Us
        </a>
      </div>
    </div>
  </section>

  {{-- ══════ WHY CHOOSE SECTION ══════ --}}
  <section class="py-16 px-4 bg-white border-t border-gray-100">
    <div class="max-w-5xl mx-auto">
      <div class="text-center mb-10">
        <h2 class="text-2xl sm:text-3xl font-black text-gray-900">Why SKSolutions</h2>
      </div>
      @php
        $whyCards = [
          ['icon'=>'trophy',      'text-color'=>'text-purple-600',  'bg-color'=>'bg-purple-50',  'border-color'=>'border-purple-100',  'title'=>'Award-Winning Work',  'desc'=>'Recognized for design excellence and performance marketing.'],
          ['icon'=>'zap',         'text-color'=>'text-blue-600',    'bg-color'=>'bg-blue-50',    'border-color'=>'border-blue-100',    'title'=>'Fast Delivery',       'desc'=>'No delays. Agile sprints with daily progress updates.'],
          ['icon'=>'shield-check','text-color'=>'text-emerald-600', 'bg-color'=>'bg-emerald-50', 'border-color'=>'border-emerald-100', 'title'=>'100% Transparency',   'desc'=>'Fixed pricing, no hidden fees. You own everything.'],
          ['icon'=>'trending-up', 'text-color'=>'text-orange-600',  'bg-color'=>'bg-orange-50',  'border-color'=>'border-orange-100',  'title'=>'ROI Focused',         'desc'=>'Every decision is backed by data and real business metrics.'],
        ];
      @endphp

      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
        @foreach($whyCards as $w)
        <div class="bg-white rounded-3xl p-6 border border-slate-100/80 hover:border-purple-200/60 shadow-sm hover:shadow-md transition-all duration-300 group ring-1 ring-slate-900/5">
          <div class="w-12 h-12 rounded-xl {{ $w['bg-color'] }} border {{ $w['border-color'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <i data-lucide="{{ $w['icon'] }}" class="w-6 h-6 {{ $w['text-color'] }}"></i>
          </div>
          <h4 class="font-bold text-slate-800 mb-1.5 text-sm group-hover:text-purple-700 transition-colors tracking-tight">{{ $w['title'] }}</h4>
          <p class="text-xs text-slate-500 leading-relaxed font-normal">{{ $w['desc'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

</div>

<style>.scrollbar-hide::-webkit-scrollbar{display:none}.scrollbar-hide{-ms-overflow-style:none;scrollbar-width:none}</style>
@endsection
