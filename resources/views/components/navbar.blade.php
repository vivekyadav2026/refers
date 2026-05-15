@hasSection('sidebar')
{{-- ===================== DASHBOARD NAVBAR ===================== --}}
<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white/80 backdrop-blur-md px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    <button type="button" class="-m-2.5 p-2.5 text-slate-700 lg:hidden" @click="sidebarOpen = true">
        <i data-lucide="menu" class="h-6 w-6"></i>
    </button>
    <div class="h-6 w-px bg-slate-200 lg:hidden"></div>
    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        <form class="relative flex flex-1" action="#" method="GET">
            <i data-lucide="search" class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-slate-400"></i>
            <input class="block h-full w-full border-0 py-0 pl-8 pr-0 text-slate-900 placeholder:text-slate-400 focus:ring-0 sm:text-sm bg-transparent outline-none" placeholder="Search..." type="search" name="search">
        </form>
        <div class="flex items-center gap-x-4 lg:gap-x-6">
            <button type="button" class="-m-2.5 p-2.5 text-slate-400 hover:text-slate-500 relative">
                <i data-lucide="bell" class="h-6 w-6"></i>
                <span class="absolute top-2.5 right-2.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-slate-200"></div>
            <div class="relative" x-data="{ open: false }">
                <button type="button" class="-m-1.5 flex items-center p-1.5 rounded-full hover:bg-slate-50 transition-colors" @click="open = !open" @click.away="open = false">
                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'VT' }}
                    </div>
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm font-semibold leading-6 text-slate-900">{{ auth()->check() ? auth()->user()->name : 'Partner' }}</span>
                        <i data-lucide="chevron-down" class="ml-2 h-4 w-4 text-slate-400"></i>
                    </span>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2.5 w-40 origin-top-right rounded-xl bg-white py-2 shadow-lg ring-1 ring-slate-900/5" style="display:none">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.kyc') : route('partner.kyc') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">My KYC / ID Card</a>
                    <div class="border-t border-slate-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@else
{{-- ===================== PUBLIC LANDING NAVBAR ===================== --}}
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-black text-sm shadow-md">V</div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900">VivekTech</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Home</a>
                <a href="{{ route('services.index') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Services</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Contact</a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('partner.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all hover:-translate-y-0.5">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors px-3 py-2 rounded-xl hover:bg-slate-100">Log in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-md shadow-blue-600/20 transition-all hover:-translate-y-0.5">
                        Start Earning <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <button class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors" @click="mobileOpen = !mobileOpen">
                <i data-lucide="menu" class="w-5 h-5" x-show="!mobileOpen"></i>
                <i data-lucide="x" class="w-5 h-5" x-show="mobileOpen" style="display:none"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden border-t border-slate-100 py-4 space-y-2" style="display:none">
            <a href="{{ url('/') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Home</a>
            <a href="{{ route('services.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Services</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Contact</a>
            <div class="pt-2 flex flex-col gap-2">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('partner.dashboard') }}" class="block w-full text-center px-4 py-3 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 transition-colors">Start Earning Free</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
@endif
