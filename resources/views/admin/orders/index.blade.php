@extends('layouts.app')

@section('title', 'Manage Orders - Admin')

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
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Orders</h1>
            <p class="text-slate-500 mt-1">Review, manage and update all customer orders.</p>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $totalOrders }}</div>
                <div class="text-xs text-slate-500 font-medium">Total Orders</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $pendingCount }}</div>
                <div class="text-xs text-slate-500 font-medium">Pending</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $paidCount }}</div>
                <div class="text-xs text-slate-500 font-medium">Paid</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $completedCount }}</div>
                <div class="text-xs text-slate-500 font-medium">Completed</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-indigo-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="indian-rupee" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-indigo-700">₹{{ number_format($totalRevenue, 0) }}</div>
                <div class="text-xs text-slate-500 font-medium">Total Revenue</div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.orders') }}" id="filter-form">
        <div class="bg-white p-4 border border-slate-200 rounded-t-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="w-full sm:w-auto relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-80 pl-10 p-2.5"
                    placeholder="Search by order ID, customer, service...">
            </div>
            <div class="flex gap-2 w-full sm:w-auto flex-wrap">
                <select name="status" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Status</option>
                    <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="paid"        {{ request('status') === 'paid'        ? 'selected' : '' }}>Paid</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed"   {{ request('status') === 'completed'   ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled"   {{ request('status') === 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">Search</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('admin.orders') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Orders Table -->
    <div class="bg-white border-x border-b border-slate-200 rounded-b-2xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold tracking-wider">Order ID</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Customer</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Service</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Lead</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Amount</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Date</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($orders as $order)
                    @php
                        $statusConfig = match($order->status) {
                            'paid'      => ['bg-blue-100 text-blue-800',    'bg-blue-500',    'credit-card'],
                            'completed' => ['bg-emerald-100 text-emerald-800','bg-emerald-500','check-circle'],
                            'cancelled' => ['bg-red-100 text-red-800',      'bg-red-500',     'x-circle'],
                            default     => ['bg-amber-100 text-amber-800',  'bg-amber-500',   'clock'],
                        };
                        $orderId = str_pad($order->id, 5, '0', STR_PAD_LEFT);
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <!-- Order ID -->
                        <td class="px-6 py-4">
                            <span class="font-mono font-semibold text-slate-900 text-xs bg-slate-100 px-2.5 py-1 rounded-lg">
                                #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <!-- Customer -->
                        <td class="px-6 py-4">
                            @if($order->user)
                                <div class="font-semibold text-slate-900">{{ $order->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $order->user->email }}</div>
                            @else
                                <span class="text-slate-400 text-xs italic">Guest / Deleted</span>
                            @endif
                        </td>

                        <!-- Service -->
                        <td class="px-6 py-4">
                            @if($order->service)
                                <div class="font-medium text-slate-800">{{ $order->service->name }}</div>
                                @if($order->service->category)
                                    <div class="text-xs text-slate-500">{{ $order->service->category }}</div>
                                @endif
                            @elseif($order->lead && $order->lead->service_needed)
                                <div class="font-medium text-slate-800">{{ $order->lead->service_needed }}</div>
                                <div class="text-xs text-slate-400 italic">Custom Service</div>
                            @else
                                <span class="text-slate-400 text-xs italic">Service removed</span>
                            @endif
                        </td>

                        <!-- Lead -->
                        <td class="px-6 py-4">
                            @if($order->lead)
                                <div class="text-xs text-slate-700 font-medium">{{ $order->lead->client_name }}</div>
                                <div class="text-xs text-slate-400 font-mono">Lead #{{ $order->lead->id }}</div>
                            @else
                                <span class="text-slate-400 text-xs">—</span>
                            @endif
                        </td>

                        <!-- Amount -->
                        <td class="px-6 py-4 text-right font-bold text-slate-900">
                            ₹{{ number_format($order->amount, 2) }}
                        </td>

                        <!-- Status (inline quick-update) -->
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs rounded-full px-3 py-1.5 border-0 font-semibold cursor-pointer focus:ring-2 focus:ring-indigo-400 outline-none {{ $statusConfig[0] }}">
                                    <option value="pending"     {{ $order->status === 'pending'     ? 'selected' : '' }}>Pending</option>
                                    <option value="paid"        {{ $order->status === 'paid'        ? 'selected' : '' }}>Paid</option>
                                    <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed"   {{ $order->status === 'completed'   ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled"   {{ $order->status === 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <span class="text-slate-400">{{ $order->created_at->format('h:i A') }}</span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                {{-- View --}}
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-indigo-50" title="View Order">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('admin.orders.edit', $order) }}"
                                   class="p-2 text-slate-400 hover:text-amber-600 transition-colors rounded-lg hover:bg-amber-50" title="Edit Order">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                      onsubmit="return confirm('Delete Order #ORD-{{ $orderId }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-slate-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50" title="Delete">
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
                                <i data-lucide="shopping-cart" class="w-12 h-12"></i>
                                <p class="font-medium">No orders found</p>
                                @if(request()->hasAny(['search','status']))
                                    <a href="{{ route('admin.orders') }}" class="text-indigo-600 text-sm hover:underline">Clear filters</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-sm text-slate-500">
                Showing <span class="font-semibold text-slate-900">{{ $orders->firstItem() }}</span>
                to <span class="font-semibold text-slate-900">{{ $orders->lastItem() }}</span>
                of <span class="font-semibold text-slate-900">{{ $orders->total() }}</span> orders
            </span>
            <div class="flex items-center gap-1">
                @if($orders->onFirstPage())
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50">Previous</a>
                @endif
                @foreach($orders->getUrlRange(max(1,$orders->currentPage()-2), min($orders->lastPage(),$orders->currentPage()+2)) as $page => $url)
                    @if($page == $orders->currentPage())
                        <span class="px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-t border-b border-slate-200">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border-t border-b border-slate-200 hover:bg-slate-50">{{ $page }}</a>
                    @endif
                @endforeach
                @if($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50">Next</a>
                @else
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @else
        <div class="p-4 border-t border-slate-200">
            <span class="text-sm text-slate-500">Showing all <span class="font-semibold text-slate-900">{{ $orders->total() }}</span> orders</span>
        </div>
        @endif
    </div>
</div>
@endsection
