@extends('layouts.app')
@section('title', 'Customer Dashboard — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')
<div class="py-4 sm:py-6">

{{-- Page Header --}}
<div class="sm:flex sm:justify-between sm:items-start mb-8 gap-4">
    <div class="mb-4 sm:mb-0">
        <!-- <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-black px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Customer Portal
        </div> -->
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ auth()->user()->name }}</span>!</h1>
        <p class="text-slate-500 font-medium mt-1 text-sm">Manage your orders, track progress, and explore new services.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-black uppercase tracking-wider hover:border-blue-300 hover:text-blue-600 shadow-sm transition-all hover:-translate-y-0.5">
            <i data-lucide="package" class="w-4 h-4"></i> My Orders
        </a>
        <!-- <a href="{{ route('customer.services') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-black uppercase tracking-wider hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
            <i data-lucide="grid-3x3" class="w-4 h-4"></i> Browse Services
        </a> -->
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-5 mb-8">
    @foreach([
        ['label' => 'Total Orders',  'value' => $totalOrders,                     'icon' => 'shopping-bag',  'color' => 'blue',    'badge' => 'All Time',     'from' => 'from-blue-50',   'to' => 'to-indigo-100',  'border' => 'border-blue-200',   'text' => 'text-blue-600',   'hborder' => 'hover:border-blue-300'],
        ['label' => 'Pending',       'value' => $pendingOrders,                   'icon' => 'clock',         'color' => 'amber',   'badge' => 'Awaiting',     'from' => 'from-amber-50',  'to' => 'to-orange-100',  'border' => 'border-amber-200',  'text' => 'text-amber-600',  'hborder' => 'hover:border-amber-300'],
        ['label' => 'In Progress',   'value' => $inProgressOrders,                'icon' => 'loader',        'color' => 'indigo',  'badge' => 'Active',       'from' => 'from-indigo-50', 'to' => 'to-violet-100',  'border' => 'border-indigo-200', 'text' => 'text-indigo-600', 'hborder' => 'hover:border-indigo-300'],
        ['label' => 'Completed',     'value' => $completedOrders,                 'icon' => 'check-circle',  'color' => 'emerald', 'badge' => 'Delivered',    'from' => 'from-emerald-50','to' => 'to-teal-100',    'border' => 'border-emerald-200','text' => 'text-emerald-600','hborder' => 'hover:border-emerald-300'],
    ] as $stat)
    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200 shadow-sm {{ $stat['hborder'] }} transition-all duration-300 group hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute -top-5 -right-5 w-20 h-20 bg-gradient-to-br {{ $stat['from'] }} {{ $stat['to'] }} rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-center justify-between mb-3 sm:mb-4 relative z-10">
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br {{ $stat['from'] }} {{ $stat['to'] }} {{ $stat['text'] }} flex items-center justify-center {{ $stat['border'] }} border group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 sm:w-6 sm:h-6 {{ $stat['label'] === 'In Progress' && $inProgressOrders > 0 ? 'animate-spin' : '' }}"></i>
            </div>
            <div class="text-[10px] font-black {{ $stat['text'] }} bg-gradient-to-r {{ $stat['from'] }} {{ $stat['to'] }} {{ $stat['border'] }} border px-2 py-0.5 rounded-full uppercase tracking-wider hidden sm:block">
                {{ $stat['badge'] }}
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-0.5 relative z-10 leading-none">{{ $stat['value'] }}</div>
        <div class="text-[10px] sm:text-xs text-slate-500 font-bold uppercase tracking-wider relative z-10">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>


{{-- Recent Orders --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="p-4 sm:px-6 sm:py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                <i data-lucide="package" class="w-4.5 h-4.5"></i>
            </div>
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight">Recent Orders</h2>
                <p class="text-[10px] text-slate-500 font-medium hidden sm:block">Your latest purchases</p>
            </div>
        </div>
        <a href="{{ route('customer.orders') }}" class="text-xs font-black text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors bg-blue-50 hover:bg-blue-100 border border-blue-100 px-3 py-1.5 rounded-xl">
            View All <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </a>
    </div>

    @if($recentOrders->count())
    {{-- Mobile Card View --}}
    <div class="block sm:hidden divide-y divide-slate-100">
        @foreach($recentOrders as $order)
        @php
            $statusColors = [
                'pending'     => ['pill' => 'bg-amber-100 text-amber-700 border-amber-200',   'dot' => 'bg-amber-500'],
                'paid'        => ['pill' => 'bg-blue-100 text-blue-700 border-blue-200',       'dot' => 'bg-blue-500'],
                'in_progress' => ['pill' => 'bg-indigo-100 text-indigo-700 border-indigo-200', 'dot' => 'bg-indigo-500'],
                'completed'   => ['pill' => 'bg-emerald-100 text-emerald-700 border-emerald-200','dot' => 'bg-emerald-500'],
                'cancelled'   => ['pill' => 'bg-red-100 text-red-700 border-red-200',          'dot' => 'bg-red-500'],
            ];
            $sc = $statusColors[$order->status] ?? ['pill' => 'bg-slate-100 text-slate-700 border-slate-200', 'dot' => 'bg-slate-400'];
        @endphp
        <a href="{{ route('customer.order.show', $order) }}" class="block p-4 hover:bg-slate-50 transition-colors">
            <div class="flex items-center justify-between mb-2">
                <div class="font-bold text-slate-900 text-sm">{{ optional($order->service)->name ?? $order->lead->service_needed ?? 'Custom Service' }}</div>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $sc['pill'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                    {{ str_replace('_', ' ', $order->status) }}
                </span>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500">
                <span class="font-medium">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} · {{ $order->created_at->diffForHumans() }}</span>
                <span class="font-black text-slate-900">₹{{ number_format($order->amount) }}</span>
            </div>
            @if($order->status !== 'pending' && $order->status !== 'cancelled' && !$order->postPaymentDetail)
            <div class="mt-3">
                <a href="{{ route('customer.business-details.create', $order) }}" class="block text-center w-full py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-[11px] font-black uppercase tracking-wider rounded-lg border border-indigo-200 transition-colors">
                    Submit Project Details <i data-lucide="arrow-right" class="w-3 h-3 inline"></i>
                </a>
            </div>
            @endif
        </a>
        @endforeach
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden sm:block divide-y divide-slate-100">
        @foreach($recentOrders as $order)
        @php
            $statusColors = [
                'pending'     => 'bg-amber-100 text-amber-700 border-amber-200',
                'paid'        => 'bg-blue-100 text-blue-700 border-blue-200',
                'in_progress' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                'completed'   => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                'cancelled'   => 'bg-red-100 text-red-700 border-red-200',
            ];
        @endphp
        <a href="{{ route('customer.order.show', $order) }}" class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors group">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-500 flex items-center justify-center border border-slate-200 group-hover:from-blue-50 group-hover:to-indigo-50 group-hover:text-blue-600 group-hover:border-blue-200 transition-all shrink-0">
                    <i data-lucide="package" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors text-sm">{{ optional($order->service)->name ?? $order->lead->service_needed ?? 'Custom Service' }}</div>
                    <div class="text-xs text-slate-400 font-medium mt-0.5">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} · {{ $order->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                    <div class="font-black text-slate-900 text-sm min-w-[5rem] text-right">₹{{ number_format($order->amount) }}</div>
                </div>
                @if($order->status !== 'pending' && $order->status !== 'cancelled' && !$order->postPaymentDetail)
                <a href="{{ route('customer.business-details.create', $order) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-wider rounded-lg border border-indigo-200 transition-colors z-10">
                    <i data-lucide="file-text" class="w-3 h-3"></i> Submit Details
                </a>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="px-6 py-16 text-center">
        <div class="w-16 h-16 rounded-full bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="shopping-bag" class="w-8 h-8 text-slate-300"></i>
        </div>
        <h3 class="text-lg font-black text-slate-900 mb-2">No orders yet</h3>
        <p class="text-slate-500 text-sm mb-6 max-w-xs mx-auto font-medium">Browse our premium digital services and place your first order today!</p>
        <!-- <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5">
            <i data-lucide="grid-3x3" class="w-4 h-4"></i> Browse Services
        </a> -->
    </div>
    @endif
</div>

{{-- Order Status Chart (Moved Below Recent Orders) --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 sm:p-6 mb-8">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-black text-slate-900 tracking-tight">Order Activity</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Your orders over the last 6 months</p>
        </div>
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
            <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
        </div>
    </div>
    <div class="h-44 sm:h-56 w-full">
        <canvas id="orderActivityChart"></canvas>
    </div>
</div>



</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = "'Poppins', sans-serif";

    const ctx = document.getElementById('orderActivityChart');
    if (!ctx) return;

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(79,70,229,0.3)');
    gradient.addColorStop(1, 'rgba(79,70,229,0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['6mo ago', '5mo ago', '4mo ago', '3mo ago', '2mo ago', 'Last mo', 'This mo'],
            datasets: [{
                label: 'Orders',
                data: [1, 2, 1, 3, 2, 4, {{ $totalOrders }}],
                borderColor: '#4f46e5',
                backgroundColor: gradient,
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 10,
                    titleFont: { size: 12 },
                    bodyFont: { size: 13, weight: 'bold' },
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9', borderDash: [4,4] },
                    border: { display: false },
                    ticks: { color: '#94a3b8', stepSize: 1, font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 10 } }
                }
            },
            interaction: { intersect: false, mode: 'index' }
        }
    });
});
</script>
@endsection
