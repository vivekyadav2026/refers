@extends('layouts.app')

@section('title', 'Users Management - Admin')

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
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">{{ $pageTitle ?? 'Users Management' }}</h1>
            <p class="text-slate-500 mt-1">Manage {{ strtolower($pageTitle ?? 'Users') }}, view their performance, and handle KYC approvals.</p>
        </div>
        <div class="mt-3 sm:mt-0">
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Add Partner
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $totalPartners }}</div>
                <div class="text-xs text-slate-500 font-medium">Total Partners</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $activePartners }}</div>
                <div class="text-xs text-slate-500 font-medium">Active Partners</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $kycPending }}</div>
                <div class="text-xs text-slate-500 font-medium">KYC Pending</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                <i data-lucide="user-x" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $suspendedCount }}</div>
                <div class="text-xs text-slate-500 font-medium">Suspended</div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.users') }}" id="filter-form">
        <div class="bg-white p-4 border border-slate-200 rounded-t-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="w-full sm:w-auto relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-80 pl-10 p-2.5"
                    placeholder="Search by name, email, phone or ID...">
            </div>

            <div class="flex gap-2 w-full sm:w-auto flex-wrap">
                <select name="role" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Roles</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="partner" {{ request('role') === 'partner' ? 'selected' : '' }}>Partner</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <select name="status" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="kyc_pending" {{ request('status') === 'kyc_pending' ? 'selected' : '' }}>KYC Pending</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Search
                </button>
                @if(request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.users') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Data Table -->
    <div class="bg-white border-x border-b border-slate-200 rounded-b-2xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">User Details</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Join Date</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">KYC Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Account Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Wallet Balance</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Referred By</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Leads</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($users as $user)
                    @php
                        $words = array_filter(explode(' ', trim($user->name)));
                        $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice($words, 0, 2))));
                        $avatarColors = ['bg-indigo-100 text-indigo-700', 'bg-purple-100 text-purple-700', 'bg-amber-100 text-amber-700', 'bg-emerald-100 text-emerald-700', 'bg-rose-100 text-rose-700', 'bg-sky-100 text-sky-700'];
                        $avatarColor = $avatarColors[$user->id % count($avatarColors)];
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors group" id="user-row-{{ $user->id }}">
                        <!-- User Details -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900 flex items-center gap-1.5">
                                        {{ $user->name }}
                                        @if(in_array($user->role, ['admin','superadmin']))
                                            <i data-lucide="badge-check" class="w-4 h-4 text-indigo-500"></i>
                                        @endif
                                    </div>
                                    <div class="text-slate-500 text-xs mt-0.5">{{ $user->email }}</div>
                                    @if($user->phone)
                                        <div class="text-slate-400 text-xs mt-0.5">{{ $user->phone }}</div>
                                    @endif
                                    <div class="text-slate-400 text-xs mt-0.5 font-mono">ID: #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Role -->
                        <td class="px-6 py-4">
                            @if(in_array($user->role, ['admin','superadmin']))
                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    <i data-lucide="shield" class="w-3 h-3"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ ucfirst($user->role) }}
                                </span>
                            @endif
                        </td>

                        <!-- Join Date -->
                        <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>

                        <!-- KYC Status -->
                        <td class="px-6 py-4">
                            @php
                                $kycBadge = match($user->kyc_status) {
                                    'approved' => 'bg-emerald-100 text-emerald-800',
                                    'pending'  => 'bg-amber-100 text-amber-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    default    => 'bg-slate-100 text-slate-600',
                                };
                                $kycDot = match($user->kyc_status) {
                                    'approved' => 'bg-emerald-500',
                                    'pending'  => 'bg-amber-500',
                                    'rejected' => 'bg-red-500',
                                    default    => 'bg-slate-400',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold {{ $kycBadge }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $kycDot }}"></span>
                                {{ ucfirst($user->kyc_status) }}
                            </span>
                        </td>

                        <!-- Account Status -->
                        <td class="px-6 py-4">
                            @if($user->status === 'active')
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Suspended
                                </span>
                            @endif
                        </td>

                        <!-- Wallet Balance -->
                        <td class="px-6 py-4 text-right">
                            @if($user->wallet)
                                <div class="font-bold text-slate-900">₹{{ number_format($user->wallet->balance, 2) }}</div>
                                @if($user->wallet->pending_balance > 0)
                                    <div class="text-xs text-amber-600 mt-0.5">+₹{{ number_format($user->wallet->pending_balance, 2) }} pending</div>
                                @endif
                            @else
                                <span class="text-slate-400 text-xs">No wallet</span>
                            @endif
                        </td>

                        <!-- Referred By -->
                        <td class="px-6 py-4">
                            @if($user->referrer)
                                <div class="font-semibold text-slate-900">{{ $user->referrer->name }}</div>
                                <div class="text-xs text-slate-500">Partner</div>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-slate-100 text-slate-600">
                                    Direct
                                </span>
                            @endif
                        </td>

                        <!-- Lead Count -->
                        <td class="px-6 py-4 text-right">
                            <span class="font-semibold text-slate-800">{{ $user->leads_count }}</span>
                            <span class="text-xs text-slate-500 ml-1">leads</span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                {{-- View Detail --}}
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-indigo-50" title="View Profile">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="p-2 text-slate-400 hover:text-amber-600 transition-colors rounded-lg hover:bg-amber-50" title="Edit Partner">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                {{-- Suspend / Restore --}}
                                @if($user->id !== auth()->id() && !in_array($user->role, ['admin','superadmin']))
                                    @if($user->status === 'active')
                                        <form method="POST" action="{{ route('admin.users.suspend', $user) }}"
                                              onsubmit="return confirm('Suspend {{ addslashes($user->name) }}?')">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50" title="Suspend">
                                                <i data-lucide="ban" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.restore', $user) }}">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-emerald-600 transition-colors rounded-lg hover:bg-emerald-50" title="Restore">
                                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Delete (non-admin partners only) --}}
                                @if($user->id !== auth()->id() && !in_array($user->role, ['admin','superadmin']))
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('Permanently DELETE {{ addslashes($user->name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-red-700 transition-colors rounded-lg hover:bg-red-50" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- KYC Review shortcut --}}
                                @if($user->kyc_status === 'pending')
                                    <a href="{{ route('admin.kyc') }}"
                                       class="p-2 text-amber-500 hover:text-amber-700 transition-colors rounded-lg hover:bg-amber-50" title="Review KYC">
                                        <i data-lucide="shield-alert" class="w-4 h-4"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <i data-lucide="users" class="w-12 h-12"></i>
                                <p class="font-medium">No users found</p>
                                @if(request()->hasAny(['search', 'role', 'status']))
                                    <a href="{{ route('admin.users') }}" class="text-indigo-600 text-sm hover:underline">Clear filters</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-sm text-slate-500">
                Showing <span class="font-semibold text-slate-900">{{ $users->firstItem() }}</span>
                to <span class="font-semibold text-slate-900">{{ $users->lastItem() }}</span>
                of <span class="font-semibold text-slate-900">{{ $users->total() }}</span> users
            </span>
            <div class="flex items-center gap-1">
                {{-- Previous --}}
                @if($users->onFirstPage())
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50 transition-colors">Previous</a>
                @endif

                {{-- Page Numbers --}}
                @foreach($users->getUrlRange(max(1, $users->currentPage()-2), min($users->lastPage(), $users->currentPage()+2)) as $page => $url)
                    @if($page == $users->currentPage())
                        <span class="px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-t border-b border-slate-200">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border-t border-b border-slate-200 hover:bg-slate-50 transition-colors">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50 transition-colors">Next</a>
                @else
                    <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @else
        <div class="p-4 border-t border-slate-200">
            <span class="text-sm text-slate-500">
                Showing all <span class="font-semibold text-slate-900">{{ $users->total() }}</span> users
            </span>
        </div>
        @endif
    </div>
</div>
@endsection
