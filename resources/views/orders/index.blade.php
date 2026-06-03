@extends('layouts.app')
@section('title', 'My Orders — SK Solutions')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection


@push('styles')
<style>
    /* ── Stats Strip ── */
    .stats-strip { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 1.5rem; }
    @media (min-width: 640px) { .stats-strip { grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; margin-bottom: 2rem; } }
    .stat-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1rem 1.25rem; display: flex; flex-direction: column; gap: 0.4rem; }
    @media (min-width: 640px) { .stat-card { padding: 1.25rem 1.5rem; } }
    .stat-card .stat-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #94a3b8; }
    .stat-card .stat-value { font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1; }
    @media (min-width: 640px) { .stat-card .stat-value { font-size: 1.75rem; } }
    .stat-card .stat-sub { font-size: 0.78rem; color: #64748b; }

    /* ── Page Header ── */
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; }
    .page-header h1 { font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.25rem; }
    @media (min-width: 640px) { .page-header h1 { font-size: 1.6rem; } }
    .page-header p  { font-size: 0.875rem; color: #64748b; margin: 0; }

    /* ── Filter Bar ── */
    .filter-bar { display: flex; gap: 0.5rem; margin-bottom: 1.25rem; overflow-x: auto; padding-bottom: 4px; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
    .filter-bar::-webkit-scrollbar { display: none; }
    .filter-btn { padding: 0.4rem 0.9rem; border-radius: 999px; border: 1px solid #e2e8f0; font-size: 0.8rem; font-weight: 600; cursor: pointer; background: #fff; color: #64748b; text-decoration: none; transition: all 0.15s; white-space: nowrap; flex-shrink: 0; }
    .filter-btn:hover, .filter-btn.active { background: #6366f1; border-color: #6366f1; color: #fff; }

    /* ── Table ── */
    .orders-table { width: 100%; border-collapse: collapse; min-width: 560px; }
    .orders-table thead th { padding: 0.65rem 1rem; text-align: left; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b; background: #f8fafc; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
    .orders-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.12s; }
    .orders-table tbody tr:last-child { border-bottom: none; }
    .orders-table tbody tr:hover { background: #f8fafc; }
    .orders-table tbody td { padding: 0.85rem 1rem; font-size: 0.875rem; color: #334155; vertical-align: middle; }


    /* ── Status Badges ── */
    .badge { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.25rem 0.7rem; border-radius: 999px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
    .badge-pending   { background: #fef3c7; color: #92400e; }
    .badge-paid      { background: #d1fae5; color: #065f46; }
    .badge-processing{ background: #dbeafe; color: #1e40af; }
    .badge-completed { background: #ede9fe; color: #4c1d95; }
    .badge-cancelled { background: #fee2e2; color: #991b1b; }

    .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* ── Order ID ── */
    .order-id { font-weight: 700; color: #0f172a; font-size: 0.875rem; }
    .order-date { font-size: 0.75rem; color: #94a3b8; margin-top: 0.2rem; }

    /* ── Amount ── */
    .amount { font-weight: 700; color: #4f46e5; }

    /* ── Action Button ── */
    .btn-view { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.85rem; border-radius: 0.5rem; background: #eef2ff; color: #4f46e5; font-size: 0.78rem; font-weight: 700; text-decoration: none; transition: background 0.15s; }
    .btn-view:hover { background: #6366f1; color: #fff; }
    .btn-pay { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.85rem; border-radius: 0.5rem; background: #fef3c7; color: #92400e; font-size: 0.78rem; font-weight: 700; text-decoration: none; margin-left: 0.4rem; transition: background 0.15s; }
    .btn-pay:hover { background: #f59e0b; color: #fff; }

    /* ── New Order Button ── */
    .btn-primary { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem; border-radius: 0.65rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-size: 0.875rem; font-weight: 700; text-decoration: none; box-shadow: 0 4px 14px rgba(99,102,241,0.3); transition: transform 0.15s, box-shadow 0.15s; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.4); color: #fff; }

    /* ── Card Wrap ── */
    .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }

    /* ── Empty State ── */
    .empty-state { text-align: center; padding: 5rem 2rem; }
    .empty-icon { display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; border-radius: 50%; background: #f1f5f9; color: #94a3b8; margin-bottom: 1.25rem; }
    .empty-state h3 { font-size: 1.15rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem; }
    .empty-state p { color: #64748b; font-size: 0.875rem; margin: 0 0 1.5rem; }

    /* ── Pagination ── */
    .pagination-wrap { padding: 1rem 1.25rem; border-top: 1px solid #f1f5f9; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1>My Orders</h1>
        <p>Track the status of your service requests and manage payments.</p>
    </div>
    <a href="{{ route('partner.services') }}" class="btn-primary" id="btn-new-order">
        <i data-lucide="plus" class="w-4 h-4"></i> New Order
    </a>
</div>

{{-- Stats Strip --}}
@php
    $all         = $orders->total();
    $pending     = $orders->getCollection()->where('status', 'pending')->count();
    $paid        = $orders->getCollection()->where('status', 'paid')->count();
    $completed   = $orders->getCollection()->where('status', 'completed')->count();
    $totalAmount = $orders->getCollection()->sum('amount');
@endphp

<div class="stats-strip">
    <div class="stat-card">
        <span class="stat-label">Total Orders</span>
        <span class="stat-value">{{ $orders->total() }}</span>
        <span class="stat-sub">All time</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Pending Payment</span>
        <span class="stat-value" style="color:#d97706;">{{ $orders->getCollection()->where('status','pending')->count() }}</span>
        <span class="stat-sub">Awaiting payment</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">In Progress</span>
        <span class="stat-value" style="color:#2563eb;">{{ $orders->getCollection()->whereIn('status',['paid','processing'])->count() }}</span>
        <span class="stat-sub">Being worked on</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Completed</span>
        <span class="stat-value" style="color:#7c3aed;">{{ $orders->getCollection()->where('status','completed')->count() }}</span>
        <span class="stat-sub">Delivered</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Total Spent</span>
        <span class="stat-value" style="color:#4f46e5;font-size:1.4rem;">₹{{ number_format($orders->getCollection()->where('status','!=','pending')->sum('amount'), 0) }}</span>
        <span class="stat-sub">Paid orders only</span>
    </div>
</div>

{{-- Filter bar --}}
@php $status = request('status', 'all'); @endphp
<div class="filter-bar">
    <a href="{{ route('partner.orders') }}" class="filter-btn {{ $status === 'all' ? 'active' : '' }}">All</a>
    <a href="{{ route('partner.orders', ['status' => 'pending']) }}" class="filter-btn {{ $status === 'pending' ? 'active' : '' }}">Pending</a>
    <a href="{{ route('partner.orders', ['status' => 'paid']) }}" class="filter-btn {{ $status === 'paid' ? 'active' : '' }}">Paid</a>
    <a href="{{ route('partner.orders', ['status' => 'processing']) }}" class="filter-btn {{ $status === 'processing' ? 'active' : '' }}">Processing</a>
    <a href="{{ route('partner.orders', ['status' => 'completed']) }}" class="filter-btn {{ $status === 'completed' ? 'active' : '' }}">Completed</a>
    <a href="{{ route('partner.orders', ['status' => 'cancelled']) }}" class="filter-btn {{ $status === 'cancelled' ? 'active' : '' }}">Cancelled</a>
</div>

{{-- Alert --}}
@if(session('success'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;border-radius:0.65rem;padding:0.75rem 1rem;font-size:0.875rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
        <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
    </div>
@endif

{{-- Orders Table --}}
<div class="card">
    @if($orders->count() > 0)
        <div style="overflow-x:auto;">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        @php
                            $badgeClass = match($order->status) {
                                'paid'       => 'badge-paid',
                                'processing' => 'badge-processing',
                                'completed'  => 'badge-completed',
                                'cancelled'  => 'badge-cancelled',
                                default      => 'badge-pending',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="order-id">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="order-date">{{ $order->created_at->format('d M Y') }}</div>
                            </td>
                            <td>
                                <span style="font-weight:600;color:#1e293b;">{{ optional($order->service)->name ?? $order->lead->service_needed ?? '—' }}</span>
                                <br>
                                <span style="font-size:0.75rem;color:#94a3b8;">{{ Str::limit($order->requirements, 40) }}</span>
                            </td>
                            <td class="amount">₹{{ number_format($order->amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    <span class="badge-dot"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td style="color:#64748b;">{{ $order->created_at->diffForHumans() }}</td>
                            <td style="text-align:right;">
                                @php
                                    $viewRoute = auth()->user()->isPartner()
                                        ? route('partner.orders.show', $order)
                                        : route('customer.order.show', $order);
                                @endphp
                                <a href="{{ $viewRoute }}" class="btn-view">
                                    <i data-lucide="eye" class="w-3 h-3"></i> View
                                </a>
                                @if($order->status === 'pending')
                                    <a href="{{ route('payment.create', $order) }}" class="btn-pay">
                                        <i data-lucide="credit-card" class="w-3 h-3"></i> Pay
                                    </a>
                                @endif
                                @if(in_array($order->status, ['paid', 'processing', 'in_progress', 'completed']))
                                    @php
                                        $invRoute = auth()->user()->isPartner() 
                                            ? route('partner.orders.invoice', $order) 
                                            : route('customer.orders.invoice', $order);
                                    @endphp
                                    <a href="{{ $invRoute }}" target="_blank" class="btn-pay" style="background:#ede9fe;color:#4c1d95;">
                                        <i data-lucide="download" class="w-3 h-3"></i> Invoice
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i data-lucide="package" class="w-10 h-10"></i>
            </div>
            <h3>No orders yet</h3>
            <p>You haven't placed any service orders. Browse our services to get started.</p>
            <a href="{{ route('partner.services') }}" class="btn-primary" style="display:inline-flex;">
                <i data-lucide="shopping-bag" class="w-4 h-4"></i> Browse Services
            </a>
        </div>
    @endif
</div>
@endsection
