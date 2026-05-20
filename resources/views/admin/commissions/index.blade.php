@extends('layouts.app')
@section('title', 'Commission Management — Admin')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Commission Management</h1>
        <p class="text-slate-500 text-sm mt-1">Manage partner commissions across all orders.</p>
    </div>
    <a href="{{ route('admin.referral.analytics') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-sm hover:bg-indigo-700 transition-colors">
        <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Referral Analytics
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 text-emerald-700 font-medium text-sm">{{ session('success') }}</div>
@endif

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-8">
    @foreach([
        ['label' => 'Total Commissions', 'value' => '₹' . number_format($totalCommissions), 'icon' => 'coins', 'color' => 'blue'],
        ['label' => 'Pending', 'value' => '₹' . number_format($pendingCommissions), 'icon' => 'clock', 'color' => 'amber'],
        ['label' => 'Cleared', 'value' => '₹' . number_format($clearedCommissions), 'icon' => 'check-circle', 'color' => 'emerald'],
        ['label' => 'Paid Out', 'value' => '₹' . number_format($paidCommissions), 'icon' => 'banknote', 'color' => 'purple'],
    ] as $stat)
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center">
                <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
            </div>
            <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ $stat['label'] }}</span>
        </div>
        <div class="text-2xl font-black text-slate-900">{{ $stat['value'] }}</div>
    </div>
    @endforeach
</div>

{{-- Filters --}}
<div class="flex gap-3 mb-6 flex-wrap items-center">
    <form method="GET" class="flex gap-3 flex-wrap items-center">
        <div class="relative">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." 
                   class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none w-64">
        </div>
        <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="cleared" {{ request('status') === 'cleared' ? 'selected' : '' }}>Cleared</option>
            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-semibold text-sm hover:bg-slate-200 transition-colors">Filter</button>
    </form>
</div>

{{-- Commissions Table --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Partner</th>
                    <th class="text-left px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Order</th>
                    <th class="text-left px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Type</th>
                    <th class="text-right px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Amount</th>
                    <th class="text-center px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-center px-6 py-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($commissions as $commission)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-900">{{ $commission->user->name ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-500">{{ $commission->user->phone ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">#ORD-{{ str_pad($commission->order_id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-xs text-slate-500">{{ $commission->order->service->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold text-slate-600">{{ ucfirst($commission->type) }}</span>
                        @if($commission->percentage > 0)
                        <span class="text-xs text-slate-400">({{ $commission->percentage }}%)</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="font-bold text-slate-900">₹{{ number_format($commission->amount, 2) }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'cleared' => 'bg-blue-100 text-blue-700',
                                'paid' => 'bg-emerald-100 text-emerald-700',
                                'rejected' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusColors[$commission->status] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ ucfirst($commission->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            @if($commission->status === 'pending')
                            <form action="{{ route('admin.commissions.approve', $commission) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors" title="Approve">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.commissions.reject', $commission) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Reject">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </form>
                            @elseif($commission->status === 'cleared')
                            <form action="{{ route('admin.commissions.paid', $commission) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors text-xs font-bold" title="Mark as Paid">
                                    Mark Paid
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-slate-400">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-slate-500">No commissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($commissions->hasPages())
<div class="mt-6">{{ $commissions->links() }}</div>
@endif

@endsection
