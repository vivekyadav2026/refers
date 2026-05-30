@extends('layouts.app')
@section('title', $service->name . ' — SKSolutions Partner Network')
@section('hide_nav_footer', true)

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;900&display=swap');

body {
    background-color: #fafafa;
    font-family: 'Roboto', sans-serif;
    -webkit-tap-highlight-color: transparent;
}

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1.05); }
    50% { transform: translateY(-8px) scale(1.07); }
}
.banner-mockup-float { animation: float 6s ease-in-out infinite; }

.bottom-nav { padding-bottom: env(safe-area-inset-bottom); }

/* Plan tab styles */
.plan-tab-btn {
    transition: all 0.2s ease;
    position: relative;
}
.plan-tab-btn.active {
    color:black;
}
.plan-tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0; right: 0;
    height: 2px;
    border-radius: 2px 2px 0 0;
}

.plan-feature-check {
    color: black;
}
</style>

<!-- Sticky Header -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100/80 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 select-none">
            <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-12 sm:h-14 w-auto object-contain">
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ route('landing') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('landing') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('services.*') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Services</a>
            <a href="{{ route('landing') }}#why-choose-us" class="text-sm font-bold text-slate-600 hover:text-indigo-800 transition-colors">Why Choose Us</a>
            <a href="{{ route('contact') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('contact') ? 'text-indigo-800' : 'text-slate-600 hover:text-indigo-800' }}">Contact</a>
        </nav>

        <!-- Right Actions -->
        <div class="flex items-center gap-4">
            <!-- Notification Bell -->
            <div class="relative" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
                <button type="button" @click="notifOpen = !notifOpen" class="p-2 text-slate-700 hover:text-indigo-800 transition-colors relative focus:outline-none rounded-full hover:bg-slate-100">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                </button>
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
                                 <div class="text-[15px] text-slate-500 font-[400] mt-0.5">Explore our premium digital agency services and scale your business today.</div>
                                 <div class="text-[9px] text-slate-400 mt-1">Just now</div>
                             </div>
                         </div>
                     </div>
                </div>
            </div>

            @auth
                @php
                    $user = auth()->user();
                    $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(array_filter(explode(' ', trim($user->name))), 0, 2))));
                    $dashUrl = match($user->role) {
                        'admin'   => route('admin.dashboard'),
                        'partner' => route('partner.dashboard'),
                        default   => route('customer.dashboard'),
                    };
                @endphp
                <div class="relative" x-data="{ profileOpen: false }" @click.away="profileOpen = false">
                    <button type="button" @click="profileOpen = !profileOpen" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-bold text-xs sm:text-sm flex items-center justify-center transition-colors focus:outline-none ring-2 ring-indigo-50/50 hover:ring-indigo-100">
                        {{ $initials }}
                    </button>
                    <div x-show="profileOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-3 w-48 bg-white rounded-[16px] shadow-xl border border-slate-100 z-50 overflow-hidden"
                         style="display:none">
                         <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                             <div class="text-xs font-bold text-slate-800 truncate">{{ $user->name }}</div>
                             <div class="text-[15px] text-slate-500 font-[400] truncate mt-0.5">{{ $user->email ?: $user->phone }}</div>
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

            <!-- Desktop CTA -->
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    @php
                        $dashUrl = match(auth()->user()->role) {
                            'admin'   => route('admin.dashboard'),
                            'partner' => route('partner.dashboard'),
                            default   => route('customer.dashboard'),
                        };
                    @endphp
                    <a href="{{ $dashUrl }}" class="inline-flex items-center gap-2 bg-[#0d1f0b] text-balck px-6 py-2.5 rounded-full font-bold text-sm shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:bg-[#0d1f0b] transition-all hover:-translate-y-0.5 active:translate-y-0">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-800 transition-colors px-3 py-2">Log in</a>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 bg-[#0d1f0b] text-black px-6 py-2.5 rounded-full font-bold text-sm shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:bg-[#0d1f0b] transition-all hover:-translate-y-0.5 active:translate-y-0">
                        Explore Services <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

@php
    $plans = $service->plans ?? [];
    if (!empty($plans)) {
        $plans = array_filter($plans, function($p) {
            return ($p['active'] ?? true) == true;
        });
    }
    $hasPlan = !empty($plans);

    // Fallback legacy plan if no plans set
    if (!$hasPlan) {
        $plans = [
            'basic'    => ['name' => 'Basic', 'price' => $service->min_price, 'description' => $service->short_description, 'delivery' => $service->delivery_timeline ?? '', 'features' => $service->features ?? [], 'emoji' => '🌱'],
            'standard' => ['name' => 'Standard', 'price' => $service->min_price * 1.5, 'description' => 'Standard package with more features', 'delivery' => '', 'features' => $service->features ?? [], 'emoji' => '⭐'],
            'premium'  => ['name' => 'Premium', 'price' => $service->min_price * 2.5, 'description' => 'Premium package — everything included', 'delivery' => '', 'features' => $service->features ?? [], 'emoji' => '👑'],
        ];
    }
    
    // Select first plan as default
    $defaultPlanKey = array_key_first($plans) ?? 'Basic';
    
    // Charges (Admin Toggles)
    $enableGst = \App\Models\Setting::get_val('enable_gst', '1') == '1';
    $gstPercent = (float) \App\Models\Setting::get_val('gst_percent', '18');
    $enableDomain = (\App\Models\Setting::get_val('enable_domain_charge', '1') == '1') && $service->requires_domain;
    $domainInCharge = (float) \App\Models\Setting::get_val('domain_in_charge_amount', '599');
    $domainComCharge = (float) \App\Models\Setting::get_val('domain_com_charge_amount', '999');
@endphp

<div x-data="{ 
    buyNowModal: false, 
    isProcessing: false, 
    selectedPlan: '{{ addslashes($defaultPlanKey) }}', 
    selectedPlanData: {{ json_encode($plans) }},
    platformsData: {{ json_encode($service->platforms ?? []) }},
    enablePlatforms: {{ $service->enable_platforms ? 'true' : 'false' }},
    selectedPlatformIndex: {{ ($service->enable_platforms && !empty($service->platforms)) ? 0 : 'null' }},
    enableGst: {{ $enableGst ? 'true' : 'false' }},
    gstPercent: {{ $gstPercent }},
    enableDomain: {{ $enableDomain ? 'true' : 'false' }},
    domainChoice: 'in',
    domainName: '',
    domainInCharge: {{ $domainInCharge }},
    domainComCharge: {{ $domainComCharge }},
    get subtotal() {
        let base = Number(this.selectedPlanData[this.selectedPlan]?.price || 0);
        let platformExtra = 0;
        if (this.enablePlatforms && this.selectedPlatformIndex != null && this.platformsData[this.selectedPlatformIndex]) {
            platformExtra = Number(this.platformsData[this.selectedPlatformIndex].price || 0);
        }
        return base + platformExtra;
    },
    get gstAmount() {
        return this.enableGst ? (this.subtotal * (this.gstPercent / 100)) : 0;
    },
    get domainChargeAmount() {
        if (!this.enableDomain) return 0;
        if (this.domainChoice === 'in') return this.domainInCharge;
        if (this.domainChoice === 'com') return this.domainComCharge;
        return 0;
    },
    get finalTotal() {
        return this.subtotal + this.gstAmount + this.domainChargeAmount;
    }
}"
     @processing-start.window="isProcessing = true"
     @processing-end.window="isProcessing = false"
     class="bg-white min-h-screen relative overflow-hidden">

    <!-- Ambient blobs -->
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

        {{-- HERO --}}
        <div class="mb-6 max-w-4xl relative z-10">
            @if($service->category || $service->is_popular)
            <div class="flex flex-wrap items-center gap-2 mb-3">
                @if($service->category)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-200/40 text-blue-700 text-[9px] font-bold uppercase tracking-wider">
                    <i data-lucide="{{ $service->icon ?? 'box' }}" class="w-3 h-3"></i> {{ $service->category }}
                </span>
                @endif
                @if($service->is_popular)
                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-800 border border-amber-200/40 text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                    🔥 Hot Selling Service
                </span>
                @endif
            </div>
            @endif
            <h1 class="text-[20px] font-[600] text-slate-900 tracking-tight leading-tight mb-3">
                {{ $service->name }} (<span class="capitalize" x-text="selectedPlanData[selectedPlan]?.name || selectedPlan"></span>)
            </h1>
            @if($service->short_description)
            <p class="text-[15px] text-slate-500 font-[400] font-medium leading-relaxed max-w-2xl">
                {{ $service->short_description }}
            </p>
            @endif
            @if(count($plans) > 0)
            <div class="mt-4 flex items-center gap-3">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-text="selectedPlan === '{{ $defaultPlanKey }}' ? 'Starting from' : 'Selected Plan Price'"></span>
                <!-- <span class="text-[32px] font-[700] text-indigo-700" x-text="'₹' + Number(selectedPlanData[selectedPlan]?.price || 0).toLocaleString('en-IN')"></span> -->
            </div>
            @endif
        </div>

        {{-- TWO-COLUMN GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start relative z-10">

            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                {{-- ABOUT CARD --}}
                @if($service->description)
                <div class="bg-white rounded-[16px] p-5 sm:p-6 lg:p-7 border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.015)] relative overflow-hidden transition-all duration-300 hover:shadow-md">
                    <h3 class="text-[20px] font-[600] text-slate-900 mb-3 tracking-tight flex items-center gap-2">
                        <span class="w-1 h-5 bg-indigo-600 rounded-full"></span> About This Service
                    </h3>
                    <div class="prose prose-slate max-w-none text-slate-600 font-medium leading-relaxed text-xs sm:text-sm space-y-3 font-sans">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>
                @endif

                {{-- REQUIREMENTS CARD --}}
                @if($service->requirements_text)
                <div class="bg-indigo-50/10 rounded-[16px] p-5 sm:p-6 lg:p-7 border border-indigo-100/50 relative overflow-hidden transition-all duration-300 hover:shadow-sm">
                    <h3 class="text-[20px] font-[600] text-indigo-950 mb-2.5 tracking-tight flex items-center gap-2">
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

            {{-- RIGHT COLUMN --}}
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">

                {{-- ── PLATFORM SELECTOR ──────────────────────────── --}}
                <template x-if="enablePlatforms && platformsData.length > 0">
                    <div class="bg-white rounded-[16px] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.015)] p-5 sm:p-6">
                        <h4 class="text-[17px] font-[600] text-slate-900 mb-4 flex items-center gap-2"><i data-lucide="layers" class="w-5 h-5 text-indigo-500"></i> Select Platform</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <template x-for="(platform, index) in platformsData" :key="index">
                                <label class="relative flex cursor-pointer rounded-xl p-4 shadow-sm focus:outline-none transition-all"
                                    :class="selectedPlatformIndex == index ? 'border border-indigo-500 bg-indigo-50 ring-1 ring-indigo-500' : 'border border-slate-200 bg-white hover:border-indigo-400'">
                                    <input type="radio" name="platform_choice" class="sr-only" :value="index" x-model="selectedPlatformIndex">
                                    <div class="flex w-full items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="text-sm">
                                                <p x-text="platform.name" class="font-bold text-slate-900"></p>
                                                <p x-show="platform.price > 0" x-text="'+ ₹' + Number(platform.price).toLocaleString('en-IN')" class="text-xs text-slate-500 font-semibold"></p>
                                                <p x-show="platform.price <= 0" class="text-xs text-slate-500 font-semibold">Included</p>
                                            </div>
                                        </div>
                                        <svg x-show="selectedPlatformIndex == index" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-indigo-600"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                    </div>
                                </label>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- ── PLAN SELECTOR CARD ──────────────────────────── --}}
                <div class="bg-white rounded-[16px] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.015)] overflow-hidden">

                    <!-- Plan Tabs -->
                    <div class="flex border-b border-slate-100 bg-slate-100 overflow-x-auto">
                        @foreach($plans as $planKey => $planMeta)
                        <button
                            type="button"
                            @click="selectedPlan = '{{ addslashes($planKey) }}'"
                            :class="selectedPlan === '{{ addslashes($planKey) }}' ? 'plan-tab-btn active text-[#0d1f0b] font-[600] bg-white border-b-2 border-[#0d1f0b]' : 'plan-tab-btn text-slate-500 font-bold hover:text-slate-700 hover:bg-slate-100'"
                            class="flex-1 min-w-fit px-4 py-4 text-[17px] uppercase tracking-wider relative transition-all font-[600] whitespace-nowrap">
                            {{ $planMeta['emoji'] ?? '' }} <span class="capitalize" x-text="selectedPlanData['{{ addslashes($planKey) }}']?.name || '{{ $planKey }}'"></span>
                        </button>
                        @endforeach
                    </div>

                    <!-- Plan Content (Alpine driven) -->
                    <div class="p-5 sm:p-6">

                        <!-- Price + Description -->
                        <div class="mb-5">
                            <div class="flex items-end gap-2 mb-1">
                                <span class="text-[32px] font-[700] text-slate-900" x-text="'₹' + subtotal.toLocaleString('en-IN')"></span>
                                <span class="text-xs text-slate-400 font-bold mb-1">/ project</span>
                            </div>
                            <p class="text-[15px] text-slate-500 font-[400] font-medium leading-relaxed" x-text="selectedPlanData[selectedPlan]?.description || ''"></p>
                        </div>

                        <!-- Delivery -->
                        <div class="flex items-center gap-4 mb-5 pb-5 border-b border-slate-100" x-show="selectedPlanData[selectedPlan]?.delivery">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Delivery</div>
                                    <div class="text-xs font-black text-slate-800" x-text="selectedPlanData[selectedPlan]?.delivery"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Features List -->
                        <div class="mb-5 space-y-2" x-show="selectedPlanData[selectedPlan]?.features?.length">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-3">Package Details</div>
                            <template x-for="feature in (selectedPlanData[selectedPlan]?.features || [])" :key="feature">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <i data-lucide="check" class="w-2.5 h-2.5" stroke-width="3"></i>
                                    </div>
                                    <span class="text-[15px] text-slate-700 font-[400] leading-snug" x-text="feature"></span>
                                </div>
                            </template>
                        </div>

                        <!-- DOMAIN SELECTION ON MAIN PAGE -->
                        <template x-if="enableDomain">
                            <div class="mb-5 bg-slate-50 border border-slate-200 rounded-[16px] p-4">
                                <label class="block text-[10px] sm:text-xs font-black text-slate-700 mb-2.5 uppercase tracking-wider">Select Domain Option</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <label class="flex flex-col items-center justify-center p-2.5 rounded-full border cursor-pointer transition-all text-center"
                                        :class="domainChoice === 'in' ? 'border-indigo-600 bg-indigo-50 text-indigo-700 font-bold' : 'border-slate-200 hover:border-slate-350 text-slate-600 bg-white'">
                                        <input type="radio" name="main_domain_choice" value="in" x-model="domainChoice" class="sr-only">
                                        <span class="text-xs">.in</span>
                                        <span class="text-[12px] text-slate-500 font-[400] mt-0.5 font-normal" x-text="'₹' + domainInCharge"></span>
                                    </label>
                                    <label class="flex flex-col items-center justify-center p-2.5 rounded-full border cursor-pointer transition-all text-center"
                                        :class="domainChoice === 'com' ? 'border-indigo-600 bg-indigo-50 text-indigo-700 font-bold' : 'border-slate-200 hover:border-slate-350 text-slate-600 bg-white'">
                                        <input type="radio" name="main_domain_choice" value="com" x-model="domainChoice" class="sr-only">
                                        <span class="text-xs">.com</span>
                                        <span class="text-[12px] text-slate-500 font-[400] mt-0.5 font-normal" x-text="'₹' + domainComCharge"></span>
                                    </label>
                                    <label class="flex flex-col items-center justify-center p-2.5 rounded-full border cursor-pointer transition-all text-center"
                                        :class="domainChoice === 'already_have' ? 'border-indigo-600 bg-indigo-50 text-indigo-700 font-bold' : 'border-slate-200 hover:border-slate-350 text-slate-650 bg-white'">
                                        <input type="radio" name="main_domain_choice" value="already_have" x-model="domainChoice" class="sr-only">
                                        <span class="text-[11px] leading-tight mt-1">Already Have</span>
                                        <span class="text-[12px] text-slate-500 font-[400] mt-0.5 font-normal">₹0</span>
                                    </label>
                                </div>
                                <!-- <div class="mt-3">
                                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider" x-text="domainChoice === 'already_have' ? 'Your Existing Domain Name *' : 'Preferred Domain Name'"></label>
                                    <input type="text" x-model="domainName" class="w-full px-3.5 py-2.5 rounded-full border border-slate-200 text-slate-800 text-xs bg-white outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all font-sans" placeholder="e.g. www.example.com">
                                </div> -->
                            </div>
                        </template>

                        <!-- TOTAL SUMMARY ON MAIN PAGE -->
                        <div class="mb-5 space-y-2 border-t border-slate-100 pt-4 px-1">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium">Subtotal</span>
                                <span class="text-slate-700 font-bold" x-text="'₹' + subtotal.toLocaleString('en-IN')"></span>
                            </div>
                            <template x-if="enableDomain">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-500 font-medium">Domain <span class="text-[10px]" x-text="domainChoice === 'in' ? '(.in)' : (domainChoice === 'com' ? '(.com)' : '')"></span></span>
                                    <span class="text-slate-700 font-bold" x-text="'+ ₹' + domainChargeAmount.toLocaleString('en-IN')"></span>
                                </div>
                            </template>
                            <template x-if="enableGst">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-500 font-medium" x-text="'GST (' + gstPercent + '%)'"></span>
                                    <span class="text-slate-700 font-bold" x-text="'+ ₹' + gstAmount.toLocaleString('en-IN')"></span>
                                </div>
                            </template>
                            <div class="flex justify-between items-center text-[18px] font-black text-indigo-900 border-t border-slate-100 pt-3 mt-3">
                                <span>Total Price</span>
                                <span x-text="'₹' + finalTotal.toLocaleString('en-IN')"></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @auth
                            @if(auth()->user()->isCustomer())
                            <button type="button" @click="buyNowModal = true"
                                class="w-full py-3.5 rounded-[16px] text-[18px] font-[600] tracking-wide text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                                Order Now — <span x-text="'₹' + finalTotal.toLocaleString('en-IN')"></span>
                            </button>
                            @endif

                            @if(auth()->user()->isPartner() || auth()->user()->isAdmin())
                            <div class="flex items-center gap-3 mb-4 text-[9px] text-slate-400 uppercase tracking-widest font-black">
                                <div class="h-px bg-slate-100 flex-1"></div>
                                <span>Submit Lead</span>
                                <div class="h-px bg-slate-100 flex-1"></div>
                            </div>
                                <form action="{{ route('partner.leads.store') }}" method="POST" class="space-y-3 font-sans">
                                    @csrf
                                    <input type="hidden" name="service_needed" value="{{ $service->name }}">
                                    <input type="hidden" name="plan_selected" x-bind:value="selectedPlan">
                                    <template x-if="enablePlatforms && selectedPlatformIndex != null">
                                        <input type="hidden" name="platform_choice" :value="platformsData[selectedPlatformIndex]?.name">
                                    </template>
                                    <div>
                                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Client Full Name *</label>
                                    <input type="text" name="client_name" required class="w-full px-3.5 py-2.5 rounded-full border border-slate-200 text-slate-800 text-xs bg-slate-50 outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all" placeholder="e.g. Rahul Sharma">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Client Phone Number *</label>
                                    <input type="tel" name="client_phone" required class="w-full px-3.5 py-2.5 rounded-full border border-slate-200 text-slate-800 text-xs bg-slate-50 outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all" placeholder="+91 9999999999">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Project Requirements</label>
                                    <textarea name="notes" rows="2" class="w-full px-3.5 py-2.5 rounded-full border border-slate-200 text-slate-800 text-xs bg-slate-50 outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all resize-none" placeholder="Deliverables, details..."></textarea>
                                </div>
                                <button type="submit" class="w-full py-2.5 rounded-full text-[10px] font-black tracking-widest uppercase text-white bg-indigo-600 hover:bg-indigo-700 shadow-md transition-all hover:-translate-y-0.5 flex items-center justify-center gap-1.5 active:translate-y-0 cursor-pointer mt-1">
                                    <i data-lucide="send" class="w-3.5 h-3.5"></i> Submit Lead
                                </button>
                            </form>
                            @endif
                        @else
                            <div class="bg-slate-50 border border-slate-200 rounded-[16px] p-5 text-center mb-4">
                                <i data-lucide="lock" class="w-7 h-7 text-slate-400 mx-auto mb-2.5"></i>
                                <h4 class="text-sm font-black text-slate-800 mb-1">Sign In to Order</h4>
                                <p class="text-[15px] text-slate-500 font-[400] leading-normal mb-4 font-semibold">Sign in to purchase or submit client leads.</p>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-1.5 w-full py-3 bg-[#0d1f0b] text-black font-[600] text-[18px] tracking-wider rounded-full hover:bg-[#0d1f0b] shadow-md shadow-[#20C20E]/20 transition-all hover:-translate-y-0.5">
                                    Secure Sign In
                                </a>
                            </div>
                            <a href="https://wa.me/919999999999?text=Hi, I am interested in {{ urlencode($service->name) }}" target="_blank"
                               class="flex items-center justify-center gap-1.5 w-full py-2.5 rounded-full text-[10px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0">
                                <i data-lucide="message-circle" class="w-3.5 h-3.5"></i> Inquire via WhatsApp
                            </a>
                        @endauth

                    </div>
                </div>

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
                         class="relative transform overflow-hidden rounded-t-[32px] sm:rounded-[16px] bg-white text-left shadow-2xl transition-all w-full sm:w-full sm:max-w-lg border-t sm:border border-slate-200 mt-6 sm:mt-0"
                         @click.away="buyNowModal = false">

                        <!-- Mobile Drag Handle -->
                        <div class="w-full flex justify-center pt-3 pb-1 sm:hidden bg-slate-50">
                            <div class="w-12 h-1.5 bg-slate-300 rounded-full"></div>
                        </div>

                        <div class="px-4 sm:px-5 py-3 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <div>
                                <h3 class="text-[18px] font-[600] text-slate-900 flex items-center gap-2" id="modal-title">
                                    <i data-lucide="zap" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600"></i> Order Summary
                                </h3>
                                <p class="text-[13px] text-slate-500 font-[500] mt-0.5">Review your package details</p>
                            </div>
                            <button @click="buyNowModal = false" type="button" class="p-2 -mr-2 text-slate-400 hover:text-slate-600 transition-colors rounded-full hover:bg-slate-200/50">
                                <i data-lucide="x" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="px-4 sm:px-5 pt-4 pb-1 bg-slate-50">
                            <!-- Selected Package Summary -->
                            <div class="bg-white rounded-[16px] border border-slate-200 p-3 mb-3">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[18px] font-[600] text-slate-900" x-text="selectedPlan + ' Package'"></span>
                                    <span class="text-[24px] font-[700] text-indigo-700" x-text="'₹' + Number(selectedPlanData[selectedPlan]?.price || 0).toLocaleString('en-IN')"></span>
                                </div>
                                <p class="text-[13px] text-slate-500 font-[400] mb-3" x-text="selectedPlanData[selectedPlan]?.description"></p>
                                
                                <template x-if="enablePlatforms && selectedPlatformIndex != null && platformsData[selectedPlatformIndex]">
                                    <div class="border-t border-slate-100 pt-3 mt-3">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-slate-700 font-medium flex items-center gap-2"><i data-lucide="layers" class="w-3.5 h-3.5 text-indigo-500"></i> Platform: <span x-text="platformsData[selectedPlatformIndex].name"></span></span>
                                            <span class="font-bold text-slate-700" x-text="platformsData[selectedPlatformIndex].price > 0 ? '+ ₹' + Number(platformsData[selectedPlatformIndex].price).toLocaleString('en-IN') : 'Included'"></span>
                                        </div>
                                    </div>
                                </template>

                                <div class="space-y-2 border-t border-slate-100 pt-3 mt-3">
                                    <template x-if="enableGst">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500 font-medium" x-text="'GST (' + gstPercent + '%)'"></span>
                                            <span class="font-bold text-slate-700" x-text="'₹' + gstAmount.toLocaleString('en-IN')"></span>
                                        </div>
                                    </template>

                                    <template x-if="enableDomain">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500 font-medium">
                                                Domain
                                                <span class="text-[10px] text-slate-400" x-text="domainChoice === 'in' ? '(.in)' : (domainChoice === 'com' ? '(.com)' : '(Already Have)')"></span>
                                            </span>
                                            <span class="font-bold text-slate-700" x-text="'₹' + domainChargeAmount.toLocaleString('en-IN')"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Total -->
                            <div class="flex items-center justify-between bg-indigo-50 rounded-[12px] border border-indigo-100 p-3 mb-0">
                                <span class="text-sm font-black text-indigo-900">Total Amount</span>
                                <span class="text-[24px] font-[700] text-indigo-700" x-text="'₹' + finalTotal.toLocaleString('en-IN')"></span>
                            </div>
                        </div>

                        <form id="buyNowForm" class="px-4 sm:px-5 pt-2 pb-5 max-h-[80vh] overflow-y-auto">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <input type="hidden" name="plan_selected" x-bind:value="selectedPlan">
                            <input type="hidden" name="plan_price" x-bind:value="finalTotal">
                            <template x-if="enablePlatforms && selectedPlatformIndex != null && platformsData[selectedPlatformIndex]">
                                <input type="hidden" name="platform_choice" :value="platformsData[selectedPlatformIndex].name">
                            </template>
                            <template x-if="enablePlatforms && selectedPlatformIndex != null && platformsData[selectedPlatformIndex]">
                                <input type="hidden" name="platform_price" :value="platformsData[selectedPlatformIndex].price">
                            </template>

                            <div class="space-y-4 font-sans">
                                <template x-if="enableDomain">
                                    <div>
                                        <input type="hidden" name="domain_choice" :value="domainChoice">
                                        <input type="hidden" name="domain_name" :value="domainName">
                                    </div>
                                </template>

                                <div>
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Full Name *</label>
                                    @php
                                        $defaultName = auth()->check() ? 'User ' . substr(auth()->user()->phone, -4) : '';
                                        $displayName = auth()->check() && auth()->user()->name !== $defaultName ? auth()->user()->name : '';
                                    @endphp
                                    <input type="text" name="customer_name" value="{{ $displayName }}" required class="w-full px-4 py-3 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Mobile Number *</label>
                                    <input type="tel" name="customer_phone" value="{{ auth()->check() ? auth()->user()->phone : '' }}" required class="w-full px-4 py-3 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                                </div>
                                <!-- <div>
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Project Requirements *</label>
                                    <textarea name="requirements" rows="3" required class="w-full px-4 py-3 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all resize-none" placeholder="Describe your project requirements briefly..."></textarea>
                                </div> -->
                            </div>

                            <div class="mt-6 sm:mt-8 flex gap-3 pb-10 sm:pb-0">
                                <button type="button" @click="buyNowModal = false" class="w-1/3 py-3.5 rounded-full text-[10px] sm:text-xs font-black tracking-wider uppercase text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" x-bind:disabled="isProcessing" class="w-2/3 py-3.5 rounded-full text-[18px] font-[600] tracking-wider text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all flex justify-center items-center gap-2 disabled:opacity-70">
                                    <span x-show="!isProcessing">Pay <span x-text="'₹' + finalTotal.toLocaleString('en-IN')"></span></span>
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

<!-- Desktop Footer -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- Mobile Bottom Nav -->
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
                'admin'   => route('admin.dashboard'),
                'partner' => route('partner.orders'),
                default   => route('customer.orders'),
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
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
                    "handler": function(response) {
                        let verifyForm = document.createElement('form');
                        verifyForm.method = 'POST';
                        verifyForm.action = '{{ route('payment.verify') }}';
                        let fields = {
                            '_token': '{{ csrf_token() }}',
                            'order_id': data.order_id,
                            'razorpay_payment_id': response.razorpay_payment_id,
                            'razorpay_order_id': response.razorpay_order_id,
                            'razorpay_signature': response.razorpay_signature
                        };
                        Object.entries(fields).forEach(([name, value]) => {
                            let input = document.createElement('input');
                            input.type = 'hidden'; input.name = name; input.value = value;
                            verifyForm.appendChild(input);
                        });
                        document.body.appendChild(verifyForm);
                        verifyForm.submit();
                    },
                    "prefill": { "name": data.name, "email": data.email, "contact": data.contact },
                    "theme": { "color": "#4f46e5" },
                    "modal": { "ondismiss": function() { window.dispatchEvent(new CustomEvent('processing-end')); } }
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

