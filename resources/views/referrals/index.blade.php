@extends('layouts.app')

@section('title', 'Referral Program - VivekTech Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Referral Program</h1>
            <p class="text-slate-500 mt-1">Invite other partners and earn a 5% overriding commission on their projects.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Main Referral Link Card -->
        <div class="lg:col-span-2 bg-gradient-to-br from-indigo-900 to-slate-900 rounded-2xl shadow-md border border-slate-800 p-6 sm:p-8 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-bl-full -z-10 transition-transform group-hover:scale-105"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center backdrop-blur-sm border border-indigo-500/30">
                        <i data-lucide="share-2" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Your Unique Referral Link</h2>
                </div>
                
                <p class="text-indigo-200 text-sm mb-6 max-w-xl">
                    Share this link with your network. When they sign up and close projects, you automatically receive a lifetime commission on their earnings.
                </p>
                
                <!-- Link Input Group -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i data-lucide="link" class="w-4 h-4"></i>
                        </div>
                        <input type="text" readonly value="https://partners.vivektech.com/ref/vtp-8x4j9m2" class="bg-slate-800/50 border border-slate-700 text-slate-200 text-sm font-mono rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-3 transition-colors">
                    </div>
                    <button class="bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl px-6 py-3 flex items-center justify-center gap-2 text-sm font-medium shadow-sm transition-all focus:ring-4 focus:ring-indigo-600/20">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                        Copy Link
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Column -->
        <div class="space-y-6">
            <!-- Total Referrals -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-purple-200 transition-colors">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-50 to-pink-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">All Time</span>
                </div>
                <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Referrals</h3>
                <div class="text-3xl font-bold text-slate-900 relative z-10">12</div>
            </div>

            <!-- Referral Earnings -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:border-emerald-200 transition-colors">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="gift" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Paid</span>
                </div>
                <h3 class="text-slate-500 text-sm font-medium mb-1 relative z-10">Referral Earnings</h3>
                <div class="text-3xl font-bold text-slate-900 relative z-10">$850.00</div>
            </div>
        </div>
    </div>

    <!-- Referral List Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-lg font-bold text-slate-900">Your Network</h2>
            
            <div class="flex items-center gap-2">
                <select class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2 transition-colors">
                    <option>All Statuses</option>
                    <option>Active</option>
                    <option>Pending</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Partner Name</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Joined Date</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right tracking-wider">Closed Deals</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right tracking-wider">Earnings Generated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <!-- Partner 1 -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                    JS
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">John Smith</div>
                                    <div class="text-slate-500 text-xs">john.s@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">Sep 12, 2023</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-900 font-medium">3</td>
                        <td class="px-6 py-4 text-right text-indigo-600 font-bold">$450.00</td>
                    </tr>

                    <!-- Partner 2 -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xs">
                                    EW
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">Emma Watson</div>
                                    <div class="text-slate-500 text-xs">emma.design@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">Oct 05, 2023</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-900 font-medium">1</td>
                        <td class="px-6 py-4 text-right text-indigo-600 font-bold">$150.00</td>
                    </tr>

                    <!-- Partner 3 -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs">
                                    MJ
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">Michael Johnson</div>
                                    <div class="text-slate-500 text-xs">mike.dev@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">Oct 20, 2023</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                Pending First Deal
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-400 font-medium">0</td>
                        <td class="px-6 py-4 text-right text-slate-400 font-medium">$0.00</td>
                    </tr>
                    
                    <!-- Partner 4 -->
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                    SD
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">Sarah Davis</div>
                                    <div class="text-slate-500 text-xs">sarah.d@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">Oct 26, 2023</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Inactive
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-400 font-medium">0</td>
                        <td class="px-6 py-4 text-right text-slate-400 font-medium">$0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-slate-200 flex items-center justify-between">
            <span class="text-sm text-slate-500">Showing <span class="font-semibold text-slate-900">1</span> to <span class="font-semibold text-slate-900">4</span> of <span class="font-semibold text-slate-900">12</span> entries</span>
            <div class="inline-flex rounded-md shadow-sm">
                <button type="button" class="px-3 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">
                    Previous
                </button>
                <button type="button" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 border-t border-b border-r border-slate-200 hover:bg-indigo-100">
                    1
                </button>
                <button type="button" class="px-3 py-2 text-sm font-medium text-slate-900 bg-white border-t border-b border-r border-slate-200 hover:bg-slate-100 hover:text-indigo-700">
                    2
                </button>
                <button type="button" class="px-3 py-2 text-sm font-medium text-slate-900 bg-white border-t border-b border-slate-200 rounded-r-lg border-r hover:bg-slate-100 hover:text-indigo-700">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
