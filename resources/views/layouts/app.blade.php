<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'VivekTech Partner Network')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
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
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
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
                <main class="py-10 flex-1">
                    <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    @else
        <!-- Landing Page Layout (No Sidebar) -->
        <div class="min-h-screen flex flex-col">
            @include('components.navbar')
            <main class="flex-1">
                @yield('content')
            </main>
            @include('components.footer')
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
