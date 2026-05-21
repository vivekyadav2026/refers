@props(['service', 'isPartnerView' => false])

<div class="relative bg-white/95 backdrop-blur-md rounded-2xl border border-slate-100 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05),0_10px_20px_-8px_rgba(0,0,0,0.03)] hover:shadow-[0_12px_24px_-10px_rgba(124,58,237,0.12),0_4px_12px_-5px_rgba(0,0,0,0.04)] hover:border-purple-200/60 hover:-translate-y-0.5 transition-all duration-300 group flex items-center p-4 gap-4 overflow-hidden">
    
    <!-- Top-Accent Animated Glow Line -->
    <div class="absolute inset-x-0 top-0 h-[2.5px] bg-gradient-to-r from-purple-500 via-pink-500 to-indigo-500 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

    <!-- Soft Ambient Mesh Spot-Glow -->
    <div class="absolute -right-12 -bottom-12 w-28 h-28 bg-gradient-to-br from-purple-400/5 to-indigo-400/5 rounded-full blur-2xl pointer-events-none group-hover:from-purple-400/10 group-hover:to-indigo-400/10 transition-all duration-300"></div>

    @if($service->is_popular ?? false)
        <div class="absolute -top-2.5 -right-2.5 bg-gradient-to-r from-purple-600 via-fuchsia-600 to-indigo-600 text-white text-[9px] font-black uppercase tracking-wider py-1 px-3.5 rounded-full shadow-md z-10 border border-purple-400/20 flex items-center gap-1">
            <i data-lucide="sparkles" class="w-2.5 h-2.5 animate-pulse"></i>
            Top Choice
        </div>
    @endif

    <!-- Logo Section (Left) -->
    <a href="{{ url('/services/' . $service->slug) }}" class="w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/50 border border-slate-200/60 flex items-center justify-center overflow-hidden p-0 group-hover:scale-105 group-hover:border-purple-100 transition-all duration-300 shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)]">
        @if($service->banner_image)
            <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
        @else
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600 group-hover:bg-purple-100/80 group-hover:text-purple-700 transition-colors">
                <i data-lucide="{{ $service->icon ?? 'box' }}" class="w-7 h-7"></i>
            </div>
        @endif
    </a>

    <!-- Content Section (Middle) -->
    <a href="{{ url('/services/' . $service->slug) }}" class="flex-1 min-w-0">
        <h3 class="text-base font-bold text-slate-900 group-hover:text-purple-950 transition-colors truncate font-sans tracking-tight">{{ $service->name }}</h3>
        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5 font-sans">{{ $service->short_description }}</p>
        
        <div class="mt-2 flex items-center gap-2">
            @if(is_array($service->features) && count($service->features) > 0)
                <span class="inline-flex items-center gap-1 text-[10px] font-semibold bg-purple-50/50 text-purple-600 border border-purple-100/50 px-2 py-0.5 rounded-full truncate max-w-[140px] shadow-sm">
                    <span class="w-1 h-1 rounded-full bg-purple-400"></span>
                    {{ $service->features[0] }}
                </span>
            @else
                <span class="inline-flex items-center gap-1 text-[10px] font-semibold bg-indigo-50/50 text-indigo-600 border border-indigo-100/50 px-2 py-0.5 rounded-full truncate max-w-[140px] shadow-sm">
                    <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                    Premium Offer
                </span>
            @endif
        </div>
    </a>

    <!-- Action Section (Right) -->
    <div class="shrink-0 flex flex-col items-end justify-center">
        @if($isPartnerView)
            <button onclick="copyServiceLink(this, '{{ url('/services/' . $service->slug) }}?ref={{ auth()->user()->referral_code ?? auth()->id() }}')" class="flex flex-col items-center justify-center px-4 py-1.5 border border-indigo-600 rounded-xl text-indigo-600 hover:bg-indigo-50 active:bg-indigo-100 transition-all duration-200 whitespace-nowrap shadow-sm hover:shadow group/btn">
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest label-text">Earn Commission</span>
                <span class="text-sm font-black amount-text tracking-tight">₹{{ number_format($service->getCommissionAmount()) }}</span>
            </button>
        @else
            <a href="{{ url('/services/' . $service->slug) }}" class="flex flex-col items-center justify-center px-4 py-1.5 border border-indigo-600 rounded-xl text-indigo-600 hover:bg-indigo-50 active:bg-indigo-100 transition-all duration-200 whitespace-nowrap shadow-sm hover:shadow group/btn">
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Earn Commission</span>
                <span class="text-sm font-black tracking-tight">₹{{ number_format($service->getCommissionAmount()) }}</span>
            </a>
        @endif
    </div>

</div>

