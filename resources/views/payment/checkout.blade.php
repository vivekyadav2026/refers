@extends('layouts.app')

@section('title', 'Secure Checkout - SK Solutions')
@section('sidebar')
    <!-- This enables the sidebar -->

@endsection

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
            <h1 class="text-xl font-bold text-slate-900">Secure Checkout</h1>
            <img src="https://razorpay.com/assets/razorpay-logo.svg" alt="Razorpay" class="h-6">
        </div>
        
        <div class="p-8">
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Order Summary</h3>
                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-slate-900">{{ $order->service->name ?? $order->lead->service_needed ?? 'Custom Service' }}</p>
                        <p class="text-sm text-slate-500">Order ID: #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-xl font-bold text-slate-900">
                        ₹{{ number_format($order->amount, 2) }}
                    </div>
                </div>
            </div>

            <!-- Razorpay Payment Form -->
            <form action="{{ route('payment.verify') }}" method="POST" id="razorpay-form">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpayOrderId }}">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                <button type="button" id="pay-button" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-lg font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    Pay ₹{{ number_format($order->amount, 2) }} Securely
                </button>
            </form>

            <div class="mt-6 flex justify-center items-center space-x-2 text-sm text-slate-500">
                <i data-lucide="lock" class="w-4 h-4"></i>
                <span>Payments are 100% secure and encrypted.</span>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $order->amount * 100 }}", 
        "currency": "INR",
        "name": "SK Solutions",
        "description": "Payment for {{ $order->service->name ?? $order->lead->service_needed ?? 'Custom Service' }}",
        "image": "https://ui-avatars.com/api/?name=SK&background=4f46e5&color=fff",
        "order_id": "{{ $razorpayOrderId }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-form').submit();
        },
        "prefill": {
            "name": "{{ auth()->user()->name }}",
            "email": "{{ auth()->user()->email }}",
            "contact": "{{ auth()->user()->phone }}"
        },
        "theme": {
            "color": "#4f46e5"
        }
    };
    var rzp1 = new Razorpay(options);
    
    document.getElementById('pay-button').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script>
@endsection
