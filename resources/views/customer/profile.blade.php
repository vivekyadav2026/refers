@extends('layouts.app')
@section('title', 'My Profile — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

<div class="mb-10">
    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full mb-3">
        <i data-lucide="user" class="w-3.5 h-3.5"></i> Account Settings
    </div>
    <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Profile</h1>
    <p class="text-slate-500 font-medium mt-1">Manage your account details and preferences.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Left Sidebar Profile Summary --}}
    <div class="space-y-6">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full -z-10 blur-xl"></div>
            
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center text-4xl font-black mx-auto mb-4 shadow-lg shadow-blue-600/20">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            
            <h2 class="text-xl font-black text-slate-900">{{ auth()->user()->name }}</h2>
            <p class="text-sm font-medium text-slate-500 mb-6">{{ auth()->user()->email ?? auth()->user()->phone }}</p>
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-bold text-sm border border-blue-100">
                <i data-lucide="shield-check" class="w-4 h-4"></i> Customer Account
            </div>
        </div>

        <div class="bg-slate-50 rounded-3xl border border-slate-200 p-8">
            <h3 class="font-black text-slate-900 mb-4">Account Stats</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-600">Total Orders</span>
                    <span class="font-bold text-slate-900">{{ auth()->user()->orders()->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-600">Member Since</span>
                    <span class="font-bold text-slate-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Profile Form --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-black text-slate-900 mb-6">Personal Information</h2>
            
            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Full Name <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                        </div>
                        @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Phone Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="phone" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <input type="text" value="{{ auth()->user()->phone }}" disabled class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-500 bg-slate-100 text-sm font-medium cursor-not-allowed">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1.5 font-medium">Phone number cannot be changed as it is used for login.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Company Name <span class="text-slate-400 font-normal normal-case">(Optional)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="building" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <input type="text" name="company_name" value="{{ old('company_name', auth()->user()->company_name) }}" placeholder="e.g. Acme Corp" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Business Type <span class="text-slate-400 font-normal normal-case">(Optional)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="briefcase" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <select name="business_type" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium appearance-none">
                                <option value="" disabled {{ !auth()->user()->business_type ? 'selected' : '' }}>Select Business Type</option>
                                @foreach(['E-commerce', 'Agency / B2B', 'Retail / Shop', 'Education', 'Healthcare', 'Real Estate', 'Other'] as $type)
                                    <option value="{{ $type }}" {{ old('business_type', auth()->user()->business_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
                        <i data-lucide="save" class="w-4 h-4"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
