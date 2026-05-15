@extends('layouts.app')
@section('title', 'Contact Us — VivekTech')
@section('content')
<div class="bg-white">
    {{-- HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 to-blue-950 pt-20 pb-24 overflow-hidden text-center">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(99,102,241,0.2),_transparent_70%)]"></div>
        <div class="relative max-w-2xl mx-auto px-4">
            <h1 class="text-5xl font-black text-white mb-4 tracking-tight">Get In <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">Touch</span></h1>
            <p class="text-slate-300 text-lg">Have a project? Need a service? We respond within 24 hours — guaranteed.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Contact Form --}}
            <div class="lg:col-span-3 bg-white rounded-3xl shadow-2xl border border-slate-100 p-8 sm:p-10">
                <h2 class="text-2xl font-black text-slate-900 mb-2">Send Us a Message</h2>
                <p class="text-slate-500 text-sm mb-8">Fill the form below and our team will reach out shortly.</p>

                @if(session('success'))
                <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl text-sm border border-emerald-100 mb-6 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Full Name *</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all" placeholder="Your full name" value="{{ old('name') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Phone Number *</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all" placeholder="+91 9999999999" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Email Address</label>
                        <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all" placeholder="you@example.com" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Service Needed</label>
                        <select name="service" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                            <option value="">Select a service...</option>
                            @foreach(\App\Models\Service::all() as $s)
                            <option value="{{ $s->name }}" {{ old('service') == $s->name ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                            <option value="Other">Other / Not Sure</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Your Requirement *</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all resize-none" placeholder="Describe your project or requirement in detail...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="w-full py-4 rounded-2xl text-base font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-xl shadow-blue-600/20 transition-all hover:-translate-y-0.5">
                        Send Message
                    </button>
                </form>
            </div>

            {{-- Contact Info --}}
            <div class="lg:col-span-2 space-y-5">
                {{-- WhatsApp CTA --}}
                <a href="https://wa.me/919999999999?text=Hi VivekTech, I need help with a project." target="_blank" class="flex items-center gap-5 p-6 bg-green-500 rounded-2xl text-white hover:bg-green-600 transition-colors shadow-lg shadow-green-500/20 group">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <i data-lucide="message-circle" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <div class="font-black text-lg">Chat on WhatsApp</div>
                        <div class="text-green-100 text-sm">Fastest response guaranteed!</div>
                    </div>
                </a>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">Email Us</div>
                            <a href="mailto:hello@vivektech.in" class="text-blue-600 text-sm hover:underline">hello@vivektech.in</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">Call Us</div>
                            <a href="tel:+919999999999" class="text-blue-600 text-sm hover:underline">+91 99999 99999</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">Working Hours</div>
                            <div class="text-slate-500 text-sm">Mon–Sat: 9 AM – 7 PM IST</div>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-50 rounded-2xl border border-indigo-100 p-6">
                    <div class="font-black text-indigo-900 mb-2">Are you a freelancer?</div>
                    <p class="text-sm text-indigo-700 mb-4">Join our partner network, refer clients, and earn 30% commission on every project.</p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700">
                        Start Earning Now <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
