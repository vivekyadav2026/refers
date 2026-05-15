@extends('layouts.app')
@section('title', 'VivekTech Partner Network — Earn by Bringing Clients')
@section('content')

{{-- ===== HERO ===== --}}
<section class="relative overflow-hidden bg-white pt-20 pb-28">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -right-32 w-[600px] h-[600px] bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-32 w-[500px] h-[500px] bg-gradient-to-tr from-purple-100 to-pink-100 rounded-full blur-3xl opacity-40"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-sm font-semibold px-4 py-2 rounded-full mb-8">
                <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span></span>
                Now open for new partners across India
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-slate-900 tracking-tight leading-tight mb-6">
                Earn Money by<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">Bringing Clients</span><br>
                <span class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-700">We Handle Everything</span>
            </h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Join as a VivekTech Sales Partner. Refer clients who need websites, apps, or marketing. We deliver the work — you earn up to <strong class="text-slate-800">30% commission</strong> on every successful project.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold rounded-2xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-xl shadow-blue-600/25 hover:-translate-y-0.5 transition-all">
                    <i data-lucide="zap" class="w-5 h-5"></i> Start Earning Free
                </a>
                <a href="{{ route('services.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold rounded-2xl text-slate-700 bg-white border-2 border-slate-200 hover:border-blue-300 hover:text-blue-600 shadow-sm hover:-translate-y-0.5 transition-all">
                    View Services <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
            <p class="text-sm text-slate-400 mt-4">✓ Free to join &nbsp; ✓ No target &nbsp; ✓ Instant commission</p>
        </div>

        {{-- Stats bar --}}
        <div class="mt-20 grid grid-cols-2 sm:grid-cols-4 gap-px bg-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="bg-white p-6 text-center"><div class="text-3xl font-black text-blue-600 mb-1">500+</div><div class="text-sm text-slate-500 font-medium">Partners Joined</div></div>
            <div class="bg-white p-6 text-center"><div class="text-3xl font-black text-indigo-600 mb-1">₹50L+</div><div class="text-sm text-slate-500 font-medium">Commission Paid</div></div>
            <div class="bg-white p-6 text-center"><div class="text-3xl font-black text-purple-600 mb-1">200+</div><div class="text-sm text-slate-500 font-medium">Projects Delivered</div></div>
            <div class="bg-white p-6 text-center"><div class="text-3xl font-black text-emerald-600 mb-1">30%</div><div class="text-sm text-slate-500 font-medium">Max Commission</div></div>
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="py-24 bg-slate-50" id="how-it-works">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-slate-900 mb-4">How It Works</h2>
            <p class="text-lg text-slate-500 max-w-xl mx-auto">Start earning in 3 simple steps — no investment, no risk.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <div class="hidden md:block absolute top-16 left-[calc(16.66%-1rem)] right-[calc(16.66%-1rem)] h-px bg-gradient-to-r from-blue-200 to-indigo-200 z-0"></div>
            @foreach([
                ['step'=>'01','icon'=>'user-plus','title'=>'Join as Partner','desc'=>'Register for free in 2 minutes. Complete your KYC verification to activate your account and get your unique referral link.','color'=>'blue'],
                ['step'=>'02','icon'=>'share-2','title'=>'Bring a Client','desc'=>'Share your link or submit a lead — Name, Phone, and Requirement. Our sales team handles the rest from there.','color'=>'indigo'],
                ['step'=>'03','icon'=>'indian-rupee','title'=>'Earn Commission','desc'=>'When the client pays for the service, your commission is automatically credited to your wallet. Withdraw anytime.','color'=>'purple'],
            ] as $step)
            <div class="relative z-10 bg-white rounded-3xl p-8 shadow-sm border border-slate-200 hover:border-blue-200 hover:shadow-lg transition-all group text-center">
                <div class="w-16 h-16 rounded-2xl bg-{{ $step['color'] }}-100 text-{{ $step['color'] }}-600 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <i data-lucide="{{ $step['icon'] }}" class="w-8 h-8"></i>
                </div>
                <div class="text-xs font-black text-{{ $step['color'] }}-400 tracking-widest mb-2">STEP {{ $step['step'] }}</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $step['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== SERVICES PREVIEW ===== --}}
<section class="py-24 bg-white" id="services">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-4xl font-black text-slate-900 mb-3">Our Services</h2>
                <p class="text-lg text-slate-500">Premium digital services — you sell, we deliver.</p>
            </div>
            <a href="{{ route('services.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-700">View All <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach(\App\Models\Service::take(4)->get() as $svc)
            <div class="group relative bg-white rounded-2xl border border-slate-200 hover:border-blue-300 hover:shadow-xl shadow-sm p-6 transition-all hover:-translate-y-1">
                @if($svc->is_popular)
                <div class="absolute -top-3 left-6 bg-gradient-to-r from-orange-400 to-amber-400 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md">⭐ Most Popular</div>
                @endif
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i data-lucide="{{ $svc->icon ?? 'box' }}" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-1">{{ $svc->name }}</h3>
                <p class="text-xs text-slate-500 mb-4">{{ $svc->short_description }}</p>
                <div class="text-2xl font-black text-slate-900 mb-4">₹{{ number_format($svc->min_price) }}<span class="text-sm font-medium text-slate-400">+</span></div>
                <ul class="space-y-1.5 mb-6">
                    @foreach(array_slice($svc->features ?? [], 0, 3) as $f)
                    <li class="flex items-center gap-2 text-xs text-slate-600">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0"><i data-lucide="check" class="w-2.5 h-2.5"></i></span> {{ $f }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('services.show', $svc->slug) }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold text-blue-600 border-2 border-blue-600 hover:bg-blue-600 hover:text-white transition-all">Get This Service</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== EARNINGS SECTION ===== --}}
<section class="py-24 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 text-white text-sm font-semibold px-4 py-2 rounded-full mb-6 border border-white/20">
                    <i data-lucide="indian-rupee" class="w-4 h-4"></i> Real Earning Example
                </div>
                <h2 class="text-4xl font-black text-white leading-tight mb-6">Earn ₹2,000 on a<br>Single Website Sale</h2>
                <p class="text-blue-200 text-lg leading-relaxed mb-8">You refer a client who needs a website. We close the deal & deliver. You pocket the commission — automatically, without any extra work.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-base font-bold text-blue-600 bg-white hover:bg-blue-50 shadow-lg transition-all hover:-translate-y-0.5">
                    <i data-lucide="zap" class="w-5 h-5"></i> Start Earning Now
                </a>
            </div>
            <div class="grid grid-cols-1 gap-4">
                @foreach([
                    ['service'=>'Website (₹10,000)','your_cut'=>'₹2,000–3,000','percent'=>'20–30%','icon'=>'globe'],
                    ['service'=>'App Dev (₹35,000)','your_cut'=>'₹7,000–10,500','percent'=>'20–30%','icon'=>'smartphone'],
                    ['service'=>'Marketing (₹10,000)','your_cut'=>'₹2,000–3,000','percent'=>'20–30%','icon'=>'trending-up'],
                ] as $e)
                <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white">
                            <i data-lucide="{{ $e['icon'] }}" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-white">{{ $e['service'] }}</div>
                            <div class="text-xs text-blue-200">Your commission</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-black text-white text-lg">{{ $e['your_cut'] }}</div>
                        <div class="text-xs text-emerald-300 font-semibold">{{ $e['percent'] }}</div>
                    </div>
                </div>
                @endforeach
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-400/20 flex items-center justify-center text-emerald-300">
                        <i data-lucide="share-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="font-bold text-white">Referral Bonus</div>
                        <div class="text-xs text-blue-200">When your referred partner earns</div>
                    </div>
                    <div class="ml-auto text-right">
                        <div class="font-black text-emerald-300 text-lg">+5–10%</div>
                        <div class="text-xs text-blue-300">Extra income</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS ===== --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-slate-900 mb-4">Partners Love Us</h2>
            <p class="text-lg text-slate-500">Real stories from our growing partner network.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['name'=>'Priya Sharma','city'=>'Mumbai','text'=>'I submitted my first lead and earned ₹2,500 within 3 weeks. The process was so smooth. I have now referred 5 more partners!','initials'=>'PS','color'=>'blue'],
                ['name'=>'Ravi Kumar','city'=>'Bangalore','text'=>'VivekTech team is very professional. My client got an amazing website and I got my full commission on time, no delays!','initials'=>'RK','color'=>'indigo'],
                ['name'=>'Sneha Patel','city'=>'Ahmedabad','text'=>'As a freelancer, this is gold. I just share the link, they handle everything — I earn commission sitting at home!','initials'=>'SP','color'=>'purple'],
            ] as $t)
            <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100">
                <div class="flex items-center gap-1 mb-4">
                    @for($i=0;$i<5;$i++) <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i> @endfor
                </div>
                <p class="text-slate-700 text-sm leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-{{ $t['color'] }}-100 text-{{ $t['color'] }}-600 font-bold text-sm flex items-center justify-center">{{ $t['initials'] }}</div>
                    <div><div class="font-bold text-slate-900 text-sm">{{ $t['name'] }}</div><div class="text-xs text-slate-500">{{ $t['city'] }}</div></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== FAQ ===== --}}
<section class="py-24 bg-slate-50" x-data="{ active: 0 }">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-slate-900 mb-4">Frequently Asked Questions</h2>
        </div>
        <div class="space-y-3">
            @foreach([
                ['q'=>'How much can I earn?','a'=>'You earn 20%–30% on every service sale you bring. A single website project of ₹10,000 = ₹2,000–3,000 in your pocket.'],
                ['q'=>'Is there any joining fee?','a'=>'Absolutely zero. Joining VivekTech Partner Network is completely free. No hidden charges, no monthly fees.'],
                ['q'=>'When will I get my commission?','a'=>'Commission is released within 7 business days after the client makes full payment for the service.'],
                ['q'=>'Do I need technical knowledge?','a'=>'No. Your only job is to bring the lead. Our team handles design, development, and delivery.'],
                ['q'=>'How does the referral system work?','a'=>'When you refer another partner and they earn a commission, you get 5–10% bonus. Single level only — no MLM.'],
            ] as $idx => $faq)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <button class="w-full flex items-center justify-between p-6 text-left font-semibold text-slate-900" @click="active = active === {{ $idx }} ? null : {{ $idx }}">
                    <span>{{ $faq['q'] }}</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform" :class="active === {{ $idx }} ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="active === {{ $idx }}" x-transition class="px-6 pb-6 text-slate-500 text-sm leading-relaxed" style="display:none">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== FINAL CTA ===== --}}
<section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-900 rounded-3xl p-12 sm:p-16 relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(99,102,241,0.3),_transparent_60%)]"></div>
            <div class="relative z-10">
                <h2 class="text-4xl sm:text-5xl font-black text-white mb-4 leading-tight">Ready to Start Earning?</h2>
                <p class="text-blue-200 text-lg mb-10 max-w-xl mx-auto">Join 500+ partners already earning from VivekTech. Register free, get your link, and start earning commissions today.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-10 py-5 rounded-2xl text-lg font-black text-blue-600 bg-white hover:bg-blue-50 shadow-2xl transition-all hover:-translate-y-1">
                    <i data-lucide="zap" class="w-6 h-6"></i> Join Now & Start Earning
                </a>
                <p class="text-blue-400 text-sm mt-6">Free forever · No investment · Instant activation</p>
            </div>
        </div>
    </div>
</section>

@endsection
