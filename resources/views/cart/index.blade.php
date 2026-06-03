@extends('layouts.app')
@section('title', 'Shopping Cart — SKSolutions')
@section('sidebar')
    <!-- enable sidebar -->
@endsection
@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Shopping Cart</h1>
    <p class="text-slate-500 text-sm mt-1">Review your selected services before checkout.</p>
</div>

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 text-emerald-700 font-medium text-sm">
    {{ session('success') }}
</div>
@endif

@if(session('info'))
<div class="mb-6 bg-blue-50 border border-blue-200 rounded-2xl px-5 py-4 text-blue-700 font-medium text-sm">
    {{ session('info') }}
</div>
@endif

@if($activeCoupons->count() > 0)
<div class="mb-6 rounded-2xl border border-indigo-100 bg-gradient-to-r from-indigo-50 to-purple-50 px-5 py-4">
    <div class="flex items-center gap-2 mb-3">
        <span class="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">
            <i data-lucide="tag" class="w-4 h-4 text-indigo-600"></i>
        </span>
        <p class="text-sm font-black text-indigo-800 tracking-tight">Available Coupons – Use at Checkout!</p>
    </div>
    <div class="flex flex-wrap gap-2">
        @foreach($activeCoupons as $ac)
        <div class="inline-flex items-center gap-2 bg-white border border-indigo-200 rounded-xl pl-3 pr-2 py-1.5 shadow-sm">
            <span class="font-mono font-black text-xs text-indigo-800 tracking-widest">{{ $ac->code }}</span>
            <span class="text-[10px] text-slate-500 font-semibold">
                @if($ac->discount_type == 'percent') {{ $ac->discount_value }}% Off
                @else ₹{{ number_format($ac->discount_value) }} Off
                @endif
                @if($ac->service) · {{ $ac->service->name }} only @endif
            </span>
        </div>
        @endforeach
    </div>
</div>
@endif

@if($cartItems->count())
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Cart Items --}}
    <div class="lg:col-span-2 space-y-4">
        @foreach($cartItems as $item)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl overflow-hidden shrink-0 border border-slate-100 shadow-sm">
                        @if($item->service->banner_image)
                            <img src="{{ asset('storage/' . $item->service->banner_image) }}" alt="{{ $item->service->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-blue-50 text-blue-600 flex items-center justify-center">
                                <i data-lucide="{{ $item->service->icon ?? 'box' }}" class="w-7 h-7"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">{{ $item->service->name }}</h3>
                        <p class="text-sm text-slate-500 mt-1">{{ $item->service->category }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ Str::limit($item->service->short_description, 80) }}</p>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <div class="text-lg font-black text-slate-900">₹{{ number_format($item->service->min_price) }}</div>
                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1 text-xs font-semibold text-red-500 hover:text-red-700 transition-colors">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Remove
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Order Summary --}}
    <div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Order Summary</h2>
            <div class="space-y-3 pb-4 border-b border-slate-100">
                @foreach($cartItems as $item)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">{{ $item->service->name }}</span>
                    <span class="font-medium text-slate-900">₹{{ number_format($item->service->min_price) }}</span>
                </div>
                @endforeach
            </div>
            <div class="flex items-center justify-between pt-4 mb-6">
                <span class="font-bold text-slate-900">Total</span>
                <span class="text-2xl font-black text-slate-900">₹{{ number_format($total) }}</span>
            </div>
            <a href="{{ route('cart.checkout') }}" class="block w-full text-center py-4 rounded-2xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20">
                Proceed to Checkout
            </a>
            <a href="{{ route('services.index') }}" class="block w-full text-center py-3 mt-3 rounded-2xl bg-slate-100 text-slate-700 font-semibold text-sm hover:bg-slate-200 transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@else
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
        <i data-lucide="shopping-cart" class="w-10 h-10 text-slate-400"></i>
    </div>
    <h3 class="text-xl font-bold text-slate-900 mb-2">Your cart is empty</h3>
    <p class="text-slate-500 mb-6">Browse our services and add them to your cart to get started.</p>
</div>
@endif

@endsection
