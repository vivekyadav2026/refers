<div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-100 -mx-6 px-6 mb-2">
    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold text-lg shadow-sm">V</div>
    <span class="font-extrabold text-xl tracking-tight text-slate-900">VivekTech</span>
</div>

<nav class="flex flex-1 flex-col mt-4">
    <ul role="list" class="flex flex-1 flex-col gap-y-1">

        @php
            $isAdmin = auth()->check() && in_array(auth()->user()->role, ['admin','superadmin']);
        @endphp

        @if($isAdmin)
        {{-- ===== ADMIN NAV ===== --}}
        <li class="text-xs font-bold text-slate-400 uppercase tracking-wider px-2 py-2 mt-2">Admin Panel</li>
        @foreach([
            ['route'=>'admin.dashboard','icon'=>'layout-dashboard','label'=>'Dashboard'],
            ['route'=>'admin.users','icon'=>'users','label'=>'All Partners'],
            ['route'=>'admin.orders','icon'=>'shopping-cart','label'=>'Orders'],
            ['route'=>'admin.tickets','icon'=>'message-square','label'=>'Support Tickets'],
            ['route'=>'admin.withdrawals','icon'=>'banknote','label'=>'Withdrawals'],
            ['route'=>'admin.leads','icon'=>'target','label'=>'Leads'],
            ['route'=>'admin.kyc','icon'=>'shield-check','label'=>'KYC Approvals'],
            ['route'=>'admin.services','icon'=>'box','label'=>'Services'],
            ['route'=>'admin.cms.index','icon'=>'file-text','label'=>'CMS Pages'],
            ['route'=>'admin.banners.index','icon'=>'image','label'=>'Banners'],
            ['route'=>'admin.settings','icon'=>'settings','label'=>'Settings'],
        ] as $item)
        <li>
            <a href="{{ route($item['route']) }}" class="group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm font-semibold leading-6 {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors' }}">
                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0 {{ request()->routeIs($item['route']) ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
                {{ $item['label'] }}
            </a>
        </li>
        @endforeach

        <li class="text-xs font-bold text-slate-400 uppercase tracking-wider px-2 py-2 mt-4">Quick Actions</li>
        <li>
            <a href="{{ route('partner.services') }}" class="group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm font-semibold leading-6 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                <i data-lucide="share-2" class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-600"></i>
                View as Partner
            </a>
        </li>

        @else
        {{-- ===== PARTNER NAV ===== --}}
        <li class="text-xs font-bold text-slate-400 uppercase tracking-wider px-2 py-2 mt-2">Partner Menu</li>
        @foreach([
            ['route'=>'partner.dashboard','icon'=>'layout-dashboard','label'=>'Dashboard'],
            ['route'=>'partner.orders','icon'=>'shopping-cart','label'=>'My Orders'],
            ['route'=>'partner.leads.index','icon'=>'target','label'=>'My Leads'],
            ['route'=>'partner.withdrawals','icon'=>'banknote','label'=>'Wallet & Payouts'],
            ['route'=>'partner.tickets','icon'=>'message-square','label'=>'Support'],
            ['route'=>'partner.referrals','icon'=>'share-2','label'=>'Referrals'],
            ['route'=>'partner.training','icon'=>'video','label'=>'Training Center'],
            ['route'=>'partner.marketing','icon'=>'image','label'=>'Marketing Assets'],
            ['route'=>'partner.kyc','icon'=>'shield-check','label'=>'KYC & ID Card'],
        ] as $item)
        <li>
            <a href="{{ route($item['route']) }}" class="group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm font-semibold leading-6 {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors' }}">
                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0 {{ request()->routeIs($item['route']) ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
                {{ $item['label'] }}
            </a>
        </li>
        @endforeach
        @endif

        {{-- BOTTOM --}}
        <li class="mt-auto pt-4 border-t border-slate-100">
            <div class="flex items-center gap-3 px-2 py-3 mb-2">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'VT' }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="text-xs text-slate-400 capitalize">{{ auth()->user()->role ?? 'partner' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                    <i data-lucide="log-out" class="h-5 w-5 shrink-0 text-red-400 group-hover:text-red-600"></i>
                    Sign Out
                </button>
            </form>
        </li>
    </ul>
</nav>
