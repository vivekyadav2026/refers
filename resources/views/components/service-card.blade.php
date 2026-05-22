@props(['service', 'isPartnerView' => false])

@php
    $findPremiumMatch = function($name) {
        $nameLower = strtolower($name);
        $mapping = [
            'web' => [
                'bg' => 'from-indigo-50 to-purple-100/40',
                'icon' => 'globe',
                'icon_color' => 'text-indigo-600'
            ],
            'app' => [
                'bg' => 'from-rose-50 to-pink-100/40',
                'icon' => 'smartphone',
                'icon_color' => 'text-rose-600'
            ],
            'video' => [
                'bg' => 'from-amber-50 to-orange-100/40',
                'icon' => 'video',
                'icon_color' => 'text-amber-600'
            ],
            'graphics' => [
                'bg' => 'from-emerald-50 to-teal-100/40',
                'icon' => 'palette',
                'icon_color' => 'text-emerald-600'
            ],
            'seo' => [
                'bg' => 'from-sky-50 to-blue-100/40',
                'icon' => 'search',
                'icon_color' => 'text-sky-600'
            ],
            'marketing' => [
                'bg' => 'from-violet-50 to-purple-100/40',
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

    $match = $findPremiumMatch($service->name);
    $icon = $service->icon ?: ($match ? $match['icon'] : 'layout-grid');
    $icon_color = $match ? $match['icon_color'] : 'text-slate-500';
    $bg = $match ? $match['bg'] : 'from-slate-50 to-slate-100';
    
    // For partner view, do not wrap in an anchor tag so it's not clickable.
    $tag = $isPartnerView ? 'div' : 'a';
    $href = $isPartnerView ? '' : 'href="' . url('/services/' . $service->slug) . '"';
@endphp

<{{ $tag }} {!! $href !!} class="service-card bg-white flex flex-col items-center justify-center group hover:bg-indigo-50/30 transition-all duration-300 min-h-[220px] p-6 text-center rounded-2xl shadow-md hover:shadow-xl hover:shadow-indigo-500/10 border border-slate-100/50 hover:-translate-y-1 relative w-full">
    
    @if($service->is_popular)
    <div class="absolute top-3 right-3 z-10 bg-gradient-to-r from-orange-400 to-amber-500 text-white text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full shadow-md shadow-orange-500/25">🔥 Top</div>
    @endif
    
    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $bg }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-white/50">
        <i data-lucide="{{ $icon }}" class="w-8 h-8 {{ $icon_color }}"></i>
    </div>
    
    <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">{{ $service->category ?? 'Service' }}</span>
    <span class="text-sm font-bold text-slate-800 leading-tight line-clamp-2 mb-2">{{ $service->name }}</span>
    <p class="text-[11px] text-slate-500 mb-4 line-clamp-2 leading-relaxed hidden sm:block">{{ $service->short_description }}</p>
    
    <!-- Action Section -->
    <div class="mt-auto w-full pt-2 border-t border-slate-100/60">
        @if($isPartnerView)
            <button onclick="copyServiceLink(this, '{{ url('/services/' . $service->slug) }}?ref={{ auth()->user()->referral_code ?? auth()->id() }}')" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white border border-indigo-100 hover:border-indigo-600 rounded-xl transition-all duration-200 group/btn shadow-sm">
                <i data-lucide="share-2" class="w-4 h-4"></i>
                <div class="flex flex-col items-start text-left">
                    <span class="text-[9px] font-black uppercase tracking-widest label-text opacity-80 leading-none">Earn Commission</span>
                    <span class="text-sm font-black amount-text leading-tight tracking-tight">₹{{ number_format($service->getCommissionAmount()) }}</span>
                </div>
            </button>
        @else
            <a href="{{ url('/services/' . $service->slug) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white border border-indigo-100 hover:border-indigo-600 rounded-xl transition-all duration-200 shadow-sm">
                <i data-lucide="share-2" class="w-4 h-4"></i>
                <div class="flex flex-col items-start text-left">
                    <span class="text-[9px] font-black uppercase tracking-widest opacity-80 leading-none">Earn Commission</span>
                    <span class="text-sm font-black leading-tight tracking-tight">₹{{ number_format($service->getCommissionAmount()) }}</span>
                </div>
            </a>
        @endif
    </div>
</{{ $tag }}>
