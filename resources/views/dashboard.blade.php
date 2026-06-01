@extends('layouts.app')

@section('title', 'Dashboard - SKSolutions Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-4 sm:py-6">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-500 mt-1">Track your performance, leads, and earnings here.</p>
        </div>
        <div class="flex flex-wrap gap-2 justify-start sm:justify-end">
            <a href="{{ route('partner.agreement.download') }}" class="w-full sm:w-auto bg-white border border-slate-200 hover:border-indigo-300 text-slate-700 hover:text-indigo-600 rounded-xl px-4 py-2.5 flex items-center justify-center gap-2 text-sm font-medium shadow-sm transition-colors">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                Download Agreement
            </a>
            <a href="{{ route('partner.leads.create') }}" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2.5 flex items-center justify-center gap-2 text-sm font-medium shadow-sm transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Submit Lead
            </a>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-indigo-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Earnings</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">₹{{ number_format($totalEarnings, 2) }}</div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-purple-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-50 to-pink-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Leads</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">{{ $totalLeads }}</div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-emerald-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Conversions</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">{{ $conversions }}</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Earnings Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4 sm:mb-6">Earnings Overview</h2>
            <div class="h-52 sm:h-72 w-full">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>

        <!-- Leads vs Conversions Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4 sm:mb-6">Leads vs Conversions</h2>
            <div class="h-52 sm:h-72 w-full">
                <canvas id="leadsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
        <div class="p-4 sm:p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-base sm:text-lg font-bold text-slate-900">Recent Leads</h2>
            <a href="{{ route('partner.leads.index') }}" class="text-xs sm:text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors bg-white border border-slate-200 px-3 py-1.5 rounded-lg shadow-sm">View All</a>
        </div>

        <!-- Mobile view (cards) -->
        <div class="block sm:hidden divide-y divide-slate-100">
            @forelse($recentLeads as $lead)
            <div class="p-4 hover:bg-slate-50 transition-colors cursor-pointer" onclick="window.location='{{ route('partner.leads.index') }}'">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-bold text-slate-900">{{ $lead->client_name }}</div>
                    @php
                        $badgeClass = match($lead->status) {
                            'new' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'contacted' => 'bg-purple-100 text-purple-800 border-purple-200',
                            'in_progress' => 'bg-amber-100 text-amber-800 border-amber-200',
                            'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                            default => 'bg-slate-100 text-slate-800 border-slate-200'
                        };
                        $dotClass = match($lead->status) {
                            'new' => 'bg-blue-600',
                            'contacted' => 'bg-purple-600',
                            'in_progress' => 'bg-amber-600',
                            'approved' => 'bg-emerald-600',
                            'rejected' => 'bg-red-600',
                            default => 'bg-slate-600'
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1 py-0.5 px-2 rounded-full text-[10px] font-semibold border {{ $badgeClass }}">
                        <span class="w-1 h-1 rounded-full {{ $dotClass }}"></span>
                        {{ str_replace('_', ' ', ucfirst($lead->status)) }}
                    </span>
                </div>
                <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                    <div class="font-semibold text-slate-700">{{ $lead->service->name ?? 'N/A' }}</div>
                    <div>{{ $lead->created_at->diffForHumans() }}</div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-dashed border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-400">Value:</span>
                        <span class="font-bold text-slate-800 ml-1">₹{{ number_format($lead->amount ?? 0, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">Commission:</span>
                        <span class="font-black text-indigo-600 ml-1">₹{{ number_format($lead->commission_amount ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-500">
                <i data-lucide="target" class="w-8 h-8 mx-auto text-slate-300 mb-3"></i>
                <p class="text-sm font-medium">No leads submitted yet.</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop view (table) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Client Name</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Service</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right tracking-wider">Potential Value</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right tracking-wider">Est. Commission</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($recentLeads as $lead)
                    <tr class="hover:bg-slate-50 transition-colors group cursor-pointer" onclick="window.location='{{ route('partner.leads.index') }}'">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900">{{ $lead->client_name }}</div>
                            <div class="text-slate-500 text-xs mt-1">Submitted {{ $lead->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium">{{ $lead->service->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $badgeClass = match($lead->status) {
                                    'new' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'contacted' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'in_progress' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                    default => 'bg-slate-100 text-slate-800 border-slate-200'
                                };
                                $dotClass = match($lead->status) {
                                    'new' => 'bg-blue-600',
                                    'contacted' => 'bg-purple-600',
                                    'in_progress' => 'bg-amber-600',
                                    'approved' => 'bg-emerald-600',
                                    'rejected' => 'bg-red-600',
                                    default => 'bg-slate-600'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                {{ str_replace('_', ' ', ucfirst($lead->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-900 font-semibold">₹{{ number_format($lead->amount ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-right text-indigo-600 font-bold">₹{{ number_format($lead->commission_amount ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <i data-lucide="target" class="w-8 h-8 mx-auto text-slate-300 mb-3"></i>
                            <p>No leads submitted yet.</p>
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
        
        // Earnings Chart
        const earningsCtx = document.getElementById('earningsChart').getContext('2d');
        
        // Gradient for Earnings Chart
        let earningsGradient = earningsCtx.createLinearGradient(0, 0, 0, 300);
        earningsGradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)'); // Indigo-600
        earningsGradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');
        
        new Chart(earningsCtx, {
            type: 'line',
            data: {
                labels: {!! $chartMonths ?? "['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']" !!},
                datasets: [{
                    label: 'Earnings (₹)',
                    data: {!! $chartEarnings ?? '[1200, 1900, 1500, 2800, 2200, 3500, 4250]' !!},
                    borderColor: '#4f46e5', // Indigo-600
                    backgroundColor: earningsGradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
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
                        ticks: {
                            color: '#64748b',
                            callback: function(value) { return '₹' + value; }
                        }
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

        // Leads vs Conversions Chart
        const leadsCtx = document.getElementById('leadsChart').getContext('2d');
        new Chart(leadsCtx, {
            type: 'bar',
            data: {
                labels: {!! $chartMonths ?? "['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']" !!},
                datasets: [
                    {
                        label: 'Total Leads',
                        data: {!! $chartLeads ?? '[5, 8, 12, 10, 15, 20, 18]' !!},
                        backgroundColor: '#e2e8f0', // Slate-200
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    },
                    {
                        label: 'Conversions',
                        data: {!! $chartConversions ?? '[2, 3, 5, 4, 8, 12, 10]' !!},
                        backgroundColor: '#a855f7', // Purple-500
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
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            color: '#64748b'
                        }
                    },
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
