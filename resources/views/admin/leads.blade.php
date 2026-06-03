@extends('layouts.app')

@section('title', 'Leads Management - Admin')

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
    @if($errors->has('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
            {{ $errors->first('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Leads Management</h1>
            <p class="text-slate-500 mt-1">Review submitted leads, update status, and process approvals.</p>
        </div>
    </div>

    <!-- Stats Banner (Live from DB) -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <i data-lucide="target" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $totalLeads }}</div>
                <div class="text-xs text-slate-500 font-medium">Total Leads</div>
            </div>
        </div>
        <div class="bg-amber-50 rounded-2xl border border-amber-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-amber-900">{{ $needsReview }}</div>
                <div class="text-xs text-amber-700 font-medium">Needs Review</div>
            </div>
        </div>
        <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                <i data-lucide="refresh-cw" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-blue-900">{{ $inPipeline }}</div>
                <div class="text-xs text-blue-700 font-medium">In Pipeline</div>
            </div>
        </div>
        <div class="bg-emerald-50 rounded-2xl border border-emerald-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <i data-lucide="trophy" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-emerald-900">{{ $closedWon }}</div>
                <div class="text-xs text-emerald-700 font-medium">Won This Month</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-600">{{ $lostCount }}</div>
                <div class="text-xs text-slate-500 font-medium">Lost</div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.leads') }}" id="filter-form">
        <div class="bg-white p-4 border border-slate-200 rounded-t-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="w-full sm:w-auto relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-80 pl-10 p-2.5"
                    placeholder="Search by client, company, partner, email...">
            </div>
            <div class="flex gap-2 w-full sm:w-auto flex-wrap">
                <select name="status" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5"
                    onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Statuses</option>
                    <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="contacted"   {{ request('status') === 'contacted'   ? 'selected' : '' }}>Contacted</option>
                    <option value="negotiation" {{ request('status') === 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                    <option value="won"         {{ request('status') === 'won'         ? 'selected' : '' }}>Won</option>
                    <option value="lost"        {{ request('status') === 'lost'        ? 'selected' : '' }}>Lost</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">Search</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('admin.leads') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Data Table -->
    <div class="bg-white border-x border-b border-slate-200 rounded-b-2xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold tracking-wider">Customer / Client Details</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Submitted By Partner</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Service</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Est. Value</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Submitted</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($leads as $lead)
                    @php
                        $statusConfig = match($lead->status) {
                            'contacted'   => ['bg-blue-100 text-blue-800',    'phone',       'Contacted'],
                            'negotiation' => ['bg-purple-100 text-purple-800','handshake',   'Negotiation'],
                            'won'         => ['bg-emerald-100 text-emerald-800','trophy',    'Won'],
                            'lost'        => ['bg-slate-100 text-slate-600',  'x-circle',   'Lost'],
                            default       => ['bg-amber-100 text-amber-800',  'clock',      'Pending'],
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors
                        {{ $lead->status === 'won' ? 'bg-emerald-50/40' : ($lead->status === 'lost' ? 'opacity-75' : '') }}">

                        <!-- Lead Details -->
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900">{{ $lead->client_name }}</div>
                            @if($lead->company_name)
                                <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="building-2" class="w-3 h-3"></i> {{ $lead->company_name }}
                                </div>
                            @endif
                            <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                <i data-lucide="mail" class="w-3 h-3"></i> {{ $lead->client_email }}
                            </div>
                            @if($lead->client_phone)
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="phone" class="w-3 h-3"></i> {{ $lead->client_phone }}
                                </div>
                            @endif
                        </td>

                        <!-- Partner -->
                        <td class="px-6 py-4">
                            @if($lead->partner)
                                <div class="font-medium text-slate-800">{{ $lead->partner->name }}</div>
                                <div class="text-xs text-slate-500">{{ $lead->partner->email }}</div>
                                <a href="{{ route('admin.users.show', $lead->partner) }}" class="text-xs text-indigo-500 hover:underline mt-1 inline-block">View profile</a>
                            @else
                                <span class="text-slate-400 text-xs italic">Deleted</span>
                            @endif
                        </td>

                        <!-- Service -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center py-1 px-2.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $lead->service_needed }}
                            </span>
                        </td>

                        <!-- Estimated Value -->
                        <td class="px-6 py-4 text-right font-bold text-slate-900">
                            ₹{{ number_format($lead->estimated_value, 0) }}
                        </td>

                        <!-- Status (inline updater) -->
                        <td class="px-6 py-4">
                            @if(in_array($lead->status, ['won', 'lost']))
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-bold {{ $statusConfig[0] }}">
                                    <i data-lucide="{{ $statusConfig[1] }}" class="w-3 h-3"></i>
                                    {{ $statusConfig[2] }}
                                </span>
                            @else
                                <form method="POST" action="{{ route('admin.leads.status', $lead) }}">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()"
                                        class="text-xs rounded-lg px-3 py-1.5 border font-semibold focus:ring-2 focus:ring-indigo-400 outline-none cursor-pointer
                                        {{ $lead->status === 'pending' ? 'bg-amber-50 border-amber-200 text-amber-800' :
                                           ($lead->status === 'contacted' ? 'bg-blue-50 border-blue-200 text-blue-800' : 'bg-purple-50 border-purple-200 text-purple-800') }}">
                                        <option value="pending"     {{ $lead->status === 'pending'     ? 'selected' : '' }}>Pending</option>
                                        <option value="contacted"   {{ $lead->status === 'contacted'   ? 'selected' : '' }}>Contacted</option>
                                        <option value="negotiation" {{ $lead->status === 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                                        <option value="won"         >Mark as Won</option>
                                        <option value="lost"        >Mark as Lost</option>
                                    </select>
                                </form>
                            @endif
                        </td>

                        <!-- Submitted -->
                        <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                            {{ $lead->created_at->format('M d, Y') }}<br>
                            <span class="text-slate-400">{{ $lead->created_at->diffForHumans() }}</span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                {{-- View Details --}}
                                <button type="button"
                                    data-lead="{{ json_encode($lead->load('partner')) }}"
                                    class="p-2 text-slate-400 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50 btn-view-lead" title="View Lead Details">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>

                                {{-- Approve (create order) for pending/contacted --}}
                                @if(in_array($lead->status, ['pending', 'contacted', 'negotiation']))
                                    <button type="button"
                                        onclick="openApproveModal({{ $lead->id }}, '{{ addslashes($lead->client_name) }}', {{ $lead->estimated_value }})"
                                        class="p-2 text-slate-400 hover:text-emerald-600 transition-colors rounded-lg hover:bg-emerald-50" title="Approve & Create Order">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    </button>
                                @endif

                                {{-- View Partner --}}
                                @if($lead->partner)
                                    <a href="{{ route('admin.users.show', $lead->partner) }}"
                                       class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-indigo-50" title="View Partner">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </a>
                                @endif

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}"
                                      onsubmit="return confirm('Delete lead from {{ addslashes($lead->client_name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <i data-lucide="target" class="w-12 h-12"></i>
                                <p class="font-medium">No leads found</p>
                                @if(request()->hasAny(['search','status']))
                                    <a href="{{ route('admin.leads') }}" class="text-indigo-600 text-sm hover:underline">Clear filters</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($leads->hasPages())
        <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-sm text-slate-500">
                Showing <span class="font-semibold text-slate-900">{{ $leads->firstItem() }}</span>
                to <span class="font-semibold text-slate-900">{{ $leads->lastItem() }}</span>
                of <span class="font-semibold text-slate-900">{{ $leads->total() }}</span> leads
            </span>
            <div class="flex items-center gap-1">
                @if($leads->onFirstPage())
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $leads->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50">Previous</a>
                @endif
                @foreach($leads->getUrlRange(max(1,$leads->currentPage()-2), min($leads->lastPage(),$leads->currentPage()+2)) as $page => $url)
                    @if($page == $leads->currentPage())
                        <span class="px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-t border-b border-slate-200">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border-t border-b border-slate-200 hover:bg-slate-50">{{ $page }}</a>
                    @endif
                @endforeach
                @if($leads->hasMorePages())
                    <a href="{{ $leads->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50">Next</a>
                @else
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @else
        <div class="p-4 border-t border-slate-200">
            <span class="text-sm text-slate-500">Showing all <span class="font-semibold text-slate-900">{{ $leads->total() }}</span> leads</span>
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
                <h3 class="font-bold text-slate-900 text-lg">Approve Lead</h3>
                <p id="approveModalDesc" class="text-sm text-slate-500"></p>
            </div>
        </div>
        <form id="approveForm" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Final Amount (₹) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-500 font-bold text-sm">₹</span>
                    <input type="number" name="final_amount" id="approveAmount" step="0.01" min="0" required
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl pl-8 pr-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none">
                </div>
                <p class="text-xs text-slate-400 mt-1">This will create a payment order for the client.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeApproveModal()"
                    class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <i data-lucide="check" class="w-4 h-4 inline mr-1"></i> Approve & Create Order
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ─── VIEW DETAILS MODAL ─────────────────────────────────────────────────── --}}
<div id="viewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-6 overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <h3 class="font-black text-slate-900 text-lg flex items-center gap-2">
                <i data-lucide="target" class="w-5 h-5 text-indigo-600"></i> Lead Profile Details
            </h3>
            <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1.5 hover:bg-slate-100 rounded-xl">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
            <!-- Client Section -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Client Details</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-slate-400">Name / Company</div>
                        <div id="viewClientName" class="text-sm font-bold text-slate-900 mt-0.5"></div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400">Company Name</div>
                        <div id="viewCompanyName" class="text-sm font-semibold text-slate-700 mt-0.5">-</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400">Phone Number</div>
                        <div id="viewClientPhone" class="text-sm font-semibold text-slate-900 mt-0.5"></div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400">Email Address</div>
                        <div id="viewClientEmail" class="text-sm font-semibold text-slate-700 mt-0.5 font-sans"></div>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-indigo-50/50 rounded-2xl p-4 border border-indigo-100/50">
                    <div class="text-xs text-indigo-600 font-bold">Service Required</div>
                    <div id="viewService" class="text-sm font-black text-indigo-950 mt-1"></div>
                </div>
                <div class="bg-emerald-50/50 rounded-2xl p-4 border border-emerald-100/50">
                    <div class="text-xs text-emerald-600 font-bold">Estimated Value</div>
                    <div id="viewValue" class="text-sm font-black text-emerald-950 mt-1"></div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Partner Notes / Requirements</h4>
                <p id="viewNotes" class="text-sm text-slate-600 leading-relaxed font-medium whitespace-pre-line"></p>
            </div>

            <!-- Partner Info -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-sm" id="viewPartnerInitials"></div>
                <div class="min-w-0 flex-1">
                    <div class="text-xs text-slate-400">Submitted By Partner</div>
                    <div id="viewPartnerName" class="text-sm font-bold text-slate-900 mt-0.5"></div>
                    <div id="viewPartnerEmail" class="text-xs text-slate-500 font-sans"></div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="mt-6 pt-4 border-t border-slate-100 flex gap-3">
            <button onclick="closeViewModal()" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-black uppercase tracking-wider rounded-xl transition-colors">
                Close Details
            </button>
        </div>
    </div>
</div>

<script>
function openApproveModal(id, clientName, estimatedValue) {
    document.getElementById('approveModalDesc').textContent = 'Approving lead for: ' + clientName;
    document.getElementById('approveAmount').value = estimatedValue;
    document.getElementById('approveForm').action = '/admin/leads/' + id + '/approve';
    const modal = document.getElementById('approveModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeApproveModal() {
    const modal = document.getElementById('approveModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('approveModal').addEventListener('click', function(e) {
    if (e.target === this) closeApproveModal();
});

// View Details Modal Functions
function openViewModal(lead) {
    document.getElementById('viewClientName').textContent = lead.client_name;
    document.getElementById('viewCompanyName').textContent = lead.company_name || 'N/A';
    document.getElementById('viewClientPhone').textContent = lead.client_phone || 'N/A';
    document.getElementById('viewClientEmail').textContent = lead.client_email || 'N/A';
    document.getElementById('viewService').textContent = lead.service_needed;
    document.getElementById('viewValue').textContent = '₹' + parseFloat(lead.estimated_value).toLocaleString('en-IN');
    document.getElementById('viewNotes').textContent = lead.notes || 'No notes provided by partner.';
    
    if (lead.partner) {
        document.getElementById('viewPartnerName').textContent = lead.partner.name;
        document.getElementById('viewPartnerEmail').textContent = lead.partner.email;
        const initials = lead.partner.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        document.getElementById('viewPartnerInitials').textContent = initials;
    } else {
        document.getElementById('viewPartnerName').textContent = 'Deleted Partner';
        document.getElementById('viewPartnerEmail').textContent = 'N/A';
        document.getElementById('viewPartnerInitials').textContent = '??';
    }

    const modal = document.getElementById('viewModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    if (window.lucide) {
        window.lucide.createIcons();
    }
}
function closeViewModal() {
    const modal = document.getElementById('viewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) closeViewModal();
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-view-lead').forEach(btn => {
        btn.addEventListener('click', function() {
            const lead = JSON.parse(this.getAttribute('data-lead'));
            openViewModal(lead);
        });
    });
});
</script>
@endsection
