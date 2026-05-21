@extends('layouts.app')
@section('title', 'Referral Analytics — Admin')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Referral Analytics</h1>
        <p class="text-slate-500 text-sm mt-1">Monitor referral performance and partner activity.</p>
    </div>
    <a href="{{ route('admin.commissions') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Commissions
    </a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">
    @foreach([
        ['label' => 'Total Referral Clicks', 'value' => number_format($totalReferralClicks), 'icon' => 'mouse-pointer-click', 'color' => 'blue'],
        ['label' => 'Registrations', 'value' => number_format($totalReferralRegistrations), 'icon' => 'user-plus', 'color' => 'indigo'],
        ['label' => 'Purchases', 'value' => number_format($totalReferralPurchases), 'icon' => 'shopping-cart', 'color' => 'emerald'],
        ['label' => 'Total Referral Sales', 'value' => '₹' . number_format($totalReferralSales), 'icon' => 'trending-up', 'color' => 'purple'],
        ['label' => 'Commissions Paid', 'value' => '₹' . number_format($totalCommissionsPaid), 'icon' => 'banknote', 'color' => 'amber'],
        ['label' => 'Commissions Pending', 'value' => '₹' . number_format($totalCommissionsPending), 'icon' => 'clock', 'color' => 'orange'],
    ] as $stat)
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center">
                <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="text-2xl font-black text-slate-900">{{ $stat['value'] }}</div>
        <div class="text-xs text-slate-500 font-bold uppercase tracking-wider mt-1">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- Top Partners --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100">
        <h2 class="text-lg font-bold text-slate-900">Top Performing Partners</h2>
        <p class="text-sm text-slate-500">Ranked by total earnings</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Rank</th>
                    <th class="text-left px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Partner</th>
                    <th class="text-center px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Total Sales</th>
                    <th class="text-right px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Earnings</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($topPartners as $i => $partner)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        @if($i < 3)
                        <span class="w-8 h-8 rounded-full inline-flex items-center justify-center font-black text-sm
                            {{ $i === 0 ? 'bg-amber-100 text-amber-700' : ($i === 1 ? 'bg-slate-100 text-slate-600' : 'bg-orange-100 text-orange-700') }}">
                            {{ $i + 1 }}
                        </span>
                        @else
                        <span class="text-slate-500 font-semibold ml-2">{{ $i + 1 }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-900">{{ $partner->name }}</div>
                        <div class="text-xs text-slate-500">{{ $partner->phone }} · {{ $partner->referral_code ?? 'No code' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-bold text-slate-900">{{ $partner->total_commissions }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="font-black text-emerald-600">₹{{ number_format($partner->total_earnings ?? 0, 2) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center text-slate-500">No referral data yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
