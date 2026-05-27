@extends('layouts.app')

@section('title', 'Partner Onboarding & Unlock Portal - SKSolutions')

@section('sidebar')
    <!-- Enables Sidebar -->
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">
    <!-- Header -->
    <div class="text-center max-w-3xl mx-auto mb-12">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
            <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600"></i> SKSolutions Partner Security & Onboarding
        </div>
        <h1 class="text-3xl md:text-4xl text-slate-900 font-extrabold tracking-tight mb-3">Unlock Your Partner Panel</h1>
        <!-- <p class="text-slate-600 text-base md:text-lg leading-relaxed">
            To maintain high standards and secure commission payouts, please complete our 4-step onboarding process. Once manually verified by our admins, your partner panel will unlock instantly.
        </p> -->
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-8 flex items-center gap-3 text-emerald-800 shadow-sm animate-fade-in">
            <i data-lucide="check-circle-2" class="w-6 h-6 text-emerald-600 shrink-0"></i>
            <div class="font-semibold text-sm">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('warning'))
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-8 flex items-center gap-3 text-amber-800 shadow-sm">
            <i data-lucide="alert-triangle" class="w-6 h-6 text-amber-600 shrink-0"></i>
            <div class="font-semibold text-sm">{{ session('warning') }}</div>
        </div>
    @endif

    <!-- 4 Step Progress Bar -->
    <!-- <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-8 mb-10 relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-gradient-to-br from-indigo-100/40 to-purple-100/40 rounded-full blur-2xl -z-10"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
            <div class="flex md:flex-col items-center md:items-start gap-4 md:gap-3 p-4 rounded-2xl transition-all {{ $step1Complete ? 'bg-emerald-50/60 border border-emerald-200/80' : 'bg-indigo-50 border-2 border-indigo-500 shadow-md shadow-indigo-500/10' }}">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 font-bold text-lg {{ $step1Complete ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 animate-pulse' }}">
                    @if($step1Complete) <i data-lucide="check" class="w-6 h-6"></i> @else 1 @endif
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Step 1</div>
                    <h3 class="font-extrabold text-slate-900 text-base">Apply Form</h3>
                    <p class="text-slate-500 text-xs mt-1 leading-snug">Submit agency & business details</p>
                    <span class="inline-block mt-2 text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $step1Complete ? 'bg-emerald-100 text-emerald-800' : 'bg-indigo-100 text-indigo-800' }}">
                        {{ $step1Complete ? 'Completed' : 'In Progress' }}
                    </span>
                </div>
            </div>
            <div class="flex md:flex-col items-center md:items-start gap-4 md:gap-3 p-4 rounded-2xl transition-all {{ $step2Complete ? 'bg-emerald-50/60 border border-emerald-200/80' : ($step1Complete ? 'bg-indigo-50 border-2 border-indigo-500 shadow-md shadow-indigo-500/10' : 'bg-slate-50 border border-slate-200 opacity-60') }}">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 font-bold text-lg {{ $step2Complete ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : ($step1Complete ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 animate-pulse' : 'bg-slate-200 text-slate-600') }}">
                    @if($step2Complete) <i data-lucide="check" class="w-6 h-6"></i> @else 2 @endif
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Step 2</div>
                    <h3 class="font-extrabold text-slate-900 text-base">KYC Verification</h3>
                    <p class="text-slate-500 text-xs mt-1 leading-snug">Verify Aadhaar, PAN & Bank</p>
                    <span class="inline-block mt-2 text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $step2Complete ? 'bg-emerald-100 text-emerald-800' : ($step1Complete ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-200 text-slate-700') }}">
                        {{ $step2Complete ? 'Submitted' : ($step1Complete ? 'Action Required' : 'Locked') }}
                    </span>
                </div>
            </div>
            <div class="flex md:flex-col items-center md:items-start gap-4 md:gap-3 p-4 rounded-2xl transition-all {{ $step3Complete ? 'bg-emerald-50/60 border border-emerald-200/80' : ($step2Complete ? 'bg-amber-50 border-2 border-amber-500 shadow-md shadow-amber-500/10' : 'bg-slate-50 border border-slate-200 opacity-60') }}">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 font-bold text-lg {{ $step3Complete ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : ($step2Complete ? 'bg-amber-600 text-white shadow-lg shadow-amber-600/30 animate-pulse' : 'bg-slate-200 text-slate-600') }}">
                    @if($step3Complete) <i data-lucide="check" class="w-6 h-6"></i> @else 3 @endif
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Step 3</div>
                    <h3 class="font-extrabold text-slate-900 text-base">Admin Approval</h3>
                    <p class="text-slate-500 text-xs mt-1 leading-snug">Manual verification by our team</p>
                    <span class="inline-block mt-2 text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $step3Complete ? 'bg-emerald-100 text-emerald-800' : ($step2Complete ? 'bg-amber-100 text-amber-800 font-bold' : 'bg-slate-200 text-slate-700') }}">
                        {{ $step3Complete ? 'Approved' : ($step2Complete ? 'Under Review' : 'Locked') }}
                    </span>
                </div>
            </div>
            <div class="flex md:flex-col items-center md:items-start gap-4 md:gap-3 p-4 rounded-2xl transition-all {{ $isUnlocked ? 'bg-gradient-to-br from-indigo-600 to-indigo-700 text-white shadow-xl shadow-indigo-600/30 scale-105' : 'bg-slate-50 border border-slate-200 opacity-60' }}">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 font-bold text-lg {{ $isUnlocked ? 'bg-white text-indigo-600 shadow-md' : 'bg-slate-200 text-slate-600' }}">
                    @if($isUnlocked) <i data-lucide="unlock" class="w-6 h-6"></i> @else <i data-lucide="lock" class="w-6 h-6 text-slate-400"></i> @endif
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider mb-1 {{ $isUnlocked ? 'text-indigo-200' : 'text-slate-400' }}">Step 4</div>
                    <h3 class="font-extrabold text-base {{ $isUnlocked ? 'text-white' : 'text-slate-900' }}">Partner Panel</h3>
                    <p class="text-xs mt-1 leading-snug {{ $isUnlocked ? 'text-indigo-100' : 'text-slate-500' }}">Unlock all partner tools</p>
                    <span class="inline-block mt-2 text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $isUnlocked ? 'bg-white text-indigo-900 shadow-sm font-black' : 'bg-slate-200 text-slate-700' }}">
                        {{ $isUnlocked ? 'Unlocked!' : 'Locked' }}
                    </span>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Active Step Action Cards -->
    @if(!$step1Complete)
        <!-- Step 1 Form Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden mb-12" x-data="locationForm()">
            <div class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-center gap-4 md:gap-12 text-xs font-bold text-slate-400">
                <div class="flex flex-col items-center gap-1.5 text-blue-600">
                    <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-md"><i data-lucide="check" class="w-3.5 h-3.5"></i></div>
                    <span class="text-blue-900">Mobile Verify</span>
                </div>
                <div class="w-12 h-px bg-slate-200"></div>
                <div class="flex flex-col items-center gap-1.5 text-blue-600">
                    <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-md">2</div>
                    <span class="text-blue-900">Applicant Details</span>
                </div>
                <div class="w-12 h-px bg-slate-200"></div>
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center">3</div>
                    <span>More Details</span>
                </div>
            </div>
            
            <form action="{{ route('partner.apply.store') }}" method="POST" class="p-6 md:p-10">
                @csrf
                
                <h3 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
                    <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i> Personal Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Full Name (As per PAN Card & Aadhaar Card) <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter applicant's full name" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Primary Mobile Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-bold pointer-events-none">+91</span>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Enter mobile number" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 py-3.5 pr-3.5 pl-12 transition-all outline-none" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Alternative Mobile Number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-bold pointer-events-none">+91</span>
                            <input type="text" name="alternate_phone" value="{{ old('alternate_phone', $user->alternate_phone) }}" placeholder="Enter alternative number" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 py-3.5 pr-3.5 pl-12 transition-all outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Email ID <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', str_contains($user->email, '@sksolution.local') ? '' : $user->email) }}" placeholder="yourname@domain.com" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <h3 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-2 pt-4 border-t border-slate-100">
                    <i data-lucide="map-pin" class="w-5 h-5 text-indigo-600"></i> Residential Address
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">House No. / Plot No. / Flat No. <span class="text-red-500">*</span></label>
                        <input type="text" name="address_house" value="{{ old('address_house', $user->address_house) }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Street / Area / Locality <span class="text-red-500">*</span></label>
                        <input type="text" name="address_street" value="{{ old('address_street', $user->address_street) }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">State <span class="text-red-500">*</span></label>
                        <select name="address_state" x-model="selectedState" @change="updateCities()" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required>
                            <option value="">Select State</option>
                            <template x-for="stateObj in statesData" :key="stateObj.state">
                                <option :value="stateObj.state" x-text="stateObj.state" :selected="selectedState === stateObj.state"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">City <span class="text-red-500">*</span></label>
                        <select name="address_city" x-model="selectedCity" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required :disabled="!selectedState">
                            <option value="">Select City</option>
                            <template x-for="city in availableCities" :key="city">
                                <option :value="city" x-text="city" :selected="selectedCity === city"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">PIN Code <span class="text-red-500">*</span></label>
                        <input type="text" name="address_pin" value="{{ old('address_pin', $user->address_pin) }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Country <span class="text-red-500">*</span></label>
                        <input type="text" name="address_country" value="India" readonly class="w-full bg-slate-100 border border-slate-200 text-slate-500 font-medium text-sm rounded-2xl p-3.5 outline-none cursor-not-allowed">
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-2xl px-8 py-4 flex items-center justify-center gap-3 text-base font-extrabold shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 transition-all hover:-translate-y-0.5">
                        Proceed
                    </button>
                </div>
            </form>
            
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('locationForm', () => ({
                        statesData: [],
                        selectedState: "{{ old('address_state', $user->address_state) }}",
                        selectedCity: "{{ old('address_city', $user->address_city) }}",
                        availableCities: [],
                        
                        init() {
                            fetch("{{ asset('assets/indian_states_cities.json') }}")
                                .then(res => res.json())
                                .then(data => {
                                    this.statesData = data.states;
                                    if(this.selectedState) {
                                        this.updateCities(false);
                                    }
                                });
                        },
                        
                        updateCities(resetCity = true) {
                            if(resetCity) this.selectedCity = '';
                            const stateObj = this.statesData.find(s => s.state === this.selectedState);
                            this.availableCities = stateObj ? stateObj.districts : [];
                        }
                    }))
                })
            </script>
        </div>

    @elseif(!$step2Complete)
        <!-- Step 2 KYC Action Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 p-8 md:p-12 text-center max-w-3xl mx-auto mb-12 relative overflow-hidden">
            <div class="absolute -top-12 -left-12 w-32 h-32 bg-indigo-50 rounded-full blur-xl -z-10"></div>
            
            <div class="w-20 h-20 rounded-3xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-6 shadow-md border border-indigo-100">
                <i data-lucide="shield-check" class="w-10 h-10"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3">Step 1 Completed! Now Submit KYC</h2>
            <p class="text-slate-600 text-base leading-relaxed mb-8 max-w-xl mx-auto">
                Your agency details have been saved successfully. To unlock your payouts and partner tools, please submit your Aadhaar, PAN Card, Selfie, and Bank Account details.
            </p>
            <a href="{{ route('partner.kyc') }}" class="inline-flex items-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-base md:text-lg px-8 py-4 rounded-2xl shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 transition-all hover:-translate-y-0.5">
                Complete KYC Verification Now
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>

    @elseif(!$step3Complete)
        <!-- Step 3 Manual Verification Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 p-8 md:p-12 text-center max-w-3xl mx-auto mb-12 relative overflow-hidden">
            <div class="absolute -top-12 -left-12 w-32 h-32 bg-amber-50 rounded-full blur-xl -z-10"></div>
            
            <div class="w-20 h-20 rounded-3xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-6 shadow-md border border-amber-100 animate-bounce">
                <i data-lucide="clock" class="w-10 h-10"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3">Manual Verification in Progress</h2>
            <p class="text-slate-600 text-base leading-relaxed mb-6 max-w-xl mx-auto">
                Thank you for submitting your KYC documents! Our verification team is currently conducting a manual review of your application and documents to ensure compliance and security.
            </p>
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-amber-100 text-amber-900 font-bold text-sm mb-6">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-600 animate-ping"></span>
                Est. Completion Time: 24 - 48 Hours
            </div>
            <div>
                <a href="{{ route('partner.kyc') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                    View Submitted Documents ➔
                </a>
            </div>
        </div>

    @else
        <!-- Unlocked Celebration Card -->
        <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 rounded-3xl shadow-2xl shadow-indigo-600/40 p-8 md:p-12 text-center max-w-3xl mx-auto mb-12 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -z-10 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/20 rounded-full blur-3xl -z-10 pointer-events-none"></div>

            <div class="w-20 h-20 rounded-3xl bg-white/10 text-white flex items-center justify-center mx-auto mb-6 shadow-lg backdrop-blur-md border border-white/20">
                <i data-lucide="rocket" class="w-10 h-10 animate-bounce"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-black mb-3 tracking-tight">Partner Panel Fully Unlocked!</h2>
            <p class="text-indigo-100 text-base md:text-lg leading-relaxed mb-8 max-w-xl mx-auto">
                Congratulations! All verification steps are complete and your partner account is fully activated. You are now ready to submit leads, refer clients, and withdraw earnings.
            </p>
            <a href="{{ route('partner.dashboard') }}" class="inline-flex items-center gap-3 bg-white text-indigo-900 font-black text-lg px-10 py-4 rounded-2xl shadow-xl hover:bg-indigo-50 transition-all hover:-translate-y-0.5">
                Enter Partner Dashboard 🚀
            </a>
        </div>
    @endif

    <!-- Onboarding Perks Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="percent" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">High Commissions</h3>
                <p class="text-slate-500 text-xs mt-1 leading-relaxed">Earn top-tier industry commissions on every successful service conversion.</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="zap" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Fast Payouts</h3>
                <p class="text-slate-500 text-xs mt-1 leading-relaxed">Verified partners enjoy expedited withdrawal processing directly to bank accounts.</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="headphones" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Priority Support</h3>
                <p class="text-slate-500 text-xs mt-1 leading-relaxed">Direct access to our dedicated partner success managers and support desk.</p>
            </div>
        </div>
    </div>
</div>
@endsection
