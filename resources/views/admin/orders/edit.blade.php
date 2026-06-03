@extends('layouts.app')

@section('title', 'Edit Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-3xl mx-auto">

    <!-- Back -->
    <div class="mb-6">
        <a href="{{ route('admin.orders.show', $order) }}"
           class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Order Detail
        </a>
    </div>

    <!-- Page Title -->
    <div class="mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200">
            <i data-lucide="pencil" class="w-6 h-6"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                Edit Order <span class="font-mono text-indigo-600">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </h1>
            <p class="text-slate-500 text-sm mt-0.5">Update status, amount, service and requirements.</p>
        </div>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm">
            <div class="font-semibold mb-2 flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i> Please fix the following:
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
        @csrf
        @method('PUT')

        <!-- Order Info (read-only summary) -->
        <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5 mb-5 flex flex-wrap gap-5 text-sm">
            <div>
                <p class="text-xs text-slate-500 font-medium mb-0.5">Customer</p>
                <p class="font-semibold text-slate-800">{{ $order->user->name ?? 'Unknown' }}</p>
                <p class="text-xs text-slate-500">{{ $order->user->email ?? '' }}</p>
            </div>
            @if($order->lead)
            <div>
                <p class="text-xs text-slate-500 font-medium mb-0.5">Lead</p>
                <p class="font-semibold text-slate-800">{{ $order->lead->client_name }}</p>
                <p class="text-xs text-slate-500">Lead #{{ $order->lead->id }}</p>
            </div>
            @endif
            <div>
                <p class="text-xs text-slate-500 font-medium mb-0.5">Order Date</p>
                <p class="font-semibold text-slate-800">{{ $order->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500">{{ $order->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Section: Order Details -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-5">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                <i data-lucide="shopping-bag" class="w-4 h-4"></i> Order Details
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <!-- Service -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Service</label>
                    <div class="relative">
                        <select name="service_id"
                            class="w-full appearance-none border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                            <option value="">— No Service —</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ old('service_id', $order->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} ({{ $service->category }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Amount (₹) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-500 font-semibold text-sm">₹</span>
                        <input type="number" id="amount" name="amount" step="0.01" min="0"
                            value="{{ old('amount', $order->amount) }}"
                            class="w-full border @error('amount') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl pl-8 pr-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                            required>
                    </div>
                    @error('amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="status" name="status"
                            class="w-full appearance-none border @error('status') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                            <option value="pending"     {{ old('status', $order->status) === 'pending'     ? 'selected' : '' }}>Pending</option>
                            <option value="paid"        {{ old('status', $order->status) === 'paid'        ? 'selected' : '' }}>Paid</option>
                            <option value="in_progress" {{ old('status', $order->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed"   {{ old('status', $order->status) === 'completed'   ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled"   {{ old('status', $order->status) === 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Requirements -->
                <div class="sm:col-span-2">
                    <label for="requirements" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Requirements / Notes
                    </label>
                    <textarea id="requirements" name="requirements" rows="5"
                        class="w-full border @error('requirements') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition resize-none"
                        placeholder="Customer requirements, special notes, project details...">{{ old('requirements', $order->requirements) }}</textarea>
                    @error('requirements') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <p class="text-xs text-slate-400 mt-1">Max 3,000 characters.</p>
                </div>
            </div>
        </div>

        @php $orderId = str_pad($order->id, 5, '0', STR_PAD_LEFT); @endphp
        <!-- Danger Zone -->
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-6">
            <h2 class="text-sm font-bold text-red-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Danger Zone
            </h2>
            <p class="text-sm text-red-600 mb-4">Permanently delete this order and all associated commissions. This cannot be undone.</p>
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                  onsubmit="return confirm('Permanently DELETE Order #ORD-{{ $orderId }}? This cannot be undone.')">

                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Delete Order
                </button>
            </form>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('admin.orders.show', $order) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i> Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i data-lucide="save" class="w-4 h-4"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
