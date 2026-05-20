@extends('layouts.app')
@section('title', 'Customer Dashboard — VivekTech')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

{{-- Page Header --}}
<div class="mb-10">
    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full mb-4">
        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Customer Portal
    </div>
    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ auth()->user()->name }}</span>!</h1>
    <p class="text-slate-500 font-medium mt-2">Manage your orders, track progress, and explore new services.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    @foreach([
        ['label' => 'Total Orders', 'value' => $totalOrders, 'icon' => 'shopping-bag', 'color' => 'blue', 'gradient' => 'from-blue-50 to-indigo-50'],
        ['label' => 'Pending', 'value' => $pendingOrders, 'icon' => 'clock', 'color' => 'amber', 'gradient' => 'from-amber-50 to-orange-50'],
        ['label' => 'Completed', 'value' => $completedOrders, 'icon' => 'check-circle', 'color' => 'emerald', 'gradient' => 'from-emerald-50 to-teal-50'],
        ['label' => 'Total Spent', 'value' => '₹' . number_format($totalSpent), 'icon' => 'wallet', 'color' => 'purple', 'gradient' => 'from-purple-50 to-fuchsia-50'],
    ] as $stat)
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-{{ $stat['color'] }}-300 transition-all duration-300 group hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br {{ $stat['gradient'] }} rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-center justify-between mb-6 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $stat['gradient'] }} text-{{ $stat['color'] }}-600 flex items-center justify-center border border-{{ $stat['color'] }}-100 group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="{{ $stat['icon'] }}" class="w-7 h-7"></i>
            </div>
        </div>
        <div class="text-3xl font-black text-slate-900 mb-1 relative z-10">{{ $stat['value'] }}</div>
        <div class="text-xs text-slate-500 font-bold uppercase tracking-wider relative z-10">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <a href="{{ route('services.index') }}" class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-bl-full -z-10 transition-transform duration-500 group-hover:scale-125 blur-xl"></div>
        <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mb-6 border border-white/20 backdrop-blur-sm group-hover:bg-white/30 transition-colors">
            <i data-lucide="grid-3x3" class="w-7 h-7"></i>
        </div>
        <h3 class="font-black text-xl mb-2 tracking-tight">Browse Services</h3>
        <p class="text-blue-100 text-sm font-medium">Explore our premium digital services</p>
    </a>
    
    <a href="{{ route('cart.index') }}" class="bg-white border border-slate-200 rounded-3xl p-8 text-slate-900 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10 transition-transform duration-500 group-hover:scale-125 blur-xl"></div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 border border-emerald-100 group-hover:bg-emerald-100 transition-colors">
            <i data-lucide="shopping-cart" class="w-7 h-7"></i>
        </div>
        <h3 class="font-black text-xl mb-2 tracking-tight">View Cart</h3>
        <p class="text-slate-500 text-sm font-medium">{{ auth()->user()->cartItems->count() }} items in your cart</p>
    </a>
    
    <a href="{{ route('customer.orders') }}" class="bg-white border border-slate-200 rounded-3xl p-8 text-slate-900 shadow-sm hover:shadow-xl hover:border-purple-300 transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full -z-10 transition-transform duration-500 group-hover:scale-125 blur-xl"></div>
        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6 border border-purple-100 group-hover:bg-purple-100 transition-colors">
            <i data-lucide="package" class="w-7 h-7"></i>
        </div>
        <h3 class="font-black text-xl mb-2 tracking-tight">My Orders</h3>
        <p class="text-slate-500 text-sm font-medium">Track your order progress</p>
    </a>
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-10">
    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Recent Orders</h2>
        <a href="{{ route('customer.orders') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">View All <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
    </div>
    
    @if($recentOrders->count())
    <div class="divide-y divide-slate-100">
        @foreach($recentOrders as $order)
        <a href="{{ route('customer.order.show', $order) }}" class="block px-8 py-6 hover:bg-slate-50 transition-colors group">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-600 flex items-center justify-center shrink-0 border border-slate-200 group-hover:from-blue-50 group-hover:to-indigo-50 group-hover:text-blue-600 group-hover:border-blue-200 transition-all">
                        <i data-lucide="package" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="font-bold text-lg text-slate-900 group-hover:text-blue-600 transition-colors">{{ optional($order->service)->name ?? $order->lead->service_needed ?? 'Custom Service' }}</div>
                        <div class="text-xs font-medium text-slate-500 mt-1">Order #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} <span class="mx-2">•</span> {{ $order->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div class="sm:text-right flex sm:flex-col items-center sm:items-end justify-between sm:justify-center w-full sm:w-auto mt-2 sm:mt-0">
                    <div class="font-black text-lg text-slate-900">₹{{ number_format($order->amount) }}</div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'paid' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'in_progress' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                            'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider mt-1 border {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="px-8 py-20 text-center">
        <div class="w-20 h-20 rounded-full bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center mx-auto mb-6">
            <i data-lucide="shopping-bag" class="w-10 h-10 text-slate-300"></i>
        </div>
        <h3 class="text-xl font-black text-slate-900 mb-2">No orders yet</h3>
        <p class="text-slate-500 text-base mb-8 max-w-sm mx-auto font-medium">Browse our premium digital services and place your first order today!</p>
        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
            <i data-lucide="grid-3x3" class="w-5 h-5"></i> Browse Services
        </a>
    </div>
    @endif
</div>

@endsection
