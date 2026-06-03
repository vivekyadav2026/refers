@extends('layouts.app')
@section('title', 'Manage Coupons — Admin')
@section('sidebar')
    <!-- enable sidebar -->
@endsection

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Coupons & Offers</h1>
        <p class="text-slate-500 text-sm mt-1">Create and manage discount codes for checkout.</p>
    </div>
    <div>
        <a href="{{ route('admin.coupons.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2.5 flex items-center gap-2 text-sm font-medium shadow-sm transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Create Coupon
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Code</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Discount</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Applicable Service</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Usage</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Expires</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900 font-mono tracking-wider">{{ $coupon->code }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-700">
                        @if($coupon->discount_type == 'percent')
                            {{ $coupon->discount_value }}%
                        @else
                            ₹{{ number_format($coupon->discount_value, 2) }}
                        @endif
                        @if($coupon->min_order_amount)
                            <div class="text-xs text-slate-400 font-normal mt-0.5">Min: ₹{{ number_format($coupon->min_order_amount, 2) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-600 text-xs">
                        @if($coupon->service)
                            <span class="inline-flex items-center bg-indigo-50 border border-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full font-bold">
                                {{ $coupon->service->name }}
                            </span>
                        @else
                            <span class="inline-flex items-center bg-slate-100 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-full font-bold">
                                All Services
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $coupon->current_uses }} / {{ $coupon->max_uses ?: '∞' }}
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $coupon->expires_at ? $coupon->expires_at->format('d M, Y') : 'Never' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($coupon->is_active)
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-800">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                        <i data-lucide="tag" class="w-8 h-8 mx-auto text-slate-300 mb-3"></i>
                        <p>No coupons found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-200">
        {{ $coupons->links() }}
    </div>
</div>
@endsection
