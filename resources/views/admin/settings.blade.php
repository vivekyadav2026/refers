@extends('layouts.app')

@section('title', 'Global Settings - SKSolutions Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-5xl mx-auto">
    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
            <div>
                @foreach($errors->all() as $err)
                    <p>{{ $err }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('admin.settings.store') }}" method="POST" id="settingsForm">
        @csrf
        <!-- Header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">System Settings</h1>
                <p class="text-slate-500 mt-1">Configure global commission rules and platform behavior.</p>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-6 py-2.5 flex items-center gap-2 text-sm font-semibold shadow-sm transition-colors">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Save All Changes
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar Navigation for Settings -->
            <div class="md:col-span-1 space-y-2">
                <!-- <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-50 text-indigo-700 font-semibold border border-indigo-100 transition-colors">
                    <i data-lucide="percent" class="w-5 h-5"></i>
                    Commission Rules
                </div> -->
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100 transition-colors">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                    Withdrawals & Payouts
                </div>
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold border border-blue-100 transition-colors">
                    <i data-lucide="headphones" class="w-5 h-5"></i>
                    Support Contacts
                </div>
            </div>

            <!-- Main Settings Form -->
            <div class="md:col-span-2 space-y-6">
                
                <!-- Global Commissions Box (Commented Out) -->
                <input type="hidden" name="default_commission" value="{{ old('default_commission', $settings['default_commission']) }}">
                <input type="hidden" name="referral_override" value="{{ old('referral_override', $settings['referral_override']) }}">
                <!--
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="percent" class="w-5 h-5 text-indigo-500"></i>
                            Commission Rules
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">Set the default rates for new partners and the network override percentage.</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Default Direct Commission (%) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="default_commission_disabled" value="{{ old('default_commission', $settings['default_commission']) }}" required min="0" max="100" step="0.01"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 pr-10 outline-none transition-all">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 font-bold">
                                    %
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Default cut a partner gets from a lead they directly close. Overridable per service.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Referral Override Commission (%) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="referral_override_disabled" value="{{ old('referral_override', $settings['referral_override']) }}" required min="0" max="100" step="0.01"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 pr-10 outline-none transition-all">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 font-bold">
                                    %
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Percentage a partner earns from the closed deals of partners they referred.</p>
                        </div>
                    </div>
                </div>
                -->

                <!-- Withdrawal Settings -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="wallet" class="w-5 h-5 text-emerald-500"></i>
                            Withdrawal Constraints
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">Control how and when partners can request to pull out their earnings.</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Minimum Withdrawal Amount (₹) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 font-bold">
                                    ₹
                                </div>
                                <input type="number" name="min_withdrawal" value="{{ old('min_withdrawal', $settings['min_withdrawal']) }}" required min="0" step="0.01"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 pl-8 outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Clearance Period (Days) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="clearance_period" value="{{ old('clearance_period', $settings['clearance_period']) }}" required min="0" step="1"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 pr-12 outline-none transition-all">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 text-xs">
                                    Days
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Number of days commissions stay in 'Pending' before becoming 'Available to Withdraw'.</p>
                        </div>

                        <div class="flex items-center justify-between p-4 border border-slate-200 rounded-xl bg-slate-50">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Require KYC before Withdrawal</div>
                                <div class="text-xs text-slate-500 mt-1">Partners cannot withdraw any funds until their KYC is manually approved by an admin.</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="require_kyc" value="1" class="sr-only peer" {{ old('require_kyc', $settings['require_kyc']) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Support Contacts Settings -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="headphones" class="w-5 h-5 text-blue-500"></i>
                            Support Contacts
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">Contact details displayed to users on the Support page.</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Support Email <span class="text-red-500">*</span></label>
                            <input type="email" name="support_email" value="{{ old('support_email', $settings['support_email']) }}" required
                                class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Support Phone / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="support_phone" value="{{ old('support_phone', $settings['support_phone']) }}" required
                                class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Billing & Taxes Settings -->

            </div>
        </div>
    </form>
</div>
@endsection
