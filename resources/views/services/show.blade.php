@extends('layouts.app')
@section('title', $service->name . ' — VivekTech')
@section('content')
<div class="bg-white">

    {{-- HERO --}}
    <div class="relative bg-gradient-to-br from-slate-900 to-blue-950 pt-16 pb-24 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(99,102,241,0.25),_transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8">
                <a href="{{ url('/') }}" class="hover:text-white">Home</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <a href="{{ route('services.index') }}" class="hover:text-white">Services</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-white">{{ $service->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    @if($service->is_popular)
                    <div class="inline-flex items-center gap-1.5 bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full mb-6">⭐ Most Popular Service</div>
                    @endif
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-500/20 text-blue-400 flex items-center justify-center border border-blue-500/30">
                            <i data-lucide="{{ $service->icon ?? 'box' }}" class="w-7 h-7"></i>
                        </div>
                        <span class="text-blue-400 font-semibold text-sm">{{ $service->category }}</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-black text-white mb-4 leading-tight">{{ $service->name }}</h1>
                    <p class="text-slate-300 text-lg leading-relaxed mb-8">{{ $service->short_description }}</p>
                    <div class="flex items-baseline gap-2 mb-6">
                        <span class="text-4xl font-black text-white">₹{{ number_format($service->min_price) }}</span>
                        <span class="text-slate-400">starting price</span>
                    </div>
                    <div class="bg-emerald-400/10 border border-emerald-400/20 rounded-2xl px-5 py-3 inline-block">
                        <span class="text-emerald-300 font-bold text-sm">🎯 Partner earns ₹{{ number_format($service->min_price * 0.20) }}–₹{{ number_format($service->min_price * 0.30) }} commission</span>
                    </div>
                </div>

                {{-- CTA Card --}}
                <div class="bg-white rounded-3xl p-8 shadow-2xl border border-slate-100">
                    <h3 class="text-xl font-black text-slate-900 mb-2">Submit Your Requirement</h3>
                    <p class="text-sm text-slate-500 mb-6">Tell us what you need — our team will contact you within 24 hours.</p>
                    <form action="{{ route('partner.leads.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="service" value="{{ $service->name }}">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Your Name *</label>
                            <input type="text" name="client_name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all" placeholder="Full name">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Phone Number *</label>
                            <input type="tel" name="client_phone" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all" placeholder="+91 9999999999">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Your Requirement *</label>
                            <textarea name="notes" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all resize-none" placeholder="Briefly describe what you need..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 rounded-2xl text-base font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/25 transition-all hover:-translate-y-0.5">
                            Submit Requirement
                        </button>
                        <a href="https://wa.me/919999999999?text=Hi, I want {{ urlencode($service->name) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl text-sm font-bold text-white bg-green-500 hover:bg-green-600 transition-colors">
                            <i data-lucide="message-circle" class="w-5 h-5"></i> WhatsApp Us Instead
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FEATURES --}}
    <div class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 mb-6">What's Included</h2>
                    <div class="space-y-4">
                        @foreach($service->features ?? [] as $feature)
                        <div class="flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-slate-800 font-medium">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-slate-900 mb-6">Pricing Packages</h2>
                    <div class="space-y-4">
                        @foreach([
                            ['label'=>'Basic','price'=> $service->min_price,'desc'=>'Perfect for startups & small businesses','features'=>['Core features included','7 day delivery','1 round of revisions']],
                            ['label'=>'Pro','price'=> $service->min_price * 1.6,'desc'=>'Most chosen by growing businesses','features'=>['Everything in Basic','Priority support','3 rounds of revisions','SEO optimized'],'popular'=>true],
                            ['label'=>'Premium','price'=> $service->min_price * 2.5,'desc'=>'For enterprises & large scale projects','features'=>['Everything in Pro','Dedicated project manager','Unlimited revisions','Post launch support']],
                        ] as $pkg)
                        <div class="relative bg-white rounded-2xl p-6 border {{ isset($pkg['popular']) ? 'border-blue-400 shadow-lg shadow-blue-100' : 'border-slate-200' }}">
                            @if(isset($pkg['popular']))
                            <div class="absolute -top-3 left-5 bg-blue-600 text-white text-[10px] font-black uppercase px-3 py-1 rounded-full">Most Chosen</div>
                            @endif
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-black text-slate-900">{{ $pkg['label'] }}</h4>
                                <span class="text-xl font-black text-blue-600">₹{{ number_format($pkg['price']) }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mb-3">{{ $pkg['desc'] }}</p>
                            <ul class="space-y-1.5">
                                @foreach($pkg['features'] as $f)
                                <li class="flex items-center gap-2 text-xs text-slate-600">
                                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-500"></i> {{ $f }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ & CTA --}}
    <div class="py-20 bg-white" x-data="{active:null}">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-black text-slate-900 mb-8 text-center">Common Questions</h2>
            <div class="space-y-3 mb-16">
                @foreach([
                    ['q'=>'How long will delivery take?','a'=>'Basic: 7 days, Pro: 14 days, Premium: 21–30 days depending on complexity.'],
                    ['q'=>'Do you provide source code?','a'=>'Yes, Pro and Premium packages include full source code and admin panel access.'],
                    ['q'=>'Can I customize the design?','a'=>'100%. We build everything custom to your brand identity and business requirements.'],
                    ['q'=>'What if I am not satisfied?','a'=>'We offer revision rounds based on your package. We work until you are happy.'],
                ] as $i => $faq)
                <div class="bg-slate-50 rounded-2xl border border-slate-200">
                    <button class="w-full flex items-center justify-between px-6 py-5 text-left font-bold text-slate-900 text-sm" @click="active = active === {{ $i }} ? null : {{ $i }}">
                        {{ $faq['q'] }}
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform" :class="active === {{ $i }} ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === {{ $i }}" x-transition class="px-6 pb-5 text-sm text-slate-500" style="display:none">{{ $faq['a'] }}</div>
                </div>
                @endforeach
            </div>

            {{-- Final CTA --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-10 text-center text-white">
                <h3 class="text-2xl font-black mb-3">Ready to Get Started?</h3>
                <p class="text-blue-200 mb-8">Submit your requirement now and get a free consultation within 24 hours.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="px-8 py-4 rounded-2xl font-bold text-blue-600 bg-white hover:bg-blue-50 shadow-lg transition-all hover:-translate-y-0.5">Get Free Consultation</a>
                    <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl font-bold text-white border-2 border-white/30 hover:bg-white/10 transition-all">Join as Partner</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
