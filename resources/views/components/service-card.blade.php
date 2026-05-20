@props(['service', 'isPartnerView' => false])

<div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 hover:border-blue-200 hover:shadow-md transition-all duration-300 group flex items-center p-4 gap-4">
    
    @if($service->is_popular ?? false)
        <div class="absolute -top-2.5 -right-2.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-[10px] font-bold uppercase tracking-wider py-1 px-3 rounded-full shadow-md z-10 border-2 border-white">
            Top Choice
        </div>
    @endif

    <!-- Logo Section (Left) -->
    <a href="{{ url('/services/' . $service->slug) }}" class="w-16 h-16 shrink-0 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden p-0 group-hover:scale-105 transition-transform shadow-inner">
        @if($service->banner_image)
            <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
        @else
            <i data-lucide="{{ $service->icon ?? 'box' }}" class="w-8 h-8 text-blue-600"></i>
        @endif
    </a>

    <!-- Content Section (Middle) -->
    <a href="{{ url('/services/' . $service->slug) }}" class="flex-1 min-w-0">
        <h3 class="text-base font-bold text-slate-900 truncate">{{ $service->name }}</h3>
        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $service->short_description }}</p>
        
        <div class="mt-2 flex items-center gap-2">
            @if(is_array($service->features) && count($service->features) > 0)
                <span class="text-[10px] font-medium bg-slate-100 text-slate-600 px-2 py-0.5 rounded truncate max-w-[120px]">
                    {{ $service->features[0] }}
                </span>
            @endif
        </div>
    </a>

    <!-- Action Section (Right) -->
    <div class="shrink-0 flex flex-col items-end justify-center">
        @if($isPartnerView)
            <button onclick="copyToClipboard('{{ url('/services/' . $service->slug) }}?ref={{ auth()->id() ?? 'test' }}')" class="flex flex-col items-center justify-center px-4 py-1.5 border border-blue-600 rounded-full text-blue-600 hover:bg-blue-50 transition-colors whitespace-nowrap">
                <span class="text-[10px] font-medium text-slate-500 uppercase">Earn Commission</span>
                <span class="text-sm font-bold">₹{{ number_format($service->getCommissionAmount()) }}</span>
            </button>
        @else
            <a href="{{ url('/services/' . $service->slug) }}" class="flex flex-col items-center justify-center px-4 py-1.5 border border-blue-600 rounded-full text-blue-600 hover:bg-blue-50 transition-colors whitespace-nowrap">
                <span class="text-[10px] font-medium text-slate-500 uppercase">Earn Commission</span>
                <span class="text-sm font-bold">₹{{ number_format($service->getCommissionAmount()) }}</span>
            </a>
        @endif
    </div>

</div>
