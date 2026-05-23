@extends('layouts.app')
@section('title', 'Provide Business Details — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

<div class="mb-6">
    <a href="{{ route('customer.order.show', $order) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm hover:shadow">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Order
    </a>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm p-6 sm:p-10 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full -z-10 blur-3xl opacity-60"></div>
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <i data-lucide="briefcase" class="w-8 h-8 text-blue-600"></i> Business Details
            </h1>
            <p class="text-slate-500 font-medium mt-2 leading-relaxed">
                Please provide the following details so our team can start working on your project immediately.
                <br>Order: <span class="font-bold text-slate-700">ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} ({{ optional($order->service)->name ?? 'Service' }})</span>
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-8 shadow-sm">
                <ul class="list-disc list-inside text-sm font-bold space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.business-details.store', $order) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- General Info Section -->
            <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-100">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-5 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-slate-400"></i> General Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">Business Name <span class="text-red-500">*</span></label>
                        <input type="text" name="business_name" required value="{{ old('business_name') }}" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm" placeholder="Your business or brand name">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">Domain Name</label>
                        <input type="text" name="domain_name" value="{{ old('domain_name') }}" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm" placeholder="e.g. www.yourdomain.com">
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="bg-indigo-50/30 rounded-2xl p-6 border border-indigo-100/50">
                <h3 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-5 flex items-center gap-2">
                    <i data-lucide="image" class="w-4 h-4 text-indigo-400"></i> Media Assets
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">Business Logo (Image)</label>
                        <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">Max size: 2MB</p>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">Product Images (Up to 10)</label>
                        <input type="file" name="product_images[]" multiple accept="image/*" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">Select up to 10 images. Max size per image: 5MB</p>
                    </div>
                </div>
            </div>

            <!-- Contact & Address Section -->
            <div class="bg-emerald-50/30 rounded-2xl p-6 border border-emerald-100/50">
                <h3 class="text-sm font-black text-emerald-900 uppercase tracking-widest mb-5 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-emerald-400"></i> Support & Address
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">Customer Support Phone</label>
                        <input type="tel" name="support_phone" value="{{ old('support_phone') }}" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all shadow-sm" placeholder="Support contact number">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">Customer Support Email</label>
                        <input type="email" name="support_email" value="{{ old('support_email') }}" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all shadow-sm" placeholder="support@yourdomain.com">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-wider">Full Office Address</label>
                    <textarea name="office_address" rows="3" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all shadow-sm resize-none" placeholder="Area, City, State, and PIN code">{{ old('office_address') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-sm uppercase tracking-wider px-8 py-4 rounded-xl shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-1 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> Submit Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
