@extends('layouts.app')

@section('title', 'Ticket #TKT-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT) . ' - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
@php
    $ticketId = str_pad($ticket->id, 5, '0', STR_PAD_LEFT);
    $statusConfig = match($ticket->status) {
        'in_progress' => ['bg-indigo-100 text-indigo-800 border-indigo-200', 'loader',       'In Progress'],
        'closed'      => ['bg-slate-100 text-slate-600 border-slate-200',   'check-circle', 'Closed'],
        default       => ['bg-emerald-100 text-emerald-800 border-emerald-200','inbox',      'Open'],
    };
    $priorityConfig = match($ticket->priority) {
        'high'  => ['bg-red-100 text-red-800 border-red-200',     'alert-triangle', 'High'],
        'low'   => ['bg-blue-100 text-blue-800 border-blue-200',  'arrow-down',     'Low'],
        default => ['bg-amber-100 text-amber-800 border-amber-200','minus',          'Medium'],
    };
@endphp

<div class="py-8 w-full max-w-6xl mx-auto">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 text-sm font-medium">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Back -->
    <div class="mb-6">
        <a href="{{ route('admin.tickets') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Tickets
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: Conversation -->
        <div class="lg:col-span-2 flex flex-col gap-5">

            <!-- Ticket Header -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <span class="font-mono text-xs font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg">#TKT-{{ $ticketId }}</span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusConfig[0] }}">
                                <i data-lucide="{{ $statusConfig[1] }}" class="w-3 h-3"></i>{{ $statusConfig[2] }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $priorityConfig[0] }}">
                                <i data-lucide="{{ $priorityConfig[1] }}" class="w-3 h-3"></i>{{ $priorityConfig[2] }}
                            </span>
                        </div>
                        <h1 class="text-xl font-bold text-slate-900">{{ $ticket->subject }}</h1>
                        <p class="text-sm text-slate-500 mt-1">
                            By <span class="font-medium text-slate-700">{{ $ticket->user->name ?? 'Unknown' }}</span>
                            &nbsp;·&nbsp; {{ $ticket->created_at->format('M d, Y h:i A') }}
                            &nbsp;·&nbsp; {{ $ticket->messages->count() }} {{ Str::plural('reply', $ticket->messages->count()) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Conversation Messages -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                    <i data-lucide="message-circle" class="w-4 h-4 text-slate-400"></i>
                    <h2 class="text-sm font-bold text-slate-700">Conversation</h2>
                    <span class="ml-auto text-xs text-slate-400">{{ $ticket->messages->count() }} messages</span>
                </div>

                <div class="p-6 space-y-6 min-h-64">
                    @forelse($ticket->messages as $msg)
                    @php
                        $isAdmin   = in_array($msg->user->role ?? '', ['admin', 'superadmin']);
                        $isMe      = $msg->user_id === auth()->id();
                        $initials  = strtoupper(substr($msg->user->name ?? 'A', 0, 2));
                    @endphp

                    <div class="flex gap-3 {{ $isAdmin ? 'flex-row-reverse' : 'flex-row' }}">
                        <!-- Avatar -->
                        <div class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm
                            {{ $isAdmin ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white' : 'bg-slate-200 text-slate-700' }}">
                            {{ $initials }}
                        </div>
                        <!-- Bubble -->
                        <div class="flex flex-col {{ $isAdmin ? 'items-end' : 'items-start' }} max-w-lg">
                            <div class="flex items-center gap-2 mb-1 {{ $isAdmin ? 'flex-row-reverse' : '' }}">
                                <span class="text-xs font-semibold text-slate-700">
                                    {{ $msg->user->name ?? 'Deleted User' }}
                                    @if($isAdmin)
                                        <span class="text-indigo-600 font-bold ml-1">· Admin</span>
                                    @endif
                                </span>
                                <span class="text-xs text-slate-400">{{ $msg->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed whitespace-pre-wrap
                                {{ $isAdmin
                                    ? 'bg-indigo-600 text-white rounded-tr-sm shadow-sm'
                                    : 'bg-slate-100 text-slate-800 rounded-tl-sm' }}">
                                {{ $msg->message }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-10 text-center text-slate-400">
                        <i data-lucide="message-circle" class="w-10 h-10 mx-auto mb-3 opacity-50"></i>
                        <p class="text-sm">No messages yet. Be the first to reply.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Reply Box -->
                @if($ticket->status !== 'closed')
                    <div class="border-t border-slate-200 bg-slate-50/50">
                        <form action="{{ route('admin.tickets.message', $ticket) }}" method="POST">
                            @csrf
                            <div class="p-4">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Admin Reply</label>
                                <textarea name="message" rows="4" required
                                    class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition resize-none"
                                    placeholder="Type your reply here...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="px-4 pb-4 flex items-center justify-between gap-3">
                                <p class="text-xs text-slate-400">Sending as <span class="font-semibold text-indigo-600">{{ auth()->user()->name }}</span> (Admin)</p>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                                    <i data-lucide="send" class="w-4 h-4"></i>
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="border-t border-slate-200 px-6 py-5 bg-slate-50 text-center">
                        <p class="text-sm text-slate-500 flex items-center justify-center gap-2">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            This ticket is closed. Reopen it to send more replies.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT: Sidebar / Actions -->
        <div class="space-y-5">

            <!-- Ticket Info -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4"></i> Ticket Info
                </h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Submitted by</span>
                        <span class="font-semibold text-slate-800">{{ $ticket->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Email</span>
                        <span class="font-medium text-slate-700 text-xs">{{ $ticket->user->email ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Created</span>
                        <span class="font-medium text-slate-700">{{ $ticket->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Last update</span>
                        <span class="font-medium text-slate-700">{{ $ticket->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Messages</span>
                        <span class="font-bold text-indigo-600">{{ $ticket->messages->count() }}</span>
                    </div>
                    @if($ticket->user)
                    <div class="pt-2 border-t border-slate-100">
                        <a href="{{ route('admin.users.show', $ticket->user) }}"
                           class="inline-flex items-center gap-1.5 text-xs text-indigo-600 hover:underline font-medium">
                            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            View Partner Profile
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Actions -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4"></i> Actions
                </h2>
                <div class="space-y-2">
                    @if($ticket->status !== 'closed')
                        <form method="POST" action="{{ route('admin.tickets.close', $ticket) }}">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                                Close Ticket
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.tickets.reopen', $ticket) }}">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-semibold rounded-xl border border-emerald-200 transition-colors">
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                Reopen Ticket
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}"
                          onsubmit="return confirm('Delete this ticket permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-semibold rounded-xl border border-red-200 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Delete Ticket
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Priority -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="flag" class="w-4 h-4"></i> Priority
                </h2>
                <form method="POST" action="{{ route('admin.tickets.priority', $ticket) }}" class="space-y-3">
                    @csrf
                    <div class="space-y-2">
                        @foreach(['high' => ['text-red-700 bg-red-50 border-red-200', 'alert-triangle'], 'medium' => ['text-amber-700 bg-amber-50 border-amber-200', 'minus'], 'low' => ['text-blue-700 bg-blue-50 border-blue-200', 'arrow-down']] as $p => $cfg)
                        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all
                            {{ $ticket->priority === $p ? $cfg[0] . ' border' : 'border-slate-200 hover:bg-slate-50' }}">
                            <input type="radio" name="priority" value="{{ $p }}" class="hidden"
                                {{ $ticket->priority === $p ? 'checked' : '' }}
                                onchange="this.closest('form').submit()">
                            <i data-lucide="{{ $cfg[1] }}" class="w-4 h-4 shrink-0"></i>
                            <span class="text-sm font-semibold capitalize">{{ $p }}</span>
                            @if($ticket->priority === $p)
                                <i data-lucide="check" class="w-4 h-4 ml-auto"></i>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
