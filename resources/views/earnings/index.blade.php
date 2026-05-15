@extends('layouts.app')

@section('title', 'Earnings & Wallet - VivekTech Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Earnings & Wallet</h1>
            <p class="text-slate-500 mt-1">Manage your balance, view transaction history, and request withdrawals.</p>
        </div>
    </div>

    <!-- Wallet Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Total Earnings Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-indigo-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Lifetime Earnings</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">$12,450.00</div>
        </div>

        <!-- Available Balance Card -->
        <div class="bg-gradient-to-br from-slate-900 to-indigo-900 rounded-2xl shadow-md border border-slate-800 p-6 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-white/10 text-white flex items-center justify-center backdrop-blur-sm border border-white/10">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <div class="flex items-center gap-1 text-sm font-semibold text-emerald-400 bg-emerald-400/10 px-2.5 py-1 rounded-full border border-emerald-400/20">
                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                    Ready to Withdraw
                </div>
            </div>
            <h3 class="text-indigo-200 text-sm font-medium mb-1 relative z-10">Available Balance</h3>
            <div class="text-3xl font-bold text-white relative z-10">$3,250.00</div>
        </div>

        <!-- Pending Clearance -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-amber-200 transition-colors">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-orange-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Pending Clearance</h3>
            <div class="text-3xl font-bold text-slate-900 relative z-10">$850.00</div>
            <p class="text-xs text-slate-400 mt-2">Will be available in 3-5 business days</p>
        </div>

    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 mb-8 bg-indigo-50/50 p-5 rounded-2xl border border-indigo-100 items-center justify-between">
        <div>
            <h3 class="text-sm font-semibold text-indigo-900">Withdraw Funds</h3>
            <p class="text-xs text-indigo-700/70 mt-1">Transfer your available balance to your connected bank account.</p>
        </div>
        <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-6 py-2.5 flex items-center justify-center gap-2 text-sm font-medium shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
            Withdraw $3,250.00
        </button>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-lg font-bold text-slate-900">Transaction History</h2>
            
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2 transition-colors" placeholder="Search transactions...">
                </div>
                <button class="p-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Transaction ID</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <!-- Commission Earned -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 font-mono text-xs">TXN-7829-A1B</td>
                        <td class="px-6 py-4 text-slate-500">Today, 10:45 AM</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i data-lucide="arrow-down-left" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    Referral Commission
                                    <div class="text-xs text-slate-500 font-normal">TechFlow Inc. Project</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-emerald-600 font-bold">+$1,250.00</td>
                    </tr>

                    <!-- Pending Commission -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 font-mono text-xs">TXN-7824-X9F</td>
                        <td class="px-6 py-4 text-slate-500">Yesterday, 02:15 PM</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    Commission Clearance
                                    <div class="text-xs text-slate-500 font-normal">Global Logistics Project</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-amber-600 font-bold">+$850.00</td>
                    </tr>

                    <!-- Withdrawal -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 font-mono text-xs">WDL-4592-K2L</td>
                        <td class="px-6 py-4 text-slate-500">Oct 24, 2023</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center">
                                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    Bank Withdrawal
                                    <div class="text-xs text-slate-500 font-normal">To Chase Bank ending in ****4921</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                Processed
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-900 font-bold">-$2,000.00</td>
                    </tr>
                    
                    <!-- Commission Earned -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500 font-mono text-xs">TXN-7611-C3M</td>
                        <td class="px-6 py-4 text-slate-500">Oct 18, 2023</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i data-lucide="arrow-down-left" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    Referral Commission
                                    <div class="text-xs text-slate-500 font-normal">Acme Corp Project</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-emerald-600 font-bold">+$1,500.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (Mockup) -->
        <div class="p-4 border-t border-slate-200 flex items-center justify-between">
            <span class="text-sm text-slate-500">Showing <span class="font-semibold text-slate-900">1</span> to <span class="font-semibold text-slate-900">4</span> of <span class="font-semibold text-slate-900">24</span> entries</span>
            <div class="inline-flex rounded-md shadow-sm">
                <button type="button" class="px-3 py-2 text-sm font-medium text-slate-900 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-100 hover:text-indigo-700">
                    Previous
                </button>
                <button type="button" class="px-3 py-2 text-sm font-medium text-slate-900 bg-white border-t border-b border-r border-slate-200 hover:bg-slate-100 hover:text-indigo-700">
                    1
                </button>
                <button type="button" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 border-t border-b border-r border-slate-200 hover:bg-indigo-100">
                    2
                </button>
                <button type="button" class="px-3 py-2 text-sm font-medium text-slate-900 bg-white border-t border-b border-r border-slate-200 hover:bg-slate-100 hover:text-indigo-700">
                    3
                </button>
                <button type="button" class="px-3 py-2 text-sm font-medium text-slate-900 bg-white border-t border-b border-slate-200 rounded-r-lg border-r hover:bg-slate-100 hover:text-indigo-700">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
