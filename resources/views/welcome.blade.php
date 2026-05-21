@extends('layouts.app')
@section('title', 'VivekTech — Premium Digital Agency')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
* { font-family: 'Inter', sans-serif; }

/* Gradient text animation */
@keyframes gradient-shift {
  0%   { background-position: 0% 50%; }
  50%  { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
.animated-gradient {
  background: linear-gradient(270deg, #7C3AED, #A855F7, #EC4899, #7C3AED);
  background-size: 400% 400%;
  animation: gradient-shift 4s ease infinite;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Floating glow blobs */
@keyframes float-slow {
  0%,100% { transform: translateY(0px) scale(1); }
  50%      { transform: translateY(-24px) scale(1.04); }
}
@keyframes float-slow2 {
  0%,100% { transform: translateY(0px) scale(1); }
  50%      { transform: translateY(20px) scale(0.97); }
}
.blob1 { animation: float-slow  7s ease-in-out infinite; }
.blob2 { animation: float-slow2 9s ease-in-out infinite; }

/* Fade up animation */
@keyframes fadeUp {
  from { opacity:0; transform:translateY(32px); }
  to   { opacity:1; transform:translateY(0); }
}
.fade-up { animation: fadeUp 0.7s ease both; }
.delay-1 { animation-delay:0.1s; }
.delay-2 { animation-delay:0.2s; }
.delay-3 { animation-delay:0.3s; }
.delay-4 { animation-delay:0.4s; }

/* Glass card */
.glass {
  background: rgba(255,255,255,0.7);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.9);
}

/* Service card hover */
.svc-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.svc-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px -12px rgba(124,58,237,0.25); }

/* Counter animation */
@keyframes countUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
.stat-num { animation: countUp 0.6s ease both; }

/* Testimonial dots */
.tdot { width:8px; height:8px; border-radius:9999px; background:#e2d9f3; transition:all 0.3s; }
.tdot.active { width:24px; background:#7C3AED; }

/* FAQ arrow */
.faq-arrow { transition: transform 0.3s ease; }
.faq-open .faq-arrow { transform: rotate(180deg); }
</style>

<div class="bg-[#FAFAFA] min-h-screen overflow-x-hidden">

  {{-- ══════════════════════════════════════
       HERO SECTION
  ══════════════════════════════════════ --}}
  <section class="relative min-h-screen flex flex-col justify-center pt-20 pb-16 px-4 overflow-hidden">

    {{-- Background glow blobs --}}
    <div class="absolute top-[-10%] right-[-8%] w-[520px] h-[520px] rounded-full blob1 pointer-events-none" style="background:radial-gradient(circle, rgba(167,139,250,0.3) 0%, transparent 70%);"></div>
    <div class="absolute bottom-[5%] left-[-10%] w-[480px] h-[480px] rounded-full blob2 pointer-events-none" style="background:radial-gradient(circle, rgba(236,72,153,0.18) 0%, transparent 70%);"></div>
    <div class="absolute top-[30%] left-[40%] w-64 h-64 rounded-full blob1 pointer-events-none" style="background:radial-gradient(circle, rgba(124,58,237,0.12) 0%, transparent 70%);"></div>

    <div class="max-w-5xl mx-auto text-center relative z-10">

      {{-- Badge --}}
      <div class="fade-up inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-50 border border-purple-200 text-purple-700 text-sm font-semibold mb-8">
        <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse inline-block"></span>
        Trusted by 500+ Businesses Across India
      </div>

      {{-- Heading --}}
      <h1 class="fade-up delay-1 text-4xl sm:text-6xl lg:text-7xl font-black text-gray-900 leading-[1.08] tracking-tight mb-6">
        We Build Digital<br>
        <span class="animated-gradient">Products That Convert</span>
      </h1>

      <p class="fade-up delay-2 text-lg sm:text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed mb-10 font-medium">
        From stunning websites to high-converting ad campaigns — VivekTech delivers end-to-end digital solutions that grow your revenue and brand authority.
      </p>

      {{-- CTA Buttons --}}
      <div class="fade-up delay-3 flex flex-col sm:flex-row gap-4 justify-center mb-16">
        <a href="{{ route('services.index') }}"
           class="px-8 py-4 rounded-2xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-base transition-all shadow-[0_8px_30px_rgba(124,58,237,0.4)] hover:shadow-[0_12px_40px_rgba(124,58,237,0.5)] hover:-translate-y-0.5 flex items-center justify-center gap-2">
          Explore Services
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
        <a href="{{ route('contact') }}"
           class="px-8 py-4 rounded-2xl bg-white hover:bg-gray-50 text-gray-800 font-bold text-base border border-gray-200 hover:border-purple-300 transition-all shadow-sm hover:-translate-y-0.5 flex items-center justify-center gap-2">
          <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Chat on WhatsApp
        </a>
      </div>

      {{-- Trust Badges --}}
      <div class="fade-up delay-4 flex flex-wrap items-center justify-center gap-6 text-sm text-gray-400 font-medium">
        @foreach(['98% Client Satisfaction', '₹2Cr+ Revenue Generated', '500+ Projects Delivered', '5-Star Rated Agency'] as $badge)
        <div class="flex items-center gap-1.5">
          <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          {{ $badge }}
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ══════════════════════════════════════
       SERVICES PREVIEW
  ══════════════════════════════════════ --}}
  <section class="py-20 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-14">
        <p class="text-purple-600 font-bold text-sm uppercase tracking-widest mb-3">What We Do</p>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4">Services Built to Scale</h2>
        <p class="text-gray-500 text-lg max-w-xl mx-auto">Every service is crafted to deliver measurable results for your business growth.</p>
      </div>

      @php
        $services = [
          [
            'icon' => 'shopping-cart',
            'name' => 'E-commerce Development',
            'desc' => 'Powerful, conversion-optimised online stores built on modern platforms.',
            'color' => 'from-violet-500 to-purple-600',
            'light' => 'bg-violet-50',
            'border' => 'border-violet-100/80',
            'text' => 'text-violet-600',
            'tag' => 'Most Popular'
          ],
          [
            'icon' => 'smartphone',
            'name' => 'Mobile App Development',
            'desc' => 'Native iOS & Android apps built for performance, UX, and user retention.',
            'color' => 'from-blue-500 to-indigo-600',
            'light' => 'bg-blue-50',
            'border' => 'border-blue-100/80',
            'text' => 'text-blue-600',
            'tag' => null
          ],
          [
            'icon' => 'megaphone',
            'name' => 'Facebook & Instagram Ads',
            'desc' => 'Hyper-targeted Meta ad campaigns that maximise your ROAS and brand reach.',
            'color' => 'from-pink-500 to-rose-600',
            'light' => 'bg-pink-50',
            'border' => 'border-pink-100/80',
            'text' => 'text-pink-600',
            'tag' => 'High Demand'
          ],
          [
            'icon' => 'search',
            'name' => 'Google Ads & SEO',
            'desc' => 'Rank on page 1 and get instant traffic with Google Ads + SEO strategy.',
            'color' => 'from-amber-500 to-orange-500',
            'light' => 'bg-amber-50',
            'border' => 'border-amber-100/80',
            'text' => 'text-amber-600',
            'tag' => null
          ],
          [
            'icon' => 'video',
            'name' => 'Reels & Video Editing',
            'desc' => 'Scroll-stopping short-form video content that grows your social presence.',
            'color' => 'from-teal-500 to-cyan-600',
            'light' => 'bg-teal-50',
            'border' => 'border-teal-100/80',
            'text' => 'text-teal-600',
            'tag' => null
          ],
          [
            'icon' => 'palette',
            'name' => 'UI/UX & Branding',
            'desc' => 'Premium design systems, logos, and brand identities that build trust instantly.',
            'color' => 'from-fuchsia-500 to-purple-600',
            'light' => 'bg-fuchsia-50',
            'border' => 'border-fuchsia-100/80',
            'text' => 'text-fuchsia-600',
            'tag' => null
          ],
        ];
      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($services as $svc)
        <a href="{{ route('services.index') }}" 
           class="svc-card group bg-white/95 backdrop-blur-md rounded-[32px] border border-slate-100/90 p-8 flex flex-col shadow-[0_2px_8px_-3px_rgba(0,0,0,0.04),0_10px_24px_-10px_rgba(0,0,0,0.03)] hover:shadow-[0_20px_40px_-15px_rgba(124,58,237,0.12),0_4px_12px_-5px_rgba(0,0,0,0.03)] hover:border-purple-200/60 hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden ring-1 ring-slate-900/[0.03] group">
          
          {{-- Sliding top accent line --}}
          <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r {{ $svc['color'] }} transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left z-20"></div>
          
          {{-- Hover gradient spotlight bg effect --}}
          <div class="absolute inset-0 bg-gradient-to-br {{ $svc['color'] }} opacity-0 group-hover:opacity-[0.03] transition-opacity duration-300 pointer-events-none rounded-[32px]"></div>

          {{-- Dynamic Dot Pattern Overlay --}}
          <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

          {{-- Popular tag --}}
          @if($svc['tag'])
          <span class="absolute top-6 right-6 text-[9px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full bg-gradient-to-r {{ $svc['color'] }} text-white shadow-sm border border-white/10 z-10">
            {{ $svc['tag'] }}
          </span>
          @endif

          {{-- Icon Box (Clean nested position inside card) --}}
          <div class="w-14 h-14 {{ $svc['light'] }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-105 group-hover:rotate-1 transition-all duration-300 shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] border {{ $svc['border'] }}">
            <i data-lucide="{{ $svc['icon'] }}" class="w-6 h-6 {{ $svc['text'] }}"></i>
          </div>

          {{-- Title & Desc --}}
          <h3 class="text-lg font-extrabold text-slate-900 mb-2.5 group-hover:text-purple-700 transition-colors tracking-tight font-sans">{{ $svc['name'] }}</h3>
          <p class="text-sm text-slate-500 leading-relaxed flex-1 font-normal font-sans">{{ $svc['desc'] }}</p>

          {{-- Bottom learn more link --}}
          <div class="mt-8 flex items-center text-purple-600 font-extrabold text-sm tracking-wide gap-1.5 transition-all group/link">
            <span class="border-b-2 border-transparent group-hover/link:border-purple-600 transition-all duration-200">Learn more</span>
            <i data-lucide="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-300"></i>
          </div>
        </a>
        @endforeach
      </div>

      <div class="text-center mt-10">
        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl border border-purple-200 text-purple-700 font-bold text-sm hover:bg-purple-50 transition-all">
          View All Services
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      </div>
    </div>
  </section>

  {{-- ══════════════════════════════════════
       STATS
  ══════════════════════════════════════ --}}
  <section class="py-16 px-4 bg-gradient-to-br from-purple-700 via-violet-700 to-indigo-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:url('data:image/svg+xml,<svg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'><g fill=\'%23fff\' fill-opacity=\'1\'><circle cx=\'20\' cy=\'20\' r=\'1.5\'/></g></svg>');"></div>
    <div class="max-w-5xl mx-auto relative z-10">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
        @foreach([['500+','Projects Delivered'],['₹2Cr+','Revenue Generated'],['98%','Client Retention'],['50+','Expert Team Members']] as $s)
        <div>
          <div class="text-4xl sm:text-5xl font-black mb-2">{{ $s[0] }}</div>
          <div class="text-purple-200 font-semibold text-sm">{{ $s[1] }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ══════════════════════════════════════
       WHY CHOOSE US
  ══════════════════════════════════════ --}}
  <section class="py-20 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
          <p class="text-purple-600 font-bold text-sm uppercase tracking-widest mb-3">Why VivekTech</p>
          <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-6 leading-tight">Built for Results,<br>Not Just Aesthetics</h2>
          <p class="text-gray-500 text-lg leading-relaxed mb-8">We combine creative design with performance engineering to build digital experiences that don't just look great — they convert and grow.</p>

          @php
            $whyItems = [
              [
                'icon' => 'zap',
                'title' => 'Fast Turnaround',
                'desc' => 'Projects delivered on time with transparent milestones and daily updates.',
                'color' => 'text-amber-600 bg-amber-50 border-amber-100/70'
              ],
              [
                'icon' => 'award',
                'title' => 'Premium Quality',
                'desc' => 'Every pixel, every line of code built to the highest standard.',
                'color' => 'text-purple-600 bg-purple-50 border-purple-100/70'
              ],
              [
                'icon' => 'bar-chart-3',
                'title' => 'Data-Driven',
                'desc' => 'Strategy backed by analytics, A/B testing and real-world performance data.',
                'color' => 'text-blue-600 bg-blue-50 border-blue-100/70'
              ],
              [
                'icon' => 'users-2',
                'title' => 'Dedicated Support',
                'desc' => 'Your own account manager available 6 days a week, all year round.',
                'color' => 'text-emerald-600 bg-emerald-50 border-emerald-100/70'
              ],
            ];
          @endphp

          <div class="space-y-4">
            @foreach($whyItems as $w)
            <div class="flex items-start gap-4 p-4.5 rounded-2xl bg-slate-50/50 hover:bg-white hover:shadow-[0_4px_20px_rgba(124,58,237,0.06)] border border-transparent hover:border-purple-100/50 transition-all duration-300 group cursor-default">
              <div class="w-12 h-12 rounded-xl {{ $w['color'] }} border flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)]">
                <i data-lucide="{{ $w['icon'] }}" class="w-5.5 h-5.5"></i>
              </div>
              <div>
                <h4 class="font-extrabold text-slate-900 mb-0.5 tracking-tight group-hover:text-purple-950 transition-colors">{{ $w['title'] }}</h4>
                <p class="text-sm text-slate-500 leading-relaxed font-normal">{{ $w['desc'] }}</p>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
          {{-- Card 1: Years Experience (Purple Gradient) --}}
          <div class="bg-gradient-to-br from-purple-600 via-indigo-600 to-violet-800 rounded-[32px] p-7 text-white shadow-[0_10px_30px_-10px_rgba(124,58,237,0.3)] relative overflow-hidden flex flex-col justify-between min-h-[180px] group hover:-translate-y-1.5 transition-all duration-300">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_120%,rgba(192,132,252,0.35),transparent_70%)] pointer-events-none"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] bg-[size:10px_10px] pointer-events-none"></div>
            <div class="w-11 h-11 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center shadow-[inset_0_1px_2px_rgba(255,255,255,0.1)] backdrop-blur-md">
              <i data-lucide="briefcase" class="w-5.5 h-5.5 text-white"></i>
            </div>
            <div class="relative z-10">
              <div class="text-4xl font-black mb-1 tracking-tight">10+</div>
              <div class="text-xs font-bold text-purple-100 tracking-wider uppercase">Years Experience</div>
            </div>
          </div>

          {{-- Card 2: Happy Clients (White Glass) --}}
          <div class="bg-white/90 backdrop-blur-md rounded-[32px] p-7 border border-slate-100 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.04),0_10px_20px_-8px_rgba(0,0,0,0.03)] hover:border-purple-200/60 hover:-translate-y-1.5 transition-all duration-300 group flex flex-col justify-between min-h-[180px] ring-1 ring-slate-900/[0.03]">
            <div class="w-11 h-11 rounded-xl bg-purple-50 border border-purple-100/50 flex items-center justify-center shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)]">
              <i data-lucide="users" class="w-5.5 h-5.5 text-purple-600"></i>
            </div>
            <div>
              <div class="text-4xl font-black text-slate-900 mb-1 tracking-tight group-hover:text-purple-700 transition-colors">50+</div>
              <div class="text-xs font-bold text-slate-500 tracking-wider uppercase">Happy Clients</div>
            </div>
          </div>

          {{-- Card 3: Transparency (White Glass) --}}
          <div class="bg-white/90 backdrop-blur-md rounded-[32px] p-7 border border-slate-100 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.04),0_10px_20px_-8px_rgba(0,0,0,0.03)] hover:border-purple-200/60 hover:-translate-y-1.5 transition-all duration-300 group flex flex-col justify-between min-h-[180px] ring-1 ring-slate-900/[0.03]">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100/50 flex items-center justify-center shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)]">
              <i data-lucide="shield-check" class="w-5.5 h-5.5 text-emerald-600"></i>
            </div>
            <div>
              <div class="text-4xl font-black text-slate-900 mb-1 tracking-tight group-hover:text-purple-700 transition-colors">100%</div>
              <div class="text-xs font-bold text-slate-500 tracking-wider uppercase">Transparency</div>
            </div>
          </div>

          {{-- Card 4: Support Always (Pink/Purple Gradient) --}}
          <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-[32px] p-7 text-white shadow-[0_10px_30px_-10px_rgba(79,70,229,0.3)] relative overflow-hidden flex flex-col justify-between min-h-[180px] group hover:-translate-y-1.5 transition-all duration-300">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_120%,rgba(244,63,94,0.3),transparent_70%)] pointer-events-none"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] bg-[size:10px_10px] pointer-events-none"></div>
            <div class="w-11 h-11 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center shadow-[inset_0_1px_2px_rgba(255,255,255,0.1)] backdrop-blur-md">
              <i data-lucide="phone-call" class="w-5.5 h-5.5 text-white"></i>
            </div>
            <div class="relative z-10">
              <div class="text-4xl font-black mb-1 tracking-tight">24/7</div>
              <div class="text-xs font-bold text-purple-100 tracking-wider uppercase">Support Always</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ══════════════════════════════════════
       TESTIMONIALS
  ══════════════════════════════════════ --}}
  <section class="py-20 px-4 bg-gray-50">
    <div class="max-w-5xl mx-auto">
      <div class="text-center mb-14">
        <p class="text-purple-600 font-bold text-sm uppercase tracking-widest mb-3">Testimonials</p>
        <h2 class="text-3xl sm:text-4xl font-black text-gray-900">What Our Clients Say</h2>
      </div>

      <div x-data="{ active: 0, total: 3, init(){ setInterval(()=>{ this.active=(this.active+1)%this.total },5000) } }">
        @php
          $testimonials = [
            ['name'=>'Rajesh Kumar',    'role'=>'CEO, FashionMart',        'text'=>'VivekTech built our e-commerce platform from scratch. Sales increased by 340% in just 3 months. The team is incredibly professional and responsive.', 'rating'=>5, 'avatar'=>'R'],
            ['name'=>'Priya Sharma',    'role'=>'Founder, HealthPlus',     'text'=>'Their Facebook Ads expertise is unmatched. We went from ₹50k to ₹8L monthly revenue in 6 months. Best investment we ever made.', 'rating'=>5, 'avatar'=>'P'],
            ['name'=>'Amit Patel',      'role'=>'Director, TechStartup',   'text'=>'The mobile app they built for us has 50,000+ downloads and 4.8 rating on Play Store. Exceptional quality, on-time delivery.', 'rating'=>5, 'avatar'=>'A'],
          ];
        @endphp

        <div class="relative max-w-3xl mx-auto pt-6">
          {{-- Floating quotes badge --}}
          <div class="absolute top-0 left-6 sm:left-10 w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-600 via-fuchsia-600 to-indigo-600 text-white flex items-center justify-center shadow-[0_8px_20px_rgba(124,58,237,0.3)] border border-purple-400/30 transform -rotate-12 z-20 animate-pulse">
            <i data-lucide="quote" class="w-5 h-5"></i>
          </div>

          @foreach($testimonials as $i => $t)
          <div x-show="active === {{ $i }}" x-transition.opacity.duration.500ms
               class="relative bg-white/95 backdrop-blur-md rounded-[32px] p-8 sm:p-14 border border-slate-100 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.04),0_20px_40px_-15px_rgba(124,58,237,0.08)] overflow-hidden ring-1 ring-slate-900/[0.03]"
               style="{{ $i > 0 ? 'display:none' : '' }}">
            
            {{-- Soft Spot Glow --}}
            <div class="absolute -right-24 -bottom-24 w-48 h-48 bg-gradient-to-br from-purple-400/10 to-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex items-center gap-1 mb-6 mt-4">
              @for($r=0;$r<$t['rating'];$r++)
              <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              @endfor
            </div>
            
            <p class="text-lg sm:text-2xl text-slate-750 font-medium leading-relaxed mb-8 italic tracking-tight font-sans">"{{ $t['text'] }}"</p>
            
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 via-fuchsia-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-lg shadow-sm border border-white/20">
                {{ $t['avatar'] }}
              </div>
              <div>
                <div class="font-extrabold text-slate-900 font-sans tracking-tight">{{ $t['name'] }}</div>
                <div class="text-sm text-slate-500 font-medium font-sans">{{ $t['role'] }}</div>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        {{-- Dots --}}
        <div class="flex justify-center gap-2 mt-8">
          @for($i=0;$i<3;$i++)
          <button @click="active={{ $i }}"
                  :class="active === {{ $i }} ? 'active' : ''"
                  class="tdot transition-all duration-300"
                  :style="active === {{ $i }} ? 'width:24px;background:#7C3AED' : 'width:8px;background:#e2d9f3'"></button>
          @endfor
        </div>
      </div>
    </div>
  </section>

  {{-- ══════════════════════════════════════
       FAQ
  ══════════════════════════════════════ --}}
  <section class="py-20 px-4 bg-white">
    <div class="max-w-3xl mx-auto">
      <div class="text-center mb-14">
        <p class="text-purple-600 font-bold text-sm uppercase tracking-widest mb-3">FAQ</p>
        <h2 class="text-3xl sm:text-4xl font-black text-gray-900">Frequently Asked Questions</h2>
      </div>

      <div x-data="{ open: null }" class="space-y-3">
        @php
          $faqs = [
            ['q'=>'How long does it take to build a website?', 'a'=>'Most websites are delivered within 7–21 days depending on complexity. E-commerce projects with custom features may take 4–6 weeks. We always share a clear timeline upfront.'],
            ['q'=>'What is your pricing structure?', 'a'=>'We offer transparent project-based pricing. Basic websites start from ₹15,000, e-commerce from ₹35,000, and mobile apps from ₹80,000. Custom enterprise projects are quoted based on scope.'],
            ['q'=>'Do you offer post-launch support?', 'a'=>'Absolutely. We provide 30 days of free support after launch. After that, affordable monthly maintenance packages are available starting at ₹3,000/month.'],
            ['q'=>'Can I refer clients and earn commission?', 'a'=>'Yes! Join our Partner Program and earn up to 20-30% commission on every project your referrals purchase. Payouts are processed directly to your bank account.'],
            ['q'=>'Which industries do you work with?', 'a'=>'We work across all industries including retail, healthcare, education, real estate, food & beverage, and tech startups. Our experience spans 50+ different verticals.'],
          ];
        @endphp

        @foreach($faqs as $i => $faq)
        <div x-data="{ isOpen: false }" 
             class="border rounded-2xl overflow-hidden transition-all duration-300 bg-white"
             :class="isOpen ? 'border-purple-200 shadow-md shadow-purple-500/5 bg-purple-50/10' : 'border-slate-200/80 hover:border-slate-300 shadow-sm'">
          <button @click="isOpen = !isOpen"
                  class="w-full flex items-center justify-between p-5 text-left bg-transparent hover:bg-slate-50/50 transition-colors">
            <span class="font-semibold text-slate-800 pr-4">{{ $faq['q'] }}</span>
            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-300" :class="isOpen ? 'rotate-180 text-purple-600' : ''"></i>
          </button>
          <div x-show="isOpen" x-collapse style="display:none">
            <div class="px-5 pb-5 text-slate-500 leading-relaxed text-sm border-t border-slate-100 pt-4">{{ $faq['a'] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ══════════════════════════════════════
       BOTTOM CTA
  ══════════════════════════════════════ --}}
  <section class="py-20 px-4 relative overflow-hidden" style="background:linear-gradient(135deg,#1e1b4b 0%,#4c1d95 50%,#1e1b4b 100%)">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] opacity-20 blob1 pointer-events-none" style="background:radial-gradient(circle,#a855f7,transparent 70%);"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] opacity-20 blob2 pointer-events-none" style="background:radial-gradient(circle,#6366f1,transparent 70%);"></div>

    <div class="max-w-3xl mx-auto text-center relative z-10">
      <h2 class="text-3xl sm:text-5xl font-black text-white mb-6 leading-tight">Ready to Grow Your Business?</h2>
      <p class="text-purple-200 text-lg mb-10 leading-relaxed">Let's build something extraordinary together. Get a free consultation and custom proposal in 24 hours.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-gray-900 rounded-2xl font-bold hover:bg-purple-50 transition-all shadow-lg hover:-translate-y-0.5">
          Get Free Consultation
        </a>
        <a href="{{ route('register') }}" class="px-8 py-4 bg-white/10 border border-white/20 text-white rounded-2xl font-bold hover:bg-white/20 transition-all backdrop-blur-md hover:-translate-y-0.5">
          Join Partner Network
        </a>
      </div>
    </div>
  </section>

</div>

@push('scripts')
<script>
  // Simple collapse for FAQ (Alpine x-collapse fallback)
  document.querySelectorAll('[x-data]').forEach(el => {
    if (!window.Alpine) {
      const btn = el.querySelector('button');
      const content = el.querySelector('[x-show]');
      if (btn && content) {
        btn.addEventListener('click', () => {
          content.style.display = content.style.display === 'none' ? 'block' : 'none';
          const svg = btn.querySelector('svg');
          if (svg) svg.style.transform = content.style.display === 'block' ? 'rotate(180deg)' : '';
        });
      }
    }
  });
</script>
@endpush

@endsection
