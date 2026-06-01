@extends('layouts.app')
@section('title', 'My Profile — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')
<div class="py-4 sm:py-6">

{{-- Page Header --}}
<div class="mb-8">
    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-black px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
        <i data-lucide="user" class="w-3.5 h-3.5"></i> Account Settings
    </div>
    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">My Profile</h1>
    <p class="text-slate-500 font-medium mt-1 text-sm">Manage your account details and preferences.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left Sidebar --}}
    <div class="space-y-5 mb-6 lg:mb-0">

        {{-- Avatar Card --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full -z-10 blur-xl"></div>
            <div class="absolute -top-4 -left-4 w-20 h-20 bg-gradient-to-br from-purple-50 to-pink-50 rounded-full blur-2xl -z-10"></div>

            @if(auth()->user()->avatar)
                <div class="w-20 h-20 rounded-full mx-auto mb-4 shadow-lg ring-4 ring-blue-50 overflow-hidden">
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center text-3xl font-black mx-auto mb-4 shadow-lg shadow-blue-600/25 ring-4 ring-blue-50">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif

            <h2 class="text-lg font-black text-slate-900">{{ auth()->user()->name }}</h2>
            <p class="text-xs font-medium text-slate-500 mb-4">{{ auth()->user()->email ?? auth()->user()->phone }}</p>
<!-- 
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 font-black text-xs border border-blue-100 uppercase tracking-wider">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Verified Customer
            </div> -->
        </div>

        {{-- Account Stats --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 relative overflow-hidden">
            <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-gradient-to-br from-slate-50 to-slate-100 rounded-full blur-2xl -z-10"></div>
            <h3 class="font-black text-slate-900 mb-4 text-sm uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="w-4 h-4 text-blue-500"></i> Account Stats
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between bg-slate-50 rounded-2xl px-4 py-3 border border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-600">Total Orders</span>
                    </div>
                    <span class="font-black text-slate-900">{{ auth()->user()->orders()->count() }}</span>
                </div>
                <div class="flex items-center justify-between bg-slate-50 rounded-2xl px-4 py-3 border border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-600">Member Since</span>
                    </div>
                    <span class="font-black text-slate-900">{{ auth()->user()->created_at->format('d-M-Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Quick Links --}}
        <!-- <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-black text-slate-900 mb-4 text-xs uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="link" class="w-4 h-4 text-blue-500"></i> Quick Links
            </h3>
            <div class="space-y-2">
                <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-blue-50 hover:text-blue-600 text-slate-600 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-blue-100 text-slate-500 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                        <i data-lucide="package" class="w-4 h-4"></i>
                    </div>
                    <span class="text-xs font-black">My Orders</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-auto opacity-40 group-hover:opacity-100 transition-opacity"></i>
                </a>
                <a href="{{ route('customer.services') }}" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-blue-50 hover:text-blue-600 text-slate-600 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-blue-100 text-slate-500 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                        <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                    </div>
                    <span class="text-xs font-black">Browse Services</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-auto opacity-40 group-hover:opacity-100 transition-opacity"></i>
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-blue-50 hover:text-blue-600 text-slate-600 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-blue-100 text-slate-500 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                        <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    </div>
                    <span class="text-xs font-black">My Cart</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-auto opacity-40 group-hover:opacity-100 transition-opacity"></i>
                </a>
            </div>
        </div> -->
    </div>

    {{-- Main Profile Form --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Form Header --}}
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                    <i data-lucide="user-cog" class="w-4.5 h-4.5"></i>
                </div>
                <div>
                    <h2 class="text-base font-black text-slate-900">Personal Information</h2>
                    <p class="text-xs text-slate-500 font-medium">Update your account details below</p>
                </div>
            </div>

            <div class="p-5 sm:p-8">
                @if(session('success'))
                <div class="flex items-center gap-3 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl text-sm font-bold">
                    <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Profile Photo <span class="text-red-500">*</span></label>
                            <input type="file" name="avatar" accept="image/*" {{ !auth()->user()->avatar ? 'required' : '' }}
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                            @error('avatar') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Full Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                    class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                            </div>
                            @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                            </div>
                            @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Phone Number <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="phone" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                                    class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                            </div>
                            @error('phone') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Company Name <span class="text-slate-400 font-normal normal-case">(Optional)</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="building" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="text" name="company_name" value="{{ old('company_name', auth()->user()->company_name) }}" placeholder="e.g. Acme Corp"
                                    class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <div class="relative group/field">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Business Type</label>
                                <div class="absolute inset-y-0 left-0 pt-6 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="briefcase" class="w-5 h-5 text-slate-400 group-focus-within/field:text-blue-500 transition-colors"></i>
                                </div>
                                <select name="business_type" class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all font-medium appearance-none">
                                    <option value="">-- Select Business Type --</option>
                                    {{-- @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @if($category->subcategories->count() > 0)
                                                @foreach($category->subcategories as $sub)
                                                    <option value="{{ $sub->name }}" {{ auth()->user()->business_type == $sub->name ? 'selected' : '' }}>{{ $sub->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="{{ $category->name }}" {{ auth()->user()->business_type == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endif
                                        </optgroup>
                                    @endforeach --}}
                                    @foreach(['Grocery Store', 'Kirana Store', 'Supermarket', 'Dairy Shop', 'Sweet Shop', 'Bakery', 'Fruits & Vegetables Shop', 'Mobile Shop', 'Mobile Accessories Shop', 'Computer & Laptop Shop', 'Electronics Store', 'Electrical Shop', 'Hardware Store', 'Paint Shop', 'Sanitary & Bath Fittings Shop', 'Building Material Store', 'Furniture Shop', 'Mattress Shop', 'Home Decor Shop', 'Gift Shop', 'Stationery Shop', 'Book Store', 'Toy Shop', 'Sports Shop', 'Garments Shop', "Men's Wear Shop", "Women's Wear Shop", 'Kids Wear Shop', 'Footwear Shop', 'Jewellery Shop', 'Cosmetic Shop', 'Medical Store', 'Optical Shop', 'Pet Shop', 'Automobile Parts Shop', 'Bike Accessories Shop', 'Car Accessories Shop', 'Tyre Shop', 'Agricultural Equipment Shop', 'Seed & Fertilizer Shop'] as $cat)
                                        <option value="{{ $cat }}" {{ auth()->user()->business_type == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                    
                                    <optgroup label="Services Categories">
                                        @foreach(['Travel Agency', 'Tour Operator', 'Taxi Service', 'Car Rental Service', 'Packers & Movers', 'Courier Service', 'Event Management', 'Wedding Planner', 'Catering Service', 'Photography Service', 'Videography Service', 'Printing Service', 'GST Consultant', 'CA Services', 'Legal Services', 'Insurance Consultant', 'Real Estate Consultant', 'Property Dealer', 'Interior Designer', 'Architect', 'Construction Contractor', 'Security Guard Service', 'Housekeeping Service', 'Pest Control Service', 'Cleaning Service', 'AC Repair Service', 'Refrigerator Repair', 'Washing Machine Repair', 'Electrician Service', 'Plumber Service', 'Carpenter Service', 'CCTV Installation', 'Computer Repair Service', 'Mobile Repair Service', 'Beauty Parlour', 'Salon Service', 'Spa & Wellness Center', 'Gym & Fitness Center', 'Yoga Classes', 'Coaching Institute', 'Tuition Center', 'Driving School', 'Nursing Service', 'Ambulance Service', 'Diagnostic Lab', 'Vehicle Service Center', 'Water Tank Cleaning Service', 'Others'] as $cat)
                                            <option value="{{ $cat }}" {{ auth()->user()->business_type == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-4 top-10 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5 flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <button type="submit" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-xs uppercase tracking-wider hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-0.5 w-full sm:w-auto justify-center">
                            <i data-lucide="save" class="w-4 h-4"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
