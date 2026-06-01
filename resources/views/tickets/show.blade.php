@extends('layouts.app')

@section('title', 'Ticket #TKT-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT) . ' — SK Solutions')
@section('sidebar') 
    <!-- This enables the sidebar -->

@endsection

@push('styles')
<style>
    .page-back { display:inline-flex; align-items:center; gap:.4rem; font-size:.82rem; font-weight:600; color:#6366f1; text-decoration:none; margin-bottom:1rem; }
    .page-back:hover { color:#4338ca; }

    .ticket-layout { display:grid; grid-template-columns:1fr 280px; gap:1.75rem; max-width:1000px; }
    @media(max-width:820px) { .ticket-layout { grid-template-columns:1fr; } }

    .card { background:#fff; border:1px solid #e2e8f0; border-radius:1rem; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.04); }
    .card-header { padding:1rem 1.4rem; border-bottom:1px solid #f1f5f9; background:#fafbfc; display:flex; align-items:center; gap:.65rem; }
    .card-header h3 { font-size:.9rem; font-weight:700; color:#0f172a; margin:0; }
    .card-header-icon { width:30px; height:30px; border-radius:.5rem; background:#eef2ff; color:#6366f1; display:flex; align-items:center; justify-content:center; }

    /* Badges */
    .badge { display:inline-flex; align-items:center; gap:.3rem; padding:.25rem .7rem; border-radius:999px; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
    .badge-open { background:#d1fae5; color:#065f46; }
    .badge-in_progress { background:#dbeafe; color:#1e40af; }
    .badge-closed { background:#f1f5f9; color:#64748b; }
    .badge-high { background:#fee2e2; color:#991b1b; }
    .badge-medium { background:#fef3c7; color:#92400e; }
    .badge-low { background:#dbeafe; color:#1e40af; }
    .badge-dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

    /* Conversation */
    .messages-area { padding:1.5rem; display:flex; flex-direction:column; gap:1.25rem; min-height:300px; }
    .msg-wrap { display:flex; gap:.75rem; }
    .msg-wrap.is-me { flex-direction:row-reverse; }
    .msg-avatar { width:34px; height:34px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:.75rem; }
    .msg-avatar.partner { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; }
    .msg-avatar.admin   { background:#f1f5f9; color:#475569; }
    .msg-bubble { max-width:520px; }
    .msg-meta { font-size:.72rem; color:#94a3b8; margin-bottom:.3rem; display:flex; align-items:center; gap:.4rem; }
    .msg-wrap.is-me .msg-meta { flex-direction:row-reverse; }
    .msg-text {
        padding:.85rem 1.1rem; border-radius:1rem; font-size:.875rem; line-height:1.65; white-space:pre-wrap;
    }
    .msg-text.partner { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-radius:1rem 1rem .25rem 1rem; }
    .msg-text.admin   { background:#f1f5f9; color:#1e293b; border-radius:1rem 1rem 1rem .25rem; }

    /* Reply box */
    .reply-form { padding:1.25rem 1.4rem; border-top:1px solid #f1f5f9; background:#fafbfc; }
    .reply-textarea { width:100%; border:1.5px solid #d1d5db; border-radius:.65rem; padding:.75rem 1rem; font-size:.875rem; color:#1e293b; background:#fff; resize:none; font-family:'Poppins', sans-serif; transition:border-color .2s,box-shadow .2s; box-sizing:border-box; }
    .reply-textarea:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.15); }
    .btn-reply { display:inline-flex; align-items:center; gap:.4rem; padding:.65rem 1.25rem; border-radius:.6rem; background:#6366f1; color:#fff; border:none; font-size:.875rem; font-weight:700; cursor:pointer; font-family:'Poppins', sans-serif; transition:background .15s; }
    .btn-reply:hover { background:#4f46e5; }

    /* Info sidebar */
    .info-item { display:flex; justify-content:space-between; align-items:center; padding:.55rem 0; border-bottom:1px solid #f1f5f9; font-size:.82rem; }
    .info-item:last-child { border-bottom:none; }
    .info-label { color:#94a3b8; font-weight:600; }
    .info-value { font-weight:700; color:#0f172a; }

    .closed-notice { padding:1.25rem; text-align:center; }
    .closed-notice p { font-size:.85rem; color:#94a3b8; display:flex; align-items:center; justify-content:center; gap:.4rem; margin:0; }
</style>
@endpush

@section('content')

<a href="{{ route('partner.tickets') }}" class="page-back">
    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Tickets
</a>

@php
    $ticketId = str_pad($ticket->id, 5, '0', STR_PAD_LEFT);
@endphp

<h1 style="font-size:1.4rem;font-weight:800;color:#0f172a;margin:0 0 .25rem;">{{ $ticket->subject }}</h1>
<p style="font-size:.8rem;color:#94a3b8;margin:0 0 1.75rem;">
    Ticket #TKT-{{ $ticketId }}
    &nbsp;·&nbsp; Opened {{ $ticket->created_at->format('d M Y, h:i A') }}
</p>

{{-- Flash --}}
@if(session('success'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;border-radius:.65rem;padding:.75rem 1rem;font-size:.875rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;">
        <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
    </div>
@endif

<div class="ticket-layout">

    {{-- LEFT: Conversation --}}
    <div>
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="message-circle" class="w-4 h-4"></i></div>
                <h3>Conversation</h3>
                <span style="margin-left:auto;font-size:.72rem;color:#94a3b8;">{{ $ticket->messages->count() }} messages</span>
            </div>

            <div class="messages-area" id="messages-area">
                @forelse($ticket->messages as $msg)
                    @php
                        $isPartner = $msg->user_id === auth()->id();
                        $initials  = strtoupper(substr($msg->user->name ?? 'A', 0, 2));
                        $isAdmin   = in_array($msg->user->role ?? '', ['admin','superadmin']);
                    @endphp
                    <div class="msg-wrap {{ $isPartner ? 'is-me' : '' }}">
                        <div class="msg-avatar {{ $isPartner ? 'partner' : 'admin' }}">{{ $initials }}</div>
                        <div class="msg-bubble">
                            <div class="msg-meta">
                                <strong>{{ $msg->user->name ?? 'Support' }}</strong>
                                @if($isAdmin)<span style="background:#eef2ff;color:#6366f1;font-size:.65rem;padding:.1rem .4rem;border-radius:999px;font-weight:700;">ADMIN</span>@endif
                                <span>{{ $msg->created_at->format('d M, h:i A') }}</span>
                            </div>
                            <div class="msg-text {{ $isPartner ? 'partner' : 'admin' }}">{{ $msg->message }}</div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:3rem;color:#94a3b8;">
                        <i data-lucide="message-circle" style="width:40px;height:40px;margin:0 auto 1rem;display:block;opacity:.5;"></i>
                        <p style="font-size:.875rem;margin:0;">No messages yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Reply / Closed State --}}
            @if($ticket->status !== 'closed')
                <div class="reply-form">
                    <form action="{{ route('partner.tickets.message', $ticket) }}" method="POST">
                        @csrf
                        <textarea name="message" rows="4" class="reply-textarea"
                            placeholder="Type your reply here..." required></textarea>
                        <div style="display:flex;justify-content:flex-end;margin-top:.75rem;">
                            <button type="submit" class="btn-reply">
                                <i data-lucide="send" class="w-4 h-4"></i> Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="closed-notice">
                    <p><i data-lucide="lock" class="w-4 h-4"></i> This ticket is closed. Open a new one if you need further help.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: Info --}}
    <div>
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="info" class="w-4 h-4"></i></div>
                <h3>Ticket Info</h3>
            </div>
            <div style="padding:1.25rem 1.4rem;">
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="badge badge-{{ $ticket->status }}">
                        <span class="badge-dot"></span>
                        {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Priority</span>
                    <span class="badge badge-{{ $ticket->priority }}">
                        <span class="badge-dot"></span>
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Messages</span>
                    <span class="info-value">{{ $ticket->messages->count() }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Opened</span>
                    <span class="info-value" style="font-size:.78rem;">{{ $ticket->created_at->format('d M Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Updated</span>
                    <span class="info-value" style="font-size:.78rem;">{{ $ticket->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-header-icon" style="background:#fef3c7;color:#d97706;"><i data-lucide="help-circle" class="w-4 h-4"></i></div>
                <h3>Need More Help?</h3>
            </div>
            <div style="padding:1.25rem 1.4rem;font-size:.82rem;color:#64748b;line-height:1.6;">
                <p style="margin:0 0 .75rem;">Our team typically responds within <strong>2–4 business hours</strong> during business days.</p>
                <a href="{{ route('partner.tickets.create') }}" style="display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;font-weight:700;color:#6366f1;text-decoration:none;">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Open Another Ticket
                </a>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    // Scroll messages area to bottom
    const area = document.getElementById('messages-area');
    if (area) area.scrollTop = area.scrollHeight;
</script>
@endpush
@endsection
