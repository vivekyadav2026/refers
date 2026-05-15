@extends('layouts.app')

@section('title', 'Register - Partner Network')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-slate-50 px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-4xl opacity-40 pointer-events-none">
        <div class="absolute top-1/4 right-0 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-1/3 left-0 w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create your account</h2>
            <p class="mt-2 text-sm text-slate-500">
                Join the partner network and start earning today.
            </p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl py-8 px-10 shadow-2xl rounded-3xl border border-white/50">
            <form class="space-y-5" action="{{ route('register') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm border border-red-100">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="user" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="name" name="name" type="text" autocomplete="name" required class="appearance-none block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all sm:text-sm" placeholder="John Doe" value="{{ old('name') }}">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all sm:text-sm" placeholder="you@example.com" value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required class="appearance-none block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all sm:text-sm" placeholder="••••••••">
                    </div>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all sm:text-sm" placeholder="••••••••">
                    </div>
                </div>

                <!-- Optional Referral Code -->
                <div>
                    <label for="ref_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Referral Code (Optional)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="tag" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="ref_id" name="ref_id" type="text" class="appearance-none block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all sm:text-sm" placeholder="Partner ID (if referred)" value="{{ request('ref') }}">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-blue-600/30 hover:shadow-blue-600/40 hover:-translate-y-0.5">
                        Create Account
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-center text-sm text-slate-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-500 transition-colors">Log in instead</a>
            </div>
        </div>
    </div>
</div>
@endsection
