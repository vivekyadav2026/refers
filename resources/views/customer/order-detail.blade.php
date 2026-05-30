@extends('layouts.app')
@section('title', 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')
<div class="max-w-3xl mx-auto">

<div class="mb-8">
    <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-white hover:text-white transition-colors bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-full shadow-sm hover:shadow-md">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Orders
    </a>
</div>

@if($order->status === 'paid' || $order->status === 'in_progress')
    @if(!$order->businessDetail)
    <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-blue-600/20 flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 text-center sm:text-left">
            <h3 class="text-xl font-black mb-2 flex items-center gap-2 justify-center sm:justify-start">
                <i data-lucide="alert-circle" class="w-6 h-6 text-blue-200"></i> Action Required
            </h3>
            <p class="text-blue-100 font-medium">Please provide your business details so our team can start working on your project.</p>
        </div>
        <div class="relative z-10 shrink-0">
            <a href="{{ route('customer.business-details.create', $order) }}" class="inline-flex items-center gap-2 bg-white text-blue-700 hover:bg-blue-50 font-black text-sm uppercase tracking-wider px-6 py-3 rounded-xl transition-all shadow-sm hover:shadow">
                <i data-lucide="edit-3" class="w-4 h-4"></i> Fill Details Form
            </a>
        </div>
    </div>
    @endif
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Order Header --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full -z-10 blur-xl"></div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                <div>
                    <div class="inline-flex items-center gap-2 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full mb-3">
                        <i data-lucide="hash" class="w-3 h-3"></i> ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Order Summary</h1>
                    <p class="text-sm font-medium text-slate-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                @php
                    $statusDetails = [
                        'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'clock'],
                        'paid' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'check-circle-2'],
                        'in_progress' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'icon' => 'loader-2'],
                        'completed' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'check-circle'],
                        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'x-circle'],
                    ];
                    $status = $statusDetails[$order->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'icon' => 'circle'];
                @endphp
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl {{ $status['bg'] }} {{ $status['text'] }} border {{ $status['border'] }} shadow-sm">
                    <i data-lucide="{{ $status['icon'] }}" class="w-4 h-4 {{ $order->status === 'in_progress' ? 'animate-spin' : '' }}"></i>
                    <span class="text-sm font-bold uppercase tracking-wider">{{ str_replace('_', ' ', $order->status) }}</span>
                </div>
            </div>
        </div>

        {{-- Service Info --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-8">
            <h2 class="text-xl font-black text-slate-900 mb-6">Service Details</h2>
            <div class="flex items-center gap-5 mb-6 bg-slate-50 p-5 rounded-2xl border border-slate-100">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/20 shrink-0">
                    <i data-lucide="{{ optional($order->service)->icon ?? 'box' }}" class="w-8 h-8"></i>
                </div>
                <div>
                    <h3 class="font-black text-lg text-slate-900 mb-1">{{ optional($order->service)->name ?? $order->lead->service_needed ?? 'Custom Service' }}</h3>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider text-[10px]">{{ optional($order->service)->category ?? 'Custom' }}</p>
                </div>
            </div>

            @if($order->items->count())
            <div class="border-t border-slate-100 pt-6">
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Included Items</h4>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl p-4 hover:border-blue-200 hover:shadow-md transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i data-lucide="{{ optional($item->service)->icon ?? 'box' }}" class="w-5 h-5"></i>
                            </div>
                            <span class="font-bold text-slate-800">{{ optional($item->service)->name ?? 'Custom Service' }}</span>
                        </div>
                        <span class="font-black text-slate-900">₹{{ number_format($item->subtotal) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Requirements --}}
        @if($order->requirements)
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <h2 class="text-xl font-black text-slate-900">Project Requirements</h2>
            </div>
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <p class="text-slate-600 leading-relaxed whitespace-pre-wrap font-medium">{{ $order->requirements }}</p>
            </div>
        </div>
        @endif

        {{-- Business Details Summary --}}
        @if($order->businessDetail)
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                </div>
                <h2 class="text-xl font-black text-slate-900">Business Details Submitted</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 rounded-2xl p-6 border border-slate-100 text-sm">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Business Name</span>
                    <span class="font-bold text-slate-800">{{ $order->businessDetail->business_name }}</span>
                </div>
                @if($order->businessDetail->domain_name)
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Domain Name</span>
                    <span class="font-bold text-slate-800">{{ $order->businessDetail->domain_name }}</span>
                </div>
                @endif
                @if($order->businessDetail->support_phone)
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Support Phone</span>
                    <span class="font-bold text-slate-800">{{ $order->businessDetail->support_phone }}</span>
                </div>
                @endif
                @if($order->businessDetail->support_email)
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Support Email</span>
                    <span class="font-bold text-slate-800">{{ $order->businessDetail->support_email }}</span>
                </div>
                @endif
                @if($order->businessDetail->office_address)
                <div class="md:col-span-2">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Office Address</span>
                    <span class="font-bold text-slate-800">{{ $order->businessDetail->office_address }}</span>
                </div>
                @endif
                
                @if($order->businessDetail->logo_path)
                <div class="md:col-span-2 mt-4">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Logo Provided</span>
                    <div class="w-16 h-16 rounded-xl border border-slate-200 overflow-hidden bg-white p-1">
                        <img src="{{ asset('storage/' . $order->businessDetail->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                </div>
                @endif

                @if($order->businessDetail->product_images && count($order->businessDetail->product_images) > 0)
                <div class="md:col-span-2 mt-4">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">{{ count($order->businessDetail->product_images) }} Product Images Uploaded</span>
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        @foreach($order->businessDetail->product_images as $imgPath)
                            <div class="w-16 h-16 rounded-xl border border-slate-200 overflow-hidden shrink-0 bg-white">
                                <img src="{{ asset('storage/' . $imgPath) }}" alt="Product Image" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Order Progress --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-8">
            <h2 class="text-xl font-black text-slate-900 mb-8">Order Timeline</h2>
            <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-slate-200 before:to-transparent">
                @php
                    $steps = [
                        ['status' => 'pending', 'title' => 'Order Placed', 'desc' => 'We received your order.', 'icon' => 'shopping-cart'],
                        ['status' => 'paid', 'title' => 'Payment Confirmed', 'desc' => 'Your payment has been processed.', 'icon' => 'credit-card'],
                        ['status' => 'in_progress', 'title' => 'In Progress', 'desc' => 'Our team is working on your project.', 'icon' => 'cog'],
                        ['status' => 'completed', 'title' => 'Completed', 'desc' => 'Project delivered successfully.', 'icon' => 'check'],
                    ];
                    $statusOrder = ['pending' => 0, 'paid' => 1, 'in_progress' => 2, 'completed' => 3];
                    $currentStep = $statusOrder[$order->status] ?? 0;
                @endphp
                
                @foreach($steps as $i => $step)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm 
                        {{ $i < $currentStep ? 'bg-emerald-500 text-white' : ($i === $currentStep ? 'bg-blue-600 text-white shadow-blue-600/30 shadow-lg ring-4 ring-blue-100' : 'bg-slate-100 text-slate-400') }} z-10">
                        <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4 {{ $i === $currentStep && $order->status === 'in_progress' ? 'animate-spin' : '' }}"></i>
                    </div>
                    <!-- Card -->
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl border shadow-sm {{ $i <= $currentStep ? 'bg-white border-slate-200' : 'bg-slate-50 border-transparent opacity-60' }}">
                        <div class="flex items-center justify-between space-x-2 mb-1">
                            <div class="font-bold {{ $i <= $currentStep ? 'text-slate-900' : 'text-slate-500' }}">{{ $step['title'] }}</div>
                        </div>
                        <div class="text-sm font-medium {{ $i <= $currentStep ? 'text-slate-600' : 'text-slate-400' }}">{{ $step['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Payment Summary --}}
        <div class="bg-gradient-to-br from-slate-900 to-blue-950 rounded-3xl shadow-xl p-5 sm:p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl -z-10"></div>
            <h2 class="text-xl font-black mb-6">Payment Summary</h2>
            
            <div class="space-y-4 pb-6 border-b border-white/10 text-sm font-medium">
                @php
                    $planPrice = $order->items->first()->subtotal ?? $order->amount;
                @endphp
                <div class="flex items-center justify-between text-blue-100">
                    <span>Plan Price</span>
                    <span class="text-white">₹{{ number_format($planPrice) }}</span>
                </div>
                
                @if($order->platform_choice)
                <div class="flex items-center justify-between text-blue-100">
                    <span>Platform ({{ ucfirst($order->platform_choice) }})</span>
                    <span class="text-white">₹{{ number_format($order->platform_price) }}</span>
                </div>
                @endif
                
                @if($order->domain_choice && $order->domain_choice !== 'already_have')
                <div class="flex items-center justify-between text-blue-100">
                    <span>Domain (.{{ $order->domain_choice }})</span>
                    <span class="text-white">₹{{ number_format($order->domain_charge) }}</span>
                </div>
                @endif
                
                @if($order->gst_amount > 0)
                <div class="flex items-center justify-between text-blue-100">
                    <span>GST (18%)</span>
                    <span class="text-white">₹{{ number_format($order->gst_amount) }}</span>
                </div>
                @endif
            </div>
            
            <div class="flex items-center justify-between pt-6">
                <span class="font-bold text-blue-100">Total</span>
                <span class="text-3xl font-black text-white">₹{{ number_format($order->amount) }}</span>
            </div>

            @if($order->status === 'pending')
            <a href="{{ route('payment.create', $order) }}" class="mt-8 w-full block text-center py-4 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-400 hover:to-indigo-400 text-white font-black text-base shadow-lg shadow-blue-500/25 transition-all hover:-translate-y-0.5">
                <i data-lucide="credit-card" class="inline-block w-5 h-5 mr-1 align-text-bottom"></i> Pay Securely Now
            </a>
            <p class="text-xs text-center text-blue-200 mt-4 font-medium"><i data-lucide="lock" class="inline w-3 h-3"></i> 100% Secure Encrypted Payment</p>
            @endif
        </div>

        {{-- Contact Info --}}
        @if($order->customer_name || $order->customer_phone)
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 sm:p-8">
            <h2 class="text-lg font-black text-slate-900 mb-5">Billing Details</h2>
            <div class="space-y-4 text-sm font-medium text-slate-600">
                @if($order->customer_name)
                <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400"><i data-lucide="user" class="w-4 h-4"></i></div> {{ $order->customer_name }}</div>
                @endif
                @if($order->customer_phone)
                <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400"><i data-lucide="phone" class="w-4 h-4"></i></div> {{ $order->customer_phone }}</div>
                @endif
                @if($order->customer_email)
                <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400"><i data-lucide="mail" class="w-4 h-4"></i></div> {{ $order->customer_email }}</div>
                @endif
                @if($order->company_name)
                <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400"><i data-lucide="building" class="w-4 h-4"></i></div> {{ $order->company_name }}</div>
                @endif
            </div>
        </div>
        @endif

        {{-- Need Help? --}}
        <div class="bg-blue-50 rounded-3xl border border-blue-100 p-5 sm:p-8 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-200/50 rounded-full blur-xl -z-10"></div>
            <div class="w-16 h-16 rounded-full bg-white text-blue-600 flex items-center justify-center mx-auto mb-4 shadow-sm">
                <i data-lucide="headphones" class="w-8 h-8"></i>
            </div>
            <h3 class="font-black text-lg text-slate-900 mb-2">Need Support?</h3>
            <p class="text-sm font-medium text-slate-600 mb-6">Our team is here to help you with any questions about your order.</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center w-full py-3 gap-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                <i data-lucide="message-circle" class="w-4 h-4"></i> Contact Support
            </a>
        </div>
    </div>
</div>

</div>

@endsection
