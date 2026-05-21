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

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <!-- Wallet Balance Card -->
    <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-900 rounded-2xl shadow-xl shadow-indigo-200 overflow-hidden text-white relative">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 blur-3xl rounded-full"></div>
        <div class="p-6 relative z-10">
            <div class="flex items-center justify-between opacity-90 mb-4">
                <span class="text-sm font-semibold tracking-wide uppercase">Available Balance</span>
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-md">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
            </div>
            <h2 class="text-4xl font-black mb-1 tracking-tight">₹{{ number_format($wallet->balance, 2) }}</h2>
            <div class="mt-4 flex items-center text-sm font-medium bg-white/10 w-fit px-3 py-1.5 rounded-lg backdrop-blur-md">
                <i data-lucide="info" class="w-4 h-4 mr-1.5 opacity-80"></i> Minimum withdrawal: ₹1,000
            </div>
        </div>
    </div>
    
    <!-- Pending Withdrawals Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden relative">
        <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-bl-full -z-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between text-slate-500 mb-4">
                <span class="text-sm font-semibold tracking-wide uppercase">Pending Approvals</span>
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">₹{{ number_format($withdrawals->where('status', 'pending')->sum('amount'), 2) }}</h2>
            <div class="mt-4 text-sm text-amber-600 font-bold flex items-center gap-1.5">
                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Processing requests
            </div>
        </div>
    </div>

    <!-- Total Withdrawn Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden relative">
        <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between text-slate-500 mb-4">
                <span class="text-sm font-semibold tracking-wide uppercase">Total Withdrawn</span>
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
            </div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">₹{{ number_format($withdrawals->where('status', 'approved')->sum('amount'), 2) }}</h2>
            <div class="mt-4 text-sm text-emerald-600 font-bold flex items-center gap-1.5">
                <i data-lucide="trending-up" class="w-4 h-4"></i> Successfully paid out
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

                    <div class="mb-5">
                        <label for="payment_method" class="block text-sm font-medium text-slate-700 mb-1">Withdrawal Method</label>
                        <select name="payment_method" id="payment_method" required onchange="document.getElementById('payment_details_container').style.display='block'; document.getElementById('payment_details_label').innerText = this.value === 'upi' ? 'UPI ID' : 'Bank Account Details (Acct No, IFSC, Name)'" class="mt-1 block w-full rounded-md border-slate-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a method...</option>
                            <option value="upi">UPI Transfer</option>
                            <option value="bank">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="mb-5" id="payment_details_container" style="display: none;">
                        <label for="payment_details" id="payment_details_label" class="block text-sm font-medium text-slate-700 mb-1">Payment Details</label>
                        <textarea name="payment_details" id="payment_details" rows="3" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter your payment details here..."></textarea>
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
                <div class="overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Method</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500">{{ $withdrawal->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-slate-900">₹{{ number_format($withdrawal->amount, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500" style="min-width:120px;">
                                    <div class="font-medium text-slate-900 uppercase">{{ $withdrawal->payment_method ?? 'N/A' }}</div>
                                    <div class="text-xs break-all mt-0.5 max-w-[160px]">{{ Str::limit($withdrawal->payment_details ?? '-', 40) }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : ($withdrawal->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500 max-w-[120px]">{{ $withdrawal->admin_notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>{{-- /overflow-x-auto --}}
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
