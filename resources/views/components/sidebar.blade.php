<div class="flex h-20 shrink-0 items-center gap-3.5 border-b border-slate-100/80 -mx-6 px-8 mb-6">
    <img src="{{ asset('sksolutions_logo.jpg') }}" alt="SK Solutions Logo" class="h-12 sm:h-14 w-auto rounded-xl object-contain shadow-sm border border-slate-100 bg-white">
</div>

<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-1.5">

        @php
            $isAdmin = auth()->check() && in_array(auth()->user()->role, ['admin','superadmin']);
            $isCustomer = auth()->check() && auth()->user()->role === 'customer';
            $isPartner = auth()->check() && auth()->user()->role === 'partner';
        @endphp

        @if($isAdmin)
        {{-- ===== ADMIN NAV ===== --}}
        <li class="text-[11px] font-black text-slate-400 uppercase tracking-widest px-3 py-2 mt-2">Admin Control Panel</li>
        @foreach([
            ['route'=>'admin.dashboard','icon'=>'layout-dashboard','label'=>'Dashboard'],
            ['route'=>'admin.customers','icon'=>'users','label'=>'Customers'],
            ['route'=>'admin.partners','icon'=>'briefcase','label'=>'Partners'],
            ['route'=>'admin.orders','icon'=>'shopping-bag','label'=>'All Orders'],
            ['route'=>'admin.post-payments.index','icon'=>'file-text','label'=>'Customer Detail Forms'],
            ['route'=>'admin.commissions','icon'=>'coins','label'=>'Commissions'],
            ['route'=>'admin.tickets','icon'=>'message-square','label'=>'Support Tickets'],
            ['route'=>'admin.withdrawals','icon'=>'banknote','label'=>'Withdrawals'],
            ['route'=>'admin.leads','icon'=>'target','label'=>'Lead Management'],
            ['route'=>'admin.kyc','icon'=>'shield-check','label'=>'KYC Approvals'],
            ['route'=>'admin.notifications.create','icon'=>'send','label'=>'Send Notifications'],
            ['route'=>'admin.services','icon'=>'box','label'=>'Services Catalog'],
            ['route'=>'admin.training.index','icon'=>'graduation-cap','label'=>'Training Center'],
            ['route'=>'admin.banners.index','icon'=>'image','label'=>'Banners System'],
            ['route'=>'admin.portfolios.index','icon'=>'briefcase','label'=>'Portfolio Manager'],
            ['route'=>'admin.settings','icon'=>'settings','label'=>'Global Settings'],
            ['route'=>'admin.coupons.index','icon'=>'tag','label'=>'Coupons Manager'],
            ] as $item)
        <li>
            <a href="{{ route($item['route']) }}" class="group flex items-center gap-x-3.5 rounded-2xl px-4 py-3 text-sm font-bold transition-all duration-200 {{ request()->routeIs($item['route']) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/25 -translate-y-0.5' : 'text-slate-600 hover:bg-blue-50/60 hover:text-blue-700' }}">
                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs($item['route']) ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        </li>
        @endforeach

        @elseif($isCustomer)
        {{-- ===== CUSTOMER NAV ===== --}}
        <li class="text-[11px] font-black text-slate-400 uppercase tracking-widest px-3 py-2 mt-2">Customer Menu</li>
        @foreach([
            ['route'=>'customer.dashboard','icon'=>'layout-dashboard','label'=>'Dashboard Overview'],
            ['route'=>'customer.services','icon'=>'grid-3x3','label'=>'Explore Services'],
            ['route'=>'cart.index','icon'=>'shopping-cart','label'=>'My Cart', 'count' => auth()->user()->cartItems->count()],
            ['route'=>'customer.orders','icon'=>'package','label'=>'Order History', 'count' => auth()->user()->orders()->whereIn('status', ['pending', 'in_progress'])->count()],
            ['route'=>'customer.profile','icon'=>'user','label'=>'Account Settings'],
        ] as $item)
        <li>
            <a href="{{ route($item['route']) }}" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-bold transition-all duration-200 {{ request()->routeIs($item['route']) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/25 -translate-y-0.5' : 'text-slate-600 hover:bg-blue-50/60 hover:text-blue-700' }}">
                <div class="flex items-center gap-x-3.5">
                    <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs($item['route']) ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
                    <span>{{ $item['label'] }}</span>
                </div>
                @if(isset($item['count']) && $item['count'] > 0)
                <span class="px-2 py-0.5 rounded-full text-xs font-black {{ request()->routeIs($item['route']) ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-700' }}">{{ $item['count'] }}</span>
                @endif
            </a>
        </li>
        @endforeach

        @else
        {{-- ===== PARTNER NAV ===== --}}
        <li class="text-[11px] font-black text-slate-400 uppercase tracking-widest px-3 py-2 mt-2 flex items-center justify-between">
            <span>Partner Network</span>
            @if(empty(auth()->user()->company_name) || auth()->user()->kyc_status !== 'approved')
                <span class="bg-amber-100 text-amber-800 text-[10px] font-black px-2 py-0.5 rounded-full flex items-center gap-1 animate-pulse"><i data-lucide="lock" class="w-3 h-3"></i> LOCKED</span>
            @else
                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2 py-0.5 rounded-full flex items-center gap-1"><i data-lucide="unlock" class="w-3 h-3"></i> ACTIVE</span>
            @endif
        </li>

        {{-- Onboarding Link --}}
        <li class="mb-2">
            <a href="{{ route('partner.apply') }}" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-bold transition-all duration-200 {{ request()->routeIs('partner.apply') ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-600/25 -translate-y-0.5' : 'bg-indigo-50/80 border border-indigo-100/80 text-indigo-700 hover:bg-indigo-100' }}">
                <div class="flex items-center gap-x-3.5">
                    <i data-lucide="shield-check" class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('partner.apply') ? 'text-white' : 'text-indigo-600' }}"></i>
                    <span>Onboarding Status</span>
                </div>
                @if(empty(auth()->user()->company_name) || auth()->user()->kyc_status !== 'approved')
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                @else
                    <i data-lucide="check-circle-2" class="w-4 h-4 {{ request()->routeIs('partner.apply') ? 'text-white' : 'text-emerald-600' }}"></i>
                @endif
            </a>
        </li>
        @foreach([
            ['route'=>'partner.dashboard','icon'=>'layout-dashboard','label'=>'Dashboard Overview'],
            ['route'=>'partner.services','icon'=>'grid-3x3','label'=>'Services Catalog'],
            ['route'=>'partner.leads.index','icon'=>'target','label'=>'Lead Management'],
            ['route'=>'partner.referrals','icon'=>'link','label'=>'Referrals'],
            ['route'=>'partner.earnings','icon'=>'coins','label'=>'Earnings'],
            ['route'=>'partner.withdrawals','icon'=>'wallet','label'=>'Wallet & Payouts'],
            ['route'=>'partner.tickets','icon'=>'headphones','label'=>'Support Desk'],
            ['route'=>'partner.training','icon'=>'graduation-cap','label'=>'Training Center'],
            ['route'=>'partner.kyc','icon'=>'shield-check','label'=>'KYC & Agreements'],
            ['route'=>'partner.profile','icon'=>'user','label'=>'Account Settings'],
        ] as $item)
        <li>
            <a href="{{ route($item['route']) }}" class="group flex items-center gap-x-3.5 rounded-2xl px-4 py-3 text-sm font-bold transition-all duration-200 {{ request()->routeIs($item['route']) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/25 -translate-y-0.5' : 'text-slate-600 hover:bg-blue-50/60 hover:text-blue-700' }}">
                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs($item['route']) ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        </li>
        @endforeach

        {{-- Referral Link Card --}}
        @if(auth()->user()->referral_code)
        <li class="mt-6 mb-2">
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-5 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                <div class="text-xs font-black uppercase tracking-wider mb-2 text-blue-200 flex items-center gap-1.5"><i data-lucide="link" class="w-3.5 h-3.5"></i> Referral Link</div>
                <div class="bg-slate-950/40 rounded-2xl p-3 text-xs font-mono break-all border border-white/10 mb-3 text-blue-100 select-all backdrop-blur-md">
                    {{ auth()->user()->referral_link }}
                </div>
                <button onclick="navigator.clipboard.writeText('{{ auth()->user()->referral_link }}'); this.textContent='Copied!'; setTimeout(() => this.textContent='Copy Link', 2000);" 
                        class="w-full py-2.5 rounded-xl bg-white text-slate-900 text-xs font-bold hover:bg-blue-50 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                    <i data-lucide="copy" class="w-3.5 h-3.5 text-blue-600"></i> Copy Link
                </button>
            </div>
        </li>
        @endif
        @endif

        {{-- BOTTOM USER PROFILE --}}
        <li class="mt-auto pt-6 border-t border-slate-100 mb-2">
            <div class="flex items-center gap-3.5 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 mb-3">
                @if(auth()->check() && auth()->user()->avatar)
                    <div class="w-10 h-10 rounded-xl shadow-md overflow-hidden">
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-md">
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'VT' }}
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <div class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">{{ auth()->user()->role ?? 'customer' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full group flex items-center justify-center gap-x-3 rounded-2xl py-3 px-4 text-sm font-bold text-red-600 bg-red-50/60 hover:bg-red-500 hover:text-white transition-all duration-200 shadow-sm">
                    <i data-lucide="log-out" class="h-4 w-4 shrink-0 transition-transform group-hover:scale-110"></i>
                    <span>Secure Sign Out</span>
                </button>
            </form>
        </li>
    </ul>
</nav>

