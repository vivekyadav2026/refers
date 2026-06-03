@extends('layouts.app')

@section('title', 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' - Admin')

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

    <!-- Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.orders') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Orders
        </a>
        <div class="flex gap-2">
            @if(in_array($order->status, ['paid', 'processing', 'in_progress', 'completed']))
            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-medium rounded-xl border border-indigo-200 transition-colors">
                <i data-lucide="download" class="w-4 h-4"></i> Invoice
            </a>
            @endif
            <a href="{{ route('admin.orders.edit', $order) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-medium rounded-xl border border-amber-200 transition-colors">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit
            </a>
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                  onsubmit="return confirm('Delete this order permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                </button>
            </form>
        </div>
    </div>

    @php
        $statusConfig = match($order->status) {
            'paid'      => ['bg-blue-100 text-blue-800 border-blue-200',    'credit-card', 'Paid'],
            'completed' => ['bg-emerald-100 text-emerald-800 border-emerald-200', 'check-circle','Completed'],
            'cancelled' => ['bg-red-100 text-red-800 border-red-200',       'x-circle',    'Cancelled'],
            default     => ['bg-amber-100 text-amber-800 border-amber-200', 'clock',       'Pending'],
        };
    @endphp

    <!-- Order Header Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="shopping-bag" class="w-7 h-7"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        Order <span class="font-mono">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </h1>
                    <p class="text-slate-500 text-sm">Placed {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold border {{ $statusConfig[0] }}">
                    <i data-lucide="{{ $statusConfig[1] }}" class="w-4 h-4"></i>
                    {{ $statusConfig[2] }}
                </span>
                <div class="text-2xl font-bold text-slate-900">₹{{ number_format($order->amount, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <!-- Left: Customer + Service + Lead -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Customer Info -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4"></i> Customer
                </h2>
                @if($order->user)
                    @php
                        $words = array_filter(explode(' ', trim($order->user->name)));
                        $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice($words, 0, 2))));
                    @endphp
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ $initials }}
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900">{{ $order->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $order->user->email }}</div>
                            @if($order->user->phone)
                                <div class="text-xs text-slate-500">{{ $order->user->phone }}</div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.users.show', $order->user) }}"
                       class="inline-flex items-center gap-1.5 text-xs text-indigo-600 hover:underline font-medium">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        View {{ ucfirst($order->user->role) }} Profile
                    </a>
                @else
                    <p class="text-slate-400 text-sm italic">Customer account has been deleted.</p>
                @endif
            </div>

            <!-- Service Info -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="box" class="w-4 h-4"></i> Service
                </h2>
                @if($order->service)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 border border-slate-100">
                            @if($order->service->banner_image)
                                <img src="{{ asset('storage/' . $order->service->banner_image) }}" alt="{{ $order->service->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-purple-50 text-purple-600 flex items-center justify-center">
                                    <i data-lucide="{{ $order->service->icon ?? 'box' }}" class="w-5 h-5"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900">{{ $order->service->name }}</div>
                            @if($order->service->category)
                                <div class="text-xs text-slate-500">{{ $order->service->category }}</div>
                            @endif
                            <div class="text-xs text-slate-500 mt-1">{{ $order->service->short_description }}</div>
                        </div>
                    </div>
                @elseif($order->lead && $order->lead->service_needed)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <i data-lucide="box" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900">{{ $order->lead->service_needed }}</div>
                            <div class="text-xs text-slate-500">Custom Service</div>
                        </div>
                    </div>
                @else
                    <p class="text-slate-400 text-sm italic">Service has been removed.</p>
                @endif
            </div>

            <!-- Lead Info -->
            @if($order->lead)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="target" class="w-4 h-4"></i> Associated Lead
                </h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-500 text-xs font-medium mb-0.5">Client</p>
                        <p class="font-semibold text-slate-900">{{ $order->lead->client_name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-medium mb-0.5">Company</p>
                        <p class="text-slate-700">{{ $order->lead->company_name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-medium mb-0.5">Email</p>
                        <p class="text-slate-700">{{ $order->lead->client_email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-medium mb-0.5">Phone</p>
                        <p class="text-slate-700">{{ $order->lead->client_phone ?? '—' }}</p>
                    </div>
                    @if($order->lead->partner)
                    <div class="col-span-2">
                        <p class="text-slate-500 text-xs font-medium mb-0.5">Referring Partner</p>
                        <p class="font-semibold text-indigo-700">{{ $order->lead->partner->name }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Requirements -->
            @if($order->requirements)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="w-4 h-4"></i> Requirements
                </h2>
                <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $order->requirements }}</div>
            </div>
            @endif

            <!-- Business Details -->
            @if($order->businessDetail)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-4 h-4"></i> Business Details
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm bg-slate-50 rounded-xl p-5 border border-slate-100">
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mb-0.5">Business Name</p>
                        <p class="font-bold text-slate-900">{{ $order->businessDetail->business_name }}</p>
                    </div>
                    @if($order->businessDetail->domain_name)
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mb-0.5">Domain Name</p>
                        <p class="font-bold text-slate-900">{{ $order->businessDetail->domain_name }}</p>
                    </div>
                    @endif
                    @if($order->businessDetail->support_phone)
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mb-0.5">Support Phone</p>
                        <p class="font-bold text-slate-900">{{ $order->businessDetail->support_phone }}</p>
                    </div>
                    @endif
                    @if($order->businessDetail->support_email)
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mb-0.5">Support Email</p>
                        <p class="font-bold text-slate-900">{{ $order->businessDetail->support_email }}</p>
                    </div>
                    @endif
                    @if($order->businessDetail->office_address)
                    <div class="md:col-span-2">
                        <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mb-0.5">Office Address</p>
                        <p class="font-bold text-slate-900">{{ $order->businessDetail->office_address }}</p>
                    </div>
                    @endif

                    @if($order->businessDetail->logo_path)
                    <div class="md:col-span-2 mt-2">
                        <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mb-2">Business Logo</p>
                        <div class="w-20 h-20 rounded-xl border border-slate-200 overflow-hidden bg-white p-1">
                            <a href="{{ asset('storage/' . $order->businessDetail->logo_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->businessDetail->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($order->businessDetail->product_images && count($order->businessDetail->product_images) > 0)
                    <div class="md:col-span-2 mt-2">
                        <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider mb-2">Product Images ({{ count($order->businessDetail->product_images) }})</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($order->businessDetail->product_images as $imgPath)
                                <a href="{{ asset('storage/' . $imgPath) }}" target="_blank" class="block w-16 h-16 rounded-xl border border-slate-200 overflow-hidden bg-white shrink-0 hover:ring-2 hover:ring-indigo-500 transition-all">
                                    <img src="{{ asset('storage/' . $imgPath) }}" alt="Product" class="w-full h-full object-cover">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-4 h-4"></i> Business Details
                </h2>
                <div class="bg-amber-50 text-amber-700 text-sm font-medium px-4 py-3 rounded-xl border border-amber-200 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    Customer has not submitted their business details yet.
                </div>
            </div>
            @endif

        </div>

        <!-- Right: Quick Actions + Commissions + Review -->
        <div class="space-y-5">

            <!-- Quick Status Update -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4"></i> Quick Status
                </h2>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="relative">
                        <select name="status"
                            class="w-full appearance-none bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                            <option value="pending"     {{ $order->status === 'pending'     ? 'selected' : '' }}>Pending</option>
                            <option value="paid"        {{ $order->status === 'paid'        ? 'selected' : '' }}>Paid</option>
                            <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed"   {{ $order->status === 'completed'   ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled"   {{ $order->status === 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4"></i> Timeline
                </h2>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Order Placed</p>
                            <p class="text-xs text-slate-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @if($order->status !== 'pending')
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Payment Received</p>
                            <p class="text-xs text-slate-500">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($order->status === 'completed')
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Order Completed</p>
                            <p class="text-xs text-slate-500">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Details -->
            @if($order->razorpay_order_id || $order->razorpay_payment_id)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4"></i> Razorpay Payment Info
                </h2>
                <div class="space-y-3 text-sm">
                    @if($order->razorpay_order_id)
                    <div>
                        <p class="text-slate-500 text-xs font-medium mb-0.5">Razorpay Order ID</p>
                        <p class="font-mono text-xs font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded inline-block">{{ $order->razorpay_order_id }}</p>
                    </div>
                    @endif
                    @if($order->razorpay_payment_id)
                    <div>
                        <p class="text-slate-500 text-xs font-medium mb-0.5">Razorpay Payment ID</p>
                        <p class="font-mono text-xs font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded inline-block">{{ $order->razorpay_payment_id }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Payment Breakdown -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="receipt" class="w-4 h-4"></i> Payment Breakdown
                </h2>
                <div class="space-y-3 text-sm">
                    @php
                        $planPrice = $order->items->first()->subtotal ?? $order->amount;
                    @endphp
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 font-medium">Plan Price</span>
                        <span class="text-slate-900 font-bold">₹{{ number_format($planPrice) }}</span>
                    </div>
                    @if($order->platform_choice)
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 font-medium">Platform ({{ ucfirst($order->platform_choice) }})</span>
                        <span class="text-slate-900 font-bold">₹{{ number_format($order->platform_price) }}</span>
                    </div>
                    @endif
                    @if($order->domain_choice && $order->domain_choice !== 'already_have')
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 font-medium">Domain (.{{ $order->domain_choice }})</span>
                        <span class="text-slate-900 font-bold">₹{{ number_format($order->domain_charge) }}</span>
                    </div>
                    @endif
                    @if($order->gst_amount > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 font-medium">GST (18%)</span>
                        <span class="text-slate-900 font-bold">₹{{ number_format($order->gst_amount) }}</span>
                    </div>
                    @endif
                    <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-slate-800 font-bold">Total Paid</span>
                        <span class="text-indigo-600 font-black text-lg">₹{{ number_format($order->amount) }}</span>
                    </div>
                </div>
            </div>

            <!-- Commissions -->
            @if($order->commissions->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="percent" class="w-4 h-4"></i> Commissions
                </h2>
                <div class="space-y-3">
                    @foreach($order->commissions as $commission)
                    <div class="flex items-center justify-between text-sm">
                        <div>
                            <p class="font-medium text-slate-800">{{ $commission->user->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ $commission->type }} · {{ $commission->percentage }}%</p>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-emerald-600">₹{{ number_format($commission->amount, 2) }}</div>
                            <div class="text-xs capitalize {{ $commission->status === 'paid' ? 'text-emerald-500' : 'text-amber-500' }}">
                                {{ $commission->status }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Review -->
            @if($order->review)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="star" class="w-4 h-4"></i> Customer Review
                </h2>
                <div class="flex items-center gap-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i data-lucide="star" class="w-4 h-4 {{ $i <= $order->review->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}"></i>
                    @endfor
                    <span class="text-sm font-bold text-slate-700 ml-1">{{ $order->review->rating }}/5</span>
                </div>
                @if($order->review->comment)
                    <p class="text-sm text-slate-600 italic">"{{ $order->review->comment }}"</p>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
