@extends('layouts.app')
@section('title', 'Contact Us — VivekTech')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
* { font-family: 'Inter', sans-serif; }
.glass-form {
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,0.9);
}
.input-field {
  width: 100%;
  padding: 14px 18px;
  border-radius: 14px;
  border: 1.5px solid #e5e7eb;
  background: #f9fafb;
  font-size: 14px;
  font-weight: 500;
  color: #111827;
  transition: all 0.2s ease;
  outline: none;
}
.input-field:focus {
  border-color: #7C3AED;
  background: #fff;
  box-shadow: 0 0 0 4px rgba(124,58,237,0.1);
}
.input-field::placeholder { color: #9ca3af; }
@keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
.fade-up { animation: fadeUp 0.6s ease both; }
.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
.float-anim { animation: float 5s ease-in-out infinite; }
</style>

<div class="bg-[#FAFAFA] min-h-screen">

  {{-- ══════ HERO ══════ --}}
  <div class="relative bg-gradient-to-br from-purple-900 via-violet-800 to-indigo-900 pt-28 pb-24 overflow-hidden">
    <div class="absolute inset-0" style="background:radial-gradient(ellipse at 30% 50%, rgba(167,139,250,0.3) 0%, transparent 60%), radial-gradient(ellipse at 80% 40%, rgba(99,102,241,0.2) 0%, transparent 60%);"></div>

    {{-- Floating shapes --}}
    <div class="absolute top-16 right-16 w-24 h-24 rounded-full bg-purple-400/20 float-anim hidden lg:block"></div>
    <div class="absolute bottom-10 left-20 w-16 h-16 rounded-2xl bg-violet-400/20 float-anim hidden lg:block" style="animation-delay:1.5s"></div>

    <div class="max-w-3xl mx-auto px-4 text-center relative z-10">
      <p class="text-purple-300 font-bold text-sm uppercase tracking-widest mb-4 fade-up">Contact Us</p>
      <h1 class="text-3xl sm:text-5xl font-black text-white mb-6 leading-tight fade-up delay-1">Let's Build Something <span class="text-purple-300">Amazing Together</span></h1>
      <p class="text-purple-200 text-lg leading-relaxed fade-up delay-2">Have a project in mind? Our team responds within 24 hours — often much faster. Let's talk.</p>
    </div>
  </div>

  {{-- ══════ MAIN CONTENT ══════ --}}
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

      {{-- ─── LEFT: Info panel ─── --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- Quick contact cards --}}
        <div class="fade-up">
          <h2 class="text-xl font-black text-gray-900 mb-5">Reach Us Directly</h2>

          {{-- WhatsApp --}}
          <a href="https://wa.me/919999999999?text=Hi VivekTech, I need help with a project."
             target="_blank"
             class="flex items-center gap-5 p-6 rounded-3xl bg-gradient-to-r from-emerald-500 to-green-600 text-white hover:shadow-xl hover:shadow-green-500/20 hover:-translate-y-0.5 transition-all duration-300 mb-4 group relative overflow-hidden shadow-lg shadow-green-500/10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_120%,rgba(255,255,255,0.15),transparent_70%)] pointer-events-none"></div>
            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
              <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </div>
            <div class="flex-1">
              <div class="font-black text-base">Chat on WhatsApp</div>
              <div class="text-green-100 text-sm">Fastest response — usually within minutes</div>
            </div>
            <i data-lucide="arrow-right" class="w-5 h-5 ml-auto opacity-80 group-hover:translate-x-1 transition-transform"></i>
          </a>

          {{-- Info cards --}}
          @php
            $infoCards = [
              ['icon'=>'mail',  'label'=>'Email',         'val'=>'hello@vivektech.in',          'href'=>'mailto:hello@vivektech.in', 'bg'=>'bg-purple-50',  'text'=>'text-purple-600', 'border'=>'border-purple-100'],
              ['icon'=>'phone', 'label'=>'Phone',         'val'=>'+91 99999 99999',             'href'=>'tel:+919999999999',         'bg'=>'bg-blue-50',    'text'=>'text-blue-600',   'border'=>'border-blue-100'],
              ['icon'=>'clock', 'label'=>'Working Hours', 'val'=>'Mon–Sat: 9 AM – 7 PM IST',    'href'=>null,                        'bg'=>'bg-amber-50',   'text'=>'text-amber-600',  'border'=>'border-amber-100'],
            ];
          @endphp

          <div class="space-y-3">
            @foreach($infoCards as $info)
            <div class="flex items-center gap-4 p-5 bg-white rounded-3xl border border-slate-100/80 shadow-sm hover:border-purple-200/60 hover:shadow-md transition-all duration-300 group ring-1 ring-slate-900/5">
              <div class="w-12 h-12 rounded-2xl {{ $info['bg'] }} border {{ $info['border'] }} flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <i data-lucide="{{ $info['icon'] }}" class="w-5 h-5 {{ $info['text'] }}"></i>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">{{ $info['label'] }}</div>
                @if($info['href'])
                  <a href="{{ $info['href'] }}" class="font-bold text-slate-800 hover:text-purple-700 transition-colors text-sm truncate block">{{ $info['val'] }}</a>
                @else
                  <div class="font-bold text-slate-800 text-sm truncate">{{ $info['val'] }}</div>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>

        {{-- Partner CTA --}}
        <div class="fade-up delay-2 bg-gradient-to-br from-purple-700 via-purple-800 to-indigo-900 rounded-3xl p-6 sm:p-7 text-white relative overflow-hidden shadow-lg shadow-purple-500/10 group hover:-translate-y-0.5 transition-all duration-300">
          <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_120%,rgba(192,132,252,0.25),transparent_70%)] pointer-events-none"></div>
          <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-sm">
            <i data-lucide="briefcase" class="w-6 h-6 text-white"></i>
          </div>
          <h3 class="font-black text-xl mb-2 tracking-tight">Are You a Freelancer?</h3>
          <p class="text-purple-200 text-sm mb-5 leading-relaxed">Join our Partner Network and earn 20–30% commission on every referral. Zero investment required.</p>
          <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-purple-700 hover:bg-purple-50 px-5 py-3 rounded-2xl font-bold text-sm transition-colors shadow-md w-full justify-center">
            <span>Start Earning Now</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
          </a>
        </div>
      </div>

      {{-- ─── RIGHT: Contact Form ─── --}}
      <div class="lg:col-span-3">
        <div class="glass-form rounded-3xl p-8 sm:p-10 shadow-2xl shadow-purple-100/50">
          <h2 class="text-2xl font-black text-gray-900 mb-2">Send a Message</h2>
          <p class="text-gray-500 text-sm mb-8">We'll get back to you within 24 hours with a detailed response.</p>

          @if(session('success'))
          <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-4 mb-8 text-sm font-medium shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
          </div>
          @endif

          @if($errors->any())
          <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 mb-8 text-sm font-medium">
            <ul class="list-disc list-inside space-y-1">
              @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
          </div>
          @endif

          <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="input-field" placeholder="e.g. Rahul Sharma" value="{{ old('name') }}">
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" name="phone" required class="input-field" placeholder="+91 98765 43210" value="{{ old('phone') }}">
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Email Address</label>
              <input type="email" name="email" class="input-field" placeholder="you@company.com" value="{{ old('email') }}">
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Service Needed</label>
              <select name="service" class="input-field" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 1rem center; background-size:0.65rem; appearance:none;">
                <option value="">Select a service...</option>
                @foreach(\App\Models\Service::all() as $s)
                <option value="{{ $s->name }}" {{ old('service') == $s->name ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
                <option value="Other">Other / Not Sure</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Project Details <span class="text-red-500">*</span></label>
              <textarea name="message" rows="5" required class="input-field resize-none" placeholder="Tell us about your project, goals, timeline, and budget...">{{ old('message') }}</textarea>
            </div>

            <div class="pt-2">
              <button type="submit"
                      class="w-full py-4 bg-purple-700 hover:bg-purple-800 text-white rounded-2xl font-bold text-base transition-all shadow-lg shadow-purple-200 hover:shadow-purple-300 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                Send Message
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
              </button>
              <p class="text-center text-xs text-gray-400 mt-3 font-medium">🔒 Your data is secure. We never share your information.</p>
            </div>
          </form>
        </div>
      </div>

    </div>

    {{-- ══════ FAQ SECTION ══════ --}}
    <div class="mt-20">
      <div class="text-center mb-10">
        <h2 class="text-2xl sm:text-3xl font-black text-gray-900">Quick Answers</h2>
        <p class="text-gray-500 mt-2">Common questions before reaching out</p>
      </div>

      @php
        $quickFaqs = [
          ['icon'=>'clock',       'label'=>'How fast do you reply?',            'val'=>'We respond to all inquiries within 4 business hours. WhatsApp messages are often replied to within minutes.', 'bg'=>'bg-purple-50',  'text'=>'text-purple-600',  'border'=>'border-purple-100'],
          ['icon'=>'sparkles',    'label'=>'Do you offer free consultation?',   'val'=>'Yes! Initial consultation calls are completely free. We\'ll understand your needs before quoting anything.', 'bg'=>'bg-blue-50',    'text'=>'text-blue-600',    'border'=>'border-blue-100'],
          ['icon'=>'globe',       'label'=>'Do you work with clients remotely?','val'=>'Absolutely. 90% of our clients are serviced remotely via Zoom, WhatsApp, and our project management tools.', 'bg'=>'bg-emerald-50', 'text'=>'text-emerald-600', 'border'=>'border-emerald-100'],
          ['icon'=>'file-text',   'label'=>'What info do I need to share?',     'val'=>'Simply describe your project goals, budget range, and timeline. We\'ll guide you through everything else.', 'bg'=>'bg-amber-50',   'text'=>'text-amber-600',   'border'=>'border-amber-100'],
        ];
      @endphp

      <div class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($quickFaqs as $faq)
        <div class="bg-white rounded-3xl border border-slate-100 p-6 hover:border-purple-200/60 shadow-sm hover:shadow-md transition-all duration-300 group ring-1 ring-slate-900/5">
          <div class="w-11 h-11 rounded-xl {{ $faq['bg'] }} border {{ $faq['border'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <i data-lucide="{{ $faq['icon'] }}" class="w-5 h-5 {{ $faq['text'] }}"></i>
          </div>
          <h4 class="font-bold text-slate-800 mb-2 text-sm group-hover:text-purple-700 transition-colors tracking-tight">{{ $faq['label'] }}</h4>
          <p class="text-xs text-slate-500 leading-relaxed font-normal">{{ $faq['val'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>

</div>
@endsection
