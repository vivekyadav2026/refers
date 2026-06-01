@extends('layouts.app')

@section('title', 'Services Management - SKSolutions Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
{{-- Flash --}}
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

<!-- Header -->
<div class="sm:flex sm:justify-between sm:items-center mb-8">
    <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Services Management</h1>
        <p class="text-slate-500 mt-1">Configure services with Basic, Standard & Premium plans.</p>
    </div>
    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-3">
        <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2.5 flex items-center gap-2 text-sm font-medium shadow-sm transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add New Service
        </button>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
    <form method="GET" action="{{ route('admin.services') }}" id="filter-form">
        <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Active Services Directory</h2>
            
            <div class="flex gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2"
                        placeholder="Search services...">
                </div>
                <button type="submit" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">Search</button>
                @if(request('search'))
                    <a href="{{ route('admin.services') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium rounded-lg transition-colors">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Service Name & Description</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-center">Plans (Basic→Premium)</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($services as $service)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center shrink-0 overflow-hidden border border-slate-200 shadow-sm">
                                @if($service->banner_image)
                                    <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="{{ $service->icon ?? 'box' }}" class="w-5 h-5 text-indigo-600"></i>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-base">{{ $service->name }}</div>
                                <div class="text-slate-500 text-xs mt-1 max-w-md">{{ Str::limit($service->short_description, 80) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php $plans = $service->plans; @endphp
                        @if($plans && isset($plans['basic']))
                            <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                <span class="inline-flex flex-col items-center px-2 py-1 rounded-lg bg-slate-100 text-slate-700 text-[10px] font-bold border border-slate-200">
                                    <span class="text-[8px] uppercase tracking-wider text-slate-400">{{ $plans['basic']['name'] ?? 'Basic' }}</span>
                                    ₹{{ number_format($plans['basic']['price'], 0) }}
                                </span>
                                <span class="text-slate-300">→</span>
                                <span class="inline-flex flex-col items-center px-2 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-[10px] font-bold border border-indigo-100">
                                    <span class="text-[8px] uppercase tracking-wider text-indigo-400">{{ $plans['standard']['name'] ?? 'Standard' }}</span>
                                    ₹{{ number_format($plans['standard']['price'] ?? 0, 0) }}
                                </span>
                                <span class="text-slate-300">→</span>
                                <span class="inline-flex flex-col items-center px-2 py-1 rounded-lg bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-100">
                                    <span class="text-[8px] uppercase tracking-wider text-amber-400">{{ $plans['premium']['name'] ?? 'Premium' }}</span>
                                    ₹{{ number_format($plans['premium']['price'] ?? 0, 0) }}
                                </span>
                            </div>
                        @else
                            <div class="inline-flex items-center justify-center px-4 py-2 rounded-full border-2 border-emerald-100 bg-emerald-50 text-emerald-700 font-bold text-sm">
                                ₹{{ number_format($service->min_price, 0) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $service->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1.5">
                            @if($service->is_popular)
                                <span class="inline-flex items-center w-max gap-1 py-0.5 px-2.5 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800 border border-amber-200">
                                    <i data-lucide="star" class="w-2.5 h-2.5"></i> Popular
                                </span>
                            @endif
                            <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 py-0.5 px-2.5 rounded-full text-[10px] font-black uppercase transition-all {{ $service->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200 hover:bg-emerald-200' : 'bg-red-100 text-red-800 border border-red-200 hover:bg-red-200' }}" title="Click to Toggle Status">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $service->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ $service->is_active ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            @php
                                $servicePlans = $service->plans ?? [];
                                $basicPlan    = $servicePlans['basic']    ?? [];
                                $stdPlan      = $servicePlans['standard'] ?? [];
                                $premiumPlan  = $servicePlans['premium']  ?? [];
                            @endphp
                             <button onclick="openModal({{ json_encode([
                                'id'               => $service->id,
                                'name'             => $service->name,
                                'category'         => $service->category,
                                'short_description'=> $service->short_description,
                                'description'      => $service->description,
                                'icon'             => $service->icon,
                                'banner_image'     => $service->banner_image,
                                'is_popular'       => $service->is_popular,
                                'is_active'        => $service->is_active,
                                'requires_domain'  => $service->requires_domain,
                                'enable_gst'       => $service->enable_gst,
                                'gst_percent'      => $service->gst_percent,
                                'domain_in_charge' => $service->domain_in_charge,
                                'domain_com_charge'=> $service->domain_com_charge,
                                'enable_platforms' => $service->enable_platforms,
                                'platforms'        => $service->platforms ?? [],
                                'plans'            => $service->plans ?? [],
                                'pricing_matrix'   => $service->pricing_matrix ?? [],
                                'delivery_timeline'=> $service->delivery_timeline,
                                'requirements_text'=> $service->requirements_text,
                                'commission_rate'  => $service->commission_rate,
                                'commission_type'  => $service->commission_type,
                                'basic_name'          => $basicPlan['name']        ?? 'Basic',
                                'basic_price'         => $basicPlan['price']       ?? $service->min_price,
                                'basic_description'   => $basicPlan['description'] ?? '',
                                'basic_delivery'      => $basicPlan['delivery']    ?? '',
                                'basic_revisions'     => $basicPlan['revisions']   ?? '',
                                'basic_features'      => (isset($basicPlan['features']) && is_array($basicPlan['features'])) ? implode("\n", $basicPlan['features']) : (is_string($basicPlan['features'] ?? null) ? $basicPlan['features'] : (is_array($service->features) ? implode("\n", $service->features) : '')),
                                'basic_active'        => $basicPlan['active']      ?? true,
                                'standard_name'       => $stdPlan['name']          ?? 'Standard',
                                'standard_price'         => $stdPlan['price']       ?? '',
                                'standard_description'   => $stdPlan['description'] ?? '',
                                'standard_delivery'      => $stdPlan['delivery']    ?? '',
                                'standard_revisions'     => $stdPlan['revisions']   ?? '',
                                'standard_features'      => (isset($stdPlan['features']) && is_array($stdPlan['features'])) ? implode("\n", $stdPlan['features']) : (is_string($stdPlan['features'] ?? null) ? $stdPlan['features'] : ''),
                                'standard_active'        => $stdPlan['active']      ?? true,
                                'premium_name'        => $premiumPlan['name']         ?? 'Premium',
                                'premium_price'          => $premiumPlan['price']       ?? '',
                                'premium_description'    => $premiumPlan['description'] ?? '',
                                'premium_delivery'       => $premiumPlan['delivery']    ?? '',
                                'premium_revisions'      => $premiumPlan['revisions']   ?? '',
                                'premium_features'       => (isset($premiumPlan['features']) && is_array($premiumPlan['features'])) ? implode("\n", $premiumPlan['features']) : (is_string($premiumPlan['features'] ?? null) ? $premiumPlan['features'] : ''),
                                'premium_active'         => $premiumPlan['active']     ?? true,
                            ]) }})" class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors" title="Edit Service">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                  onsubmit="return confirm('Delete this service? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <i data-lucide="layout-grid" class="w-12 h-12"></i>
                            <p class="font-medium">No services found</p>
                            @if(request('search'))
                                <a href="{{ route('admin.services') }}" class="text-indigo-600 text-sm hover:underline">Clear search</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($services->hasPages())
    <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-sm text-slate-500">
            Showing <span class="font-semibold text-slate-900">{{ $services->firstItem() }}</span>
            to <span class="font-semibold text-slate-900">{{ $services->lastItem() }}</span>
            of <span class="font-semibold text-slate-900">{{ $services->total() }}</span> services
        </span>
        <div class="flex items-center gap-1">
            @if($services->onFirstPage())
                <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $services->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50">Previous</a>
            @endif
            @foreach($services->getUrlRange(max(1,$services->currentPage()-2), min($services->lastPage(),$services->currentPage()+2)) as $page => $url)
                @if($page == $services->currentPage())
                    <span class="px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 border-t border-b border-slate-200">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border-t border-b border-slate-200 hover:bg-slate-50">{{ $page }}</a>
                @endif
            @endforeach
            @if($services->hasMorePages())
                <a href="{{ $services->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50">Next</a>
            @else
                <span class="px-3 py-2 text-sm text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">Next</span>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- ─── SERVICE MODAL (Add/Edit) ────────────────────────────────────────────── --}}
<div id="serviceModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 sm:p-6">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl" style="max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
        
        <!-- Modal Header -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                </div>
                <h3 id="modalTitle" class="font-bold text-slate-900 text-lg">Add New Service</h3>
            </div>
            <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-100">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Body (Scrollable) -->
        <div class="p-5 sm:p-6" style="flex: 1 1 0%; overflow-y: auto; min-height: 0;">
            <form id="serviceForm" method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>
                
                {{-- ── BASIC INFO ──────────────────────────────────────────── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Service Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="serviceName" required
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category</label>
                        {{-- <select name="category" id="serviceCategory"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                            <option value="">Select a Category...</option>
                            @foreach($categories as $parent)
                                <optgroup label="{{ $parent->name }}">
                                    <option value="{{ $parent->name }}">{{ $parent->name }} (Parent)</option>
                                    @foreach($parent->subcategories as $sub)
                                        <option value="{{ $sub->name }}">{{ $sub->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select> --}}
                        <input type="text" name="category" id="serviceCategory" placeholder="Enter custom category"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Service Banner Image (For Details Page)</label>
                        <input type="file" name="banner_image" id="serviceBanner" accept="image/*"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-1.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        <span class="text-[10px] text-slate-400 font-bold block mt-1">Compressed auto under 200KB.</span>
                        
                        <!-- Dynamic Image Preview & Ratio Analysis -->
                        <div id="bannerPreviewWrapper" class="mt-3 hidden bg-slate-50 border border-slate-200/80 rounded-xl p-3 shadow-inner">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Image Preview & Analysis</span>
                            <div class="flex items-center gap-3">
                                <div class="w-20 h-16 rounded-lg overflow-hidden border border-slate-200 bg-white flex items-center justify-center shrink-0">
                                    <img id="bannerPreviewImg" src="" class="max-w-full max-h-full object-contain">
                                </div>
                                <div class="text-xs font-sans">
                                    <div class="font-bold text-slate-800" id="bannerPreviewDimensions">Dimensions: -</div>
                                    <div class="text-[11px] text-indigo-600 font-bold mt-0.5" id="bannerPreviewRatio">Aspect Ratio: -</div>
                                    <div class="text-[10px] text-slate-500 mt-0.5" id="bannerPreviewSize">File Size: -</div>
                                </div>
                            </div>
                            <div id="bannerPreviewFeedback" class="mt-2 text-[10px] font-bold hidden"></div>
                        </div>
                    </div>
                    <input type="hidden" name="icon" id="serviceIcon" value="box">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Short Description</label>
                    <textarea name="short_description" id="serviceDesc" rows="2"
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Long Description (Detailed About Page)</label>
                    <textarea name="description" id="serviceLongDesc" rows="3"
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"
                        placeholder="Detailed explanation of the project/service..."></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">What We Need From Client (Requirements Text)</label>
                    <textarea name="requirements_text" id="serviceRequirements" rows="2"
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"
                        placeholder="Key access details, design references, business assets needed..."></textarea>
                </div>

                {{-- ── DYNAMIC PRICING MATRIX ─────────────────────────────────────── --}}
                @include('admin.pricing_matrix')

                {{-- ── COMMISSION & SETTINGS ────────────────────────────── --}}
                <div class="mt-8 mb-4">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i data-lucide="settings-2" class="w-4 h-4 text-indigo-500"></i> Settings & Commission
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Delivery Timeline</label>
                            <input type="text" name="delivery_timeline" id="serviceTimeline"
                                class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none shadow-sm"
                                placeholder="e.g. 3-4 Weeks">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Commission Rate</label>
                            <input type="number" name="commission_rate" id="serviceCommissionRate" min="0" step="0.01"
                                class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none shadow-sm"
                                placeholder="e.g. 10 or 500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Commission Type</label>
                            <select name="commission_type" id="serviceCommissionType"
                                class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none shadow-sm">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed (₹)</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ── GST & DOMAIN CONFIGURATION ────────────────────────────── --}}
                <div class="mt-8 mb-6">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i data-lucide="percent" class="w-4 h-4 text-emerald-500"></i> GST & Domain Configuration
                    </h4>
                    <div class="bg-slate-50/50 p-5 rounded-2xl border border-slate-200/60 space-y-5">
                        <!-- GST Config Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="flex items-center">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative flex items-center justify-center shrink-0">
                                        <input type="hidden" name="enable_gst" value="0">
                                        <input type="checkbox" name="enable_gst" id="serviceEnableGst" value="1" class="peer sr-only">
                                        <div class="w-5 h-5 border-2 border-slate-300 rounded-md peer-checked:bg-emerald-500 peer-checked:border-emerald-500 transition-all"></div>
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-white absolute opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-emerald-700 transition-colors">Calculate GST for this Service</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">GST Percentage (%)</label>
                                <input type="number" name="gst_percent" id="serviceGstPercent" min="0" max="100" step="0.1"
                                    class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none shadow-sm"
                                    placeholder="18">
                            </div>
                        </div>

                        <hr class="border-slate-200/60">

                        <!-- Domain Config Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div class="flex items-center">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative flex items-center justify-center shrink-0">
                                        <input type="hidden" name="requires_domain" value="0">
                                        <input type="checkbox" name="requires_domain" id="serviceRequiresDomain" value="1" class="peer sr-only">
                                        <div class="w-5 h-5 border-2 border-slate-300 rounded-md peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all"></div>
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-white absolute opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-700 transition-colors">Requires Domain (Registration)</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">.IN Domain Price (₹)</label>
                                <input type="number" name="domain_in_charge" id="serviceDomainInCharge" min="0" step="0.1"
                                    class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none shadow-sm"
                                    placeholder="599">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">.COM Domain Price (₹)</label>
                                <input type="number" name="domain_com_charge" id="serviceDomainComCharge" min="0" step="0.1"
                                    class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none shadow-sm"
                                    placeholder="999">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs to preserve JS logic and set default states -->
                <input type="hidden" name="is_popular" value="0">
                <input type="checkbox" name="is_popular" id="servicePopular" value="1" class="hidden">
                <input type="hidden" name="is_active" value="1">
                <input type="checkbox" name="is_active" id="serviceActive" value="1" class="hidden" checked>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 sm:p-6 border-t border-slate-100 shrink-0 bg-white rounded-b-2xl flex items-center justify-between shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.02)]">
            <button type="button" onclick="closeModal()"
                class="px-6 py-2.5 bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold rounded-xl transition-all shadow-sm flex items-center gap-2">
                <i data-lucide="x" class="w-4 h-4"></i> Cancel
            </button>
            <button type="submit" form="serviceForm" id="submitBtn"
                class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                <i data-lucide="save" class="w-4 h-4"></i> Save Service
            </button>
        </div>

    </div>
</div>

<script>
// ── Plan Tab Switcher ──────────────────────────────────────────────────────────
function switchPlanTab(plan) {
    const tabs   = ['basic', 'standard', 'premium'];
    tabs.forEach(t => {
        const tab   = document.getElementById('tab-' + t);
        const panel = document.getElementById('panel-' + t);
        if (t === plan) {
            tab.className = 'plan-tab flex-1 py-3 text-xs font-black uppercase tracking-wider transition-all text-indigo-700 bg-white border-b-2 border-indigo-500';
            panel.classList.remove('hidden');
        } else {
            tab.className = 'plan-tab flex-1 py-3 text-xs font-black uppercase tracking-wider transition-all text-slate-500 hover:text-slate-700 hover:bg-slate-100';
            panel.classList.add('hidden');
        }
    });
}

// ── Image Preview Helpers ──────────────────────────────────────────────────────
function getClosestRatio(width, height) {
    const ratio = width / height;
    const targets = [
        { name: '16:9', val: 16/9, desc: 'Landscape' },
        { name: '16:7', val: 16/7, desc: 'Ideal Detail Banner' },
        { name: '21:9', val: 21/9, desc: 'Widescreen Banner' },
        { name: '6:5',  val: 6/5,  desc: 'Ideal Card Thumbnail' },
        { name: '4:3',  val: 4/3,  desc: 'Standard Desktop' },
        { name: '1:1',  val: 1,    desc: 'Square' }
    ];
    let minDiff = Infinity, closest = null;
    targets.forEach(t => { const d = Math.abs(ratio - t.val); if (d < minDiff) { minDiff = d; closest = t; } });
    return minDiff < 0.15 ? `${closest.name} (${closest.desc})` : ratio.toFixed(2) + ' : 1';
}

function analyzeImage(imgSrc, isUploadedFile = false, fileSizeKB = null) {
    const previewWrapper    = document.getElementById('bannerPreviewWrapper');
    const previewImg        = document.getElementById('bannerPreviewImg');
    const previewDimensions = document.getElementById('bannerPreviewDimensions');
    const previewRatio      = document.getElementById('bannerPreviewRatio');
    const previewSize       = document.getElementById('bannerPreviewSize');
    const previewFeedback   = document.getElementById('bannerPreviewFeedback');
    previewWrapper.classList.remove('hidden');
    previewFeedback.classList.add('hidden');
    previewImg.src = imgSrc;
    previewDimensions.textContent = 'Dimensions: loading...';
    previewRatio.textContent      = 'Aspect Ratio: loading...';
    previewSize.textContent       = isUploadedFile ? `File Size: ${fileSizeKB} KB` : 'File Size: Existing Server Image';
    const imgObj = new Image();
    imgObj.onload = function() {
        const w = this.naturalWidth, h = this.naturalHeight;
        previewDimensions.textContent = `Dimensions: ${w} x ${h} px`;
        previewRatio.textContent      = `Aspect Ratio: ${getClosestRatio(w, h)}`;
        previewFeedback.classList.remove('hidden');
        const ratio = w / h;
        if (ratio >= 2.0) {
            previewFeedback.innerHTML = '<span class="text-emerald-600">✓ Perfect aspect ratio for widescreen banner (16:7 / 21:9).</span>';
        } else if (ratio >= 1.1 && ratio <= 1.3) {
            previewFeedback.innerHTML = '<span class="text-indigo-600">ℹ️ Great for card thumbnail (6:5).</span>';
        } else {
            previewFeedback.innerHTML = '<span class="text-amber-600">⚠️ Widescreen banner is recommended (16:7 / 21:9).</span>';
        }
    };
    imgObj.src = imgSrc;
}

// ── Modal Open/Close ────────────────────────────────────────────────────────────
function openModal(service = null) {
    const form      = document.getElementById('serviceForm');
    const title     = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('bannerPreviewWrapper').classList.add('hidden');

    if (service) {
        title.textContent = 'Edit Service';
        form.action = `/admin/services/${service.id}`;
        methodField.innerHTML = '@method("PUT")';
        submitBtn.textContent = 'Update Service';

        document.getElementById('serviceName').value       = service.name;
        document.getElementById('serviceCategory').value   = service.category;
        document.getElementById('serviceIcon').value       = service.icon || 'box';
        document.getElementById('serviceBanner').value     = '';
        document.getElementById('serviceDesc').value       = service.short_description;
        document.getElementById('serviceLongDesc').value   = service.description || '';
        document.getElementById('serviceRequirements').value = service.requirements_text || '';
        document.getElementById('serviceTimeline').value   = service.delivery_timeline || '';
        document.getElementById('serviceCommissionRate').value = service.commission_rate || '';
        document.getElementById('serviceCommissionType').value = service.commission_type || 'percentage';
        document.getElementById('servicePopular').checked  = service.is_popular ? true : false;
        document.getElementById('serviceActive').checked   = service.is_active ? true : false;
        document.getElementById('serviceRequiresDomain').checked = service.requires_domain ? true : false;
        document.getElementById('serviceEnableGst').checked = service.enable_gst !== undefined ? (service.enable_gst ? true : false) : true;
        document.getElementById('serviceGstPercent').value = service.gst_percent !== undefined ? service.gst_percent : '18.00';
        document.getElementById('serviceDomainInCharge').value = service.domain_in_charge !== undefined ? service.domain_in_charge : '599.00';
        document.getElementById('serviceDomainComCharge').value = service.domain_com_charge !== undefined ? service.domain_com_charge : '999.00';
        
        window.dispatchEvent(new CustomEvent('load-service-pricing', { detail: service }));

        if (service.banner_image) {
            analyzeImage('/storage/' + service.banner_image, false);
        }
    } else {
        title.textContent = 'Add New Service';
        form.action = "{{ route('admin.services.store') }}";
        methodField.innerHTML = '';
        submitBtn.textContent = 'Save Service';
        form.reset();
        document.getElementById('serviceIcon').value = 'box';
        document.getElementById('serviceActive').checked = true;
        document.getElementById('serviceRequiresDomain').checked = false;
        document.getElementById('serviceEnableGst').checked = true;
        document.getElementById('serviceGstPercent').value = '18.00';
        document.getElementById('serviceDomainInCharge').value = '599.00';
        document.getElementById('serviceDomainComCharge').value = '999.00';
        
        window.dispatchEvent(new CustomEvent('load-service-pricing', { detail: null }));
    }

    const modal = document.getElementById('serviceModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('serviceModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Removed legacy platform and plan helpers

// File input selection
document.getElementById('serviceBanner').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) { return; }
    const sizeKB = (file.size / 1024).toFixed(1);
    const reader = new FileReader();
    reader.onload = function(event) { analyzeImage(event.target.result, true, sizeKB); };
    reader.readAsDataURL(file);
});

// Close modal on backdrop click
document.getElementById('serviceModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

</script>
@endsection
