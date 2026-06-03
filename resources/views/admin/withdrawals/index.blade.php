@extends('layouts.app')

@section('title', 'Withdrawal Requests - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-9xl mx-auto">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Withdrawal Requests</h1>
            <p class="text-slate-500 mt-1">Review and process partner payout requests.</p>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <i data-lucide="list" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-slate-900">{{ $totalCount }}</div>
                <div class="text-xs text-slate-500">Total</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-amber-200 shadow-sm p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-slate-900">{{ $pendingCount }}</div>
                <div class="text-xs text-slate-500">Pending</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-emerald-200 shadow-sm p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-slate-900">{{ $approvedCount }}</div>
                <div class="text-xs text-slate-500">Approved</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-slate-900">{{ $rejectedCount }}</div>
                <div class="text-xs text-slate-500">Rejected</div>
            </div>
        </div>
        <div class="bg-amber-50 rounded-2xl border border-amber-200 shadow-sm p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i data-lucide="hourglass" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-amber-900">₹{{ number_format($pendingAmount, 0) }}</div>
                <div class="text-xs text-amber-700">Pending Amount</div>
            </div>
        </div>
        <div class="bg-emerald-50 rounded-2xl border border-emerald-200 shadow-sm p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <i data-lucide="indian-rupee" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-emerald-800">₹{{ number_format($paidAmount, 0) }}</div>
                <div class="text-xs text-emerald-700">Total Paid Out</div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.withdrawals') }}" id="filter-form">
        <div class="bg-white p-4 border border-slate-200 rounded-t-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="w-full sm:w-auto relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-80 pl-10 p-2.5"
                    placeholder="Search by name, email, phone, ID...">
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <select name="status" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5"
                    onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Status</option>
                    <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">Search</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('admin.withdrawals') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white border-x border-b border-slate-200 rounded-b-2xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
            <table class="min-w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold tracking-wider">ID</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Partner</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Amount</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Method & Details</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Admin Notes</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Date</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($withdrawals as $w)
                    @php
                        $statusConfig = match($w->status) {
                            'approved' => ['bg-emerald-100 text-emerald-800', 'check-circle'],
                            'rejected' => ['bg-red-100 text-red-800',         'x-circle'],
                            default    => ['bg-amber-100 text-amber-800',     'clock'],
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors {{ $w->status === 'pending' ? 'border-l-4 border-l-amber-400' : '' }}">

                        <!-- ID -->
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">#{{ str_pad($w->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>

                        <!-- Partner -->
                        <td class="px-6 py-4">
                            @if($w->user)
                                <div class="font-semibold text-slate-900">{{ $w->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $w->user->email }}</div>
                                @if($w->user->phone)
                                    <div class="text-xs text-slate-400">{{ $w->user->phone }}</div>
                                @endif
                                @if($w->user->wallet)
                                    <div class="text-xs text-indigo-600 mt-1 font-medium">
                                        Wallet: ₹{{ number_format($w->user->wallet->balance, 2) }}
                                    </div>
                                @endif
                            @else
                                <span class="text-slate-400 text-xs italic">Deleted Account</span>
                            @endif
                        </td>

                        <!-- Amount -->
                        <td class="px-6 py-4 text-right">
                            <div class="text-lg font-bold text-slate-900">₹{{ number_format($w->amount, 2) }}</div>
                        </td>

                        <!-- Method & Details -->
                        <td class="px-6 py-4 max-w-xs">
                            <div class="font-bold text-slate-900 uppercase text-xs">{{ $w->payment_method ?? 'N/A' }}</div>
                            <div class="text-xs text-slate-600 break-all whitespace-pre-wrap mt-0.5">{{ $w->payment_details ?? '-' }}</div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusConfig[0] }}">
                                <i data-lucide="{{ $statusConfig[1] }}" class="w-3 h-3"></i>
                                {{ ucfirst($w->status) }}
                            </span>
                        </td>

                        <!-- Admin Notes -->
                        <td class="px-6 py-4 max-w-xs">
                            @if($w->admin_notes)
                                <p class="text-xs text-slate-600 truncate" title="{{ $w->admin_notes }}">{{ $w->admin_notes }}</p>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                            {{ $w->created_at->format('M d, Y') }}<br>
                            <span class="text-slate-400">{{ $w->created_at->diffForHumans() }}</span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            @if($w->status === 'pending')
                            <div class="flex flex-col gap-2 items-end">
                                {{-- Approve Modal Trigger --}}
                                <button type="button"
                                    onclick="openApproveModal({{ $w->id }}, '{{ addslashes($w->user->name ?? 'Partner') }}', '{{ number_format($w->amount, 2) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm w-full justify-center">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> Approve
                                </button>
                                {{-- Reject Modal Trigger --}}
                                <button type="button"
                                    onclick="openRejectModal({{ $w->id }}, '{{ addslashes($w->user->name ?? 'Partner') }}', '{{ number_format($w->amount, 2) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold rounded-lg border border-red-200 transition-colors w-full justify-center">
                                    <i data-lucide="x" class="w-3.5 h-3.5"></i> Reject
                                </button>
                            </div>
                            @else
                            <div class="flex items-center justify-end gap-1">
                                {{-- View partner --}}
                                @if($w->user)
                                <a href="{{ route('admin.users.show', $w->user) }}"
                                   class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors" title="View Partner">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </a>
                                @endif
                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.withdrawals.destroy', $w) }}"
                                      onsubmit="return confirm('Delete this withdrawal record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <i data-lucide="banknote" class="w-12 h-12"></i>
                                <p class="font-medium">No withdrawal requests found</p>
                                @if(request()->hasAny(['search','status']))
                                    <a href="{{ route('admin.withdrawals') }}" class="text-indigo-600 text-sm hover:underline">Clear filters</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($withdrawals->hasPages())
        <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-sm text-slate-500">
                Showing <span class="font-semibold text-slate-900">{{ $withdrawals->firstItem() }}</span>
                to <span class="font-semibold text-slate-900">{{ $withdrawals->lastItem() }}</span>
                of <span class="font-semibold text-slate-900">{{ $withdrawals->total() }}</span> requests
            </span>
            <div class="flex items-center gap-1">
                @if($withdrawals->onFirstPage())
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $withdrawals->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50">Previous</a>
                @endif
                @foreach($withdrawals->getUrlRange(max(1,$withdrawals->currentPage()-2), min($withdrawals->lastPage(),$withdrawals->currentPage()+2)) as $page => $url)
                    @if($page == $withdrawals->currentPage())
                        <span class="px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-t border-b border-slate-200">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border-t border-b border-slate-200 hover:bg-slate-50">{{ $page }}</a>
                    @endif
                @endforeach
                @if($withdrawals->hasMorePages())
                    <a href="{{ $withdrawals->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50">Next</a>
                @else
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @else
        <div class="p-4 border-t border-slate-200">
            <span class="text-sm text-slate-500">Showing all <span class="font-semibold text-slate-900">{{ $withdrawals->total() }}</span> records</span>
        </div>
        @endif
    </div>
</div>

{{-- ─── APPROVE MODAL ──────────────────────────────────────────────────────── --}}
<div id="approveModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-11 h-11 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-lg">Approve Withdrawal</h3>
                <p id="approveModalDesc" class="text-sm text-slate-500"></p>
            </div>
        </div>
        <form id="approveForm" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Transaction ID / Notes <span class="text-slate-400 font-normal">(optional)</span>
                </label>
                <textarea name="admin_notes" rows="3"
                    class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none resize-none"
                    placeholder="e.g. NEFT-TXN123456, paid via UPI..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModals()"
                    class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <i data-lucide="check" class="w-4 h-4 inline mr-1"></i> Confirm Approve
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ─── REJECT MODAL ───────────────────────────────────────────────────────── --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-11 h-11 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-lg">Reject Withdrawal</h3>
                <p id="rejectModalDesc" class="text-sm text-slate-500"></p>
            </div>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-xs text-amber-800 flex items-start gap-2">
                <i data-lucide="info" class="w-4 h-4 shrink-0 mt-0.5"></i>
                The amount will be automatically refunded to the partner's wallet.
            </div>
            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Reason for Rejection <span class="text-red-500">*</span>
                </label>
                <textarea name="admin_notes" rows="3" required
                    class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none resize-none"
                    placeholder="e.g. Bank details incomplete, duplicate request..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModals()"
                    class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <i data-lucide="x" class="w-4 h-4 inline mr-1"></i> Confirm Reject
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openApproveModal(id, name, amount) {
    document.getElementById('approveModalDesc').textContent = 'Approve ₹' + amount + ' for ' + name;
    document.getElementById('approveForm').action = '/admin/withdrawals/' + id + '/approve';
    const modal = document.getElementById('approveModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function openRejectModal(id, name, amount) {
    document.getElementById('rejectModalDesc').textContent = 'Reject ₹' + amount + ' for ' + name + ' (amount will be refunded)';
    document.getElementById('rejectForm').action = '/admin/withdrawals/' + id + '/reject';
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModals() {
    ['approveModal','rejectModal'].forEach(id => {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
    });
}

// Close on backdrop click
['approveModal','rejectModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModals();
    });
});
</script>
@endsection
