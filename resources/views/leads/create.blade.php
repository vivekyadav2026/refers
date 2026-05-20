@extends('layouts.app')

@section('title', 'Submit New Lead - SK Solutions Partner Network')

@section('sidebar')
    <!-- Enables sidebar -->
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto">

    <!-- Back -->
    <div class="mb-6">
        <a href="{{ route('partner.leads.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to My Leads
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Submit a New Lead</h1>
        <p class="text-slate-500 mt-1">Provide details about the potential client to help us close the deal faster.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm">
        <div class="font-semibold mb-2 flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4"></i> Please fix the following errors:
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('partner.leads.store') }}" method="POST" id="lead-form">
        @csrf
        <div class="space-y-6">

            <!-- Client Info -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4"></i> Client Information
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <!-- Client Name -->
                    <div class="sm:col-span-2">
                        <label for="client_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Client Name / Company <span class="text-red-500">*</span></label>
                        <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}"
                            class="w-full border @error('client_name') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                            placeholder="e.g. Rahul Kumar / TechCorp Pvt. Ltd." required>
                        @error('client_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="client_phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="phone" class="h-4 w-4 text-slate-400"></i>
                            </div>
                            <input type="tel" id="client_phone" name="client_phone" value="{{ old('client_phone') }}"
                                class="w-full border @error('client_phone') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                                placeholder="+91 98765 43210" required>
                        </div>
                        @error('client_phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="client_email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="h-4 w-4 text-slate-400"></i>
                            </div>
                            <input type="email" id="client_email" name="client_email" value="{{ old('client_email') }}"
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                                placeholder="client@example.com">
                        </div>
                    </div>

                    <!-- Company -->
                    <div class="sm:col-span-2">
                        <label for="company_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Company Name <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                            placeholder="Company name if applicable">
                    </div>

                </div>
            </div>

            <!-- Project Details -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-4 h-4"></i> Project Details
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <!-- Service Needed -->
                    <div class="sm:col-span-2">
                        <label for="service_needed" class="block text-sm font-semibold text-slate-700 mb-1.5">Service Required <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="service_needed" name="service_needed"
                                class="w-full appearance-none border @error('service_needed') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition" required>
                                <option value="" data-price="">-- Select a service --</option>
                                @forelse($services as $service)
                                    <option value="{{ $service->name }}" data-price="{{ $service->min_price }}" {{ old('service_needed') === $service->name ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @empty
                                    <option value="Web Development" data-price="25000">Web Development</option>
                                    <option value="Mobile App" data-price="50000">Mobile App</option>
                                    <option value="UI/UX Design" data-price="15000">UI/UX Design</option>
                                    <option value="Digital Marketing" data-price="10000">Digital Marketing</option>
                                    <option value="Other" data-price="5000">Other</option>
                                @endforelse
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                        @error('service_needed') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Estimated Value -->
                    <div>
                        <label for="estimated_value" class="block text-sm font-semibold text-slate-700 mb-1.5">Estimated Project Value (₹)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none font-semibold text-slate-400">₹</div>
                            <input type="number" id="estimated_value" name="estimated_value" value="{{ old('estimated_value') }}" min="0" step="100"
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl pl-8 pr-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                                placeholder="50000">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="sm:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Additional Notes <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <textarea id="notes" name="notes" rows="4"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition resize-none"
                            placeholder="Any specific requirements, deadlines, or context that would help our team...">{{ old('notes') }}</textarea>
                    </div>

                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('partner.leads.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Submit Lead
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const serviceSelect = document.getElementById('service_needed');
    const estimatedValueInput = document.getElementById('estimated_value');

    // Run on change
    serviceSelect.addEventListener('change', function () {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        
        if (price) {
            estimatedValueInput.value = price;
        } else {
            estimatedValueInput.value = '';
        }
    });

    // Run on load in case of validation errors with an already selected value
    const initialOption = serviceSelect.options[serviceSelect.selectedIndex];
    if (initialOption && initialOption.getAttribute('data-price') && !estimatedValueInput.value) {
        estimatedValueInput.value = initialOption.getAttribute('data-price');
    }
});
</script>
@endpush
@endsection
