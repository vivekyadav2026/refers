@extends('layouts.app')
@section('title', 'My Orders — VivekTech')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

<div class="mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full mb-3">
            <i data-lucide="package" class="w-3.5 h-3.5"></i> Order History
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Orders</h1>
        <p class="text-slate-500 font-medium mt-1">Track all your service purchases and their progress.</p>
    </div>
    <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
        <i data-lucide="plus" class="w-4 h-4"></i> New Order
    </a>
</div>

{{-- Filters --}}
<div class="flex gap-2 mb-8 flex-wrap">
    @foreach(['all' => 'All Orders', 'pending' => 'Pending', 'paid' => 'Paid', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $key => $label)
    <a href="{{ route('customer.orders', ['status' => $key]) }}" 
       class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('status', 'all') === $key ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 hover:border-slate-300' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Orders List --}}
<div class="space-y-5">
    @forelse($orders as $order)
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300 group">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-600 flex items-center justify-center shrink-0 border border-slate-200 group-hover:from-blue-50 group-hover:to-indigo-50 group-hover:text-blue-600 group-hover:border-blue-200 transition-all duration-300">
                        <i data-lucide="{{ optional($order->service)->icon ?? 'box' }}" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-2 mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-slate-300">•</span>
                            <span class="text-xs font-semibold text-slate-500">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <h3 class="font-black text-xl text-slate-900 group-hover:text-blue-600 transition-colors mb-2">{{ optional($order->service)->name ?? $order->lead->service_needed ?? 'Custom Service' }}</h3>
                        
                        @if($order->requirements)
                        <p class="text-sm font-medium text-slate-500 line-clamp-2 max-w-2xl bg-slate-50 p-3 rounded-xl border border-slate-100">{{ Str::limit($order->requirements, 120) }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="sm:text-right flex sm:flex-col items-center sm:items-end justify-between sm:justify-start shrink-0 pt-2 sm:pt-0 border-t border-slate-100 sm:border-0 mt-2 sm:mt-0">
                    <div class="text-2xl font-black text-slate-900 mb-1">₹{{ number_format($order->amount) }}</div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'paid' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'in_progress' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                            'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </div>
            </div>
            
            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-100">
                <a href="{{ route('customer.order.show', $order) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all">
                    <i data-lucide="eye" class="w-4 h-4 text-slate-400"></i> View Details
                </a>
                @if($order->status === 'pending')
                <a href="{{ route('payment.create', $order) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-md shadow-emerald-500/20 transition-all">
                    <i data-lucide="credit-card" class="w-4 h-4"></i> Pay Now
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-20 text-center">
        <div class="w-24 h-24 rounded-full bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center mx-auto mb-6">
            <i data-lucide="package-open" class="w-12 h-12 text-slate-300"></i>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-2">No orders found</h3>
        <p class="text-slate-500 text-base font-medium mb-8">You haven't placed any orders matching this filter.</p>
        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
            <i data-lucide="grid-3x3" class="w-5 h-5"></i> Browse Services
        </a>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($orders->hasPages())
<div class="mt-8">
    {{ $orders->links() }}
</div>
@endif

@endsection
