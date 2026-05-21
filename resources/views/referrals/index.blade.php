@extends('layouts.app')

@section('title', 'Referrals - Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-extrabold tracking-tight">Referral Network</h1>
            <p class="text-slate-500 mt-1">Track customers who registered through your unique referral link.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
        
        <!-- Main Referral Link Card -->
        <div class="lg:col-span-2 bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl shadow-lg border border-slate-800 p-6 sm:p-8 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-bl-full -z-10 transition-transform group-hover:scale-105"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center backdrop-blur-sm border border-indigo-500/30">
                        <i data-lucide="share-2" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Your Unique Referral Link</h2>
                </div>
                
                <p class="text-indigo-200 text-sm mb-6 max-w-xl">
                    Share this link with your network. When they sign up using this link, they will be permanently associated with your partner account, earning you commissions on their purchases.
                </p>
                
                <!-- Link Input Group -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i data-lucide="link" class="w-4 h-4"></i>
                        </div>
                        <input id="referral-url-field" type="text" readonly value="{{ route('referral.link', ['code' => auth()->user()->referral_code ?? 'VTP-CODE']) }}" class="bg-slate-800/50 border border-slate-700 text-slate-200 text-sm font-mono rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-3 transition-colors">
                    </div>
                    <button onclick="copyReferralUrl(this)" class="bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white rounded-xl px-6 py-3 flex items-center justify-center gap-2 text-sm font-semibold shadow-md transition-all">
                        <i data-lucide="copy" class="w-4 h-4 btn-icon"></i>
                        <span class="btn-text">Copy Link</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Column -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1 gap-4">
            <!-- Total Clicks -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 relative overflow-hidden group hover:border-blue-200 transition-colors">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                        <i data-lucide="mouse-pointer" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Clicks</span>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Total Clicks</h3>
                <div class="text-2xl font-black text-slate-900 relative z-10">{{ $totalClicks }}</div>
            </div>

            <!-- Total Registrations -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 relative overflow-hidden group hover:border-purple-200 transition-colors">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-50 to-pink-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Users</span>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Referred Registrations</h3>
                <div class="text-2xl font-black text-slate-900 relative z-10">{{ $totalRegistrations }}</div>
            </div>

            <!-- Total Purchases -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 relative overflow-hidden group hover:border-emerald-200 transition-colors">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Sales</span>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Referred Sales</h3>
                <div class="text-2xl font-black text-slate-900 relative z-10">{{ $totalPurchases }}</div>
            </div>
        </div>
    </div>

    <!-- Referral List Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
            <h2 class="text-lg font-black text-slate-900">Your Network Activity</h2>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $referrals->total() }} records</span>
        </div>
        
        @if($referrals->count())
        <div class="overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">IP Address</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Type / Status</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Recent Order</th>
                        <th scope="col" class="px-6 py-4 font-black text-right tracking-wider">Value</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($referrals as $ref)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-50 text-slate-700 flex items-center justify-center font-bold text-xs border border-slate-100">
                                    {{ $ref->customer ? strtoupper(substr($ref->customer->name, 0, 2)) : 'CL' }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $ref->customer->name ?? 'Referred Click' }}</div>
                                    <div class="text-slate-400 text-xs">{{ $ref->customer->phone ?? 'Visitor' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono text-xs">{{ $ref->ip_address }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = [
                                    'clicked' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-100', 'label' => 'Link Clicked'],
                                    'registered' => ['bg' => 'bg-purple-50 text-purple-700 border-purple-100', 'label' => 'Registered'],
                                    'purchased' => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'label' => 'Purchased'],
                                ];
                                $st = $statusMap[$ref->status] ?? ['bg' => 'bg-slate-50 text-slate-700 border-slate-100', 'label' => ucfirst($ref->status)];
                            @endphp
                            <span class="inline-flex items-center gap-1 py-1 px-2.5 rounded-full text-xs font-bold border {{ $st['bg'] }}">
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-700">
                            @if($ref->order)
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="{{ $ref->order->service->icon ?? 'box' }}" class="w-3.5 h-3.5 text-indigo-500"></i>
                                    <span class="truncate max-w-[150px]">{{ $ref->order->service->name ?? 'Service Order' }}</span>
                                </div>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-slate-900 font-bold">
                            @if($ref->order)
                                ₹{{ number_format($ref->order->amount, 2) }}
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                            {{ $ref->created_at->format('d M Y') }}<br>
                            <span class="text-slate-400">{{ $ref->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $referrals->links() }}
        </div>
        @else
        <div class="py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="share-2" class="w-8 h-8 text-slate-300"></i>
            </div>
            <h3 class="text-lg font-black text-slate-900 mb-1">No referral activity yet</h3>
            <p class="text-slate-500 text-sm max-w-sm mx-auto">Copy and share your unique referral link. Once someone visits or signs up, they will appear here!</p>
        </div>
        @endif
    </div>
</div>

<script>
function copyReferralUrl(btn) {
    const input = document.getElementById('referral-url-field');
    navigator.clipboard.writeText(input.value).then(() => {
        const btnText = btn.querySelector('.btn-text');
        const btnIcon = btn.querySelector('.btn-icon');
        
        btnText.textContent = 'Copied!';
        btnIcon.setAttribute('data-lucide', 'check');
        if (window.lucide) {
            lucide.createIcons();
        }
        
        btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-500');
        btn.classList.add('bg-emerald-600');
        
        setTimeout(() => {
            btnText.textContent = 'Copy Link';
            btnIcon.setAttribute('data-lucide', 'copy');
            if (window.lucide) {
                lucide.createIcons();
            }
            btn.classList.remove('bg-emerald-600');
            btn.classList.add('bg-indigo-600', 'hover:bg-indigo-500');
        }, 2000);
    });
}
</script>
@endsection
