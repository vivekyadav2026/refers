@extends('layouts.app')

@section('title', 'Admin Dashboard — SKSolutions Platform')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-4 sm:py-6">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full mb-2">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Admin Control Center
            </div>
            <h1 class="text-3xl text-slate-900 font-black tracking-tight">Platform Overview</h1>
            <p class="text-slate-500 font-medium mt-1">Live revenue metrics, partner signups, and system activity.</p>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-3">
            <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-700 hover:text-blue-600 hover:border-blue-200 rounded-2xl px-5 py-3 flex items-center gap-2 text-xs font-black uppercase tracking-wider shadow-sm transition-all duration-300 hover:-translate-y-0.5">
                <i data-lucide="download" class="w-4 h-4"></i> Export Report
            </button>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 sm:gap-6 mb-8 sm:mb-10">
        <!-- Card 1: Total Revenue -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-emerald-300 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-100 text-emerald-600 flex items-center justify-center border border-emerald-200 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="coins" class="w-7 h-7"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-black text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full shadow-xs uppercase tracking-wider">
                    <i data-lucide="trending-up" class="w-3 h-3 text-emerald-600"></i> Live Value
                </div>
            </div>
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Total Platform Revenue</h3>
            <div class="text-3xl font-black text-slate-900 relative z-10">₹{{ number_format($totalRevenue) }}</div>
        </div>

        <!-- Card 2: Active Partners -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-indigo-300 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-100 text-indigo-600 flex items-center justify-center border border-indigo-200 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-black text-indigo-700 bg-indigo-50 border border-indigo-200 px-3 py-1 rounded-full shadow-xs uppercase tracking-wider">
                    Total: {{ $totalPartners }}
                </div>
            </div>
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Active V-Partners</h3>
            <div class="text-3xl font-black text-slate-900 relative z-10">{{ $activePartners }}</div>
        </div>

        <!-- Card 2.5: Total Customers -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-blue-300 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-100 text-blue-600 flex items-center justify-center border border-blue-200 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="user-check" class="w-7 h-7"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-black text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full shadow-xs uppercase tracking-wider">
                    Clients
                </div>
            </div>
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Total Customers</h3>
            <div class="text-3xl font-black text-slate-900 relative z-10">{{ $totalCustomers }}</div>
        </div>

        <!-- Card 3: Pending Leads -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-amber-300 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-amber-50 to-orange-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-100 text-amber-600 flex items-center justify-center border border-amber-200 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="target" class="w-7 h-7"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-black text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full shadow-xs uppercase tracking-wider">
                    Requires Action
                </div>
            </div>
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Pending Leads</h3>
            <div class="text-3xl font-black text-slate-900 relative z-10">{{ $pendingLeads }}</div>
        </div>

        <!-- Card 4: Total Paid Out -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-blue-300 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-100 text-blue-600 flex items-center justify-center border border-blue-200 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="arrow-up-right" class="w-7 h-7"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-black text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full shadow-xs uppercase tracking-wider">
                    Payouts
                </div>
            </div>
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Total Commissions Paid</h3>
            <div class="text-3xl font-black text-slate-900 relative z-10">₹{{ number_format($totalPaidOut) }}</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <h2 class="text-xl font-black text-slate-900 mb-6 tracking-tight">Revenue Growth (Last 6 Months)</h2>
            <div class="h-52 sm:h-72 w-full">
                <canvas id="adminRevenueChart"></canvas>
            </div>
        </div>

        <!-- Partner Signups Chart -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <h2 class="text-xl font-black text-slate-900 mb-6 tracking-tight">Partner Signups (Last 6 Months)</h2>
            <div class="h-52 sm:h-72 w-full">
                <canvas id="adminSignupsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- System Activity Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-10">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Recent Orders & Activity</h2>
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 uppercase tracking-wider transition-colors">View All Orders <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
        </div>
        <!-- Mobile view (cards) -->
        <div class="block sm:hidden divide-y divide-slate-100">
            @forelse($recentOrders as $order)
            <div class="p-4 hover:bg-slate-50 transition-colors">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-bold text-slate-900">{{ $order->user->name ?? 'Guest' }}</div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                            'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </div>
                <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                    <div class="font-bold text-slate-800">{{ Str::limit($order->service->name ?? 'Digital Service', 25) }}</div>
                    <div>{{ $order->created_at->diffForHumans() }}</div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-dashed border-slate-100 text-xs">
                    <div class="text-slate-400 font-semibold">{{ $order->user->email ?? '' }}</div>
                    <div class="font-black text-slate-900 text-sm">₹{{ number_format($order->amount) }}</div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-500">
                <i data-lucide="inbox" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                <p class="text-sm font-medium">No recent orders found.</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop view (table) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="text-[11px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/80 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-4 sm:px-6 py-4 whitespace-nowrap">Time</th>
                        <th scope="col" class="px-4 sm:px-6 py-4 whitespace-nowrap">Customer</th>
                        <th scope="col" class="px-4 sm:px-6 py-4 whitespace-nowrap">Service</th>
                        <th scope="col" class="px-4 sm:px-6 py-4 text-right whitespace-nowrap">Amount</th>
                        <th scope="col" class="px-4 sm:px-6 py-4 text-center whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white font-medium">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-4 sm:px-6 py-4 text-slate-500 text-xs whitespace-nowrap">{{ $order->created_at->diffForHumans() }}</td>
                        <td class="px-4 sm:px-6 py-4">
                            <div class="font-bold text-slate-900 whitespace-nowrap">{{ $order->user->name ?? 'Guest' }}</div>
                            <div class="text-xs text-slate-400 font-semibold">{{ $order->user->email ?? '' }}</div>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-slate-800 font-bold whitespace-nowrap">{{ Str::limit($order->service->name ?? 'Digital Service', 25) }}</td>
                        <td class="px-4 sm:px-6 py-4 text-right font-black text-slate-900">₹{{ number_format($order->amount) }}</td>
                        <td class="px-4 sm:px-6 py-4 text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                    'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-slate-400 font-semibold">
                            <i data-lucide="inbox" class="w-12 h-12 mx-auto text-slate-300 mb-3"></i>
                            No recent orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.font.family = "'Poppins', sans-serif";
        
        // Admin Revenue Chart
        const revenueCtx = document.getElementById('adminRevenueChart').getContext('2d');
        let revGradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
        revGradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)'); // Emerald-500
        revGradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! $chartMonths ?? "['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']" !!},
                datasets: [{
                    label: 'Platform Revenue (₹)',
                    data: {!! $chartRevenue ?? '[15000, 22000, 18000, 31000, 26000, 42000]' !!},
                    borderColor: '#10b981', // Emerald-500
                    backgroundColor: revGradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
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
                        padding: 12,
                        titleFont: { size: 13 },
                        bodyFont: { size: 14, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) { return '₹' + context.parsed.y.toLocaleString(); }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#64748b', callback: function(value) { return '₹' + (value/1000) + 'k'; } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#64748b' }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });

        // Signups Chart
        const signupsCtx = document.getElementById('adminSignupsChart').getContext('2d');
        new Chart(signupsCtx, {
            type: 'bar',
            data: {
                labels: {!! $chartMonths ?? "['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']" !!},
                datasets: [
                    {
                        label: 'New Partners',
                        data: {!! $chartPartners ?? '[12, 19, 15, 25, 22, 30]' !!},
                        backgroundColor: '#6366f1', // Indigo-500
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13 },
                        bodyFont: { size: 14, weight: 'bold' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#64748b' }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#64748b' }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });
    });
</script>
@endsection
