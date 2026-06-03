@extends('layouts.app')
@section('title', 'Checkout — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Checkout</h1>
    <p class="text-slate-500 text-sm mt-1">Complete your information to proceed with payment.</p>
</div>

@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 text-red-700 text-sm">
    <ul class="list-disc pl-5 space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('cart.processCheckout') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Checkout Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <h2 class="text-lg font-bold text-slate-900 mb-6">Customer Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Full Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Full Name <span class="text-red-500">*</span></label>
                        @php
                            $defaultName = auth()->check() ? 'User ' . substr(auth()->user()->phone, -4) : '';
                            $displayName = auth()->check() && auth()->user()->name !== $defaultName ? auth()->user()->name : '';
                        @endphp
                        <input type="text" name="customer_name" value="{{ old('customer_name', $displayName) }}" required 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                    </div>

                    {{-- Mobile Number --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Mobile Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone) }}" required 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all"
                               placeholder="9999999999">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Email <span class="text-slate-400">(Optional)</span></label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all"
                               placeholder="you@example.com">
                    </div>

                    {{-- Company Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Company Name</label>
                        <input type="text" name="company_name" value="{{ old('company_name', auth()->user()->company_name) }}" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all"
                               placeholder="Your company name">
                    </div>

                    {{-- Business Type --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Business Type</label>
                        <input type="text" name="business_type" value="{{ old('business_type') }}" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all"
                               placeholder="e.g. E-commerce, Retail, Agency">
                    </div>

                    {{-- Project Requirements --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Project Requirements <span class="text-red-500">*</span></label>
                        <textarea name="requirements" rows="5" required 
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all resize-none"
                                  placeholder="Describe your project requirements in detail...">{{ old('requirements') }}</textarea>
                    </div>

                    {{-- File Upload --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Upload Reference File <span class="text-slate-400">(Optional)</span></label>
                        <div class="w-full border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-blue-400 transition-colors">
                            <input type="file" name="file_upload" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-slate-400 mt-2">Max file size: 10MB. Supported formats: PDF, DOC, DOCX, JPG, PNG, ZIP</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Order Summary</h2>
                <div class="space-y-3 pb-4 border-b border-slate-100">
                    @foreach($cartItems as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg overflow-hidden shrink-0 border border-slate-100">
                            @if($item->service->banner_image)
                                <img src="{{ asset('storage/' . $item->service->banner_image) }}" alt="{{ $item->service->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i data-lucide="{{ $item->service->icon ?? 'box' }}" class="w-4 h-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-slate-900">{{ $item->service->name }}</div>
                        </div>
                        <span class="text-sm font-bold text-slate-900">₹{{ number_format($item->service->min_price) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between pt-4 mb-4">
                    <span class="font-bold text-slate-900">Total</span>
                    <span class="text-2xl font-black text-slate-900">₹{{ number_format($total) }}</span>
                </div>

                {{-- Coupon Code --}}
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Have a Coupon?</label>
                    <div class="flex gap-2 mb-3">
                        <input type="text" id="coupon_input" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Enter code" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none uppercase font-mono tracking-wider">
                    </div>
                    
                    @if($activeCoupons->count() > 0)
                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Available Coupons</p>
                            @foreach($activeCoupons as $ac)
                                <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-2.5 flex items-center justify-between gap-2 text-xs">
                                    <div class="min-w-0">
                                        <button type="button" onclick="document.getElementById('coupon_input').value='{{ $ac->code }}'" class="font-bold text-indigo-750 hover:underline font-mono uppercase tracking-wider block text-left">
                                            {{ $ac->code }}
                                        </button>
                                        <p class="text-[10px] text-slate-500 font-semibold mt-0.5 truncate">
                                            @if($ac->discount_type == 'percent')
                                                {{ $ac->discount_value }}% Off
                                            @else
                                                ₹{{ number_format($ac->discount_value) }} Off
                                            @endif
                                            @if($ac->service)
                                                on {{ $ac->service->name }}
                                            @else
                                                on all services
                                            @endif
                                        </p>
                                    </div>
                                    <button type="button" onclick="document.getElementById('coupon_input').value='{{ $ac->code }}'" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-2.5 py-1 text-[10px] font-bold shadow-sm transition-colors shrink-0">
                                        Apply
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-sm hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-600/20 hover:-translate-y-0.5">
                    Place Order & Pay ₹{{ number_format($total) }}
                </button>

                <div class="mt-4 flex items-center gap-2 justify-center text-xs text-slate-400">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    Secure payment via Razorpay
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
