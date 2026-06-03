@extends('layouts.app')
@section('title', 'Edit Coupon — Admin')
@section('sidebar')
    <!-- enable sidebar -->
@endsection

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 mb-2">
        <a href="{{ route('admin.coupons.index') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Coupon</h1>
    </div>
    <p class="text-slate-500 text-sm pl-7">Update details for discount code <span class="font-bold text-slate-700">{{ $coupon->code }}</span>.</p>
</div>

<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Coupon Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50 uppercase tracking-widest font-mono">
                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Discount Type <span class="text-red-500">*</span></label>
                <select name="discount_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                    <option value="percent" {{ old('discount_type', $coupon->discount_type) == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Discount Value <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', $coupon->discount_value) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                @error('discount_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Applicable Service <span class="text-slate-400">(Optional - leave empty for all services)</span></label>
                <select name="service_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id', $coupon->service_id) == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Min Order Amount <span class="text-slate-400">(Optional)</span></label>
                <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Max Uses <span class="text-slate-400">(Optional)</span></label>
                <input type="number" name="max_uses" value="{{ old('max_uses', $coupon->max_uses) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Expiration Date <span class="text-slate-400">(Optional)</span></label>
                <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50">
            </div>

            <div class="md:col-span-2 mt-2">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" {{ $coupon->is_active ? 'checked' : '' }}>
                    <span class="text-sm font-semibold text-slate-700">Coupon is Active</span>
                </label>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-3 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">Update Coupon</button>
        </div>
    </form>
</div>
@endsection
