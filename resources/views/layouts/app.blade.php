<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SKSolutions Partner Network')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback if Vite is not compiled -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Poppins"', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Page-specific styles -->
    @stack('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif !important;
        }

        /* ── GLOBAL PREMIUM STYLING & ANIMATIONS ───────────────── */
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

        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%      { transform: translateY(-16px) scale(1.02); }
        }
        @keyframes float-slow2 {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%      { transform: translateY(12px) scale(0.98); }
        }
        .blob1 { animation: float-slow 8s ease-in-out infinite; }
        .blob2 { animation: float-slow2 10s ease-in-out infinite; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        /* ── GLOBAL RESPONSIVE TABLE FIX ────────────────────────── */
        /* Any table inside a .table-responsive wrapper scrolls on mobile */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        /* Auto-wrap ALL tables inside cards */
        .bg-white table, .bg-white .overflow-x-auto {
            min-width: 0;
        }
        table {
            border-collapse: collapse;
        }
        /* Prevent table cell overflow on mobile */
        @media (max-width: 640px) {
            td, th {
                white-space: nowrap;
            }
        }

        /* ── DASHBOARD CONTENT PADDING ───────────────────────────── */
        @media (max-width: 640px) {
            main > div {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }



        /* ── FORMS: Full width inputs on mobile ─────────────────── */
        @media (max-width: 640px) {
            input[type="text"],
            input[type="email"],
            input[type="number"],
            input[type="url"],
            input[type="password"],
            input[type="search"],
            select,
            textarea {
                width: 100%;
                font-size: 16px; /* prevent iOS zoom */
            }
        }

        /* ── STAT CARDS: Label truncation ────────────────────────── */
        .stat-label-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ── ACTION BUTTONS: Wrap on mobile ─────────────────────── */
        @media (max-width: 640px) {
            .page-actions {
                flex-direction: column;
                width: 100%;
            }
            .page-actions a,
            .page-actions button {
                width: 100%;
                justify-content: center;
            }
        }

        /* ── MOBILE BOTTOM NAV BAR (dashboard users) ────────────── */
        .mobile-bottom-nav {
            display: none;
        }
        @media (max-width: 1024px) {
            .mobile-bottom-nav {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                border-top: 1px solid #e2e8f0;
                z-index: 40;
                padding: 6px 0 env(safe-area-inset-bottom, 0);
                box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
            }
            /* Add bottom padding to main content so it doesn't hide behind nav */
            .min-h-full main {
                padding-bottom: 5rem !important;
            }
        }
        @media (min-width: 1024px) {
            .mobile-bottom-nav {
                display: none !important;
            }
        }

        /* ── SIDEBAR SCROLLBAR HIDE ──────────────────────────────── */
        .lg\:overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }
        .lg\:overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }
        .lg\:overflow-y-auto::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }

        /* ── HIDE SCROLLBAR FOR HORIZONTAL SCROLL ───────────────── */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── NOTIFICATION DROPDOWN: Full width on mobile ─────────── */
        @media (max-width: 480px) {
            [x-data*="notifOpen"] > div[x-show] {
                position: fixed !important;
                left: 1rem !important;
                right: 1rem !important;
                width: auto !important;
            }
        }

        /* ── MODAL FIX: Full screen on mobile ────────────────────── */
        @media (max-width: 640px) {
            .modal-content {
                margin: 1rem;
                max-height: calc(100vh - 2rem);
                overflow-y: auto;
            }
        }

        /* ── FORCE TEXT WRAP IN TIGHT CELLS ─────────────────────── */
        .allow-wrap { white-space: normal !important; }

        /* Styled thin scrollbars for tables */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Ensure all inputs placeholders are not bold */
        ::placeholder {
            font-weight: 400 !important;
        }
    </style>
</head>
<body class="h-full text-slate-900 bg-slate-50 selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    @hasSection('sidebar')
        <!-- Dashboard Layout -->
        <div class="min-h-full">
            <!-- Off-canvas menu for mobile -->
            <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
                <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

                <div class="fixed inset-0 flex">
                    <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1" @click.away="sidebarOpen = false">
                        <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                            <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                <span class="sr-only">Close sidebar</span>
                                <i data-lucide="x" class="h-6 w-6 text-white"></i>
                            </button>
                        </div>
                        <!-- Mobile Sidebar -->
                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 shadow-2xl">
                            @include('components.sidebar')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Static sidebar for desktop -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-slate-200 bg-white px-6 pb-4 shadow-sm">
                    @include('components.sidebar')
                </div>
            </div>

            <div class="lg:pl-72 flex flex-col min-h-screen">
                <!-- Dashboard Navbar -->
                @include('components.navbar')

                <!-- Main Content -->
                <main class="py-6 sm:py-10 flex-1">
                    <div class="px-4 sm:px-6 lg:px-8 max-w-9xl mx-auto">
                        @yield('content')
                    </div>
                </main>
            </div>

            <!-- Mobile Bottom Navigation Bar -->
            @if(auth('admin')->check() || auth('partner')->check() || auth('customer')->check())
            <nav class="mobile-bottom-nav lg:hidden">
                @php
                    $isAdmin = request()->is('admin*') && auth('admin')->check();
                    $isPartner = request()->is('partner*') && auth('partner')->check();
                    $isCustomer = request()->is('customer*', 'cart*', 'checkout*') && auth('customer')->check();

                    if (!$isAdmin && !$isPartner && !$isCustomer) {
                        if (auth('customer')->check()) {
                            $isCustomer = true;
                        } elseif (auth('partner')->check()) {
                            $isPartner = true;
                        } elseif (auth('admin')->check()) {
                            $isAdmin = true;
                        }
                    }

                    $u = null;
                    if ($isAdmin) {
                        $u = auth('admin')->user();
                    } elseif ($isPartner) {
                        $u = auth('partner')->user();
                    } elseif ($isCustomer) {
                        $u = auth('customer')->user();
                    }
                @endphp
                @if($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mb-0.5"></i> Home
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('admin.users') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="users" class="w-5 h-5 mb-0.5"></i> Users
                    </a>
                    <a href="{{ route('admin.orders') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('admin.orders') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="shopping-bag" class="w-5 h-5 mb-0.5"></i> Orders
                    </a>
                    <a href="{{ route('admin.commissions') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('admin.commissions') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="coins" class="w-5 h-5 mb-0.5"></i> Commissions
                    </a>
                    <button @click="sidebarOpen = true" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold text-slate-500">
                        <i data-lucide="menu" class="w-5 h-5 mb-0.5"></i> More
                    </button>
                @elseif($isPartner)
                    <a href="{{ route('partner.dashboard') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('partner.dashboard') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mb-0.5"></i> Home
                    </a>
                    <a href="{{ route('partner.leads.index') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('partner.leads.*') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="target" class="w-5 h-5 mb-0.5"></i> Leads
                    </a>
                    <a href="{{ route('partner.referrals') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('partner.referrals') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="link" class="w-5 h-5 mb-0.5"></i> Referrals
                    </a>
                    <a href="{{ route('partner.withdrawals') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('partner.withdrawals') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="wallet" class="w-5 h-5 mb-0.5"></i> Wallet
                    </a>
                    <button @click="sidebarOpen = true" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold text-slate-500">
                        <i data-lucide="menu" class="w-5 h-5 mb-0.5"></i> More
                    </button>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('customer.dashboard') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mb-0.5"></i> Home
                    </a>
                    <a href="{{ route('customer.services') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('customer.services') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="grid-3x3" class="w-5 h-5 mb-0.5"></i> Services
                    </a>
                    <a href="{{ route('cart.index') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('cart.index') ? 'text-indigo-600' : 'text-slate-500' }} relative">
                        <i data-lucide="shopping-cart" class="w-5 h-5 mb-0.5"></i>
                        @if($u && method_exists($u, 'cartItems') && $u->cartItems()->count() > 0)
                        <span class="absolute top-1 right-5 w-4 h-4 bg-indigo-600 text-white text-[9px] font-black rounded-full flex items-center justify-center">{{ $u->cartItems()->count() }}</span>
                        @endif
                        Cart
                    </a>
                    <a href="{{ route('customer.orders') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->routeIs('customer.orders') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="package" class="w-5 h-5 mb-0.5"></i> Orders
                    </a>
                    <a href="{{ url('/portfolio') }}" class="flex-1 flex flex-col items-center py-2 gap-0.5 text-[10px] font-bold {{ request()->is('portfolio') ? 'text-indigo-600' : 'text-slate-500' }}">
                        <i data-lucide="briefcase" class="w-5 h-5 mb-0.5"></i> Portfolio
                    </a>
                @endif
            </nav>
            @endif
        </div>

    @else
        <!-- Landing Page Layout (No Sidebar) -->
        <div class="min-h-screen flex flex-col">
            @unless(View::hasSection('hide_nav_footer'))
                @include('components.navbar')
            @endunless
            <main class="flex-1">
                @yield('content')
            </main>
            @unless(View::hasSection('hide_nav_footer'))
                @include('components.footer')
            @endunless
        </div>
    @endif

    <!-- Global Premium Toasts / Notifications -->
    @if(session('success') || session('error') || session('info') || session('status'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 6000)"
        x-show="show" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border p-5 flex items-start gap-4 transition-all"
        :class="{
            'border-emerald-100 bg-emerald-50/95 backdrop-blur-md': '{{ session('success') }}',
            'border-red-100 bg-red-50/95 backdrop-blur-md': '{{ session('error') }}',
            'border-blue-100 bg-blue-50/95 backdrop-blur-md': '{{ session('info') || session('status') }}'
        }"
        style="display: none;"
    >
        <!-- Icon -->
        @if(session('success'))
        <div class="p-2 rounded-2xl bg-emerald-500 text-white shrink-0 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        @elseif(session('error'))
        <div class="p-2 rounded-2xl bg-red-500 text-white shrink-0 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        @else
        <div class="p-2 rounded-2xl bg-blue-500 text-white shrink-0 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        @endif
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <h4 class="text-sm font-black text-slate-900 capitalize">
                @if(session('success')) Success @elseif(session('error')) Error @else Notification @endif
            </h4>
            <p class="text-xs text-slate-600 font-semibold mt-1 leading-relaxed">
                {{ session('success') ?? session('error') ?? session('info') ?? session('status') }}
            </p>
        </div>

        <!-- Close button -->
        <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors p-1 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif

    <!-- Initialize Icons -->
    <script>
        lucide.createIcons();
    </script>

    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>
