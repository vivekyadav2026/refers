@props(['service', 'isPartnerView' => false])

@php
    $lowerName = strtolower($service->name);
    $lowerSlug = strtolower($service->slug);
    
    $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
    $isBrandIcon = false;
    
    if (str_contains($lowerName, 'e-commerce') || str_contains($lowerSlug, 'ecommerce')) {
        $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
        $svg = '
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'informative') || str_contains($lowerSlug, 'informative')) {
        $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
        $svg = '
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <rect x="2" y="3" width="20" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 11h6"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'facebook')) {
        $bg = 'linear-gradient(135deg, #e8f4fe, #dbeafe)';
        $isBrandIcon = true;
        $svg = '
            <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                <circle cx="20" cy="20" r="20" fill="#1877F2"/>
                <path d="M27.5 20H22.5V17.5C22.5 16.67 23.17 16.25 24 16.25H27V12.5H24C21.24 12.5 19 14.74 19 17.5V20H16V24H19V32.5H22.5V24H26L27.5 20Z" fill="white"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'instagram')) {
        $bg = 'linear-gradient(135deg, #fde8f4, #fce7f3)';
        $isBrandIcon = true;
        $svg = '
            <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                <defs>
                    <radialGradient id="ig1" cx="30%" cy="107%" r="150%"><stop offset="0%" stop-color="#ffd600"/><stop offset="50%" stop-color="#ff6a00"/><stop offset="100%" stop-color="#ee0979"/></radialGradient>
                    <radialGradient id="ig2" cx="5%" cy="100%" r="60%"><stop offset="0%" stop-color="#a855f7"/><stop offset="100%" stop-color="transparent"/></radialGradient>
                </defs>
                <rect width="40" height="40" rx="10" fill="url(#ig1)"/>
                <rect width="40" height="40" rx="10" fill="url(#ig2)"/>
                <rect x="10" y="10" width="20" height="20" rx="5" stroke="white" stroke-width="2.2" fill="none"/>
                <circle cx="20" cy="20" r="5.5" stroke="white" stroke-width="2.2" fill="none"/>
                <circle cx="27" cy="13" r="1.5" fill="white"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'google')) {
        $bg = 'linear-gradient(135deg, #f0fdf4, #dcfce7)';
        $isBrandIcon = true;
        $svg = '
            <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                <path d="M20 5L32 27H8L20 5Z" fill="#4285F4"/>
                <circle cx="32" cy="27" r="6" fill="#FBBC05"/>
                <circle cx="8" cy="27" r="6" fill="#34A853"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'youtube')) {
        $bg = 'linear-gradient(135deg, #fef2f2, #fee2e2)';
        $isBrandIcon = true;
        $svg = '
            <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:36px; height:36px;">
                <rect width="40" height="40" rx="10" fill="#FF0000"/>
                <path d="M30.5 14.8C30.3 13.9 29.6 13.2 28.7 13C26.7 12.5 20 12.5 20 12.5C20 12.5 13.3 12.5 11.3 13C10.4 13.2 9.7 13.9 9.5 14.8C9 16.8 9 21 9 21C9 21 9 25.2 9.5 27.2C9.7 28.1 10.4 28.8 11.3 29C13.3 29.5 20 29.5 20 29.5C20 29.5 26.7 29.5 28.7 29C29.6 28.8 30.3 28.1 30.5 27.2C31 25.2 31 21 31 21C31 21 31 16.8 30.5 14.8Z" fill="white"/>
                <path d="M17.5 24.5V17.5L23.5 21L17.5 24.5Z" fill="#FF0000"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'seo') || str_contains($lowerSlug, 'seo')) {
        $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
        $svg = '
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'video') || str_contains($lowerName, 'reels') || str_contains($lowerName, 'edit')) {
        $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
        $svg = '
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
            </svg>
        ';
    } elseif (str_contains($lowerName, 'app') || str_contains($lowerName, 'mobile') || str_contains($lowerSlug, 'app')) {
        $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
        $svg = '
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/>
            </svg>
        ';
    } else {
        $bg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
        $iconName = $service->icon ?? 'box';
        $svg = '<i data-lucide="' . $iconName . '" class="w-6 h-6 sm:w-7 sm:h-7 text-violet-600"></i>';
    }

    $tag = $isPartnerView ? 'div' : 'a';
    $href = $isPartnerView ? '' : 'href="' . url('/services/' . $service->slug) . '"';
@endphp

<{{ $tag }} {!! $href !!} class="bg-white flex flex-col items-center justify-center group hover:bg-violet-50/30 transition-all duration-300 min-h-[220px] p-6 text-center rounded-2xl shadow-md hover:shadow-xl hover:shadow-violet-500/10 border border-violet-100/50 hover:-translate-y-1 relative w-full" style="font-family:'Poppins', sans-serif;">
    
    @if($service->is_popular)
        <div class="absolute top-3 right-3 z-10 bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white text-[8px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full shadow-md shadow-violet-500/25">Top</div>
    @endif
    
    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-white/50" style="background: {{ $bg }}">
        {!! $svg !!}
    </div>
    
    <span class="text-[9px] font-black text-violet-600 uppercase tracking-widest mb-1">{{ $service->category ?? 'Service' }}</span>
    <span class="text-sm font-bold text-gray-800 leading-tight line-clamp-2 mb-1.5">{{ $service->name }}</span>
    <p class="text-[10px] sm:text-[11px] text-gray-500 mb-4 line-clamp-2 leading-relaxed font-semibold">{{ $service->short_description }}</p>
    
    <!-- Action Section -->
    <div class="mt-auto w-full pt-3 border-t border-violet-50">
        @if($isPartnerView)
            <button onclick="copyServiceLink(this, '{{ url('/services/' . $service->slug) }}?ref={{ auth()->user()->referral_code ?? auth()->id() }}')" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-violet-50 hover:bg-violet-700 text-violet-750 hover:text-white border border-violet-100 hover:border-violet-700 rounded-xl transition-all duration-200 group/btn shadow-sm cursor-pointer outline-none">
                <svg class="w-4 h-4 text-violet-600 group-hover/btn:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.59 13.51 6.83 3.98m-.01-10.98-6.82 3.98"/></svg>
                <div class="flex flex-col items-start text-left">
                    <span class="text-[8px] font-black uppercase tracking-widest label-text opacity-85 leading-none">Earn Commission</span>
                    <span class="text-xs font-black amount-text leading-tight tracking-tight mt-0.5">₹{{ number_format($service->getCommissionAmount()) }}</span>
                </div>
            </button>
        @else
            <a href="{{ url('/services/' . $service->slug) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-violet-50 hover:bg-violet-700 text-violet-750 hover:text-white border border-violet-100 hover:border-violet-700 rounded-xl transition-all duration-200 shadow-sm text-decoration-none">
                <svg class="w-4 h-4 text-violet-600 hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.59 13.51 6.83 3.98m-.01-10.98-6.82 3.98"/></svg>
                <div class="flex flex-col items-start text-left">
                    <span class="text-[8px] font-black uppercase tracking-widest opacity-85 leading-none">Earn Commission</span>
                    <span class="text-xs font-black leading-tight tracking-tight mt-0.5">₹{{ number_format($service->getCommissionAmount()) }}</span>
                </div>
            </a>
        @endif
    </div>
</{{ $tag }}>
