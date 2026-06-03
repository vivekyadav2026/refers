@extends('layouts.app')

@section('title', 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' — SK Solutions')
@section('sidebar')
    <!-- This enables the sidebar -->

@endsection

@push('styles')
<style>
    .page-back { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.82rem; font-weight: 600; color: #6366f1; text-decoration: none; margin-bottom: 1rem; }
    .page-back:hover { color: #4338ca; }

    .page-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; }
    .page-header h1 { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 0.25rem; }
    .page-header p  { font-size: 0.85rem; color: #64748b; margin: 0; }

    .header-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; }
    .btn-primary { display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.65rem 1.25rem; border-radius: 0.65rem; background: linear-gradient(135deg,#6366f1,#8b5cf6); color: #fff; font-size: 0.875rem; font-weight: 700; text-decoration: none; box-shadow: 0 4px 14px rgba(99,102,241,.3); transition: transform .15s, box-shadow .15s; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.4); color: #fff; }
    .btn-outline { display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.65rem 1.25rem; border-radius: 0.65rem; background: #fff; border: 1px solid #e2e8f0; color: #334155; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: background .15s; }
    .btn-outline:hover { background: #f8fafc; color: #1e293b; }

    .grid-layout { display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; }
    @media(max-width:900px) { .grid-layout { grid-template-columns: 1fr; } }

    .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.04); margin-bottom: 1.25rem; }
    .card-header { padding: 1.1rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 0.65rem; background: #fafbfc; }
    .card-header h3 { font-size: 0.95rem; font-weight: 700; color: #0f172a; margin: 0; }
    .card-header-icon { width: 32px; height: 32px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; background: #eef2ff; color: #6366f1; }
    .card-body { padding: 1.5rem; }

    /* ── Badge ── */
    .badge { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.3rem 0.85rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
    .badge-pending   { background:#fef3c7; color:#92400e; }
    .badge-paid      { background:#d1fae5; color:#065f46; }
    .badge-processing{ background:#dbeafe; color:#1e40af; }
    .badge-completed { background:#ede9fe; color:#4c1d95; }
    .badge-cancelled { background:#fee2e2; color:#991b1b; }
    .badge-dot { width:6px;height:6px;border-radius:50%;background:currentColor; }

    /* ── Summary rows ── */
    .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; }
    .summary-row:last-child { border-bottom: none; }
    .summary-label { font-size: 0.82rem; color: #64748b; }
    .summary-value { font-size: 0.875rem; font-weight: 600; color: #1e293b; }
    .summary-total { display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; margin-top: 0.5rem; border-top: 2px solid #e2e8f0; }
    .summary-total .label { font-size: 1rem; font-weight: 800; color: #0f172a; }
    .summary-total .value { font-size: 1.25rem; font-weight: 800; color: #4f46e5; }

    /* ── Timeline ── */
    .timeline { position: relative; padding-left: 1.5rem; }
    .timeline::before { content:''; position:absolute; left:0.6rem; top:0; bottom:0; width:2px; background:#e2e8f0; }
    .tl-item { position:relative; padding-bottom: 2rem; }
    .tl-item:last-child { padding-bottom: 0; }
    .tl-dot { position:absolute; left:-1.5rem; top:0.15rem; width:1.15rem; height:1.15rem; border-radius:50%; border:3px solid #fff; box-shadow:0 0 0 2px #e2e8f0; background:#cbd5e1; }
    .tl-dot.done { background:#6366f1; box-shadow:0 0 0 2px #6366f1, 0 0 0 4px #eef2ff; }
    .tl-dot.current { background:#f59e0b; box-shadow:0 0 0 2px #f59e0b, 0 0 0 4px #fef3c7; }
    .tl-title { font-size:0.875rem; font-weight:700; color:#1e293b; margin-bottom:0.2rem; }
    .tl-time  { font-size:0.75rem; color:#94a3b8; }
    .tl-desc  { font-size:0.8rem; color:#64748b; margin-top:0.25rem; }

    /* ── Requirements ── */
    .requirements-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:0.65rem; padding:1.25rem; font-size:0.875rem; color:#334155; line-height:1.75; white-space:pre-wrap; }

    /* ── Review Form ── */
    .review-label { font-size:0.8rem; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:.04em; margin-bottom:.5rem; display:block; }
    .review-input { width:100%; border:1px solid #d1d5db; border-radius:.5rem; padding:.65rem .85rem; font-size:.875rem; color:#1e293b; transition:border-color .2s,box-shadow .2s; background:#fff; box-sizing:border-box; }
    .review-input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.15); }
    .star-group { display:flex; gap:.5rem; margin-bottom:.25rem; }
    .star-group input[type=radio] { display:none; }
    .star-group label { font-size:1.5rem; cursor:pointer; color:#cbd5e1; transition:color .15s; }
    .star-group input[type=radio]:checked ~ label,
    .star-group label:hover, .star-group label:hover ~ label { color:#f59e0b; }
    .stars-wrap { display:flex; flex-direction:row-reverse; }
    .stars-wrap label:hover,
    .stars-wrap label:hover ~ label { color:#f59e0b !important; }

    .alert-success { background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; border-radius:.65rem; padding:.75rem 1rem; font-size:.875rem; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }
</style>
@endpush

@section('content')

@php
    $role = auth()->user()->isPartner() ? 'partner' : (auth()->user()->isAdmin() ? 'admin' : 'customer');
    $ordersRoute = $role === 'partner' ? route('partner.orders') : ($role === 'admin' ? route('admin.orders') : route('customer.orders'));
    $invoiceRoute = $role === 'partner' ? route('partner.orders.invoice', $order) : ($role === 'admin' ? route('admin.orders.invoice', $order) : route('customer.orders.invoice', $order));
@endphp
{{-- Back Link --}}
<a href="{{ $ordersRoute }}" class="page-back">
    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Orders
</a>

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1>Order #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
        <p>Placed on {{ $order->created_at->format('d M Y, h:i A') }} &nbsp;·&nbsp;
            @php
                $badgeClass = match($order->status) {
                    'paid'       => 'badge-paid',
                    'processing' => 'badge-processing',
                    'completed'  => 'badge-completed',
                    'cancelled'  => 'badge-cancelled',
                    default      => 'badge-pending',
                };
            @endphp
            <span class="badge {{ $badgeClass }}">
                <span class="badge-dot"></span> {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>
    <div class="header-actions">
        @if($order->status === 'pending')
            <a href="{{ route('payment.create', $order) }}" class="btn-primary">
                <i data-lucide="credit-card" class="w-4 h-4"></i> Pay Now
            </a>
        @endif
        @if(in_array($order->status, ['paid', 'processing', 'in_progress', 'completed']))
            <a href="{{ $invoiceRoute }}" target="_blank" class="btn-outline">
                <i data-lucide="download" class="w-4 h-4"></i> Download Invoice
            </a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
    </div>
@endif

<div class="grid-layout">

    {{-- ── Left Column ── --}}
    <div>

        {{-- Requirements --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="file-text" class="w-4 h-4"></i></div>
                <h3>Your Requirements</h3>
            </div>
            <div class="card-body">
                <div class="requirements-box">{{ $order->requirements }}</div>
            </div>
        </div>

        {{-- Order Tracking --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="activity" class="w-4 h-4"></i></div>
                <h3>Order Tracking</h3>
            </div>
            <div class="card-body">
                <div class="timeline">

                    {{-- Step 1: Placed --}}
                    <div class="tl-item">
                        <div class="tl-dot done"></div>
                        <div class="tl-title">Order Placed</div>
                        <div class="tl-time">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                        <div class="tl-desc">Your order has been received and is awaiting payment.</div>
                    </div>

                    {{-- Step 2: Payment --}}
                    <div class="tl-item">
                        <div class="tl-dot {{ in_array($order->status, ['paid','processing','completed']) ? 'done' : ($order->status === 'pending' ? 'current' : '') }}"></div>
                        <div class="tl-title" style="color:{{ in_array($order->status, ['paid','processing','completed']) ? '#1e293b' : '#94a3b8' }}">Payment Confirmed</div>
                        @if(in_array($order->status, ['paid','processing','completed']))
                            <div class="tl-time">{{ $order->updated_at->format('d M Y, h:i A') }}</div>
                            <div class="tl-desc">Payment received. Our team has been notified.</div>
                        @else
                            <div class="tl-desc" style="color:#94a3b8;">Waiting for payment.</div>
                        @endif
                    </div>

                    {{-- Step 3: In Progress --}}
                    <div class="tl-item">
                        <div class="tl-dot {{ in_array($order->status, ['processing','completed']) ? 'done' : ($order->status === 'paid' ? 'current' : '') }}"></div>
                        <div class="tl-title" style="color:{{ in_array($order->status, ['processing','completed']) ? '#1e293b' : '#94a3b8' }}">In Progress</div>
                        @if(in_array($order->status, ['processing','completed']))
                            <div class="tl-desc">Our team is actively working on your order.</div>
                        @else
                            <div class="tl-desc" style="color:#94a3b8;">Work will begin after payment.</div>
                        @endif
                    </div>

                    {{-- Step 4: Completed --}}
                    <div class="tl-item">
                        <div class="tl-dot {{ $order->status === 'completed' ? 'done' : '' }}"></div>
                        <div class="tl-title" style="color:{{ $order->status === 'completed' ? '#1e293b' : '#94a3b8' }}">Order Completed</div>
                        @if($order->status === 'completed')
                            <div class="tl-desc">Your order has been delivered. Thank you!</div>
                        @else
                            <div class="tl-desc" style="color:#94a3b8;">Pending delivery.</div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- Review Section --}}
        @if($order->status === 'completed')
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon"><i data-lucide="star" class="w-4 h-4"></i></div>
                    <h3>Rate Your Experience</h3>
                </div>
                <div class="card-body">
                    @if($order->review)
                        <div style="display:flex;align-items:center;gap:.25rem;margin-bottom:.75rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-5 h-5" style="color:{{ $i <= $order->review->rating ? '#f59e0b' : '#cbd5e1' }};fill:{{ $i <= $order->review->rating ? '#f59e0b' : 'none' }}"></i>
                            @endfor
                            <span style="margin-left:.5rem;font-size:.875rem;font-weight:700;color:#374151;">{{ $order->review->rating }}/5</span>
                        </div>
                        <p style="font-size:.875rem;color:#4b5563;font-style:italic;border-left:3px solid #6366f1;padding-left:.75rem;margin:0;">"{{ $order->review->comment }}"</p>
                    @else
                        <form action="{{ route('partner.reviews.store', $order) }}" method="POST">
                            @csrf
                            <div style="margin-bottom:1.25rem;">
                                <label class="review-label">Star Rating</label>
                                <div class="stars-wrap" style="display:flex;flex-direction:row-reverse;gap:.25rem;font-size:2rem;margin-bottom:.5rem;">
                                    @foreach([5,4,3,2,1] as $star)
                                        <input type="radio" id="star{{ $star }}" name="rating" value="{{ $star }}" {{ old('rating') == $star ? 'checked' : '' }} required>
                                        <label for="star{{ $star }}" style="cursor:pointer;color:#cbd5e1;font-size:2rem;transition:color .15s;" onmouseover="highlightStars({{ $star }})" onmouseout="resetStars()">★</label>
                                    @endforeach
                                </div>
                                @error('rating')<p style="color:#ef4444;font-size:.78rem;">{{ $message }}</p>@enderror
                            </div>
                            <div style="margin-bottom:1.25rem;">
                                <label class="review-label" for="review-comment">Your Comment</label>
                                <textarea id="review-comment" name="comment" rows="4" class="review-input" placeholder="Share your experience with this service...">{{ old('comment') }}</textarea>
                                @error('comment')<p style="color:#ef4444;font-size:.78rem;">{{ $message }}</p>@enderror
                            </div>
                            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                                <i data-lucide="send" class="w-4 h-4"></i> Submit Review
                            </button>
                        </form>
                        <script>
                            const labels = document.querySelectorAll('.stars-wrap label');
                            function highlightStars(n) {
                                labels.forEach((l,i) => l.style.color = (labels.length - i) <= n ? '#f59e0b' : '#cbd5e1');
                            }
                            function resetStars() {
                                const checked = document.querySelector('.stars-wrap input:checked');
                                const val = checked ? parseInt(checked.value) : 0;
                                labels.forEach((l,i) => l.style.color = (labels.length - i) <= val ? '#f59e0b' : '#cbd5e1');
                            }
                        </script>
                    @endif
                </div>
            </div>
        @endif

    </div>{{-- /left --}}

    {{-- ── Right Column ── --}}
    <div>

        {{-- Order Summary --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="receipt" class="w-4 h-4"></i></div>
                <h3>Order Summary</h3>
            </div>
            <div class="card-body" style="padding:1.25rem 1.5rem;">
                <div class="summary-row">
                    <span class="summary-label">Order ID</span>
                    <span class="summary-value">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Service</span>
                    <span class="summary-value" style="text-align:right;max-width:180px;">{{ optional($order->service)->name ?? $order->lead->service_needed ?? '—' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Status</span>
                    <span class="badge {{ $badgeClass }}"><span class="badge-dot"></span> {{ ucfirst($order->status) }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Placed On</span>
                    <span class="summary-value">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                @if($order->lead)
                <div class="summary-row">
                    <span class="summary-label">Lead</span>
                    <span class="summary-value">{{ $order->lead->name ?? '—' }}</span>
                </div>
                @endif
                <div class="summary-total">
                    <span class="label">Total Amount</span>
                    <span class="value">₹{{ number_format($order->amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="zap" class="w-4 h-4"></i></div>
                <h3>Quick Actions</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.65rem;padding:1.25rem;">
                @if($order->status === 'pending')
                    <a href="{{ route('payment.create', $order) }}" class="btn-primary" style="justify-content:center;">
                        <i data-lucide="credit-card" class="w-4 h-4"></i> Complete Payment
                    </a>
                @endif
                @if(in_array($order->status, ['paid', 'processing', 'in_progress', 'completed']))
                    <a href="{{ $invoiceRoute }}" target="_blank" class="btn-outline" style="justify-content:center;">
                        <i data-lucide="file-down" class="w-4 h-4"></i> Download Invoice PDF
                    </a>
                @endif
                <a href="{{ $ordersRoute }}" class="btn-outline" style="justify-content:center;">
                    <i data-lucide="list" class="w-4 h-4"></i> All My Orders
                </a>
                @php
                    $servicesRoute = $role === 'partner' ? route('partner.services') : route('customer.services.index');
                @endphp
                <a href="{{ $servicesRoute }}" class="btn-outline" style="justify-content:center;">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i> Place New Order
                </a>
                @if($order->status === 'pending')
                    <div style="font-size:.75rem;color:#94a3b8;text-align:center;padding-top:.25rem;">
                        <i data-lucide="clock" class="w-3 h-3" style="display:inline;vertical-align:middle;"></i>
                        Payment pending — your order is reserved
                    </div>
                @endif
            </div>
        </div>

        {{-- Need Help? --}}
        <div class="card" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);border:none;">
            <div class="card-body" style="padding:1.5rem;text-align:center;">
                <i data-lucide="headphones" class="w-8 h-8" style="color:#c7d2fe;margin-bottom:.75rem;"></i>
                <p style="font-size:.875rem;font-weight:700;color:#fff;margin:0 0 .4rem;">Need Help?</p>
                <p style="font-size:.78rem;color:#c7d2fe;margin:0 0 1rem;">Raise a support ticket for any issues with this order.</p>
                @if($role === 'partner')
                    <a href="{{ route('partner.tickets.create') }}" style="display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.1rem;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);color:#fff;border-radius:.5rem;font-size:.8rem;font-weight:700;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,.25)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                        <i data-lucide="message-circle" class="w-4 h-4"></i> Open Ticket
                    </a>
                @else
                    <a href="{{ route('contact') }}" style="display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.1rem;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);color:#fff;border-radius:.5rem;font-size:.8rem;font-weight:700;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,.25)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                        <i data-lucide="mail" class="w-4 h-4"></i> Contact Support
                    </a>
                @endif
            </div>
        </div>

    </div>{{-- /right --}}

</div>{{-- /grid --}}
@endsection
