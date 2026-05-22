@extends('layouts.app')

@section('title', 'KYC Detail — ' . ($kyc->user->name ?? 'Unknown') . ' — Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
@php
    $aadhaar = is_string($kyc->aadhaar_path) && str_starts_with($kyc->aadhaar_path, '{')
               ? json_decode($kyc->aadhaar_path, true) : [];
    $pan     = is_string($kyc->pan_path) && str_starts_with($kyc->pan_path, '{')
               ? json_decode($kyc->pan_path, true) : [];
    $bank    = $kyc->bank_details ?? [];
    $statusConfig = match($kyc->status) {
        'approved' => ['bg-emerald-100 text-emerald-800 border-emerald-200', 'shield-check', 'Approved'],
        'rejected' => ['bg-red-100 text-red-800 border-red-200',             'shield-x',     'Rejected'],
        default    => ['bg-amber-100 text-amber-800 border-amber-200',       'clock',        'Pending Review'],
    };
@endphp

{{-- Flash --}}
@if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 text-sm font-medium">
        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
        {{ session('success') }}
    </div>
@endif

<!-- Back -->
<div class="mb-6">
    <a href="{{ route('admin.kyc') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to KYC List
    </a>
</div>

<!-- Header Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xl shrink-0">
                {{ strtoupper(substr($kyc->user->name ?? '?', 0, 2)) }}
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">{{ $kyc->user->name ?? 'Unknown' }}</h1>
                <p class="text-slate-500 text-sm">{{ $kyc->user->email ?? '' }}</p>
                @if($kyc->user->phone ?? false)
                    <p class="text-slate-400 text-xs">{{ $kyc->user->phone }}</p>
                @endif
                <p class="text-xs text-slate-400 mt-1">
                    Submitted {{ $kyc->created_at->format('M d, Y h:i A') }} · {{ $kyc->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        <div class="flex flex-col items-start sm:items-end gap-3">
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold border {{ $statusConfig[0] }}">
                <i data-lucide="{{ $statusConfig[1] }}" class="w-4 h-4"></i>
                {{ $statusConfig[2] }}
            </span>
            @if($kyc->user)
                <a href="{{ route('admin.users.show', $kyc->user) }}"
                   class="text-xs text-indigo-600 hover:underline inline-flex items-center gap-1">
                    <i data-lucide="external-link" class="w-3 h-3"></i> View Partner Profile
                </a>
            @endif
        </div>
    </div>
    @if($kyc->status === 'rejected' && $kyc->rejection_reason)
    <div class="mt-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700 flex items-start gap-2">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <div><span class="font-semibold">Rejection Reason: </span>{{ $kyc->rejection_reason }}</div>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT: Documents & Details -->
    <div class="lg:col-span-2 space-y-5">

        <!-- Applicant Details -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="user-check" class="w-4 h-4"></i> Applicant Details
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Full Name</p>
                    <p class="font-semibold text-slate-800">{{ $kyc->user->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Gender</p>
                    <p class="font-medium text-slate-800">{{ $kyc->user->gender ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Primary Phone</p>
                    <p class="font-mono text-slate-800 font-semibold">{{ $kyc->user->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Alternate Phone</p>
                    <p class="font-mono text-slate-800">{{ $kyc->user->alternate_phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Email</p>
                    <p class="font-medium text-slate-800">{{ $kyc->user->email ?? '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Residential Address</p>
                    <p class="font-medium text-slate-800">
                        {{ $kyc->user->address_house ?? '' }} {{ $kyc->user->address_street ?? '' }}<br>
                        {{ $kyc->user->address_city ?? '' }}, {{ $kyc->user->address_state ?? '' }} - {{ $kyc->user->address_pin ?? '' }}<br>
                        {{ $kyc->user->address_country ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Aadhaar -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="id-card" class="w-4 h-4"></i> Aadhaar Card
                @if(!empty($aadhaar['number']))
                    <span class="font-mono text-xs text-slate-700 ml-auto">{{ $aadhaar['number'] }}</span>
                @endif
            </h2>
            @if(!empty($aadhaar))
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if(!empty($aadhaar['front']))
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-2">Front Side</p>
                        <a href="{{ asset('storage/' . $aadhaar['front']) }}" target="_blank">
                            <img src="{{ asset('storage/' . $aadhaar['front']) }}" alt="Aadhaar Front"
                                class="w-full rounded-xl border border-slate-200 object-cover max-h-40 hover:opacity-90 transition-opacity cursor-pointer">
                        </a>
                    </div>
                    @endif
                    @if(!empty($aadhaar['back']))
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-2">Back Side</p>
                        <a href="{{ asset('storage/' . $aadhaar['back']) }}" target="_blank">
                            <img src="{{ asset('storage/' . $aadhaar['back']) }}" alt="Aadhaar Back"
                                class="w-full rounded-xl border border-slate-200 object-cover max-h-40 hover:opacity-90 transition-opacity cursor-pointer">
                        </a>
                    </div>
                    @endif
                </div>
            @else
                <p class="text-slate-400 text-sm italic">Not submitted</p>
            @endif
        </div>

        <!-- PAN -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="credit-card" class="w-4 h-4"></i> PAN Card
                @if(!empty($pan['number']))
                    <span class="font-mono text-xs text-slate-700 ml-auto">{{ $pan['number'] }}</span>
                @endif
            </h2>
            @if(!empty($pan['image']))
                <a href="{{ asset('storage/' . $pan['image']) }}" target="_blank">
                    <img src="{{ asset('storage/' . $pan['image']) }}" alt="PAN Card"
                        class="w-full max-w-sm rounded-xl border border-slate-200 object-cover max-h-44 hover:opacity-90 transition-opacity cursor-pointer">
                </a>
            @else
                <p class="text-slate-400 text-sm italic">Not submitted</p>
            @endif
        </div>

        <!-- Bank Proof -->
        @if(!empty($bank['proof_path']))
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="building-2" class="w-4 h-4"></i> Bank Proof Document
            </h2>
            @php $ext = strtolower(pathinfo($bank['proof_path'], PATHINFO_EXTENSION)); @endphp
            @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                <a href="{{ asset('storage/' . $bank['proof_path']) }}" target="_blank">
                    <img src="{{ asset('storage/' . $bank['proof_path']) }}" alt="Bank Proof"
                        class="w-full max-w-sm rounded-xl border border-slate-200 max-h-44 object-cover hover:opacity-90 transition-opacity cursor-pointer">
                </a>
            @else
                <a href="{{ asset('storage/' . $bank['proof_path']) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-xl border border-indigo-200 transition-colors">
                    <i data-lucide="file-text" class="w-4 h-4"></i> View Bank Proof PDF
                </a>
            @endif
        </div>
        @endif

    </div>

    <!-- RIGHT: Sidebar -->
    <div class="space-y-5">

        <!-- Selfie -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="camera" class="w-4 h-4"></i> Selfie / Photo
            </h2>
            @if($kyc->photo_path)
                <a href="{{ asset('storage/' . $kyc->photo_path) }}" target="_blank">
                    <img src="{{ asset('storage/' . $kyc->photo_path) }}" alt="Selfie"
                        class="w-full rounded-2xl border border-slate-200 object-cover hover:opacity-90 transition-opacity cursor-pointer">
                </a>
            @else
                <div class="flex flex-col items-center py-6 text-slate-400">
                    <i data-lucide="camera-off" class="w-10 h-10 mb-2"></i>
                    <p class="text-sm">Not submitted</p>
                </div>
            @endif
        </div>

        <!-- Bank Details -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="landmark" class="w-4 h-4"></i> Bank Details
            </h2>
            @if(!empty($bank))
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Account Holder</p>
                        <p class="font-semibold text-slate-800">{{ $bank['account_name'] ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Account Number</p>
                        <p class="font-mono text-slate-800 font-semibold">{{ $bank['account_number'] ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">IFSC Code</p>
                        <p class="font-mono text-slate-700 uppercase">{{ $bank['ifsc'] ?? '—' }}</p>
                    </div>
                </div>
            @else
                <p class="text-slate-400 text-sm italic">Not provided</p>
            @endif
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="zap" class="w-4 h-4"></i> Actions
            </h2>
            <div class="space-y-2">
                @if($kyc->status !== 'approved')
                    <form method="POST" action="{{ route('admin.kyc.approve', $kyc) }}">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                            <i data-lucide="shield-check" class="w-4 h-4"></i> Approve KYC
                        </button>
                    </form>
                @endif

                @if($kyc->status !== 'rejected')
                    <button type="button"
                        onclick="openRejectModal({{ $kyc->id }}, '{{ addslashes($kyc->user->name ?? '') }}')"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-semibold rounded-xl border border-red-200 transition-colors">
                        <i data-lucide="shield-x" class="w-4 h-4"></i> Reject KYC
                    </button>
                @else
                    <form method="POST" action="{{ route('admin.kyc.approve', $kyc) }}">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-semibold rounded-xl border border-emerald-200 transition-colors">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Re-Approve
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.kyc.destroy', $kyc) }}"
                      onsubmit="return confirm('Delete this KYC and reset partner verification status?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl border border-slate-200 transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Delete KYC Record
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Reject Modal --}}
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
                    Reject KYC
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(id, name) {
    document.getElementById('rejectModalDesc').textContent = name;
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
