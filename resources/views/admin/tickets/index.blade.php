@extends('layouts.app')

@section('title', 'Support Tickets - Admin')

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
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Support Tickets</h1>
            <p class="text-slate-500 mt-1">Manage and respond to partner and customer support requests.</p>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <i data-lucide="message-square" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $totalTickets }}</div>
                <div class="text-xs text-slate-500 font-medium">Total</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="inbox" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $openCount }}</div>
                <div class="text-xs text-slate-500 font-medium">Open</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="loader" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $inProgressCount }}</div>
                <div class="text-xs text-slate-500 font-medium">In Progress</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $closedCount }}</div>
                <div class="text-xs text-slate-500 font-medium">Closed</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-red-600">{{ $highPriority }}</div>
                <div class="text-xs text-slate-500 font-medium">High Priority</div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.tickets') }}" id="filter-form">
        <div class="bg-white p-4 border border-slate-200 rounded-t-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="w-full sm:w-auto relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-80 pl-10 p-2.5"
                    placeholder="Search by subject, user, ID...">
            </div>
            <div class="flex gap-2 w-full sm:w-auto flex-wrap">
                <select name="status" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Status</option>
                    <option value="open"        {{ request('status') === 'open'        ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="closed"      {{ request('status') === 'closed'      ? 'selected' : '' }}>Closed</option>
                </select>
                <select name="priority" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Priority</option>
                    <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>High</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>Low</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">Search</button>
                @if(request()->hasAny(['search','status','priority']))
                    <a href="{{ route('admin.tickets') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Tickets Table -->
    <div class="bg-white border-x border-b border-slate-200 rounded-b-2xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold tracking-wider">Ticket</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">User</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Subject</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Priority</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-center">Replies</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Date</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($tickets as $ticket)
                    @php
                        $statusConfig = match($ticket->status) {
                            'in_progress' => ['bg-indigo-100 text-indigo-800', 'loader'],
                            'closed'      => ['bg-slate-100 text-slate-600',   'check-circle'],
                            default       => ['bg-emerald-100 text-emerald-800','inbox'],
                        };
                        $priorityConfig = match($ticket->priority) {
                            'high'   => ['bg-red-100 text-red-800',    'alert-triangle'],
                            'low'    => ['bg-blue-100 text-blue-800',  'arrow-down'],
                            default  => ['bg-amber-100 text-amber-800','minus'],
                        };
                        $ticketId = str_pad($ticket->id, 5, '0', STR_PAD_LEFT);
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors {{ $ticket->status === 'open' ? 'border-l-4 border-l-emerald-400' : ($ticket->status === 'in_progress' ? 'border-l-4 border-l-indigo-400' : '') }}">
                        <!-- Ticket ID -->
                        <td class="px-6 py-4">
                            <span class="font-mono font-semibold text-xs bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg">
                                #TKT-{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <!-- User -->
                        <td class="px-6 py-4">
                            @if($ticket->user)
                                <div class="font-semibold text-slate-900">{{ $ticket->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $ticket->user->email }}</div>
                            @else
                                <span class="text-slate-400 text-xs italic">Deleted</span>
                            @endif
                        </td>

                        <!-- Subject -->
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800 max-w-xs truncate" title="{{ $ticket->subject }}">
                                {{ $ticket->subject }}
                            </div>
                        </td>

                        <!-- Priority -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-semibold {{ $priorityConfig[0] }}">
                                <i data-lucide="{{ $priorityConfig[1] }}" class="w-3 h-3"></i>
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-semibold {{ $statusConfig[0] }}">
                                <i data-lucide="{{ $statusConfig[1] }}" class="w-3 h-3"></i>
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>

                        <!-- Message Count -->
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold
                                {{ $ticket->messages_count > 0 ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $ticket->messages_count }}
                            </span>
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                            {{ $ticket->created_at->format('M d, Y') }}<br>
                            <span class="text-slate-400">{{ $ticket->created_at->diffForHumans() }}</span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                {{-- View/Respond --}}
                                <a href="{{ route('admin.tickets.show', $ticket) }}"
                                   class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-indigo-50" title="View & Respond">
                                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                                </a>

                                {{-- Close/Reopen --}}
                                @if($ticket->status !== 'closed')
                                    <form method="POST" action="{{ route('admin.tickets.close', $ticket) }}">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-400 hover:text-slate-700 transition-colors rounded-lg hover:bg-slate-100" title="Close Ticket">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.tickets.reopen', $ticket) }}">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors rounded-lg hover:bg-emerald-50" title="Reopen Ticket">
                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}"
                                      onsubmit="return confirm('Delete ticket #TKT-{{ $ticketId }}?')">

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
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <i data-lucide="message-square" class="w-12 h-12"></i>
                                <p class="font-medium">No tickets found</p>
                                @if(request()->hasAny(['search','status','priority']))
                                    <a href="{{ route('admin.tickets') }}" class="text-indigo-600 text-sm hover:underline">Clear filters</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tickets->hasPages())
        <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-sm text-slate-500">
                Showing <span class="font-semibold text-slate-900">{{ $tickets->firstItem() }}</span>
                to <span class="font-semibold text-slate-900">{{ $tickets->lastItem() }}</span>
                of <span class="font-semibold text-slate-900">{{ $tickets->total() }}</span> tickets
            </span>
            <div class="flex items-center gap-1">
                @if($tickets->onFirstPage())
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $tickets->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50">Previous</a>
                @endif
                @foreach($tickets->getUrlRange(max(1,$tickets->currentPage()-2), min($tickets->lastPage(),$tickets->currentPage()+2)) as $page => $url)
                    @if($page == $tickets->currentPage())
                        <span class="px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-t border-b border-slate-200">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border-t border-b border-slate-200 hover:bg-slate-50">{{ $page }}</a>
                    @endif
                @endforeach
                @if($tickets->hasMorePages())
                    <a href="{{ $tickets->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50">Next</a>
                @else
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @else
        <div class="p-4 border-t border-slate-200">
            <span class="text-sm text-slate-500">Showing all <span class="font-semibold text-slate-900">{{ $tickets->total() }}</span> tickets</span>
        </div>
        @endif
    </div>
</div>
@endsection
