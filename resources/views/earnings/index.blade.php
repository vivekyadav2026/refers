@extends('layouts.app')
@section('title', 'My Earnings — SKSolutions Partner')
@section('sidebar')<!-- enable sidebar -->@endsection

@section('content')
<div class="mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-bold px-3 py-1.5 rounded-full mb-3">
            <i data-lucide="indian-rupee" class="w-3.5 h-3.5"></i> Commission Earnings
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Earnings</h1>
        <p class="text-slate-500 font-medium mt-1">Track every commission you earn from referred sales.</p>
    </div>
    <a href="{{ route('partner.withdrawals') }}"
        class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold text-sm shadow-lg shadow-emerald-500/20 hover:from-emerald-600 hover:to-teal-700 transition-all hover:-translate-y-0.5">
        <i data-lucide="banknote" class="w-4 h-4"></i> Withdraw Earnings
    </a>
</div>

{{-- ── Stats Cards ── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-10">
    @foreach([
        ['label' => 'Wallet Balance',    'value' => '₹'.number_format($walletBalance,2),  'icon' => 'wallet',        'color' => 'emerald', 'gradient' => 'from-emerald-50 to-teal-50',   'desc' => 'Available to withdraw'],
        ['label' => 'Total Earned',      'value' => '₹'.number_format($totalEarned,2),    'icon' => 'trending-up',   'color' => 'blue',    'gradient' => 'from-blue-50 to-indigo-50',    'desc' => 'Cleared + paid commissions'],
        ['label' => 'Pending Approval',  'value' => '₹'.number_format($pendingAmount,2),  'icon' => 'clock',         'color' => 'amber',   'gradient' => 'from-amber-50 to-orange-50',   'desc' => 'Awaiting admin approval'],
        ['label' => 'Total Sales',       'value' => $totalSales,                           'icon' => 'shopping-bag',  'color' => 'purple',  'gradient' => 'from-purple-50 to-fuchsia-50', 'desc' => 'Orders you referred'],
    ] as $stat)
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-{{ $stat['color'] }}-200 transition-all duration-300 group hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br {{ $stat['gradient'] }} rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-center justify-between mb-5 relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $stat['gradient'] }} text-{{ $stat['color'] }}-600 flex items-center justify-center border border-{{ $stat['color'] }}-100">
                <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="text-2xl font-black text-slate-900 mb-0.5 relative z-10">{{ $stat['value'] }}</div>
        <div class="text-xs text-slate-500 font-bold uppercase tracking-wider relative z-10">{{ $stat['label'] }}</div>
        <div class="text-[11px] text-slate-400 font-medium mt-0.5 relative z-10">{{ $stat['desc'] }}</div>
    </div>
    @endforeach
</div>

{{-- ── Referral Link Banner ── --}}
@if(auth()->user()->referral_code)
<div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-3xl p-8 mb-10 text-white relative overflow-hidden shadow-xl shadow-indigo-600/20">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -z-10"></div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="link-2" class="w-5 h-5 text-indigo-200"></i>
                <span class="text-sm font-bold text-indigo-200 uppercase tracking-wider">Your Referral Link</span>
            </div>
            <h2 class="text-xl font-black mb-1">Share & Earn Commission</h2>
            <p class="text-indigo-200 text-sm font-medium">Every time a customer registers through your link and makes a purchase, you earn a commission automatically.</p>
        </div>
        <div class="shrink-0 w-full md:w-auto">
            <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-2xl px-4 py-3 backdrop-blur-sm">
                <span id="ref-link" class="text-sm font-mono text-white truncate max-w-[260px]">{{ auth()->user()->referralLink }}</span>
                <button onclick="copyRefLink()" class="shrink-0 p-2 rounded-xl bg-white/20 hover:bg-white/30 transition-colors" title="Copy link">
                    <i data-lucide="copy" class="w-4 h-4 text-white" id="copy-icon"></i>
                </button>
            </div>
            <p class="text-xs text-indigo-300 text-center mt-2 font-medium">Code: <span class="font-black text-white">{{ auth()->user()->referral_code }}</span></p>
        </div>
    </div>
</div>
@endif

{{-- ── How It Works ── --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mb-10">
    <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
        <i data-lucide="help-circle" class="w-5 h-5 text-indigo-500"></i> How Commission Works
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        @foreach([
            ['step' => '1', 'icon' => 'share-2',      'color' => 'blue',   'title' => 'Share Your Link',       'desc'  => 'Send your referral link to potential customers'],
            ['step' => '2', 'icon' => 'user-plus',    'color' => 'purple', 'title' => 'Customer Registers',    'desc'  => 'They sign up using your unique referral link'],
            ['step' => '3', 'icon' => 'shopping-bag', 'color' => 'amber',  'title' => 'Customer Buys',         'desc'  => 'They purchase any service and complete payment'],
            ['step' => '4', 'icon' => 'indian-rupee', 'color' => 'emerald','title' => 'You Earn Commission',   'desc'  => 'Commission % is credited to your wallet on approval'],
        ] as $step)
        <div class="flex flex-col items-center text-center p-5 rounded-2xl bg-slate-50 border border-slate-100 relative">
            <div class="absolute -top-3 -left-3 w-7 h-7 rounded-full bg-{{ $step['color'] }}-600 text-white text-xs font-black flex items-center justify-center shadow-md">
                {{ $step['step'] }}
            </div>
            <div class="w-12 h-12 rounded-2xl bg-{{ $step['color'] }}-50 text-{{ $step['color'] }}-600 flex items-center justify-center mb-3 border border-{{ $step['color'] }}-100">
                <i data-lucide="{{ $step['icon'] }}" class="w-6 h-6"></i>
            </div>
            <div class="font-black text-slate-900 text-sm mb-1">{{ $step['title'] }}</div>
            <div class="text-xs text-slate-500 font-medium">{{ $step['desc'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- ── Commission Table ── --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h2 class="text-xl font-black text-slate-900">Commission History</h2>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $commissions->total() }} records</span>
    </div>

    @if($commissions->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Sale Amount</th>
                    <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Rate</th>
                    <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Your Commission</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($commissions as $commission)
                @php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-amber-100',  'text' => 'text-amber-700',  'icon' => 'clock',        'label' => 'Pending'],
                        'cleared' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'icon' => 'check-circle', 'label' => 'Cleared'],
                        'paid'    => ['bg' => 'bg-emerald-100','text' => 'text-emerald-700','icon' => 'banknote',     'label' => 'Paid'],
                        'rejected'=> ['bg' => 'bg-red-100',    'text' => 'text-red-700',    'icon' => 'x-circle',    'label' => 'Rejected'],
                    ];
                    $sc = $statusConfig[$commission->status] ?? $statusConfig['pending'];
                    $rate = $commission->type === 'percentage'
                        ? $commission->percentage . '%'
                        : '₹' . number_format($commission->amount, 0) . ' fixed';
                @endphp
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-black text-slate-800 text-xs">#ORD-{{ str_pad($commission->order_id, 5, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ optional($commission->order->user)->name ?? '—' }}</div>
                        <div class="text-xs text-slate-400">{{ optional($commission->order->user)->phone ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <i data-lucide="{{ optional($commission->order->service)->icon ?? 'box' }}" class="w-4 h-4"></i>
                            </div>
                            <span class="font-semibold text-slate-700 max-w-[180px] truncate">{{ optional($commission->order->service)->name ?? 'Custom Service' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-slate-900">
                        ₹{{ number_format($commission->order->amount ?? 0, 2) }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-xs font-black text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">{{ $rate }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-lg font-black text-emerald-600">₹{{ number_format($commission->amount, 2) }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                            <i data-lucide="{{ $sc['icon'] }}" class="w-3 h-3"></i>
                            {{ $sc['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                        {{ $commission->created_at->format('d M Y') }}<br>
                        <span class="text-slate-400">{{ $commission->created_at->diffForHumans() }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $commissions->links() }}
    </div>
    @else
    <div class="py-24 text-center">
        <div class="w-20 h-20 rounded-full bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center mx-auto mb-6">
            <i data-lucide="indian-rupee" class="w-10 h-10 text-slate-300"></i>
        </div>
        <h3 class="text-xl font-black text-slate-900 mb-2">No commissions yet</h3>
        <p class="text-slate-500 font-medium mb-8 max-w-sm mx-auto">Share your referral link with customers. Every time they purchase a service, you earn a commission.</p>
        <a href="{{ route('partner.services') }}"
            class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-sm hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-0.5">
            <i data-lucide="grid-3x3" class="w-5 h-5"></i> Browse Services to Share
        </a>
    </div>
    @endif
</div>

<script>
function copyRefLink() {
    const link = document.getElementById('ref-link').textContent.trim();
    navigator.clipboard.writeText(link).then(() => {
        const icon = document.getElementById('copy-icon');
        icon.setAttribute('data-lucide', 'check');
        lucide.createIcons();
        setTimeout(() => {
            icon.setAttribute('data-lucide', 'copy');
            lucide.createIcons();
        }, 2000);
    });
}
</script>
@endsection
