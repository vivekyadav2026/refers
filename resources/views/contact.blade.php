@extends('layouts.app')
@section('title', 'Contact Us — SK Solutions')
@section('content')
<div class="bg-slate-50 min-h-screen">
    {{-- HEADER --}}
    <div class="relative bg-white pt-20 pb-32 overflow-hidden text-center border-b border-slate-200">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-50/80 to-transparent"></div>
        <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] bg-purple-200/30 rounded-full blur-[100px] -z-10"></div>
        <div class="relative max-w-3xl mx-auto px-4 z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 mb-6 tracking-tight">Get In <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">Touch</span></h1>
            <p class="text-slate-500 text-lg sm:text-xl font-medium max-w-2xl mx-auto leading-relaxed">Have a project? Need a service? Our team is ready to help you grow your business. We respond within 24 hours — guaranteed.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 pb-24 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Contact Form --}}
            <div class="lg:col-span-3 bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 p-8 sm:p-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-100/50 rounded-bl-full -z-10 blur-xl"></div>
                
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mb-2 tracking-tight">Send Us a Message</h2>
                <p class="text-slate-500 text-sm font-medium mb-10">Fill the form below and our team will reach out shortly.</p>

                @if(session('success'))
                <div class="bg-emerald-50 text-emerald-700 p-5 rounded-2xl text-sm font-bold border border-emerald-100 mb-8 flex items-center gap-3 shadow-sm">
                    <i data-lucide="check-circle" class="w-6 h-6 shrink-0"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 mb-1.5 uppercase tracking-wider">Full Name *</label>
                            <input type="text" name="name" required class="w-full px-5 py-4 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm bg-slate-50 outline-none transition-all font-medium" placeholder="John Doe" value="{{ old('name') }}">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 mb-1.5 uppercase tracking-wider">Phone Number *</label>
                            <input type="tel" name="phone" required class="w-full px-5 py-4 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm bg-slate-50 outline-none transition-all font-medium" placeholder="+91 9999999999" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 mb-1.5 uppercase tracking-wider">Email Address</label>
                        <input type="email" name="email" class="w-full px-5 py-4 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm bg-slate-50 outline-none transition-all font-medium" placeholder="you@example.com" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 mb-1.5 uppercase tracking-wider">Service Needed</label>
                        <select name="service" class="w-full px-5 py-4 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm bg-slate-50 outline-none transition-all font-medium appearance-none" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem top 50%; background-size: 0.65rem auto;">
                            <option value="">Select a service...</option>
                            @foreach(\App\Models\Service::all() as $s)
                            <option value="{{ $s->name }}" {{ old('service') == $s->name ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                            <option value="Other">Other / Not Sure</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 mb-1.5 uppercase tracking-wider">Your Requirement *</label>
                        <textarea name="message" rows="5" required class="w-full px-5 py-4 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm bg-slate-50 outline-none transition-all resize-none font-medium" placeholder="Describe your project or requirement in detail...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="w-full py-4 rounded-2xl text-base font-black text-white bg-purple-700 hover:bg-purple-800 shadow-[0_8px_25px_-5px_rgba(109,40,217,0.4)] transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        Send Message <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

            {{-- Contact Info --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- WhatsApp CTA --}}
                <a href="https://wa.me/919999999999?text=Hi SK Solutions, I need help with a project." target="_blank" class="flex items-center gap-5 p-8 bg-emerald-500 rounded-[2rem] text-white hover:bg-emerald-600 transition-colors shadow-[0_10px_30px_-10px_rgba(16,185,129,0.5)] group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-inner relative z-10 border border-white/20">
                        <i data-lucide="message-circle" class="w-8 h-8"></i>
                    </div>
                    <div class="relative z-10">
                        <div class="font-black text-xl mb-1 tracking-tight">Chat on WhatsApp</div>
                        <div class="text-emerald-50 text-sm font-medium">Fastest response guaranteed!</div>
                    </div>
                </a>

                <div class="bg-white rounded-[2rem] border border-slate-100 p-8 space-y-8 shadow-sm">
                    <div class="flex items-start gap-5 group">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 border border-purple-100 group-hover:scale-110 group-hover:bg-purple-100 transition-all duration-300">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-400 text-xs uppercase tracking-wider mb-1">Email Us</div>
                            <a href="mailto:hello@sksolutions.in" class="text-slate-900 font-bold text-base hover:text-purple-600 transition-colors">hello@sksolutions.in</a>
                        </div>
                    </div>
                    <div class="h-px w-full bg-slate-50"></div>
                    <div class="flex items-start gap-5 group">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100 group-hover:scale-110 group-hover:bg-indigo-100 transition-all duration-300">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-400 text-xs uppercase tracking-wider mb-1">Call Us</div>
                            <a href="tel:+919999999999" class="text-slate-900 font-bold text-base hover:text-indigo-600 transition-colors">+91 99999 99999</a>
                        </div>
                    </div>
                    <div class="h-px w-full bg-slate-50"></div>
                    <div class="flex items-start gap-5 group">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-400 text-xs uppercase tracking-wider mb-1">Working Hours</div>
                            <div class="text-slate-900 font-bold text-base">Mon–Sat: 9 AM – 7 PM IST</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-[2rem] border border-purple-100 p-8 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/40 rounded-bl-full -z-10 blur-xl"></div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-4">
                        <i data-lucide="briefcase" class="w-6 h-6"></i>
                    </div>
                    <div class="font-black text-slate-900 text-xl mb-3 tracking-tight">Are you a freelancer?</div>
                    <p class="text-sm font-medium text-slate-600 mb-6 leading-relaxed">Join our partner network, refer clients, and earn up to 30% commission on every project.</p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-slate-900 px-5 py-3 rounded-xl hover:bg-purple-700 transition-all shadow-md">
                        Start Earning Now <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
