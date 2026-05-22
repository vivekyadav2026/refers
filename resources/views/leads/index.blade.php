@extends('layouts.app')

@section('title', 'My Leads - SK Solutions Partner Network')

@section('sidebar')
    <!-- Enables sidebar -->
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">

    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">My Leads</h1>
            <p class="text-slate-500 mt-1">Manage and track the status of all your submitted leads.</p>
        </div>
        <a href="{{ route('partner.leads.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Submit New Lead
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Total Leads', 'value' => $stats['total'], 'icon' => 'target', 'color' => 'indigo'],
            ['label' => 'Pending Review', 'value' => $stats['pending'], 'icon' => 'clock', 'color' => 'amber'],
            ['label' => 'Won / Converted', 'value' => $stats['won'], 'icon' => 'check-circle', 'color' => 'emerald'],
            ['label' => 'Lost / Rejected', 'value' => $stats['lost'], 'icon' => 'x-circle', 'color' => 'red'],
        ] as $stat)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center shrink-0">
                <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</div>
                <div class="text-xs text-slate-500 font-medium">{{ $stat['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('partner.leads.index') }}">
        <div class="bg-white rounded-t-2xl border border-slate-200 shadow-sm border-b-0 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                    placeholder="Search client, phone or service...">
            </div>

            <div class="flex gap-2 items-center flex-wrap">
                @foreach([''=>'All Leads','pending'=>'Pending','contacted'=>'Contacted','negotiation'=>'Negotiating','won'=>'Won','lost'=>'Lost'] as $val=>$label)
                <a href="{{ route('partner.leads.index', array_merge(request()->query(), ['status' => $val])) }}"
                   class="px-4 py-2 text-xs font-semibold rounded-full transition-colors whitespace-nowrap {{ request('status', '') === $val ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                   {{ $label }}
                </a>
                @endforeach
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-b-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-y border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold tracking-wider">Client Details</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Service Required</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Est. Value</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Submitted</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($leads as $lead)
                    @php
                        $words = array_filter(explode(' ', trim($lead->client_name)));
                        $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice($words, 0, 2))));
                        $colors = ['bg-indigo-100 text-indigo-700','bg-purple-100 text-purple-700','bg-amber-100 text-amber-700','bg-emerald-100 text-emerald-700','bg-rose-100 text-rose-700'];
                        $color = $colors[$lead->id % count($colors)];
                        $badge = match($lead->status) {
                            'pending'     => ['bg-amber-100 text-amber-800 border-amber-200', 'bg-amber-500', 'Pending'],
                            'contacted'   => ['bg-blue-100 text-blue-800 border-blue-200', 'bg-blue-500', 'Contacted'],
                            'negotiation' => ['bg-purple-100 text-purple-800 border-purple-200', 'bg-purple-500 animate-pulse', 'Negotiating'],
                            'won'         => ['bg-emerald-100 text-emerald-800 border-emerald-200', 'bg-emerald-500', 'Won'],
                            'lost'        => ['bg-red-100 text-red-800 border-red-200', 'bg-red-500', 'Lost'],
                            default       => ['bg-slate-100 text-slate-700 border-slate-200', 'bg-slate-400', ucfirst($lead->status)],
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $color }} flex items-center justify-center font-bold text-sm shrink-0">{{ $initials }}</div>
                                <div>
                                    <div class="font-semibold text-slate-900">{{ $lead->client_name }}</div>
                                    @if($lead->client_phone)
                                        <div class="text-slate-500 text-xs mt-0.5 flex items-center gap-1">
                                            <i data-lucide="phone" class="w-3 h-3"></i> {{ $lead->client_phone }}
                                        </div>
                                    @endif
                                    @if($lead->client_email)
                                        <div class="text-slate-400 text-xs mt-0.5">{{ $lead->client_email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium">{{ $lead->service_needed }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            ₹{{ number_format($lead->estimated_value ?? 0, 0) }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap text-xs">
                            {{ $lead->created_at->format('M d, Y') }}<br>
                            <span class="text-slate-400">{{ $lead->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold border {{ $badge[0] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $badge[1] }}"></span>
                                {{ $badge[2] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <i data-lucide="target" class="w-12 h-12"></i>
                                <p class="font-medium text-slate-500">No leads found</p>
                                <a href="{{ route('partner.leads.create') }}" class="text-indigo-600 text-sm hover:underline">Submit your first lead →</a>
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
                    <a href="{{ $leads->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50 transition-colors">Previous</a>
                @endif
                @if($leads->hasMorePages())
                    <a href="{{ $leads->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50 transition-colors">Next</a>
                @else
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @else
        <div class="p-4 border-t border-slate-200">
            <span class="text-sm text-slate-500">Showing all <span class="font-semibold">{{ $leads->total() }}</span> leads</span>
        </div>
        @endif
    </div>
</div>
@endsection
