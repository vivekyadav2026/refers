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
        <p class="text-slate-500 mt-1">Configure the services that partners can sell and view their base details.</p>
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
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-center">Base Price</th>
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
                        <div class="inline-flex items-center justify-center px-4 py-2 rounded-full border-2 border-emerald-100 bg-emerald-50 text-emerald-700 font-bold text-sm">
                            ₹{{ number_format($service->min_price, 0) }}
                        </div>
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
                             <button onclick="openModal({{ json_encode([
                                'id' => $service->id,
                                'name' => $service->name,
                                'category' => $service->category,
                                'short_description' => $service->short_description,
                                'description' => $service->description,
                                'min_price' => $service->min_price,
                                'icon' => $service->icon,
                                'is_popular' => $service->is_popular,
                                'is_active' => $service->is_active,
                                'delivery_timeline' => $service->delivery_timeline,
                                'requirements_text' => $service->requirements_text,
                                'commission_rate' => $service->commission_rate,
                                'commission_type' => $service->commission_type,
                                'features' => is_array($service->features) ? implode('\n', $service->features) : ''
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
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl flex flex-col max-h-[90vh]">
        
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
        <div class="overflow-y-auto p-5 sm:p-6">
            <form id="serviceForm" method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Service Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="serviceName" required
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                        <input type="text" name="category" id="serviceCategory" required
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none"
                            placeholder="e.g. Development, Marketing">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Base Price (₹) <span class="text-red-500">*</span></label>
                        <input type="number" name="min_price" id="servicePrice" required min="0" step="0.01"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Service Banner Image <span id="bannerImageRequired" class="text-red-500">*</span></label>
                        <input type="file" name="banner_image" id="serviceBanner" accept="image/*"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-1.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        <input type="hidden" name="icon" id="serviceIcon" value="box">
                        <span class="text-[10px] text-slate-400 font-bold block mt-1">Compressed auto under 200KB.</span>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Short Description <span class="text-red-500">*</span></label>
                    <textarea name="short_description" id="serviceDesc" rows="2" required
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Long Description (Detailed About Page)</label>
                    <textarea name="description" id="serviceLongDesc" rows="4"
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"
                        placeholder="Detailed explanation of the project/service..."></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Features (One per line) <span class="text-red-500">*</span></label>
                    <textarea name="features" id="serviceFeatures" rows="3" required
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"
                        placeholder="e.g.&#10;Custom Design&#10;Responsive Layout&#10;SEO Optimized"></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">What We Need From Client (Requirements Text)</label>
                    <textarea name="requirements_text" id="serviceRequirements" rows="3"
                        class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"
                        placeholder="Key access details, design references, business assets needed..."></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5 border-t border-slate-100 pt-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Delivery Timeline</label>
                        <input type="text" name="delivery_timeline" id="serviceTimeline"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none"
                            placeholder="e.g. 3-4 Weeks">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Commission Rate</label>
                        <input type="number" name="commission_rate" id="serviceCommissionRate" min="0" step="0.01"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none"
                            placeholder="e.g. 10 or 500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Commission Type</label>
                        <select name="commission_type" id="serviceCommissionType"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed (₹)</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-6 border-t border-slate-100 pt-5">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_popular" id="servicePopular" value="1" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                        <label for="servicePopular" class="text-sm font-semibold text-slate-700">Mark as Popular Service</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="serviceActive" value="1" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                        <label for="serviceActive" class="text-sm font-semibold text-slate-700">Published / Active</label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 sm:p-6 border-t border-slate-100 shrink-0 bg-slate-50 rounded-b-2xl flex flex-col sm:flex-row gap-3 justify-end">
            <button type="button" onclick="closeModal()"
                class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                Cancel
            </button>
            <button type="submit" form="serviceForm" id="submitBtn"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                Save Service
            </button>
        </div>

    </div>
</div>

<script>
function openModal(service = null) {
    const form = document.getElementById('serviceForm');
    const title = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const submitBtn = document.getElementById('submitBtn');

    if (service) {
        title.textContent = 'Edit Service';
        form.action = `/admin/services/${service.id}`;
        methodField.innerHTML = '@method("PUT")';
        submitBtn.textContent = 'Update Service';

        document.getElementById('serviceName').value = service.name;
        document.getElementById('serviceCategory').value = service.category;
        document.getElementById('servicePrice').value = service.min_price;
        document.getElementById('serviceIcon').value = service.icon || 'box';
        document.getElementById('serviceBanner').value = '';
        document.getElementById('serviceBanner').required = false;
        document.getElementById('bannerImageRequired').classList.add('hidden');
        document.getElementById('serviceDesc').value = service.short_description;
        document.getElementById('serviceLongDesc').value = service.description || '';
        // Parse escaped newlines back to actual newlines
        document.getElementById('serviceFeatures').value = (service.features || '').replace(/\\n/g, '\n');
        document.getElementById('serviceRequirements').value = service.requirements_text || '';
        document.getElementById('serviceTimeline').value = service.delivery_timeline || '';
        document.getElementById('serviceCommissionRate').value = service.commission_rate || '';
        document.getElementById('serviceCommissionType').value = service.commission_type || 'percentage';
        document.getElementById('servicePopular').checked = service.is_popular ? true : false;
        document.getElementById('serviceActive').checked = service.is_active ? true : false;
    } else {
        title.textContent = 'Add New Service';
        form.action = "{{ route('admin.services.store') }}";
        methodField.innerHTML = '';
        submitBtn.textContent = 'Save Service';

        form.reset();
        document.getElementById('serviceIcon').value = 'box'; // Default icon
        document.getElementById('serviceBanner').value = '';
        document.getElementById('serviceBanner').required = true;
        document.getElementById('bannerImageRequired').classList.remove('hidden');
        document.getElementById('serviceLongDesc').value = '';
        document.getElementById('serviceRequirements').value = '';
        document.getElementById('serviceTimeline').value = '';
        document.getElementById('serviceCommissionRate').value = '';
        document.getElementById('serviceCommissionType').value = 'percentage';
        document.getElementById('serviceActive').checked = true; // Default to checked (published)
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

// Close modal on backdrop click
document.getElementById('serviceModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
