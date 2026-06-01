@hasSection('sidebar')
{{-- ===================== DASHBOARD NAVBAR ===================== --}}
<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white/80 backdrop-blur-md px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    <button type="button" class="-m-2.5 p-2.5 text-slate-700 lg:hidden" @click="sidebarOpen = true">
        <i data-lucide="menu" class="h-6 w-6"></i>
    </button>
    <div class="h-6 w-px bg-slate-200 lg:hidden"></div>
    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        @php
            $searchRoute = route('services.index');
            if (auth()->check()) {
                if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin') {
                    $searchRoute = route('admin.services');
                } elseif (auth()->user()->role === 'partner') {
                    $searchRoute = route('partner.services');
                } else {
                    $searchRoute = route('customer.services');
                }
            }
        @endphp
        <form class="relative flex flex-1" action="{{ $searchRoute }}" method="GET">
            <i data-lucide="search" class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-slate-400"></i>
            <input value="{{ request('search') }}" class="block h-full w-full border-0 py-0 pl-8 pr-0 text-slate-900 placeholder:text-slate-400 focus:ring-0 sm:text-sm bg-transparent outline-none" placeholder="Search services..." type="search" name="search">
        </form>
        <div class="flex items-center gap-x-4 lg:gap-x-6">
            {{-- ── Notification Bell ── --}}
            @auth
            @php $unread = auth()->user()->unreadNotifications->take(10); @endphp
            <div class="relative" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
                <button type="button" @click="notifOpen = !notifOpen"
                    class="-m-2.5 p-2.5 text-slate-400 hover:text-slate-600 relative transition-colors">
                    <i data-lucide="bell" class="h-6 w-6"></i>
                    @if($unread->count() > 0)
                    <span class="absolute top-2 right-2 flex h-4 w-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-white text-[9px] font-black items-center justify-center">
                            {{ $unread->count() > 9 ? '9+' : $unread->count() }}
                        </span>
                    </span>
                    @endif
                </button>

                {{-- Dropdown Panel --}}
                <div x-show="notifOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-100 z-50 overflow-hidden"
                    style="display:none">

                    {{-- Header --}}
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <i data-lucide="bell" class="w-4 h-4 text-slate-500"></i>
                            <span class="text-sm font-black text-slate-800">Notifications</span>
                            @if($unread->count() > 0)
                            <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10px] font-black">{{ $unread->count() }} new</span>
                            @endif
                        </div>
                        @if($unread->count() > 0)
                        <form method="POST" action="{{ route('notifications.read.all') }}">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">Mark all read</button>
                        </form>
                        @endif
                    </div>

                    {{-- Notification List --}}
                    <div class="max-h-[420px] overflow-y-auto divide-y divide-slate-50">
                        @forelse($unread as $notif)
                        @php
                            $iconMap = [
                                'new_order'          => ['icon' => 'shopping-bag',  'bg' => 'bg-blue-100',   'text' => 'text-blue-600'],
                                'new_member'         => ['icon' => 'user-plus',     'bg' => 'bg-emerald-100','text' => 'text-emerald-600'],
                                'commission_credited'=> ['icon' => 'indian-rupee',  'bg' => 'bg-emerald-100','text' => 'text-emerald-600'],
                                'kyc_status' => [
                                    'icon' => $notif->data['icon'] ?? 'shield-check',
                                    'bg'   => ($notif->data['color'] ?? 'emerald') === 'red' ? 'bg-red-100'   : 'bg-emerald-100',
                                    'text' => ($notif->data['color'] ?? 'emerald') === 'red' ? 'text-red-600' : 'text-emerald-600',
                                ],
                            ];
                            $style = $iconMap[$notif->data['type']] ?? ['icon' => 'bell', 'bg' => 'bg-slate-100', 'text' => 'text-slate-600'];
                        @endphp
                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-start gap-3 px-5 py-4 hover:bg-slate-50 transition-colors group">
                                <div class="w-9 h-9 rounded-xl {{ $style['bg'] }} {{ $style['text'] }} flex items-center justify-center shrink-0 mt-0.5">
                                    <i data-lucide="{{ $style['icon'] }}" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-bold text-slate-900 truncate">{{ $notif->data['title'] ?? 'Notification' }}</div>
                                    <div class="text-xs font-medium text-slate-500 mt-0.5 line-clamp-2">{{ $notif->data['message'] ?? '' }}</div>
                                    <div class="text-[10px] text-slate-400 mt-1 font-medium">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="w-2 h-2 rounded-full bg-blue-500 shrink-0 mt-2 group-hover:bg-blue-400 transition-colors"></div>
                            </button>
                        </form>
                        @empty
                        <div class="px-5 py-12 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="bell-off" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-500">All caught up!</p>
                            <p class="text-xs text-slate-400 mt-1">No new notifications</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Footer --}}
                    @if(auth()->user()->notifications->count() > 0)
                    <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 text-center">
                        <span class="text-xs text-slate-400 font-medium">Showing {{ $unread->count() }} unread of {{ auth()->user()->notifications->count() }} total</span>
                    </div>
                    @endif
                </div>
            </div>
            @endauth

            @if(auth()->check())
            <a href="{{ route('cart.index') }}" class="-m-2.5 p-2.5 text-slate-400 hover:text-slate-500 relative">
                <i data-lucide="shopping-cart" class="h-6 w-6"></i>
                @if(auth()->user()->cartItems->count() > 0)
                <span class="absolute top-2 right-2 block h-5 w-5 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center ring-2 ring-white">{{ auth()->user()->cartItems->count() }}</span>
                @endif
            </a>
            @endif
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-slate-200"></div>
            <div class="relative" x-data="{ open: false }">
                <button type="button" class="-m-1.5 flex items-center p-1.5 rounded-full hover:bg-slate-50 transition-colors" @click="open = !open" @click.away="open = false">
                    @if(auth()->check() && auth()->user()->avatar)
                        <div class="h-8 w-8 rounded-full shadow-sm ring-2 ring-white overflow-hidden">
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
                            {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'VT' }}
                        </div>
                    @endif
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm font-semibold leading-6 text-slate-900">{{ auth()->check() ? auth()->user()->name : 'Partner' }}</span>
                        <i data-lucide="chevron-down" class="ml-2 h-4 w-4 text-slate-400"></i>
                    </span>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95 translate-y-2" x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" x-transition:leave-end="transform opacity-0 scale-95 translate-y-2" class="absolute right-0 z-50 mt-3 w-56 origin-top-right rounded-3xl bg-white p-2 shadow-2xl border border-slate-100" style="display:none">
                    <div class="px-3 py-2 border-b border-slate-100 mb-1">
                        <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Signed in as</div>
                        <div class="text-sm font-bold text-slate-900 truncate">{{ auth()->check() ? auth()->user()->name : '' }}</div>
                    </div>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('admin.kyc') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-bold text-slate-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i data-lucide="shield-check" class="w-4 h-4 text-slate-400"></i> KYC Approvals
                        </a>
                    @elseif(auth()->check() && auth()->user()->role === 'partner')
                        <a href="{{ route('partner.kyc') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-bold text-slate-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i data-lucide="shield-check" class="w-4 h-4 text-slate-400"></i> KYC & Agreements
                        </a>
                        <a href="{{ route('partner.profile') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-bold text-slate-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Account Settings
                        </a>
                    @elseif(auth()->check() && auth()->user()->role === 'customer')
                        <a href="{{ route('customer.profile') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-bold text-slate-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Account Settings
                        </a>
                    @endif
                    <div class="border-t border-slate-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm font-bold text-red-600 rounded-xl hover:bg-red-50 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4 text-red-400"></i> Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@else
{{-- ===================== PUBLIC LANDING NAVBAR ===================== --}}
<div class="fixed top-0 w-full z-50 px-0 md:px-6 lg:px-8 pt-0 md:pt-6 transition-all duration-300" x-data="{ scrolled: false, mobileOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
    <nav class="relative max-w-7xl mx-auto transition-all duration-300" :class="scrolled ? 'bg-white/90 backdrop-blur-xl border-b md:border border-slate-200/85 shadow-[0_10px_40px_-10px_rgba(109,40,217,0.15)] md:rounded-2xl py-3 px-4 md:px-6' : 'bg-white/70 backdrop-blur-md border-b border-slate-200/40 md:border-none md:bg-transparent md:backdrop-blur-none py-4 px-4 md:px-0'">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-12 sm:h-14 w-auto rounded-xl object-contain shadow-sm border border-slate-100 bg-white">
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-8 bg-white border border-slate-200 shadow-sm rounded-full px-6 py-2.5">
                <a href="{{ route('landing') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('landing') ? 'text-purple-700' : 'text-slate-600 hover:text-purple-600' }}">Home</a>
                <a href="{{ route('services.index') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('services.*') ? 'text-purple-700' : 'text-slate-600 hover:text-purple-600' }}">Services</a>
                <a href="{{ route('contact') }}" class="text-sm font-bold transition-colors {{ request()->routeIs('contact') ? 'text-purple-700' : 'text-slate-600 hover:text-purple-600' }}">Contact</a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @php
                        $dashUrl = match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'partner' => route('partner.dashboard'),
                            default => route('customer.dashboard'),
                        };
                    @endphp
                    <a href="{{ route('cart.index') }}" class="mr-2 p-2.5 text-slate-500 hover:text-purple-600 relative transition-colors">
                        <i data-lucide="shopping-cart" class="h-6 w-6"></i>
                        @if(auth()->user()->cartItems->count() > 0)
                        <span class="absolute top-1 right-1 block h-5 w-5 rounded-full bg-purple-600 text-white text-[10px] font-black flex items-center justify-center ring-2 ring-white">{{ auth()->user()->cartItems->count() }}</span>
                        @endif
                    </a>
                    <a href="{{ $dashUrl }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-sm transition-all hover:-translate-y-0.5">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-purple-600"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-purple-600 transition-colors px-4 py-2">Log in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold text-white bg-purple-700 hover:bg-purple-800 shadow-[0_8px_20px_-6px_rgba(109,40,217,0.5)] transition-all hover:-translate-y-0.5">
                        Start Free <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <button class="md:hidden p-2 rounded-xl text-slate-600 bg-white/80 border border-slate-200/80 hover:bg-slate-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20" @click="mobileOpen = !mobileOpen">
                <i data-lucide="menu" class="w-5 h-5" x-show="!mobileOpen"></i>
                <i data-lucide="x" class="w-5 h-5" x-show="mobileOpen" style="display:none"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             class="md:hidden absolute top-full left-4 right-4 mt-2 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xl z-50" 
             style="display:none; background-color: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 25px 50px -12px rgba(109, 40, 217, 0.18); border: 1px solid rgba(226, 232, 240, 0.9);">
            <div class="space-y-1.5">
                <a href="{{ route('landing') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('landing') ? 'text-purple-700 bg-purple-50/80' : 'text-slate-600 hover:bg-slate-50 hover:text-purple-600' }}">
                    <i data-lucide="home" class="w-5 h-5 {{ request()->routeIs('landing') ? 'text-purple-600' : 'text-slate-400' }}"></i>
                    Home
                </a>
                <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('services.*') ? 'text-purple-700 bg-purple-50/80' : 'text-slate-600 hover:bg-slate-50 hover:text-purple-600' }}">
                    <i data-lucide="briefcase" class="w-5 h-5 {{ request()->routeIs('services.*') ? 'text-purple-600' : 'text-slate-400' }}"></i>
                    Services
                </a>
                <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('contact') ? 'text-purple-700 bg-purple-50/80' : 'text-slate-600 hover:bg-slate-50 hover:text-purple-600' }}">
                    <i data-lucide="mail" class="w-5 h-5 {{ request()->routeIs('contact') ? 'text-purple-600' : 'text-slate-400' }}"></i>
                    Contact
                </a>
            </div>
            <div class="pt-4 mt-3 border-t border-slate-100/80 flex flex-col gap-2.5">
                @auth
                    @php
                        $dashUrlMobile = match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'partner' => route('partner.dashboard'),
                            default => route('customer.dashboard'),
                        };
                    @endphp
                    <a href="{{ route('cart.index') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-all border border-slate-200/60">
                        <i data-lucide="shopping-cart" class="w-4 h-4 text-slate-500"></i>
                        My Cart ({{ auth()->user()->cartItems->count() }})
                    </a>
                    <a href="{{ $dashUrlMobile }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl text-sm font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 transition-all shadow-[0_4px_15px_-4px_rgba(109,40,217,0.4)]">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-white"></i>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-all border border-slate-200/60">
                        <i data-lucide="log-in" class="w-4 h-4 text-slate-500"></i>
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl text-sm font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 transition-all shadow-[0_4px_15px_-4px_rgba(109,40,217,0.4)]">
                        Start Free <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</div>
@endif

