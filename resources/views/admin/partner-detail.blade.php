@extends('layouts.app')

@section('title', 'Partner: ' . $user->name . ' - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-5xl mx-auto">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 text-sm font-medium">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to All Partners
        </a>
    </div>

    @php
        $words = array_filter(explode(' ', trim($user->name)));
        $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice($words, 0, 2))));
        $avatarColors = ['from-indigo-500 to-purple-600','from-emerald-500 to-teal-600','from-amber-500 to-orange-600','from-rose-500 to-pink-600','from-sky-500 to-blue-600'];
        $avatarGradient = $avatarColors[$user->id % count($avatarColors)];
    @endphp

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="h-24 bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700"></div>
        <div class="px-6 pb-6 -mt-12">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div class="flex items-end gap-4">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br {{ $avatarGradient }} flex items-center justify-center text-white font-bold text-2xl shadow-lg border-4 border-white">
                        {{ $initials }}
                    </div>
                    <div class="mb-1">
                        <h1 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            {{ $user->name }}
                            @if(in_array($user->role, ['admin','superadmin']))
                                <i data-lucide="badge-check" class="w-5 h-5 text-indigo-500"></i>
                            @endif
                        </h1>
                        <p class="text-slate-500 text-sm">{{ $user->email }}</p>
                        @if($user->phone)
                            <p class="text-slate-500 text-sm">{{ $user->phone }}</p>
                        @endif
                        <p class="text-slate-400 text-xs mt-1 font-mono">ID: #{{ $user->id }} &nbsp;·&nbsp; Joined {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-2 mb-1">

                    {{-- Edit button --}}
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-medium rounded-xl border border-amber-200 transition-colors">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                        Edit
                    </a>

                    @if($user->id !== auth()->id() && !in_array($user->role, ['admin','superadmin']))
                        @if($user->status === 'active')
                            <form method="POST" action="{{ route('admin.users.suspend', $user) }}"
                                  onsubmit="return confirm('Suspend {{ addslashes($user->name) }}?')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium rounded-xl border border-red-200 transition-colors">
                                    <i data-lucide="ban" class="w-4 h-4"></i>
                                    Suspend
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.restore', $user) }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-medium rounded-xl border border-emerald-200 transition-colors">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    Restore
                                </button>
                            </form>
                        @endif

                        {{-- Delete --}}
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Permanently DELETE {{ addslashes($user->name) }}?\n\nThis cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                Delete
                            </button>
                        </form>
                    @endif

                    {{-- Role Change --}}
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex gap-2">
                        @csrf
                        <select name="role" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="partner" {{ $user->role === 'partner' ? 'selected' : '' }}>Partner</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors">
                            Update Role
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Partner Info -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6 p-6">
        <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i data-lucide="info" class="w-4 h-4"></i> Applicant Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <p class="text-xs text-slate-400 font-medium mb-1">Gender</p>
                <p class="font-semibold text-slate-800">{{ $user->gender ?? 'Not Provided' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium mb-1">Primary Phone</p>
                <p class="font-mono text-slate-800">{{ $user->phone ?? 'Not Provided' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium mb-1">Alternate Phone</p>
                <p class="font-mono text-slate-800">{{ $user->alternate_phone ?? 'Not Provided' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium mb-1">Residential Address</p>
                <p class="text-sm text-slate-800 leading-snug">
                    @if($user->address_house)
                        {{ $user->address_house }}, {{ $user->address_street }}<br>
                        {{ $user->address_city }}, {{ $user->address_state }} - {{ $user->address_pin }}<br>
                        {{ $user->address_country }}
                    @else
                        <span class="text-slate-400 italic">Not Provided</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Status Badges Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @php
            $kycBadge = match($user->kyc_status) {
                'approved' => ['bg-emerald-50 border-emerald-200 text-emerald-700', 'bg-emerald-500', 'shield-check'],
                'pending'  => ['bg-amber-50 border-amber-200 text-amber-700', 'bg-amber-500', 'clock'],
                'rejected' => ['bg-red-50 border-red-200 text-red-700', 'bg-red-500', 'shield-x'],
                default    => ['bg-slate-50 border-slate-200 text-slate-600', 'bg-slate-400', 'shield'],
            };
        @endphp
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                <i data-lucide="user" class="w-4 h-4"></i>
            </div>
            <div>
                <div class="text-xs text-slate-500">Role</div>
                <div class="text-sm font-bold text-slate-800 capitalize">{{ $user->role }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border {{ $kycBadge[0] }} p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-white/60 flex items-center justify-center shrink-0">
                <i data-lucide="{{ $kycBadge[2] }}" class="w-4 h-4"></i>
            </div>
            <div>
                <div class="text-xs opacity-70">KYC</div>
                <div class="text-sm font-bold capitalize">{{ $user->kyc_status }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} flex items-center justify-center shrink-0">
                <i data-lucide="{{ $user->status === 'active' ? 'check-circle' : 'x-circle' }}" class="w-4 h-4"></i>
            </div>
            <div>
                <div class="text-xs text-slate-500">Status</div>
                <div class="text-sm font-bold {{ $user->status === 'active' ? 'text-emerald-700' : 'text-red-700' }} capitalize">{{ $user->status }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <i data-lucide="share-2" class="w-4 h-4"></i>
            </div>
            <div>
                <div class="text-xs text-slate-500">Referred by</div>
                <div class="text-sm font-bold text-slate-800">{{ $user->referrer ? $user->referrer->name : 'Direct' }}</div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-indigo-600">{{ $user->leads_count }}</div>
            <div class="text-xs text-slate-500 font-medium mt-1">Total Leads</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-purple-600">{{ $user->referrals_count }}</div>
            <div class="text-xs text-slate-500 font-medium mt-1">Referrals</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-emerald-600">
                ₹{{ $user->wallet ? number_format($user->wallet->balance, 2) : '0.00' }}
            </div>
            <div class="text-xs text-slate-500 font-medium mt-1">Wallet Balance</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-amber-600">
                ₹{{ $user->wallet ? number_format($user->wallet->pending_balance, 2) : '0.00' }}
            </div>
            <div class="text-xs text-slate-500 font-medium mt-1">Pending Balance</div>
        </div>
    </div>

    <!-- Recent Leads -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="target" class="w-4 h-4 text-slate-400"></i>
                Recent Leads
            </h2>
            <a href="{{ route('admin.leads') }}" class="text-xs text-indigo-600 hover:underline">View All</a>
        </div>
        @if($user->leads->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Client</th>
                        <th class="px-6 py-3 text-left font-semibold">Service</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-right font-semibold">Est. Value</th>
                        <th class="px-6 py-3 text-right font-semibold">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($user->leads as $lead)
                    @php
                        $lBadge = match($lead->status) {
                            'approved','closed_won' => 'bg-emerald-100 text-emerald-800',
                            'pending'               => 'bg-amber-100 text-amber-800',
                            'rejected'              => 'bg-red-100 text-red-800',
                            default                 => 'bg-slate-100 text-slate-700',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3">
                            <div class="font-medium text-slate-900">{{ $lead->client_name }}</div>
                            <div class="text-xs text-slate-500">{{ $lead->company_name }}</div>
                        </td>
                        <td class="px-6 py-3 text-slate-700">{{ $lead->service_needed }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center gap-1.5 py-0.5 px-2.5 rounded-full text-xs font-semibold {{ $lBadge }}">
                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-right text-slate-800 font-medium">
                            ₹{{ number_format($lead->estimated_value, 0) }}
                        </td>
                        <td class="px-6 py-3 text-right text-slate-500 text-xs">
                            {{ $lead->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-10 text-center text-slate-400">
            <i data-lucide="target" class="w-8 h-8 mx-auto mb-2"></i>
            <p class="text-sm">No leads submitted yet.</p>
        </div>
        @endif
    </div>

</div>
@endsection
