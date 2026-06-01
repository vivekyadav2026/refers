@extends('layouts.app')
@section('title', 'Contact Us — SKSolutions')
@section('hide_nav_footer', true) {{-- Hide default nav to build the exact mobile UI consistent with welcome and services --}}

@section('content')

<style>
/* Add the font from the design */
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

/* ── Header ─────────────────────────────────────────────── */
.sk-header {
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid #f3f0ff;
    box-shadow: 0 1px 8px rgba(109,40,217,0.06);
}

/* ── Bottom nav ─────────────────────────────────────────── */
.bottom-nav-bar {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: #fff;
    border-top: 1px solid #ede9fe;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 8px 0 max(8px, env(safe-area-inset-bottom));
    z-index: 60;
    box-shadow: 0 -4px 20px rgba(109,40,217,0.07);
}
@media (min-width: 1024px) { .bottom-nav-bar { display: none !important; } }

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    flex: 1;
    text-decoration: none;
    color: #9ca3af;
    transition: color 0.2s;
    font-size: 0.58rem;
    font-weight: 700;
}
.nav-item.active, .nav-item:hover { color: #6d28d9; }

.glass-form {
  background: rgba(255, 255, 255, 0.82);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.7);
}

.input-field {
  width: 100%;
  padding: 14px 18px;
  border-radius: 16px;
  border: 1.5px solid rgba(229, 231, 235, 0.8);
  background: rgba(249, 250, 251, 0.7);
  font-size: 14px;
  font-weight: 500;
  color: #1f2937;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  outline: none;
}

.input-field:hover {
  border-color: rgba(124, 58, 237, 0.4);
  background: rgba(255, 255, 255, 0.9);
}

.input-field:focus {
  border-color: #4F46E5;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12), 0 4px 12px rgba(79, 70, 229, 0.05);
}

.input-field::placeholder { color: #9ca3af; }

/* Custom select arrow padding */
select.input-field {
  padding-right: 40px;
}

@keyframes float-slow {
  0%, 100% { transform: translateY(0px) scale(1); }
  50%      { transform: translateY(-12px) scale(1.02); }
}
@keyframes float-slow2 {
  0%, 100% { transform: translateY(0px) scale(1); }
  50%      { transform: translateY(10px) scale(0.98); }
}
.float-anim1 { animation: float-slow 6s ease-in-out infinite; }
.float-anim2 { animation: float-slow2 8s ease-in-out infinite; }
</style>

<!-- Standard Header Navbar -->
<header class="sk-header">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 select-none shrink-0">
            <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-12 sm:h-12 w-auto object-contain">
        </a>

        <!-- Search Bar -->
        <form action="{{ route('services.index') }}" method="GET" class="flex items-center flex-1 max-w-[220px] sm:max-w-xs relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." style="background-color: #ffffff !important;" class="w-full bg-white text-[11px] sm:text-xs font-normal text-gray-800 placeholder-gray-400 placeholder:font-normal pl-10 sm:pl-11 pr-2 sm:pr-3 py-1.5 sm:py-2 rounded-full border border-gray-200/80 focus:border-violet-500 outline-none transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 absolute left-3.5 sm:left-4 pointer-events-none" style="margin-left: 10px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>

        <!-- Desktop Navigation links -->
        <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ url('/') }}"           class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Home</a>
            <a href="{{ route('services.index') }}" class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Services</a>
            <a href="{{ url('/') }}#why-choose-us"           class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Why Us</a>
            <a href="{{ route('contact') }}"   class="text-sm font-bold text-violet-700">Contact</a>
        </nav>

        <!-- Right actions -->
        <div class="flex items-center gap-3">
            <!-- Notification bell -->
            <!-- Notification bell -->
            @auth
            @php $unread = auth()->user()->unreadNotifications->take(10); @endphp
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="relative p-2 rounded-full hover:bg-violet-50 transition-colors" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($unread->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
                    @endif
                </button>

                <!-- Dropdown -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-violet-100 z-50 overflow-hidden"
                     style="display:none">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-black text-gray-800">Notifications</span>
                        @if($unread->count() > 0)
                        <span class="text-[10px] font-bold bg-violet-100 text-violet-700 px-2 py-0.5 rounded-full">{{ $unread->count() }} new</span>
                        @endif
                    </div>
                    <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                        @forelse($unread as $notif)
                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left p-3 flex gap-3 hover:bg-gray-50 transition-colors bg-transparent border-0 cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[11px] font-bold text-gray-800 truncate">{{ $notif->data['title'] ?? 'Notification' }}</p>
                                    <p class="text-[10px] text-gray-500 mt-0.5 line-clamp-2 leading-relaxed">{{ $notif->data['message'] ?? '' }}</p>
                                    <p class="text-[9px] text-gray-400 mt-1 font-medium">{{ $notif->created_at->diffForHumans() }}</p>
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
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="relative p-2 rounded-full hover:bg-violet-50 transition-colors" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>
                <div x-show="open" class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-violet-100 z-50 overflow-hidden" style="display:none">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-black text-gray-800">Notifications</span>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-xs font-bold text-gray-500">Log in to view notifications</p>
                    </div>
                </div>
            </div>
            @endauth

            @if(auth('admin')->check() || auth('partner')->check() || auth('customer')->check())
                <!-- User avatar -->
                @php
                    $u = auth()->user();
                    $ini = strtoupper(implode('', array_map(fn($w)=>mb_substr($w,0,1), array_slice(array_filter(explode(' ',trim($u->name))),0,2))));
                    $dashUrl = match($u->role){ 'admin'=>route('admin.dashboard'),'partner'=>route('partner.dashboard'),default=>route('customer.dashboard')};
                @endphp
                <div class="relative" x-data="{ pOpen:false }" @click.away="pOpen=false">
                    <button @click="pOpen=!pOpen" class="w-9 h-9 rounded-full bg-violet-100 text-violet-700 font-black text-xs flex items-center justify-center ring-2 ring-violet-50 hover:ring-violet-200 transition-all">{{ $ini }}</button>
                    <div x-show="pOpen" x-transition class="absolute right-0 mt-2 w-44 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden" style="display:none">
                        <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/60">
                            <p class="text-xs font-bold text-gray-800 truncate">{{ $u->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate mt-0.5">{{ $u->email ?: $u->phone }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ $dashUrl }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-violet-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">@csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-50 transition-colors text-left bg-transparent border-0 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Desktop login / explore -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-violet-700 transition-colors">Log in</a>
                </div>
            @endif
        </div>
    </div>
</header>

<div class="bg-slate-50 min-h-screen pb-16">

  {{-- ══════ HERO ══════ --}}
  <div class="relative pt-3 pb-8 sm:pt-5 sm:pb-10 overflow-hidden bg-white border-b border-slate-100">
    {{-- Precision Grid Overlay --}}
    <div class="absolute inset-0 bg-[radial-gradient(#e2d9f3_1.2px,transparent_1.2px)] bg-[size:32px_32px] opacity-75 [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_80%,transparent_100%)] pointer-events-none z-0"></div>

    {{-- Floating Glassmorphic Shapes --}}
    <div class="absolute top-12 right-12 w-20 h-20 rounded-full bg-purple-200/10 border border-purple-300/20 float-anim1 hidden lg:block backdrop-blur-md"></div>
    <div class="absolute bottom-8 left-16 w-14 h-14 rounded-2xl bg-indigo-200/10 border border-indigo-300/20 float-anim2 hidden lg:block backdrop-blur-md"></div>

    {{-- Ambient glowing gradients --}}
    <div class="absolute -top-20 -right-20 w-[450px] h-[450px] bg-purple-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-25 pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-[450px] h-[450px] bg-indigo-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-25 pointer-events-none"></div>

    <div class="max-w-3xl mx-auto px-4 text-center relative z-10">
      {{-- Elegant Tech Badge --}}
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-100 text-indigo-850 text-[10px] font-bold tracking-wider uppercase mb-5">
        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Connect With Us
      </span>
      
      {{-- Slate Title with Signature Gradient --}}
      <h1 class="text-3.5xl sm:text-5xl font-black text-slate-900 mb-5 leading-tight tracking-tight">
        Let's Build Something <br class="hidden sm:inline">
        <span class="text-indigo-800 drop-shadow-[0_2px_10px_rgba(124,58,237,0.12)]">Amazing Together</span>
      </h1>
      
      <p class="text-slate-500 text-xs sm:text-sm md:text-base max-w-xl mx-auto leading-relaxed font-semibold">
        Have a project in mind? Our expert team responds within 24 hours — often much faster. Let's start the conversation.
      </p>
    </div>
  </div>

  {{-- ══════ MAIN CONTENT ══════ --}}
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-16">

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

      {{-- ─── LEFT: Info Panel ─── --}}
      <div class="lg:col-span-2 space-y-6">

        @php
            $supportEmail = \App\Models\Setting::get_val('support_email', 'support@sksolutioss.com');
            $supportPhone = \App\Models\Setting::get_val('support_phone', '+91 8287121769');
            $cleanPhone = preg_replace('/[^0-9]/', '', $supportPhone);
        @endphp

        {{-- Direct Contact Cards --}}
        <div>
          <h2 class="text-xl sm:text-2xl font-black text-slate-900 mb-6 tracking-tight flex items-center gap-2">
            <i data-lucide="message-square" class="w-6 h-6 text-indigo-800"></i> Reach Us Directly
          </h2>

          {{-- WhatsApp Card --}}
          <a href="https://wa.me/{{ $cleanPhone }}?text=https://sksolutionss.com/%20Hi%20SK%20Solutions%20team,%20I%20need%20help"
             target="_blank"
             class="flex items-center gap-4 sm:gap-5 p-5 sm:p-6 rounded-[24px] bg-gradient-to-br from-emerald-550 from-emerald-500 via-emerald-600 to-teal-700 text-white hover:shadow-2xl hover:shadow-emerald-500/30 hover:-translate-y-1 active:scale-[0.98] transition-all duration-300 mb-5 group relative overflow-hidden shadow-xl shadow-emerald-500/10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_120%,rgba(255,255,255,0.2),transparent_60%)] pointer-events-none"></div>
            {{-- Glow --}}
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-md">
              <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <div class="font-black text-base tracking-tight leading-none mb-1">Chat on WhatsApp</div>
              <div class="text-emerald-100 text-xs font-semibold opacity-90 truncate">Fastest response — usually within minutes</div>
            </div>
            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center shrink-0 group-hover:bg-white/20 transition-colors ml-auto">
              <i data-lucide="arrow-right" class="w-4 h-4 text-white group-hover:translate-x-1 transition-transform"></i>
            </div>
          </a>

          {{-- Info Cards ──--}}
          @php
            $infoCards = [
              ['icon'=>'mail',  'label'=>'Email',         'val'=>$supportEmail,          'href'=>'mailto:'.$supportEmail, 'bg'=>'bg-purple-50',  'text'=>'text-purple-600', 'border'=>'border-purple-100'],
              ['icon'=>'phone', 'label'=>'Phone',         'val'=>$supportPhone,             'href'=>'tel:+'.$cleanPhone,         'bg'=>'bg-blue-50',    'text'=>'text-blue-600',   'border'=>'border-blue-100'],
              ['icon'=>'clock', 'label'=>'Working Hours', 'val'=>'Mon–Sat: 10 AM – 6 PM IST',    'href'=>null,                        'bg'=>'bg-amber-50',   'text'=>'text-amber-600',  'border'=>'border-amber-100'],
            ];
          @endphp

          <div class="space-y-4">
            @foreach($infoCards as $info)
            <div class="flex items-center gap-4 p-5 bg-white rounded-[24px] border border-slate-100 shadow-sm hover:border-indigo-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
              <div class="w-12 h-12 rounded-2xl {{ $info['bg'] }} border {{ $info['border'] }} flex items-center justify-center shrink-0 group-hover:scale-110 transition-all duration-300">
                <i data-lucide="{{ $info['icon'] }}" class="w-5 h-5 {{ $info['text'] }}"></i>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ $info['label'] }}</div>
                @if($info['href'])
                  <a href="{{ $info['href'] }}" class="font-bold text-slate-800 hover:text-indigo-800 transition-colors text-sm sm:text-base truncate block tracking-tight">{{ $info['val'] }}</a>
                @else
                  <div class="font-bold text-slate-800 text-sm sm:text-base truncate tracking-tight">{{ $info['val'] }}</div>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- ─── RIGHT: Contact Form ─── --}}
      <div class="lg:col-span-3">
        <div class="glass-form rounded-[32px] p-6 sm:p-10 shadow-xl shadow-slate-200/50 border border-white/80">
          <h2 class="text-2.5xl sm:text-3.5xl font-black text-slate-900 mb-2 tracking-tight">Send a Message</h2>
          <p class="text-slate-500 text-xs sm:text-sm font-semibold mb-8">We'll get back to you within 24 hours with a detailed quote and analysis.</p>

          {{-- Success and Error Alerts --}}
          @if(session('success'))
          <div class="flex items-start gap-3.5 bg-emerald-50/80 border border-emerald-200/60 text-emerald-900 rounded-[20px] p-5 mb-8 text-sm font-bold shadow-sm backdrop-blur-sm">
            <div class="p-1 rounded-xl bg-emerald-500 text-white shrink-0 shadow-sm">
              <i data-lucide="check" class="w-4 h-4" stroke-width="3"></i>
            </div>
            <div class="flex-1">
              <h4 class="text-sm font-black text-emerald-950 leading-none mb-1">Message Sent!</h4>
              <p class="text-xs text-emerald-800 font-semibold leading-relaxed">{{ session('success') }}</p>
            </div>
          </div>
          @endif

          @if($errors->any())
          <div class="flex items-start gap-3.5 bg-rose-50/80 border border-rose-200/60 text-rose-900 rounded-[20px] p-5 mb-8 text-sm font-bold shadow-sm backdrop-blur-sm">
            <div class="p-1 rounded-xl bg-rose-500 text-white shrink-0 shadow-sm">
              <i data-lucide="alert-circle" class="w-4 h-4" stroke-width="3"></i>
            </div>
            <div class="flex-1">
              <h4 class="text-sm font-black text-rose-950 leading-none mb-1.5">Please correct the errors:</h4>
              <ul class="list-disc list-inside space-y-1 text-xs text-rose-800 font-semibold leading-relaxed">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif

          <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Full Name <span class="text-rose-500">*</span></label>
                <div class="relative">
                  <input type="text" name="name" required class="input-field" placeholder="e.g. Rahul Sharma" value="{{ old('name') }}">
                </div>
              </div>
              <div>
                <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Phone Number <span class="text-rose-500">*</span></label>
                <div class="relative">
                  <input type="tel" name="phone" required class="input-field" placeholder="+91 98765 43210" value="{{ old('phone') }}">
                </div>
              </div>
            </div>

            <div>
              <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Email Address</label>
              <div class="relative">
                <input type="email" name="email" class="input-field" placeholder="you@company.com" value="{{ old('email') }}">
              </div>
            </div>

            <div>
              <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Service Needed</label>
              <div class="relative">
                <select name="service" class="input-field cursor-pointer" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%236366f1%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 1.2rem center; background-size:0.65rem; appearance:none;">
                  <option value="">Select a service...</option>
                  @foreach(\App\Models\Service::all() as $s)
                  <option value="{{ $s->name }}" {{ old('service') == $s->name ? 'selected' : '' }}>{{ $s->name }}</option>
                  @endforeach
                  <option value="Other">Other / Not Sure</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Project Details <span class="text-rose-500">*</span></label>
              <div class="relative">
                <textarea name="message" rows="5" required class="input-field resize-none" placeholder="Tell us about your project goals, timeline, and budget...">{{ old('message') }}</textarea>
              </div>
            </div>

            <div class="pt-2">
              <button type="submit"
                      class="w-full py-4 bg-indigo-800 hover:bg-indigo-900 active:scale-[0.98] text-white rounded-[18px] font-bold text-base transition-all duration-300 shadow-lg shadow-indigo-800/20 hover:shadow-indigo-800/30 flex items-center justify-center gap-2 group/btn">
                <span>Send Message</span>
                <i data-lucide="send" class="w-4 h-4 group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform"></i>
              </button>
              <p class="text-center text-xs text-slate-400 mt-4 font-semibold flex items-center justify-center gap-1">
                <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-400"></i> Your data is secure. We never share your information.
              </p>
            </div>
          </form>
        </div>
      </div>

    </div>

    {{-- ══════ FAQ SECTION ══════ --}}
    <div class="mt-24">
      <div class="text-center mb-12 max-w-lg mx-auto">
        <h2 class="text-2.5xl sm:text-3.5xl font-black text-slate-900 tracking-tight">Quick Answers</h2>
        <p class="text-slate-500 text-xs sm:text-sm font-semibold mt-2">Clear solutions to common questions before reaching out</p>
      </div>

      @php
        $quickFaqs = [
          ['icon'=>'clock',       'label'=>'How fast do you reply?',            'val'=>'We respond to all inquiries within 4 business hours. WhatsApp messages are often replied to within minutes.', 'bg'=>'bg-purple-50',  'text'=>'text-purple-600',  'border'=>'border-purple-100'],
          ['icon'=>'sparkles',    'label'=>'Do you offer free consultation?',   'val'=>'Yes! Initial consultation calls are completely free. We\'ll understand your needs before quoting anything.', 'bg'=>'bg-blue-50',    'text'=>'text-blue-600',    'border'=>'border-blue-100'],
          ['icon'=>'globe',       'label'=>'Do you work with clients remotely?','val'=>'Absolutely. 90% of our clients are serviced remotely via Zoom, WhatsApp, and our project management tools.', 'bg'=>'bg-emerald-50', 'text'=>'text-emerald-600', 'border'=>'border-emerald-100'],
          ['icon'=>'file-text',   'label'=>'What info do I need to share?',     'val'=>'Simply describe your project goals, budget range, and timeline. We\'ll guide you through everything else.', 'bg'=>'bg-amber-50',   'text'=>'text-amber-600',   'border'=>'border-amber-100'],
        ];
      @endphp

      <div class="max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-5">
        @foreach($quickFaqs as $faq)
        <div class="bg-white rounded-[24px] border border-slate-100 p-6 hover:border-indigo-200/80 shadow-sm hover:shadow-md transition-all duration-300 group">
          <div class="w-11 h-11 rounded-xl {{ $faq['bg'] }} border {{ $faq['border'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-all duration-300">
            <i data-lucide="{{ $faq['icon'] }}" class="w-5 h-5 {{ $faq['text'] }}"></i>
          </div>
          <h4 class="font-bold text-slate-800 mb-2 text-sm sm:text-base group-hover:text-indigo-850 transition-colors tracking-tight">{{ $faq['label'] }}</h4>
          <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-semibold">{{ $faq['val'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

<!-- Desktop Footer (hidden on mobile, visible on desktop) -->
<div class="hidden lg:block">
    @include('components.footer')
</div>

<!-- Fixed Bottom Navigation (Public Mobile Only) -->
<nav class="bottom-nav-bar lg:hidden">
    <a href="{{ url('/') }}" class="nav-item" id="nav-home">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Home
    </a>
    <a href="{{ route('services.index') }}" class="nav-item" id="nav-services">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Services
    </a>
    @auth
        @php
            $u = auth()->user();
            $ordersUrl = match($u->role){
                'admin' => route('admin.dashboard'),
                'partner' => route('partner.orders'),
                default => route('customer.orders'),
            };
        @endphp
        <a href="{{ $ordersUrl }}" class="nav-item" id="nav-orders">
    @else
        <a href="{{ route('login') }}" class="nav-item" id="nav-orders">
    @endif
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Orders
    </a>
    <a href="{{ route('contact') }}" class="nav-item active" id="nav-support">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        Support
    </a>
    <a href="{{ url('/portfolio') }}" class="nav-item" id="nav-portfolio">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Portfolio
    </a>
</nav>

@endsection
