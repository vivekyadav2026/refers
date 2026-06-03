@extends('layouts.app')
@section('title', 'My Orders — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')
<div class="py-4 sm:py-6">

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-black px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
            <i data-lucide="package" class="w-3.5 h-3.5"></i> Order History
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">My Orders</h1>
        <p class="text-slate-500 font-medium mt-1 text-sm">Track all your service purchases and their progress.</p>
    </div>
    <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-xs uppercase tracking-wider hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5 w-full sm:w-auto">
        <i data-lucide="plus" class="w-4 h-4"></i> New Order
    </a>
</div>

{{-- Filters --}}
<div class="flex gap-2 mb-8 overflow-x-auto pb-3 -mx-4 px-4 sm:mx-0 sm:px-0 sm:pb-0 sm:flex-wrap whitespace-nowrap scrollbar-none">
    @foreach(['all' => 'All Orders', 'pending' => 'Pending', 'paid' => 'Paid', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $key => $label)
    <a href="{{ route('customer.orders', ['status' => $key]) }}"
       class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all shrink-0 {{ request('status', 'all') === $key ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 hover:border-slate-300' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Orders List --}}
<div class="space-y-4">
    @forelse($orders as $order)
    @php
        $statusMap = [
            'pending'     => ['pill' => 'bg-amber-100 text-amber-700 border-amber-200',    'dot' => 'bg-amber-500',   'icon' => 'clock'],
            'paid'        => ['pill' => 'bg-blue-100 text-blue-700 border-blue-200',        'dot' => 'bg-blue-500',    'icon' => 'check-circle-2'],
            'in_progress' => ['pill' => 'bg-indigo-100 text-indigo-700 border-indigo-200',  'dot' => 'bg-indigo-500',  'icon' => 'loader-2'],
            'completed'   => ['pill' => 'bg-emerald-100 text-emerald-700 border-emerald-200','dot' => 'bg-emerald-500', 'icon' => 'check-circle'],
            'cancelled'   => ['pill' => 'bg-red-100 text-red-700 border-red-200',           'dot' => 'bg-red-500',     'icon' => 'x-circle'],
        ];
        $sm = $statusMap[$order->status] ?? ['pill' => 'bg-slate-100 text-slate-700 border-slate-200', 'dot' => 'bg-slate-400', 'icon' => 'circle'];
    @endphp

    {{-- Mobile Card --}}
    <div class="block sm:hidden bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg hover:border-blue-200 transition-all duration-300 group">
        <div class="p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-500 flex items-center justify-center border border-slate-200 group-hover:from-blue-50 group-hover:to-indigo-50 group-hover:text-blue-600 group-hover:border-blue-200 transition-all shrink-0">
                        <i data-lucide="{{ optional($order->service)->icon ?? 'box' }}" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="font-black text-slate-900 text-sm leading-snug">{{ optional($order->service)->name ?? $order->lead->service_needed ?? 'Custom Service' }}</div>
                        <div class="text-[10px] text-slate-400 font-medium mt-0.5">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $sm['pill'] }} shrink-0 ml-2">
                    <span class="w-1.5 h-1.5 rounded-full {{ $sm['dot'] }}"></span>
                    {{ str_replace('_', ' ', $order->status) }}
                </span>
            </div>

            @if($order->requirements)
            <p class="text-xs text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100 mb-3 line-clamp-2">{{ Str::limit($order->requirements, 100) }}</p>
            @endif

            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                <div>
                    <div class="text-[10px] text-slate-400 font-medium">{{ $order->created_at->format('M d, Y') }}</div>
                    <div class="text-lg font-black text-slate-900">₹{{ number_format($order->amount) }}</div>
                </div>
                <div class="flex gap-2">
                    @if(in_array($order->status, ['paid', 'processing', 'in_progress', 'completed']))
                    <a href="{{ route('customer.orders.invoice', $order) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-black text-indigo-700 bg-indigo-50 border border-indigo-200 hover:border-indigo-300 hover:bg-indigo-100 transition-all active:scale-95">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i> Invoice
                    </a>
                    @endif
                    @if($order->status === 'pending')
                    <a href="{{ route('payment.create', $order) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-black text-white bg-gradient-to-r from-emerald-500 to-teal-600 shadow-sm transition-all active:scale-95">
                        <i data-lucide="credit-card" class="w-3.5 h-3.5"></i> Pay
                    </a>
                    @endif
                    <a href="{{ route('customer.order.show', $order) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-black text-slate-700 bg-white border border-slate-200 hover:border-blue-300 hover:text-blue-600 transition-all active:scale-95">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> View
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Desktop Card --}}
    <div class="hidden sm:block bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300 group">
        <div class="p-6">
            <div class="flex items-start justify-between gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-500 flex items-center justify-center border border-slate-200 group-hover:from-blue-50 group-hover:to-indigo-50 group-hover:text-blue-600 group-hover:border-blue-200 transition-all duration-300 shrink-0">
                        <i data-lucide="{{ optional($order->service)->icon ?? 'box' }}" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-wider">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-slate-200">•</span>
                            <span class="text-xs font-medium text-slate-400">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <h3 class="font-black text-lg text-slate-900 group-hover:text-blue-600 transition-colors mb-2">{{ optional($order->service)->name ?? $order->lead->service_needed ?? 'Custom Service' }}</h3>
                        @if($order->requirements)
                        <p class="text-sm font-medium text-slate-500 line-clamp-2 max-w-2xl bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">{{ Str::limit($order->requirements, 120) }}</p>
                        @endif
                    </div>
                </div>

                <div class="text-right shrink-0">
                    <div class="text-2xl font-black text-slate-900 mb-2">₹{{ number_format($order->amount) }}</div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $sm['pill'] }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $sm['dot'] }}"></span>
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-5 pt-5 border-t border-slate-100">
                @if(in_array($order->status, ['paid', 'processing', 'in_progress', 'completed']))
                <a href="{{ route('customer.orders.invoice', $order) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-black text-indigo-700 bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 hover:border-indigo-300 transition-all uppercase tracking-wider text-xs">
                    <i data-lucide="download" class="w-4 h-4"></i> Invoice
                </a>
                @endif
                <a href="{{ route('customer.order.show', $order) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-black text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition-all uppercase tracking-wider text-xs">
                    <i data-lucide="eye" class="w-4 h-4"></i> View Details
                </a>
                @if($order->status === 'pending')
                <a href="{{ route('payment.create', $order) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black text-white uppercase tracking-wider bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-md shadow-emerald-500/20 transition-all hover:-translate-y-0.5">
                    <i data-lucide="credit-card" class="w-4 h-4"></i> Pay Now
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-16 text-center">
        <div class="w-20 h-20 rounded-full bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center mx-auto mb-5">
            <i data-lucide="package-open" class="w-10 h-10 text-slate-300"></i>
        </div>
        <h3 class="text-xl font-black text-slate-900 mb-2">No orders found</h3>
        <p class="text-slate-500 text-sm font-medium mb-6">You haven't placed any orders matching this filter.</p>
        <!-- <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-xs uppercase tracking-wider hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
            <i data-lucide="grid-3x3" class="w-4 h-4"></i> Browse Services
        </a> -->
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($orders->hasPages())
<div class="mt-8">
    {{ $orders->links() }}
</div>
@endif

</div>
@endsection
