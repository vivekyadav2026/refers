@extends('layouts.app')

@section('title', 'Admin Dashboard - VivekTech Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Admin Dashboard</h1>
            <p class="text-slate-500 mt-1">Platform overview, revenue metrics, and system activity.</p>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-3">
            <button class="bg-white border border-slate-200 text-slate-600 hover:text-slate-900 rounded-xl px-4 py-2.5 flex items-center gap-2 text-sm font-medium shadow-sm transition-colors">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export Report
            </button>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Total Revenue -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-emerald-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                </div>
                <div class="flex items-center gap-1 text-sm font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                    <i data-lucide="trending-up" class="w-3 h-3"></i>
                    +24.5%
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Platform Revenue (YTD)</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">$124,500.00</div>
        </div>

        <!-- Card 2: Active Partners -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-indigo-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div class="flex items-center gap-1 text-sm font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                    <i data-lucide="trending-up" class="w-3 h-3"></i>
                    +12
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Active Partners</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">142</div>
        </div>

        <!-- Card 3: Pending Leads -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-amber-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-orange-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="target" class="w-6 h-6"></i>
                </div>
                <div class="flex items-center gap-1 text-sm font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">
                    Action Required
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Pending Leads</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">28</div>
        </div>

        <!-- Card 4: Total Paid Out -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-blue-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="arrow-up-right" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Commissions Paid</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">$32,850.00</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-6">Revenue Growth</h2>
            <div class="h-72 w-full">
                <canvas id="adminRevenueChart"></canvas>
            </div>
        </div>

        <!-- Partner Signups Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-6">Partner Signups</h2>
            <div class="h-72 w-full">
                <canvas id="adminSignupsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- System Activity Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-slate-900">Recent System Activity</h2>
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">View All Logs</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Time</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Event</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">User/Partner</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">2 mins ago</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                <i data-lucide="plus-circle" class="w-3 h-3"></i>
                                New Lead
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">John Smith</td>
                        <td class="px-6 py-4 text-slate-600">Submitted "TechFlow iOS App" ($12,000 est.)</td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">15 mins ago</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <i data-lucide="user-check" class="w-3 h-3"></i>
                                KYC Approved
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">System (Admin)</td>
                        <td class="px-6 py-4 text-slate-600">Approved KYC for "Emma Watson"</td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">1 hour ago</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i data-lucide="user-plus" class="w-3 h-3"></i>
                                Partner Signup
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">Michael Johnson</td>
                        <td class="px-6 py-4 text-slate-600">Signed up via referral link (Ref: JS-8X4J)</td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">3 hours ago</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                                Withdrawal Request
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">Sarah Davis</td>
                        <td class="px-6 py-4 text-slate-600">Requested withdrawal of $1,500.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.font.family = "'Inter', sans-serif";
        
        // Admin Revenue Chart
        const revenueCtx = document.getElementById('adminRevenueChart').getContext('2d');
        let revGradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
        revGradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)'); // Emerald-500
        revGradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Platform Revenue ($)',
                    data: [15000, 22000, 18000, 31000, 26000, 42000],
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
                            label: function(context) { return '$' + context.parsed.y.toLocaleString(); }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#64748b', callback: function(value) { return '$' + (value/1000) + 'k'; } }
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
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'New Partners',
                        data: [12, 19, 15, 25, 22, 30],
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
