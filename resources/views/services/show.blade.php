@extends('layouts.app')
@section('title', $service->name . ' — SKSolutions Partner Network')
@section('hide_nav_footer', true)

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

body {
    background-color: #fafafa;
    font-family: 'Poppins', sans-serif;
    -webkit-tap-highlight-color: transparent;
}

/* Force Poppins globally on this page */
html, body, p, div, span, h1, h2, h3, h4, h5, h6, a, button, input, select, textarea, label {
    font-family: 'Poppins', sans-serif !important;
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
            @auth
            @php $unread = auth()->user()->unreadNotifications->take(10); @endphp
            <div class="relative" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
                <button type="button" @click="notifOpen = !notifOpen" class="p-2 text-slate-700 hover:text-indigo-800 transition-colors relative focus:outline-none rounded-full hover:bg-slate-100">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                    @if($unread->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    @endif
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
                         @if($unread->count() > 0)
                         <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-[10px] font-black">{{ $unread->count() }} new</span>
                         @endif
                     </div>
                     <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-50">
                         @forelse($unread as $notif)
                         <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="m-0">
                             @csrf
                             <button type="submit" class="w-full text-left p-4 hover:bg-slate-50 transition-colors flex items-start gap-3 bg-transparent border-0 cursor-pointer">
                                 <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 shrink-0">
                                     <i data-lucide="bell" class="w-4 h-4"></i>
                                 </div>
                                 <div class="min-w-0 flex-1">
                                     <div class="text-xs font-bold text-slate-900 truncate">{{ $notif->data['title'] ?? 'Notification' }}</div>
                                     <div class="text-[15px] text-slate-500 font-[400] mt-0.5 line-clamp-2 leading-relaxed">{{ $notif->data['message'] ?? '' }}</div>
                                     <div class="text-[9px] text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                                 </div>
                             </button>
                         </form>
                         @empty
                         <div class="p-6 text-center">
                             <p class="text-xs font-bold text-slate-500">All caught up!</p>
                             <p class="text-[10px] text-slate-400 mt-0.5">No new notifications</p>
                         </div>
                         @endforelse
                     </div>
                </div>
            </div>
            @else
            <div class="relative" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
                <button type="button" @click="notifOpen = !notifOpen" class="p-2 text-slate-700 hover:text-indigo-800 transition-colors relative focus:outline-none rounded-full hover:bg-slate-100">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                </button>
                <div x-show="notifOpen" class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-100 z-50 overflow-hidden" style="display:none">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                        <span class="text-sm font-black text-slate-800">Notifications</span>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-xs font-bold text-slate-500">Log in to view notifications</p>
                    </div>
                </div>
            </div>
            @endauth

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
                    <a href="{{ $dashUrl }}" class="inline-flex items-center gap-2 bg-[#0d1f0b] text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:bg-[#0d1f0b] transition-all hover:-translate-y-0.5 active:translate-y-0">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-800 transition-colors px-3 py-2">Log in</a>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 bg-[#0d1f0b] text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:bg-[#0d1f0b] transition-all hover:-translate-y-0.5 active:translate-y-0">
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
            'basic'    => ['name' => 'Basic', 'price' => $service->min_price, 'description' => $service->short_description, 'delivery' => $service->delivery_timeline ?? '', 'features' => $service->features ?? [], 'emoji' => ''],
            'standard' => ['name' => 'Standard', 'price' => $service->min_price * 1.5, 'description' => 'Standard package with more features', 'delivery' => '', 'features' => $service->features ?? [], 'emoji' => ''],
            'premium'  => ['name' => 'Premium', 'price' => $service->min_price * 2.5, 'description' => 'Premium package — everything included', 'delivery' => '', 'features' => $service->features ?? [], 'emoji' => ''],
        ];
    }
    
    // Select first plan as default
    $defaultPlanKey = array_key_first($plans) ?? 'Basic';
    
    // Charges (Admin Toggles)
    $enableGst = (bool) $service->enable_gst;
    $gstPercent = (float) ($service->gst_percent ?? 18.00);
    $enableDomain = (bool) $service->requires_domain;
    $domainInCharge = (float) ($service->domain_in_charge ?? 599.00);
    $domainComCharge = (float) ($service->domain_com_charge ?? 999.00);
    $supportPhone = \App\Models\Setting::get_val('support_phone', '+91 8287121769');
    $cleanPhone = preg_replace('/[^0-9]/', '', $supportPhone);
@endphp

<div x-data="{ 
    buyNowModal: false, 
    isProcessing: false, 
    selectedPlan: '{{ addslashes($defaultPlanKey) }}', 
    selectedPlanData: {{ json_encode($plans) }},
    platformsData: {{ json_encode($service->platforms ?? []) }},
    pricingMatrix: {{ json_encode($service->pricing_matrix ?? []) }},
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
        if (this.enablePlatforms && this.selectedPlatformIndex != null && this.platformsData[this.selectedPlatformIndex]) {
            let platformName = this.platformsData[this.selectedPlatformIndex].name;
            let planName = this.selectedPlanData[this.selectedPlan]?.name || this.selectedPlan;
            
            // Try Matrix First
            if (this.pricingMatrix && this.pricingMatrix[platformName] && this.pricingMatrix[platformName][planName] !== undefined) {
                return Number(this.pricingMatrix[platformName][planName]);
            }
            
            // Fallback for legacy
            let base = Number(this.selectedPlanData[this.selectedPlan]?.price || 0);
            let platformExtra = Number(this.platformsData[this.selectedPlatformIndex].price || 0);
            return base + platformExtra;
        }
        
        return Number(this.selectedPlanData[this.selectedPlan]?.price || 0);
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
    couponCode: '',
    couponDiscount: 0,
    couponError: '',
    couponApplied: false,
    couponsData: {{ Js::from($activeCoupons->map(function($c) { return ['code'=>$c->code,'type'=>$c->discount_type,'value'=>(float)$c->discount_value,'min'=>(float)($c->min_order_amount ?? 0),'service_id'=>$c->service_id]; })->values()) }},
    applyCoupon() {
        const code = this.couponCode.trim().toUpperCase();
        if (!code) { this.couponError = 'Please enter a coupon code.'; return; }
        const coupon = this.couponsData.find(c => c.code.toUpperCase() === code);
        if (!coupon) { this.couponError = 'Invalid coupon code.'; this.couponApplied = false; this.couponDiscount = 0; return; }
        const base = this.subtotal + this.gstAmount + this.domainChargeAmount;
        if (coupon.min > 0 && base < coupon.min) { this.couponError = 'Min order ₹' + coupon.min + ' required.'; this.couponApplied = false; this.couponDiscount = 0; return; }
        if (coupon.type === 'percent') {
            this.couponDiscount = Math.round(base * coupon.value / 100);
        } else {
            this.couponDiscount = Math.min(coupon.value, base);
        }
        this.couponApplied = true;
        this.couponError = '';
        this.couponCode = coupon.code;
    },
    removeCoupon() {
        this.couponApplied = false;
        this.couponDiscount = 0;
        this.couponCode = '';
        this.couponError = '';
    },
    get finalTotal() {
        const base = this.subtotal + this.gstAmount + this.domainChargeAmount;
        return Math.max(0, base - (this.couponApplied ? this.couponDiscount : 0));
    }
}"
     @processing-start.window="isProcessing = true"
     @processing-end.window="isProcessing = false"
     class="bg-white min-h-screen relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-28 lg:pb-16 relative z-10">

        {{-- BREADCRUMBS --}}
        <nav class="flex items-center gap-2 text-[11px] font-[600] text-slate-400 mb-8 uppercase tracking-wider relative z-10 w-full overflow-hidden">
            <a href="{{ url('/') }}" class="hover:text-slate-800 transition-colors shrink-0">Home</a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('services.index') }}" class="hover:text-slate-800 transition-colors shrink-0">Services</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 truncate">{{ $service->name }}</span>
        </nav>

        {{-- HERO --}}
        <div class="mb-12 max-w-4xl relative z-10">
            @if($service->category || $service->is_popular)
            <div class="flex flex-wrap items-center gap-2 mb-5">
                @if($service->category)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">
                    <i data-lucide="{{ $service->icon ?? 'box' }}" class="w-3 h-3"></i> {{ $service->category }}
                </span>
                @endif
                @if($service->is_popular)
                <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-md">
                    Popular
                </span>
                @endif
            </div>
            @endif
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-[800] text-slate-900 tracking-tight leading-[1.15] mb-5">
                {{ $service->name }} <span class="text-slate-400 font-[400]">(<span class="capitalize" x-text="selectedPlanData[selectedPlan]?.name || selectedPlan"></span>)</span>
            </h1>
            @if($service->short_description)
            <p class="text-[16px] sm:text-[18px] text-slate-500 font-[400] leading-relaxed">
                {{ $service->short_description }}
            </p>
            @endif
        </div>

        {{-- TWO-COLUMN GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start relative z-10">

            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                {{-- ABOUT CARD --}}
                @if($service->description)
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200">
                    <h3 class="text-[18px] sm:text-[20px] font-[700] text-slate-900 mb-5 tracking-tight">About This Service</h3>
                    <div class="prose prose-slate max-w-none text-slate-600 font-[400] leading-relaxed text-[15px] sm:text-[16px] space-y-4">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>
                @endif

                {{-- REQUIREMENTS CARD --}}
                @if($service->requirements_text)
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 mt-6">
                    <h3 class="text-[18px] sm:text-[20px] font-[700] text-slate-900 mb-5 tracking-tight">What We Need From You</h3>
                    <div class="text-slate-600 font-[400] leading-relaxed text-[15px] sm:text-[16px] space-y-4">
                        {!! nl2br(e($service->requirements_text)) !!}
                    </div>
                </div>
                @endif

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">

                {{-- ── PLATFORM SELECTOR ──────────────────────────── --}}
                <template x-if="enablePlatforms && platformsData.length > 0">
                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h4 class="text-[16px] font-[700] text-slate-900 mb-4">Select Platform</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <template x-for="(platform, index) in platformsData" :key="index">
                                <label class="relative flex cursor-pointer rounded-xl p-4 transition-all"
                                    :class="selectedPlatformIndex == index ? 'border-2 border-blue-600 bg-blue-50/50' : 'border border-slate-200 bg-white hover:border-slate-300'">
                                    <input type="radio" name="platform_choice" class="sr-only" :value="index" x-model="selectedPlatformIndex">
                                    <div class="flex w-full items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="text-sm">
                                                <p x-text="platform.name" class="font-[600] text-slate-900"></p>
                                                <p x-show="platform.price > 0 && (!pricingMatrix || Object.keys(pricingMatrix).length === 0)" x-text="'+ ₹' + Number(platform.price).toLocaleString('en-IN')" class="text-[13px] text-slate-500 mt-0.5"></p>
                                                <p x-show="platform.price <= 0 && (!pricingMatrix || Object.keys(pricingMatrix).length === 0)" class="text-[13px] text-slate-500 mt-0.5">Included</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- ── PLAN SELECTOR CARD ──────────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden sticky top-24">

                    <!-- Plan Segmented Control -->
                    <div class="p-6 pb-4 border-b border-slate-100">
                        <div class="flex bg-slate-100 p-1.5 rounded-xl w-full">
                            @foreach($plans as $planKey => $planMeta)
                            <button
                                type="button"
                                @click="selectedPlan = '{{ addslashes($planKey) }}'"
                                :class="selectedPlan === '{{ addslashes($planKey) }}' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                class="flex-1 py-2 px-3 rounded-lg text-[13px] font-[600] uppercase tracking-wide transition-all whitespace-nowrap shrink-0">
                                <span x-text="selectedPlanData['{{ addslashes($planKey) }}']?.name || '{{ $planKey }}'"></span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Plan Content (Alpine driven) -->
                    <div class="p-6">
                        <!-- Price + Description -->
                        <div class="mb-6">
                            <div class="text-[36px] font-[800] text-slate-900 tracking-tight leading-none mb-3" x-text="'₹' + subtotal.toLocaleString('en-IN')"></div>
                            <p class="text-[15px] text-slate-500 font-[400] leading-relaxed" x-text="selectedPlanData[selectedPlan]?.description || ''"></p>
                        </div>

                        <!-- Delivery -->
                        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100" x-show="selectedPlanData[selectedPlan]?.delivery">
                            <i data-lucide="clock" class="w-5 h-5 text-slate-400"></i>
                            <div>
                                <div class="text-[11px] font-[600] text-slate-500 uppercase tracking-wider mb-0.5">Delivery</div>
                                <div class="text-[14px] font-[600] text-slate-900" x-text="selectedPlanData[selectedPlan]?.delivery"></div>
                            </div>
                        </div>

                        <!-- Features List -->
                        <div class="mb-8" x-show="selectedPlanData[selectedPlan]?.features?.length">
                            <div class="text-[11px] font-[700] text-slate-900 uppercase tracking-wider mb-4">What's included</div>
                            <div class="space-y-3">
                                <template x-for="feature in (selectedPlanData[selectedPlan]?.features || [])" :key="feature">
                                    <div class="flex items-start gap-3">
                                        <i data-lucide="check" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                        <span class="text-[15px] text-slate-600 font-[400]" x-text="feature"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- DOMAIN SELECTION ON MAIN PAGE -->
                        <template x-if="enableDomain">
                            <div class="mb-5 bg-white border border-slate-100 shadow-[0_4px_15px_rgba(0,0,0,0.02)] rounded-[16px] p-5">
                                <label class="block text-[11px] font-[800] text-slate-800 mb-3 tracking-wider uppercase flex items-center gap-1.5"><i data-lucide="globe" class="w-3.5 h-3.5 text-emerald-500"></i> Domain Registration</label>
                                <div class="flex flex-col gap-2.5">
                                    <!-- .IN Domain Option -->
                                    <label class="relative flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition-all overflow-hidden group bg-white"
                                        :class="domainChoice === 'in' ? 'border-emerald-500 shadow-sm shadow-emerald-100' : 'border-slate-100 hover:border-emerald-200'">
                                        <input type="radio" name="main_domain_choice" value="in" x-model="domainChoice" class="sr-only">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                                                 :class="domainChoice === 'in' ? ' text-white shadow-md shadow-emerald-200' : 'bg-slate-100 text-slate-400 group-hover:bg-emerald-100 group-hover:text-emerald-600'">
                                                <i data-lucide="globe-2" class="w-4.5 h-4.5"></i>
                                            </div>
                                            <div>
                                                <div class="text-[14.5px] font-[700]" :class="domainChoice === 'in' ? 'text-emerald-900' : 'text-slate-800'">.IN Domain</div>
                                                <div class="text-[11px] text-slate-500 font-medium mt-0.5">1 Year Registration</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[15px] font-[800]" :class="domainChoice === 'in' ? 'text-emerald-700' : 'text-slate-900'" x-text="'₹' + domainInCharge"></div>
                                        </div>
                                        
                                        <!-- Active Indicator -->
                                        <div x-show="domainChoice === 'in'" class="absolute -right-5 -top-5 w-10 h-10  rounded-full flex items-end justify-start pb-1.5 pl-2 transition-all">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
                                        </div>
                                    </label>

                                    <!-- .COM Domain Option -->
                                    <label class="relative flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition-all overflow-hidden group bg-white"
                                        :class="domainChoice === 'com' ? 'border-emerald-500 shadow-sm shadow-emerald-100' : 'border-slate-100 hover:border-emerald-200'">
                                        <input type="radio" name="main_domain_choice" value="com" x-model="domainChoice" class="sr-only">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                                                 :class="domainChoice === 'com' ? ' text-white shadow-md shadow-emerald-200' : 'bg-slate-100 text-slate-400 group-hover:bg-emerald-100 group-hover:text-emerald-600'">
                                                <i data-lucide="globe-2" class="w-4.5 h-4.5"></i>
                                            </div>
                                            <div>
                                                <div class="text-[14.5px] font-[700]" :class="domainChoice === 'com' ? 'text-emerald-900' : 'text-slate-800'">.COM Domain</div>
                                                <div class="text-[11px] text-slate-500 font-medium mt-0.5">1 Year Registration</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[15px] font-[800]" :class="domainChoice === 'com' ? 'text-emerald-700' : 'text-slate-900'" x-text="'₹' + domainComCharge"></div>
                                        </div>
                                        
                                        <!-- Active Indicator -->
                                        <div x-show="domainChoice === 'com'" class="absolute -right-5 -top-5 w-10 h-10  rounded-full flex items-end justify-start pb-1.5 pl-2 transition-all">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
                                        </div>
                                    </label>

                                    <!-- Already Have Domain -->
                                    <label class="relative flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition-all overflow-hidden group bg-white"
                                        :class="domainChoice === 'already_have' ? 'border-emerald-500 shadow-sm shadow-emerald-100' : 'border-slate-100 hover:border-emerald-200'">
                                        <input type="radio" name="main_domain_choice" value="already_have" x-model="domainChoice" class="sr-only">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                                                 :class="domainChoice === 'already_have' ? ' text-white shadow-md shadow-emerald-200' : 'bg-slate-100 text-slate-400 group-hover:bg-emerald-100 group-hover:text-emerald-600'">
                                                <i data-lucide="link" class="w-4.5 h-4.5"></i>
                                            </div>
                                            <div>
                                                <div class="text-[14.5px] font-[700]" :class="domainChoice === 'already_have' ? 'text-emerald-900' : 'text-slate-800'">I already have one</div>
                                                <div class="text-[11px] text-slate-500 font-medium mt-0.5">Use existing domain</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[14px] font-[800] text-slate-400">Free</div>
                                        </div>
                                        
                                        <!-- Active Indicator -->
                                        <div x-show="domainChoice === 'already_have'" class="absolute -right-5 -top-5 w-10 h-10  rounded-full flex items-end justify-start pb-1.5 pl-2 transition-all">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </template>

                        <!-- TOTAL SUMMARY ON MAIN PAGE -->
                        <div class="mb-6 bg-slate-50 rounded-[16px] border border-slate-100 p-5 shadow-[0_4px_15px_rgba(0,0,0,0.02)]">
                            <label class="block text-[11px] font-[800] text-slate-800 mb-4 tracking-wider uppercase flex items-center gap-1.5"><i data-lucide="indian-rupee" class="w-3.5 h-3.5 text-slate-400"></i> Order Summary</label>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-[14px]">
                                    <span class="text-slate-500 font-medium">Package Plan</span>
                                    <span class="text-slate-700 font-[800]" x-text="'₹' + subtotal.toLocaleString('en-IN')"></span>
                                </div>
                                <template x-if="enableDomain">
                                    <div class="flex justify-between items-center text-[14px]">
                                        <span class="text-slate-500 font-medium">Domain <span class="text-[10px] uppercase font-bold tracking-wide" x-text="domainChoice === 'in' ? '(.in)' : (domainChoice === 'com' ? '(.com)' : '')"></span></span>
                                        <span class="text-slate-700 font-[800]" x-text="domainChargeAmount > 0 ? '₹' + domainChargeAmount.toLocaleString('en-IN') : 'Free'"></span>
                                    </div>
                                </template>
                                <template x-if="enableGst">
                                    <div class="flex justify-between items-center text-[14px]">
                                        <span class="text-slate-500 font-medium" x-text="'GST (' + gstPercent + '%)'"></span>
                                        <span class="text-slate-700 font-[800]" x-text="'₹' + gstAmount.toLocaleString('en-IN')"></span>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="flex justify-between items-center text-[20px] font-black text-emerald-700 border-t-2 border-dashed border-slate-200 pt-4 mt-4">
                                <span>Total Price</span>
                                <span x-text="'₹' + finalTotal.toLocaleString('en-IN')"></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @auth
                            @if(auth()->user()->isCustomer())
                            <button type="button" @click="buyNowModal = true"
                                class="w-full py-3.5 mt-2 rounded-xl text-[16px] font-[600] tracking-wide text-white bg-blue-600 hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                                Order Now — <span x-text="'₹' + finalTotal.toLocaleString('en-IN')"></span>
                            </button>
                            @endif

                            @if(auth()->user()->isPartner() || auth()->user()->isAdmin())
                            <div class="flex items-center gap-3 mb-5 mt-6 text-[11px] text-slate-400 uppercase tracking-wider font-[600]">
                                <div class="h-px bg-slate-100 flex-1"></div>
                                <span>Submit Lead</span>
                                <div class="h-px bg-slate-100 flex-1"></div>
                            </div>
                                <form action="{{ route('partner.leads.store') }}" method="POST" class="space-y-4 font-sans">
                                    @csrf
                                    <input type="hidden" name="service_needed" value="{{ $service->name }}">
                                    <input type="hidden" name="plan_selected" x-bind:value="selectedPlan">
                                    <template x-if="enablePlatforms && selectedPlatformIndex != null">
                                        <input type="hidden" name="platform_choice" :value="platformsData[selectedPlatformIndex].name">
                                    </template>
                                    <template x-if="enableDomain">
                                        <input type="hidden" name="domain_choice" :value="domainChoice">
                                    </template>
                                    
                                    <div>
                                        <label class="block text-[12px] font-[600] text-slate-700 mb-1.5">Client Name *</label>
                                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-[14px] bg-white transition-all outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-[600] text-slate-700 mb-1.5">Client Phone *</label>
                                        <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-[14px] bg-white transition-all outline-none">
                                    </div>
                                    <button type="submit" class="w-full py-3.5 mt-2 rounded-xl text-[16px] font-[600] tracking-wide text-white bg-slate-900 hover:bg-slate-800 transition-colors flex justify-center items-center gap-2 cursor-pointer shadow-sm">
                                        <i data-lucide="send" class="w-4 h-4"></i> Submit Lead
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-6 text-center mb-4 mt-4">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mx-auto mb-3 border border-slate-100">
                                    <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <h4 class="text-[16px] font-[600] text-slate-900 mb-1">Sign In to Order</h4>
                                <p class="text-[14px] text-slate-500 font-[400] leading-relaxed mb-5">Sign in to purchase or submit client leads.</p>
                                <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl text-[15px] font-[600] text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    Secure Sign In <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                            <a href="https://wa.me/{{ $cleanPhone }}?text=https://sksolutionss.com/%20Hi%20SK%20Solutions%20team,%20I%20need%20help%20-%20Interested%20in%20{{ urlencode($service->name) }}" target="_blank"
                               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-[14px] font-[600] text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                <i data-lucide="message-circle" class="w-4 h-4"></i> Inquire via WhatsApp
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
                <div class="flex mt-20 sm:mt-24 items-end justify-center sm:items-center p-0 sm:p-4 text-center">
                    <div x-show="buyNowModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
                         class="relative transform overflow-hidden rounded-[32px] sm:rounded-[16px] bg-white text-left shadow-2xl transition-all w-full sm:w-full sm:max-w-md border sm:border-slate-200 mt-6 mb-6 sm:mt-0"
                         @click.away="buyNowModal = false">

                        <!-- Mobile Drag Handle -->
                        <div class="w-full flex justify-center pt-3 pb-1 sm:hidden bg-slate-50">
                            <div class="w-12 h-1.5 bg-slate-300 rounded-full"></div>
                        </div>

                        <div class="px-4 sm:px-5 py-3 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <div>
                                <h3 class="text-[18px] font-[600] text-slate-900 flex items-center gap-2" id="modal-title">
                                    Order Summary
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
                                    <span class="text-[18px] font-[600] text-slate-900" x-text="(selectedPlanData[selectedPlan]?.name || selectedPlan) + ' Package'"></span>
                                    <span class="text-[24px] font-[700] text-indigo-700" x-text="'₹' + subtotal.toLocaleString('en-IN')"></span>
                                </div>
                                <p class="text-[13px] text-slate-500 font-[400] mb-3" x-text="selectedPlanData[selectedPlan]?.description"></p>
                                
                                <template x-if="enablePlatforms && selectedPlatformIndex != null && platformsData[selectedPlatformIndex]">
                                    <div class="border-t border-slate-100 pt-3 mt-3">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-slate-700 font-medium flex items-center gap-2"> Platform: <span x-text="platformsData[selectedPlatformIndex].name"></span></span>
                                            <span x-show="!pricingMatrix || Object.keys(pricingMatrix).length === 0" class="font-bold text-slate-700" x-text="platformsData[selectedPlatformIndex].price > 0 ? '+ ₹' + Number(platformsData[selectedPlatformIndex].price).toLocaleString('en-IN') : 'Included'"></span>
                                            <span x-show="pricingMatrix && Object.keys(pricingMatrix).length > 0" class="font-bold text-slate-700 text-[10px] uppercase text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded">Selected</span>
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
                            
                            <!-- Coupon Section -->
                            <div class="pt-3 pb-2 mt-3 border-t border-slate-100">
                                @if($activeCoupons->count() > 0)
                                <div class="mb-4">
                                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Available Coupons</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($activeCoupons as $ac)
                                        <button type="button"
                                            @click="couponCode='{{ $ac->code }}'; applyCoupon()"
                                            :class="couponApplied && couponCode === '{{ $ac->code }}' ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50'"
                                            class="inline-flex items-center gap-2 border rounded-md px-3 py-1.5 transition-all">
                                            <span class="text-[11px] font-mono font-bold uppercase tracking-wide">{{ $ac->code }}</span>
                                            <span class="text-[10px] font-medium px-1.5 py-0.5 rounded bg-slate-100 text-slate-600"
                                                :class="couponApplied && couponCode === '{{ $ac->code }}' ? 'bg-emerald-100 text-emerald-700' : ''">
                                                @if($ac->discount_type == 'percent') {{ $ac->discount_value }}% off @else ₹{{ number_format($ac->discount_value) }} off @endif
                                            </span>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="flex items-stretch gap-2">
                                    <div class="relative flex-1">
                                        <input type="text" x-model="couponCode" placeholder="Enter coupon code"
                                            :disabled="couponApplied"
                                            :class="couponApplied ? 'border-emerald-500 bg-emerald-50 text-emerald-800' : (couponError ? 'border-red-400 bg-red-50' : 'border-slate-300 bg-white')"
                                            class="w-full h-[42px] px-3 rounded-lg border text-sm font-medium uppercase tracking-wide placeholder:normal-case placeholder:tracking-normal placeholder:font-normal focus:ring-2 focus:ring-slate-200 focus:border-slate-400 transition-all outline-none disabled:opacity-100"
                                            @keydown.enter.prevent="applyCoupon()">
                                    </div>
                                    <button type="button" @click="couponApplied ? removeCoupon() : applyCoupon()"
                                        :class="couponApplied ? 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-300' : 'bg-slate-900 hover:bg-slate-800 text-white border border-transparent'"
                                        class="px-5 h-[42px] rounded-lg text-sm font-semibold transition-colors shrink-0 flex items-center justify-center min-w-[90px]"
                                        x-text="couponApplied ? 'Remove' : 'Apply'">
                                    </button>
                                </div>
                                <div class="mt-2 min-h-[20px] px-1">
                                    <p x-show="couponError" x-text="couponError" style="display: none;" class="text-[11px] text-red-500 font-medium"></p>
                                    <p x-show="couponApplied" style="display: none;" class="text-[11px] text-emerald-600 font-medium">✓ Coupon applied! You save ₹<span x-text="couponDiscount"></span></p>
                                </div>
                            </div>

                            <!-- Coupon Discount Row -->
                            <template x-if="couponApplied && couponDiscount > 0">
                                <div class="flex items-center justify-between bg-emerald-50 rounded-[12px] border border-emerald-100 p-3 mb-2">
                                    <span class="text-sm font-bold text-emerald-800 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Coupon: <span class="font-mono uppercase" x-text="couponCode"></span>
                                    </span>
                                    <span class="text-sm font-black text-emerald-700" x-text="'- ₹' + couponDiscount.toLocaleString('en-IN')"></span>
                                </div>
                            </template>

                            <!-- Total -->
                            <div class="flex items-center justify-between bg-indigo-50 rounded-[12px] border border-indigo-100 p-3 mb-0">
                                <span class="text-sm font-black text-indigo-900">Total Amount</span>
                                <span class="text-[24px] font-[700] text-indigo-700" x-text="'₹' + finalTotal.toLocaleString('en-IN')"></span>
                            </div>
                        </div>

                        <form id="buyNowForm" class="px-4 sm:px-5 pt-2 pb-5 max-h-[80vh] overflow-y-auto">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <input type="hidden" name="coupon_code" x-bind:value="couponApplied ? couponCode : ''">
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

