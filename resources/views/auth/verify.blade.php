@extends('layouts.app')
@section('title', 'Verify OTP — VivekTech')
@section('hide_nav_footer', true)

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950 py-16 px-4 sm:px-6 lg:px-8 relative overflow-y-auto">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-md w-full space-y-8 bg-white/5 backdrop-blur-2xl p-10 rounded-[2.5rem] border border-white/10 shadow-2xl relative z-10 text-center">
        <div>
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-600/30">
                <i data-lucide="shield-check" class="w-8 h-8"></i>
            </div>
            <h2 class="text-3xl font-black text-white tracking-tight mb-2">Verify Your Number</h2>
            <p class="text-sm text-slate-400 font-semibold">We've sent a 4-digit verification code to <br><span class="text-white font-mono font-bold">+91 {{ $phone }}</span></p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-xs font-bold rounded-2xl">
                <i data-lucide="check-circle" class="w-4 h-4 inline mr-1"></i> {{ session('success') }}
            </div>
        @endif

        <form class="space-y-6" action="{{ route('verify.check') }}" method="POST">
            @csrf
            <input type="hidden" name="phone" value="{{ $phone }}">
            
            <div>
                <label for="otp" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Enter 4-Digit Code</label>
                <input id="otp" name="otp" type="text" inputmode="numeric" maxlength="4" required class="w-full bg-black/40 border border-white/15 rounded-2xl py-4 px-6 text-center text-3xl font-mono text-white tracking-[1em] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-inner transition-all" placeholder="••••">
                @error('otp')
                    <p class="mt-3 text-xs font-bold text-red-400 flex items-center justify-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="border-t border-white/10 pt-6 space-y-4">
                <div class="text-left">
                    <h3 class="text-sm font-bold text-slate-300">Set Security PIN</h3>
                    <p class="text-xs text-slate-500">Create a 4-digit PIN to log in instantly next time without SMS OTP.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="pin" class="block text-left text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">New PIN</label>
                        <input id="pin" name="pin" type="password" inputmode="numeric" maxlength="4" required 
                               class="w-full bg-black/40 border border-white/15 rounded-xl py-3 px-4 text-center text-xl font-mono text-white tracking-[0.5em] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                               placeholder="••••">
                        @error('pin')
                            <p class="mt-2 text-left text-[11px] font-semibold text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="pin_confirmation" class="block text-left text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Confirm PIN</label>
                        <input id="pin_confirmation" name="pin_confirmation" type="password" inputmode="numeric" maxlength="4" required 
                               class="w-full bg-black/40 border border-white/15 rounded-xl py-3 px-4 text-center text-xl font-mono text-white tracking-[0.5em] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                               placeholder="••••">
                        @error('pin_confirmation')
                            <p class="mt-2 text-left text-[11px] font-semibold text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl text-sm font-black tracking-wider uppercase text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-xl shadow-blue-600/30 transition-all hover:-translate-y-0.5">
                Verify & Secure Login <i data-lucide="arrow-right" class="w-4 h-4 inline ml-1.5"></i>
            </button>
        </form>
        
        <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs font-bold text-slate-400">
            <span>Didn't receive code?</span>
            <form action="{{ route('login.send_otp') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">
                <input type="hidden" name="login_as" value="{{ $loginAs ?? 'customer' }}">
                <button type="submit" class="text-blue-400 hover:text-blue-300 underline font-extrabold transition-colors">Resend Code</button>
            </form>
        </div>

        <div class="text-center">
            <a href="{{ ($loginAs ?? 'customer') === 'partner' ? route('partner.login') : route('login') }}" class="text-xs text-slate-500 hover:text-slate-300 transition-colors font-semibold"><i data-lucide="arrow-left" class="w-3 h-3 inline mr-1"></i> Change Mobile Number</a>
        </div>
    </div>
</div>
@endsection
