<footer class="bg-slate-900 text-slate-400 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm">V</div>
                    <span class="font-extrabold text-xl tracking-tight text-white">VivekTech</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                    Earn by Bringing Clients, We Deliver the Work. Join India's fastest-growing digital service affiliate network.
                </p>
                <div class="flex items-center gap-4 mt-6">
                    <a href="https://wa.me/919999999999" target="_blank" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-green-600 flex items-center justify-center transition-colors">
                        <i data-lucide="message-circle" class="w-4 h-4 text-white"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-colors">
                        <i data-lucide="linkedin" class="w-4 h-4 text-white"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-pink-600 flex items-center justify-center transition-colors">
                        <i data-lucide="instagram" class="w-4 h-4 text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Platform</h4>
                <ul class="space-y-3">
                    <li><a href="{{ url('/') }}" class="text-sm hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-sm hover:text-white transition-colors">Services</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm hover:text-white transition-colors">Contact Us</a></li>
                    <li><a href="{{ route('register') }}" class="text-sm hover:text-white transition-colors">Become a Partner</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Services</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('services.show', 'website-development') }}" class="text-sm hover:text-white transition-colors">Website Development</a></li>
                    <li><a href="{{ route('services.show', 'app-development') }}" class="text-sm hover:text-white transition-colors">App Development</a></li>
                    <li><a href="{{ route('services.show', 'digital-marketing') }}" class="text-sm hover:text-white transition-colors">Digital Marketing</a></li>
                    <li><a href="{{ route('services.show', 'video-editing') }}" class="text-sm hover:text-white transition-colors">Video Editing</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-500">© {{ date('Y') }} VivekTech. All rights reserved.</p>
            <p class="text-xs text-slate-500">Built with ❤️ in India</p>
        </div>
    </div>
</footer>
