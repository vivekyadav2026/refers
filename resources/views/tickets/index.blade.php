
@extends('layouts.app')

@section('title', 'Support Tickets — SK Solutions') 
@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@push('styles')
<style>
    .page-header { display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1rem; margin-bottom:2rem; }
    .page-header h1 { font-size:1.6rem; font-weight:800; color:#0f172a; margin:0 0 .25rem; }
    .page-header p  { font-size:.875rem; color:#64748b; margin:0; }

    /* Stats */
    .stats-strip { display:grid; grid-template-columns:repeat(auto-fit,minmax(130px,1fr)); gap:1rem; margin-bottom:2rem; }
    .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:1rem; padding:1.15rem 1.4rem; display:flex; flex-direction:column; gap:.3rem; box-shadow:0 1px 4px rgba(0,0,0,.04); }
    .stat-label { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; }
    .stat-value { font-size:1.7rem; font-weight:800; color:#0f172a; line-height:1; }

    /* Filters */
    .filter-bar { display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1.25rem; }
    .filter-btn { padding:.4rem 1rem; border-radius:999px; border:1px solid #e2e8f0; font-size:.8rem; font-weight:600; cursor:pointer; background:#fff; color:#64748b; text-decoration:none; transition:all .15s; }
    .filter-btn:hover,.filter-btn.active { background:#6366f1; border-color:#6366f1; color:#fff; }

    /* Table */
    .ticket-table { width:100%; border-collapse:collapse; }
    .ticket-table thead th { padding:.75rem 1.25rem; text-align:left; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
    .ticket-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .12s; }
    .ticket-table tbody tr:last-child { border-bottom:none; }
    .ticket-table tbody tr:hover { background:#f8fafc; }
    .ticket-table tbody td { padding:.95rem 1.25rem; font-size:.875rem; color:#334155; vertical-align:middle; }

    /* Badges */
    .badge { display:inline-flex; align-items:center; gap:.3rem; padding:.25rem .7rem; border-radius:999px; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
    .badge-open { background:#d1fae5; color:#065f46; }
    .badge-in_progress { background:#dbeafe; color:#1e40af; }
    .badge-closed { background:#f1f5f9; color:#64748b; }
    .badge-high { background:#fee2e2; color:#991b1b; }
    .badge-medium { background:#fef3c7; color:#92400e; }
    .badge-low { background:#dbeafe; color:#1e40af; }
    .badge-dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

    /* Actions */
    .btn-view { display:inline-flex; align-items:center; gap:.35rem; padding:.4rem .85rem; border-radius:.5rem; background:#eef2ff; color:#4f46e5; font-size:.78rem; font-weight:700; text-decoration:none; transition:background .15s; }
    .btn-view:hover { background:#6366f1; color:#fff; }
    .btn-primary { display:inline-flex; align-items:center; gap:.5rem; padding:.65rem 1.25rem; border-radius:.65rem; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; font-size:.875rem; font-weight:700; text-decoration:none; box-shadow:0 4px 14px rgba(99,102,241,.3); transition:transform .15s,box-shadow .15s; }
    .btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(99,102,241,.4); color:#fff; }

    .card { background:#fff; border:1px solid #e2e8f0; border-radius:1rem; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.04); }

    .empty-state { text-align:center; padding:5rem 2rem; }
    .empty-icon { display:inline-flex; align-items:center; justify-content:center; width:80px; height:80px; border-radius:50%; background:#f1f5f9; color:#94a3b8; margin-bottom:1.25rem; }
    .empty-state h3 { font-size:1.15rem; font-weight:700; color:#1e293b; margin:0 0 .5rem; }
    .empty-state p { color:#64748b; font-size:.875rem; margin:0 0 1.5rem; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="page-header">
    <div>
        <h1>Support Tickets</h1>
        <p>Need help? Raise a ticket and our team will respond promptly.</p>
    </div>
    <a href="{{ route('partner.tickets.create') }}" class="btn-primary" id="btn-new-ticket">
        <i data-lucide="plus" class="w-4 h-4"></i> New Ticket
    </a>
</div>

{{-- Stats Strip --}}
@php
    $allCount  = $tickets->total();
    $openCount = $tickets->getCollection()->where('status','open')->count();
    $ipCount   = $tickets->getCollection()->where('status','in_progress')->count();
    $closedCnt = $tickets->getCollection()->where('status','closed')->count();
@endphp
<div class="stats-strip">
    <div class="stat-card">
        <span class="stat-label">Total</span>
        <span class="stat-value">{{ $tickets->total() }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Open</span>
        <span class="stat-value" style="color:#059669;">{{ $tickets->getCollection()->where('status','open')->count() }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">In Progress</span>
        <span class="stat-value" style="color:#2563eb;">{{ $tickets->getCollection()->where('status','in_progress')->count() }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Closed</span>
        <span class="stat-value" style="color:#94a3b8;">{{ $tickets->getCollection()->where('status','closed')->count() }}</span>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;border-radius:.65rem;padding:.75rem 1rem;font-size:.875rem;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
        <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
    </div>
@endif

{{-- Filter Bar --}}
@php $status = request('status','all'); @endphp
<div class="filter-bar">
    <a href="{{ route('partner.tickets') }}" class="filter-btn {{ $status === 'all' ? 'active' : '' }}">All</a>
    <a href="{{ route('partner.tickets', ['status'=>'open']) }}" class="filter-btn {{ $status === 'open' ? 'active' : '' }}">Open</a>
    <a href="{{ route('partner.tickets', ['status'=>'in_progress']) }}" class="filter-btn {{ $status === 'in_progress' ? 'active' : '' }}">In Progress</a>
    <a href="{{ route('partner.tickets', ['status'=>'closed']) }}" class="filter-btn {{ $status === 'closed' ? 'active' : '' }}">Closed</a>
</div>

{{-- Table --}}
<div class="card">
    @if($tickets->count() > 0)
        <div style="overflow-x:auto;">
            <table class="ticket-table">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td>
                            <span style="font-family:'Poppins', sans-serif;font-weight:700;font-size:.8rem;background:#f1f5f9;color:#475569;padding:.2rem .55rem;border-radius:.4rem;">
                                #TKT-{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <span style="font-weight:600;color:#1e293b;">{{ Str::limit($ticket->subject, 45) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $ticket->priority }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $ticket->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                            </span>
                        </td>
                        <td style="color:#64748b;font-size:.8rem;">
                            {{ $ticket->created_at->format('d M Y') }}<br>
                            <span style="color:#94a3b8;">{{ $ticket->created_at->diffForHumans() }}</span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('partner.tickets.show', $ticket) }}" class="btn-view">
                                <i data-lucide="eye" class="w-3 h-3"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1rem 1.25rem;border-top:1px solid #f1f5f9;">
            {{ $tickets->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i data-lucide="life-buoy" class="w-10 h-10"></i>
            </div>
            <h3>No tickets yet</h3>
            <p>You haven't raised any support tickets. If you need help, we're here.</p>
            <a href="{{ route('partner.tickets.create') }}" class="btn-primary" style="display:inline-flex;">
                <i data-lucide="plus" class="w-4 h-4"></i> Open First Ticket
            </a>
        </div>
    @endif
</div>
@endsection
