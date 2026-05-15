<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'VivekTech Partner Network')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback if Vite is not compiled -->
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Page-specific styles -->
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-slate-900 bg-slate-50 selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

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

    <!-- Initialize Icons -->
    <script>
        lucide.createIcons();
    </script>

    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>
