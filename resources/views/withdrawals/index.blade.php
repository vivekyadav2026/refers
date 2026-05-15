@extends('layouts.app')

@section('title', 'My Withdrawals - SK Solutions')

@section('sidebar')
    <!-- Enables sidebar -->
@endsection

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Wallet & Withdrawals</h1>
        <p class="text-slate-500 mt-1">Manage your earnings and request payouts.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Wallet Balance Card -->
    <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-xl shadow-md overflow-hidden text-white">
        <div class="p-6">
            <div class="flex items-center justify-between opacity-80 mb-4">
                <span class="text-sm font-medium">Available Balance</span>
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
            <h2 class="text-4xl font-bold">₹{{ number_format($wallet->balance, 2) }}</h2>
            <div class="mt-4 flex items-center text-sm opacity-80">
                <i data-lucide="info" class="w-4 h-4 mr-1"></i> Minimum withdrawal: ₹1,000
            </div>
        </div>
    </div>
    
    <!-- Pending Withdrawals Card -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between text-slate-500 mb-4">
                <span class="text-sm font-medium">Pending Approvals</span>
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-900">₹{{ number_format($withdrawals->where('status', 'pending')->sum('amount'), 2) }}</h2>
            <div class="mt-4 text-sm text-yellow-600 font-medium">
                Currently processing
            </div>
        </div>
    </div>

    <!-- Total Withdrawn Card -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between text-slate-500 mb-4">
                <span class="text-sm font-medium">Total Withdrawn</span>
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-900">₹{{ number_format($withdrawals->where('status', 'approved')->sum('amount'), 2) }}</h2>
            <div class="mt-4 text-sm text-green-600 font-medium">
                Successfully paid out
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Withdrawal Form -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-medium text-slate-900">Request Withdrawal</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('partner.withdrawals.store') }}" method="POST">
                    @csrf
                    
                    @if(session('error'))
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg p-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-5">
                        <label for="amount" class="block text-sm font-medium text-slate-700 mb-1">Amount to Withdraw (₹)</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-500 sm:text-sm">₹</span>
                            </div>
                            <input type="number" name="amount" id="amount" min="1000" max="{{ floor($wallet->balance) }}" required 
                                class="block w-full rounded-md border-slate-300 pl-7 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="1000">
                        </div>
                        <p class="mt-1 text-xs text-slate-500">Available: ₹{{ number_format($wallet->balance, 2) }}</p>
                    </div>

                    <button type="submit" 
                        {{ $wallet->balance < 1000 ? 'disabled' : '' }} 
                        class="w-full inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-2.5 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- History Table -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-medium text-slate-900">Withdrawal History</h3>
            </div>
            
            @if($withdrawals->count() > 0)
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $withdrawal->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">₹{{ number_format($withdrawal->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : ($withdrawal->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $withdrawal->admin_notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $withdrawals->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i data-lucide="receipt" class="w-12 h-12 mx-auto text-slate-300 mb-4"></i>
                    <h3 class="text-base font-medium text-slate-900">No withdrawal history</h3>
                    <p class="mt-1 text-sm text-slate-500">You haven't requested any payouts yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
