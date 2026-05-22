<footer class="bg-white text-slate-500 pt-16 pb-8 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <img src="{{ asset('logo.jpg') }}" alt="SK Solutions Logo" class="h-10 w-auto rounded-xl object-contain shadow-sm border border-slate-100">
                </div>
                <p class="text-slate-500 text-sm leading-relaxed max-w-sm font-medium">
                    We deliver high-quality digital solutions to help you scale your business efficiently. Join our partner network and grow with us.
                </p>
                <div class="flex items-center gap-4 mt-6">
                    <a href="https://wa.me/919999999999" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-colors text-slate-500">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors text-slate-500">
                        <i data-lucide="linkedin" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-pink-600 hover:text-white flex items-center justify-center transition-colors text-slate-500">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="text-slate-900 font-black mb-4 text-sm uppercase tracking-wider">Platform</h4>
                <ul class="space-y-3">
                    <li><a href="{{ url('/') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Home</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Services</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Contact Us</a></li>
                    <li><a href="{{ route('register') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Become a Partner</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-slate-900 font-black mb-4 text-sm uppercase tracking-wider">Services</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('services.show', 'custom-ecommerce-website-development') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Website Development</a></li>
                    <li><a href="{{ route('services.show', 'premium-mobile-app-development') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">App Development</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Digital Marketing</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Video Editing</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs font-bold text-slate-400">© {{ date('Y') }} SKSolutions. All rights reserved.</p>
            <p class="text-xs font-bold text-slate-400">Built with <span class="text-red-500">❤️</span> by SKSolutions</p>
        </div>
    </div>
</footer>
