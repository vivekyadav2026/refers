@extends('layouts.app')
@section('title', 'KYC Approvals — Admin')
@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
{{-- Flash --}}
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
        <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">KYC Approvals</h1>
        <p class="text-slate-500 mt-1">Review and verify partner identity & bank documents.</p>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
            <i data-lucide="shield" class="w-5 h-5"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ $totalCount }}</div>
            <div class="text-xs text-slate-500 font-medium">Total</div>
        </div>
    </div>
    <div class="bg-amber-50 rounded-2xl border border-amber-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
            <i data-lucide="clock" class="w-5 h-5"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-amber-900">{{ $pendingCount }}</div>
            <div class="text-xs text-amber-700 font-medium">Pending</div>
        </div>
    </div>
    <div class="bg-emerald-50 rounded-2xl border border-emerald-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
            <i data-lucide="shield-check" class="w-5 h-5"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-emerald-900">{{ $approvedCount }}</div>
            <div class="text-xs text-emerald-700 font-medium">Approved</div>
        </div>
    </div>
    <div class="bg-red-50 rounded-2xl border border-red-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
            <i data-lucide="shield-x" class="w-5 h-5"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-red-700">{{ $rejectedCount }}</div>
            <div class="text-xs text-red-600 font-medium">Rejected</div>
        </div>
    </div>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('admin.kyc') }}" id="filter-form">
    <div class="bg-white p-4 border border-slate-200 rounded-t-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="w-full sm:w-auto relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-80 pl-10 p-2.5"
                placeholder="Search by name, email, phone...">
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
                <a href="{{ route('admin.kyc') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">Clear</a>
            @endif
        </div>
    </div>
</form>

<!-- Table -->
<div class="bg-white border-x border-b border-slate-200 rounded-b-2xl shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 font-semibold tracking-wider">Partner</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Documents</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Bank Details</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Submitted</th>
                    <th class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($kycDocuments as $kyc)
                @php
                    $aadhaar   = is_string($kyc->aadhaar_path) && str_starts_with($kyc->aadhaar_path, '{')
                                 ? json_decode($kyc->aadhaar_path, true) : [];
                    $pan       = is_string($kyc->pan_path) && str_starts_with($kyc->pan_path, '{')
                                 ? json_decode($kyc->pan_path, true) : [];
                    $bankDets  = $kyc->bank_details ?? [];
                    $statusConfig = match($kyc->status) {
                        'approved' => ['bg-emerald-100 text-emerald-800', 'shield-check', 'Approved'],
                        'rejected' => ['bg-red-100 text-red-800',         'shield-x',     'Rejected'],
                        default    => ['bg-amber-100 text-amber-800',     'clock',        'Pending'],
                    };
                @endphp
                <tr class="hover:bg-slate-50 transition-colors {{ $kyc->status === 'pending' ? 'border-l-4 border-l-amber-400' : '' }}">

                    <!-- Partner -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr($kyc->user->name ?? '?', 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900">{{ $kyc->user->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-slate-500">{{ $kyc->user->email ?? '' }}</div>
                                @if($kyc->user->phone ?? false)
                                    <div class="text-xs text-slate-400">{{ $kyc->user->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    <!-- Documents -->
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-xs px-2 py-1 rounded-lg {{ !empty($aadhaar) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-400' }}">
                                <i data-lucide="{{ !empty($aadhaar) ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                Aadhaar {{ !empty($aadhaar['number'] ?? '') ? '· ' . $aadhaar['number'] : '' }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs px-2 py-1 rounded-lg {{ !empty($pan) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-400' }}">
                                <i data-lucide="{{ !empty($pan) ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                PAN {{ !empty($pan['number'] ?? '') ? '· ' . $pan['number'] : '' }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs px-2 py-1 rounded-lg {{ $kyc->photo_path ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-400' }}">
                                <i data-lucide="{{ $kyc->photo_path ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                Selfie
                            </span>
                        </div>
                    </td>

                    <!-- Bank Details -->
                    <td class="px-6 py-4">
                        @if(!empty($bankDets))
                            <div class="text-sm font-medium text-slate-800">{{ $bankDets['account_name'] ?? '—' }}</div>
                            <div class="text-xs text-slate-500 font-mono">{{ $bankDets['account_number'] ?? '' }}</div>
                            <div class="text-xs text-slate-400">IFSC: {{ $bankDets['ifsc'] ?? '' }}</div>
                        @else
                            <span class="text-slate-400 text-xs italic">Not provided</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusConfig[0] }}">
                                <i data-lucide="{{ $statusConfig[1] }}" class="w-3 h-3"></i>
                                {{ $statusConfig[2] }}
                            </span>
                            @if($kyc->status === 'rejected' && $kyc->rejection_reason)
                                <span class="text-xs text-red-500 italic mt-1 max-w-[160px] truncate" title="{{ $kyc->rejection_reason }}">
                                    "{{ $kyc->rejection_reason }}"
                                </span>
                            @endif
                        </div>
                    </td>

                    <!-- Submitted -->
                    <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                        {{ $kyc->created_at->format('M d, Y') }}<br>
                        <span class="text-slate-400">{{ $kyc->created_at->diffForHumans() }}</span>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.kyc.show', $kyc) }}"
                               class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors" title="View Documents">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            @if($kyc->status === 'pending')
                                <form method="POST" action="{{ route('admin.kyc.approve', $kyc) }}">
                                    @csrf
                                    <button type="submit" class="p-2 text-slate-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors" title="Approve">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                <button type="button"
                                    onclick="openRejectModal({{ $kyc->id }}, '{{ addslashes($kyc->user->name ?? '') }}')"
                                    class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Reject">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                </button>
                            @elseif($kyc->status === 'rejected')
                                <form method="POST" action="{{ route('admin.kyc.approve', $kyc) }}">
                                    @csrf
                                    <button type="submit" class="p-2 text-slate-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors" title="Re-Approve">
                                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.kyc.destroy', $kyc) }}"
                                  onsubmit="return confirm('Delete KYC for {{ addslashes($kyc->user->name ?? '') }}? This resets their verification status.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <i data-lucide="shield" class="w-12 h-12"></i>
                            <p class="font-medium">No KYC submissions found</p>
                            @if(request()->hasAny(['search','status']))
                                <a href="{{ route('admin.kyc') }}" class="text-indigo-600 text-sm hover:underline">Clear filters</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($kycDocuments->hasPages())
    <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-sm text-slate-500">
            Showing <span class="font-semibold text-slate-900">{{ $kycDocuments->firstItem() }}</span>
            to <span class="font-semibold text-slate-900">{{ $kycDocuments->lastItem() }}</span>
            of <span class="font-semibold text-slate-900">{{ $kycDocuments->total() }}</span> records
        </span>
        <div class="flex items-center gap-1">
            @if($kycDocuments->onFirstPage())
                <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $kycDocuments->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50">Previous</a>
            @endif
            @foreach($kycDocuments->getUrlRange(max(1,$kycDocuments->currentPage()-2), min($kycDocuments->lastPage(),$kycDocuments->currentPage()+2)) as $page => $url)
                @if($page == $kycDocuments->currentPage())
                    <span class="px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-t border-b border-slate-200">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border-t border-b border-slate-200 hover:bg-slate-50">{{ $page }}</a>
                @endif
            @endforeach
            @if($kycDocuments->hasMorePages())
                <a href="{{ $kycDocuments->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50">Next</a>
            @else
                <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
            @endif
        </div>
    </div>
    @else
    <div class="p-4 border-t border-slate-200">
        <span class="text-sm text-slate-500">Showing all <span class="font-semibold text-slate-900">{{ $kycDocuments->total() }}</span> records</span>
    </div>
    @endif
</div>

{{-- ─── REJECT MODAL ───────────────────────────────────────────────────────── --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-11 h-11 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                <i data-lucide="shield-x" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-lg">Reject KYC</h3>
                <p id="rejectModalDesc" class="text-sm text-slate-500"></p>
            </div>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Rejection Reason <span class="text-red-500">*</span>
                </label>
                <textarea name="reason" rows="3" required
                    class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none resize-none"
                    placeholder="e.g. Aadhaar image is blurry. Please resubmit with clear scans..."></textarea>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <button type="button" onclick="fillReason('Aadhaar image is not clear. Please resubmit.')"
                    class="px-3 py-2 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors text-left">Aadhaar not clear</button>
                <button type="button" onclick="fillReason('PAN card image is not visible. Please resubmit.')"
                    class="px-3 py-2 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors text-left">PAN not visible</button>
                <button type="button" onclick="fillReason('Selfie does not match Aadhaar. Please resubmit.')"
                    class="px-3 py-2 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors text-left">Selfie mismatch</button>
                <button type="button" onclick="fillReason('Bank account details are incomplete. Please verify and resubmit.')"
                    class="px-3 py-2 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors text-left">Bank incomplete</button>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()"
                    class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">Cancel</button>
                <button type="submit"
                    class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <i data-lucide="x" class="w-4 h-4 inline mr-1"></i> Reject KYC
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(id, name) {
    document.getElementById('rejectModalDesc').textContent = 'Rejecting KYC for: ' + name;
    document.getElementById('rejectForm').action = '/admin/kyc/' + id + '/reject';
    document.querySelector('#rejectForm textarea[name="reason"]').value = '';
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function fillReason(text) {
    document.querySelector('#rejectForm textarea[name="reason"]').value = text;
}
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endsection
