@extends('layouts.app')
@section('title', 'VivekTech Partner Network — Refer Premium Digital Services & Earn')
@section('content')

<div class="bg-slate-50 min-h-screen pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ===== HERO & HEADLINE ===== --}}
        <div class="text-center max-w-3xl mx-auto mb-10">
            <br>
            <br>
            <h1 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-[1.15] mb-4">
                Share Premium Services.<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700">Top-Tier Digital Service Delivery.</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-500 font-semibold max-w-2xl mx-auto leading-relaxed">
                Explore our high-ticket digital catalog. Purchase for your business or refer clients to earn direct bank payouts with zero upfront investment.
            </p>
        </div>

        {{-- ===== CAROUSEL BANNERS ===== --}}
        @if($banners->count() > 0)
        <div class="mb-14 relative" x-data="{ activeSlide: 0, slides: {{ $banners->count() }}, autoPlay() { setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides }, 4000) } }" x-init="autoPlay()">
            <div class="overflow-hidden rounded-3xl shadow-2xl border border-slate-200/80 bg-white">
                <div class="flex transition-transform duration-700 ease-out" :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                    @foreach($banners as $banner)
                    <div class="w-full shrink-0 relative aspect-[21/9] sm:aspect-[24/8] bg-gradient-to-r from-blue-900 to-indigo-950 overflow-hidden group">
                        <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover opacity-40 mix-blend-overlay group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent flex flex-col justify-end p-8 sm:p-14">
                            <span class="inline-block px-3 py-1 bg-blue-500 text-white font-black text-[10px] uppercase tracking-widest rounded-full mb-3 w-max shadow-md">Featured Offer</span>
                            <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight mb-4 max-w-2xl">{{ $banner->title }}</h2>
                            @if($banner->link)
                            <a href="{{ url($banner->link) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-600 font-extrabold text-sm rounded-xl hover:bg-blue-50 transition-all duration-300 w-max shadow-lg hover:-translate-y-0.5">
                                Explore Now <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Navigation Arrows --}}
            <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/90 text-slate-800 hover:bg-white shadow-xl flex items-center justify-center border border-slate-200 transition-all hover:scale-105 hidden sm:flex">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>
            <button @click="activeSlide = (activeSlide + 1) % slides" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/90 text-slate-800 hover:bg-white shadow-xl flex items-center justify-center border border-slate-200 transition-all hover:scale-105 hidden sm:flex">
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>

            {{-- Slider Dots --}}
            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-20">
                @foreach($banners as $index => $banner)
                <button @click="activeSlide = {{ $index }}" class="w-2.5 h-2.5 rounded-full transition-all duration-300 shadow-md" :class="activeSlide === {{ $index }} ? 'bg-blue-600 w-8' : 'bg-white/60 hover:bg-white'"></button>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ===== PERFORM & EARN CATEGORIES (QUICK TILES) ===== --}}
        <div class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Perform & Earn Categories</h2>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mt-0.5">High-ticket digital services by sector</p>
                </div>
                <a href="{{ route('services.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">See More <i data-lucide="chevron-right" class="w-4 h-4"></i></a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $catIcons = [
                        'Web Development' => ['icon' => 'globe-2', 'color' => 'blue', 'est' => '₹4,500+'],
                        'App Development' => ['icon' => 'smartphone', 'color' => 'indigo', 'est' => '₹6,000+'],
                        'Digital Marketing' => ['icon' => 'trending-up', 'color' => 'emerald', 'est' => '₹3,000+'],
                        'Video Editing' => ['icon' => 'video', 'color' => 'purple', 'est' => '₹2,500+'],
                        'Design & Branding' => ['icon' => 'palette', 'color' => 'amber', 'est' => '₹3,500+'],
                        'AI & Automation' => ['icon' => 'bot', 'color' => 'pink', 'est' => '₹5,000+'],
                    ];
                @endphp
                @foreach($categories as $cat)
                @php $info = $catIcons[$cat] ?? ['icon' => 'box', 'color' => 'blue', 'est' => '₹2,500+']; @endphp
                <a href="{{ route('services.index', ['category' => $cat]) }}" class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-{{ $info['color'] }}-300 transition-all duration-300 group flex flex-col items-center text-center hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-{{ $info['color'] }}-50 text-{{ $info['color'] }}-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300 border border-{{ $info['color'] }}-100 shadow-sm">
                        <i data-lucide="{{ $info['icon'] }}" class="w-7 h-7"></i>
                    </div>
                    <h3 class="font-bold text-xs text-slate-800 mb-3 line-clamp-1">{{ $cat }}</h3>
                    <div class="mt-auto px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-black tracking-wider uppercase shadow-xs">
                        @auth
                            <span class="text-emerald-700">Est. {{ $info['est'] }}</span>
                        @else
                            <i data-lucide="lock" class="w-3 h-3 inline mr-0.5 text-slate-400"></i> View Details
                        @endauth
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- ===== CATEGORIZED SERVICE LISTS ===== --}}
        <div class="space-y-16 mb-20">
            @foreach($servicesByCategory as $catName => $services)
            <div>
                <div class="flex items-center justify-between mb-6 border-b border-slate-200 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-8 bg-blue-600 rounded-full"></div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $catName }}</h2>
                    </div>
                    <a href="{{ route('services.index', ['category' => $catName]) }}" class="text-sm font-extrabold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">See More <i data-lucide="chevron-right" class="w-4 h-4"></i></a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $svc)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-200 transition-all duration-300 p-6 flex flex-col justify-between group relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-28 h-28 bg-blue-50 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500 -z-10"></div>
                        
                        <div>
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center border border-blue-200/60 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                                    @if($svc->banner_image)
                                        <img src="{{ asset('storage/' . $svc->banner_image) }}" alt="{{ $svc->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="{{ $svc->icon ?? 'box' }}" class="w-7 h-7 text-blue-600"></i>
                                    @endif
                                </div>
                                <div class="text-right">
                                    @auth
                                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">Client Price</span>
                                        <span class="text-lg font-black text-slate-900">₹{{ number_format($svc->min_price) }}</span>
                                    @else
                                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-[11px] font-extrabold text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full shadow-xs hover:bg-blue-100 transition-colors">
                                            <i data-lucide="lock" class="w-3 h-3"></i> View Price
                                        </a>
                                    @endauth
                                </div>
                            </div>
                            
                            <h3 class="font-black text-lg text-slate-900 mb-1 group-hover:text-blue-600 transition-colors leading-snug">{{ $svc->name }}</h3>
                            <p class="text-xs font-semibold text-slate-500 mb-6 line-clamp-2 leading-relaxed">{{ $svc->short_description }}</p>
                        </div>

                            <a href="{{ route('services.show', $svc->slug) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-black hover:bg-blue-700 transition-all shadow-md hover:shadow-blue-600/30 shrink-0 w-full">
                                View Details <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        {{-- ===== WHY CHOOSE VIVEKTECH PLATFORM ===== --}}
        <div class="bg-gradient-to-br from-slate-900 to-blue-950 rounded-3xl p-10 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-20">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-3xl mb-12">
                <span class="px-3 py-1 bg-white/10 text-blue-300 border border-white/10 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">App-Like Partner Experience</span>
                <h2 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 leading-tight">Built for entrepreneurs, creators, and agencies.</h2>
                <p class="text-slate-300 font-semibold text-base sm:text-lg leading-relaxed">Submit client requirements, track order timelines in real-time, and withdraw your accumulated earnings instantly directly to your verified bank account.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-10 border-t border-white/10 font-sans font-medium">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center mb-4"><i data-lucide="zap" class="w-6 h-6"></i></div>
                    <div class="text-xl font-bold text-white mb-1">Instant Tracking</div>
                    <div class="text-sm text-slate-400 font-medium">Get real-time SMS & email notifications the moment your referred client makes a purchase.</div>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4"><i data-lucide="shield-check" class="w-6 h-6"></i></div>
                    <div class="text-xl font-bold text-white mb-1">100% Transparent</div>
                    <div class="text-sm text-slate-400 font-medium">Clear breakdown of order values, status milestones, and delivery schedules.</div>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-4"><i data-lucide="banknote" class="w-6 h-6"></i></div>
                    <div class="text-xl font-bold text-white mb-1">Fast Bank Payouts</div>
                    <div class="text-sm text-slate-400 font-medium">Transfer your wallet balance directly to your bank account with automated NEFT/IMPS processing.</div>
                </div>
            </div>
        </div>

        {{-- ===== BOTTOM CTA ===== --}}
        <!-- <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-12 text-center max-w-4xl mx-auto relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-50/50 to-transparent"></div>
            <div class="relative z-10">
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-4">Start your earning journey today.</h2>
                <p class="text-slate-500 font-semibold text-base max-w-xl mx-auto mb-8">Join hundreds of active partners who are generating reliable secondary income every month.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-10 py-5 rounded-2xl text-base font-extrabold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-xl shadow-blue-600/30 transition-all hover:-translate-y-1">
                    <i data-lucide="user-plus" class="w-5 h-5"></i> Create Free Partner Account
                </a>
            </div>
        </div> -->

    </div>
</div>

@endsection
