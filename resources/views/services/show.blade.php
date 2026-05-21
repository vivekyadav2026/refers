@extends('layouts.app')
@section('title', $service->name . ' — SKSolutions Partner Network')
@section('content')

<div x-data="{ buyNowModal: false, isProcessing: false }" 
     @processing-start.window="isProcessing = true" 
     @processing-end.window="isProcessing = false"
     class="bg-slate-50 min-h-screen pt-24 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- BREADCRUMBS --}}
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-8 uppercase tracking-wider">
            <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <a href="{{ route('services.index') }}" class="hover:text-blue-600 transition-colors">Services</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <span class="text-blue-600">{{ $service->name }}</span>
        </nav>

        {{-- MAIN HERO CARD --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 mb-14 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 relative z-10">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-black px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                            <i data-lucide="{{ $service->icon ?? 'box' }}" class="w-4 h-4 text-blue-600"></i> {{ $service->category }}
                        </div>
                        @if($service->is_popular)
                        <div class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-800 border border-amber-200 text-xs font-black uppercase tracking-wider px-3.5 py-1.5 rounded-full">
                            🔥 Hot Selling Service
                        </div>
                        @endif
                    </div>

                    @if($service->banner_image)
                    <div class="w-full aspect-[21/9] rounded-2xl overflow-hidden border border-slate-200 shadow-sm mb-6">
                        <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                    </div>
                    @endif

                    <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight mb-4 leading-[1.15]">
                        {{ $service->name }}
                    </h1>
                    <p class="text-base sm:text-lg text-slate-500 font-semibold mb-8 leading-relaxed">
                        {{ $service->short_description }}
                    </p>

                    @auth
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-6 border-t border-slate-100 mb-8 font-sans">
                        @if($service->delivery_timeline)
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Base Client Price</div>
                            <div class="text-2xl font-black text-slate-900 mt-1">₹{{ number_format($service->min_price) }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 col-span-2 sm:col-span-1">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Est. Delivery</div>
                            <div class="text-xl sm:text-2xl font-black text-blue-600 mt-1">{{ $service->delivery_timeline }}</div>
                        </div>
                        @else
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 col-span-2 sm:col-span-1">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Base Client Price</div>
                            <div class="text-2xl font-black text-slate-900 mt-1">₹{{ number_format($service->min_price) }}</div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="pt-6 border-t border-slate-100 mb-8">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-blue-600 hover:text-blue-700">
                                <i data-lucide="lock" class="w-4 h-4"></i> Member Login Required to View Price
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>

                <div class="lg:col-span-5 relative z-10">
                    <div class="bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950 rounded-3xl p-8 sm:p-10 text-white shadow-2xl border border-slate-800 relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

                        <h3 class="text-2xl font-black mb-2 tracking-tight">Purchase or Refer</h3>
                        <p class="text-xs text-slate-400 font-semibold mb-8 leading-relaxed">Add to cart or submit client requirement to get started.</p>

                        @auth
                        @if(auth()->user()->isCustomer())
                        <button type="button" @click="buyNowModal = true" class="w-full py-4 rounded-2xl text-sm font-black tracking-wide uppercase text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-xl shadow-blue-600/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 mb-4">
                            <i data-lucide="zap" class="w-5 h-5"></i> Buy Now — ₹{{ number_format($service->min_price) }}
                        </button>
                        @endif

                        @if(auth()->user()->isPartner() || auth()->user()->isAdmin())
                        <div class="flex items-center gap-4 mb-6 text-xs text-slate-500 uppercase tracking-widest font-black">
                            <div class="h-px bg-white/10 flex-1"></div>
                            <span>Submit Lead Info</span>
                            <div class="h-px bg-white/10 flex-1"></div>
                        </div>

                        <form action="{{ route('partner.leads.store') }}" method="POST" class="space-y-4 font-sans">
                            @csrf
                            <input type="hidden" name="service_needed" value="{{ $service->name }}">
                            <div>
                                <label class="block text-[11px] font-black text-slate-300 mb-1.5 uppercase tracking-wider">Client Full Name *</label>
                                <input type="text" name="client_name" required class="w-full px-4 py-3 rounded-xl border border-white/10 text-white placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-900/60 outline-none transition-all backdrop-blur-md" placeholder="e.g. Rahul Sharma">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-300 mb-1.5 uppercase tracking-wider">Client Phone Number *</label>
                                <input type="tel" name="client_phone" required class="w-full px-4 py-3 rounded-xl border border-white/10 text-white placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-900/60 outline-none transition-all backdrop-blur-md" placeholder="+91 9999999999">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-300 mb-1.5 uppercase tracking-wider">Project Requirements (Optional)</label>
                                <textarea name="notes" rows="2" class="w-full px-4 py-3 rounded-xl border border-white/10 text-white placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-900/60 outline-none transition-all backdrop-blur-md resize-none" placeholder="Key deliverables, references, budget..."></textarea>
                            </div>
                            <button type="submit" class="w-full py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase text-slate-900 bg-white hover:bg-slate-100 shadow-md transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i data-lucide="send" class="w-4 h-4 text-blue-600"></i> Submit Lead
                            </button>
                        </form>
                        @endif
                        @else
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center backdrop-blur-md mb-6">
                            <i data-lucide="lock" class="w-10 h-10 text-blue-400 mx-auto mb-3"></i>
                            <h4 class="text-lg font-black text-white mb-2">Member Authentication Required</h4>
                            <p class="text-xs text-slate-400 leading-relaxed mb-6 font-semibold">Sign in to add this item to your cart or submit a lead to get started.</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 w-full py-3.5 bg-blue-600 text-white font-black text-xs uppercase tracking-wider rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5">
                                Secure Sign In / Register
                            </a>
                        </div>
                        <a href="https://wa.me/919999999999?text=Hi, I am interested in {{ urlencode($service->name) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-xs font-black uppercase tracking-wider text-white bg-emerald-500 hover:bg-emerald-600 shadow-lg shadow-emerald-500/20 transition-all hover:-translate-y-0.5">
                            <i data-lucide="message-circle" class="w-4 h-4"></i> Inquire via WhatsApp
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAILED INFO SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-20">
            <div class="lg:col-span-8 space-y-12">
                
                {{-- DESCRIPTION --}}
                @if($service->description)
                <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm">
                    <h2 class="text-2xl font-black text-slate-900 mb-6 tracking-tight flex items-center gap-3">
                        <div class="w-3 h-8 bg-blue-600 rounded-full"></div> About This Service
                    </h2>
                    <div class="prose prose-slate max-w-none text-slate-600 font-semibold leading-relaxed text-sm sm:text-base space-y-4">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>
                @endif

                {{-- FEATURES --}}
                @if(is_array($service->features) && count($service->features) > 0)
                <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm">
                    <h2 class="text-2xl font-black text-slate-900 mb-8 tracking-tight flex items-center gap-3">
                        <div class="w-3 h-8 bg-emerald-600 rounded-full"></div> What's Included
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($service->features as $feature)
                        <div class="flex items-start gap-3.5 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-slate-800 font-extrabold text-sm leading-snug">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- REQUIREMENTS --}}
                @if($service->requirements_text)
                <div class="bg-blue-50/80 rounded-3xl p-8 sm:p-12 border border-blue-100 shadow-sm">
                    <h2 class="text-2xl font-black text-blue-950 mb-4 tracking-tight flex items-center gap-3">
                        <i data-lucide="alert-circle" class="w-7 h-7 text-blue-600"></i> What We Need From You
                    </h2>
                    <div class="text-blue-900 font-semibold text-sm leading-relaxed space-y-2">
                        {!! nl2br(e($service->requirements_text)) !!}
                    </div>
                </div>
                @endif
            </div>

            {{-- SIDEBAR PACKAGES & FAQ --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm sticky top-24">
                    <h3 class="text-xl font-black text-slate-900 mb-6 tracking-tight">Flexible Packages</h3>
                    
                    <div class="space-y-4 font-sans">
                        @auth
                            @foreach([
                                ['label'=>'Standard Start','price'=> $service->min_price,'desc'=>'Essential scope for high-quality baseline delivery','badge'=>'Popular Choice','border'=>'border-blue-300 bg-blue-50/20 shadow-md'],
                                ['label'=>'Enterprise Growth','price'=> $service->min_price * 1.8,'desc'=>'Expanded deliverables with priority engineering & unlimited revisions','badge'=>'Recommended','border'=>'border-slate-200 bg-white'],
                            ] as $pkg)
                            <div class="rounded-2xl p-5 border {{ $pkg['border'] }} relative">
                                <div class="absolute -top-3 right-4 px-3 py-0.5 bg-blue-600 text-white rounded-full text-[10px] font-black uppercase tracking-wider">{{ $pkg['badge'] }}</div>
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-black text-slate-900">{{ $pkg['label'] }}</h4>
                                    <span class="text-lg font-black text-blue-600">₹{{ number_format($pkg['price']) }}</span>
                                </div>
                                <p class="text-xs text-slate-500 font-semibold">{{ $pkg['desc'] }}</p>
                            </div>
                            @endforeach
                        @else
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 text-center">
                                <i data-lucide="lock" class="w-8 h-8 text-slate-400 mx-auto mb-2"></i>
                                <div class="text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Member Packages Locked</div>
                                <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">Login to View Pricing Packages</a>
                            </div>
                        @endauth
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                        <h4 class="font-bold text-xs text-slate-400 uppercase tracking-widest mb-3">Questions about deliverables?</h4>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs hover:bg-slate-200 transition-colors">
                            <i data-lucide="headphones" class="w-4 h-4 text-blue-600"></i> Talk to Account Manager
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- BUY NOW MODAL --}}
        <div x-show="buyNowModal" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div x-show="buyNowModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="buyNowModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200" @click.away="buyNowModal = false">
                        
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <h3 class="text-lg font-black text-slate-900 flex items-center gap-2" id="modal-title">
                                <i data-lucide="zap" class="w-5 h-5 text-blue-600"></i> Quick Checkout
                            </h3>
                            <button @click="buyNowModal = false" type="button" class="text-slate-400 hover:text-slate-600 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <form id="buyNowForm" class="p-6">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            
                            <div class="space-y-4 font-sans">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Full Name *</label>
                                    @php
                                        $defaultName = auth()->check() ? 'User ' . substr(auth()->user()->phone, -4) : '';
                                        $displayName = auth()->check() && auth()->user()->name !== $defaultName ? auth()->user()->name : '';
                                    @endphp
                                    <input type="text" name="customer_name" value="{{ $displayName }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Mobile Number *</label>
                                    <input type="tel" name="customer_phone" value="{{ auth()->check() ? auth()->user()->phone : '' }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Project Requirements *</label>
                                    <textarea name="requirements" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 outline-none transition-all resize-none" placeholder="Describe your project requirements briefly..."></textarea>
                                </div>
                            </div>

                            <div class="mt-8 flex gap-3">
                                <button type="button" @click="buyNowModal = false" class="w-1/3 py-3.5 rounded-xl text-xs font-black tracking-wider uppercase text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" x-bind:disabled="isProcessing" class="w-2/3 py-3.5 rounded-xl text-xs font-black tracking-wider uppercase text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all flex justify-center items-center gap-2 disabled:opacity-70">
                                    <span x-show="!isProcessing">Pay ₹{{ number_format($service->min_price) }}</span>
                                    <span x-show="isProcessing">Processing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('buyNowForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let form = this;
        let formData = new FormData(form);
        
        window.dispatchEvent(new CustomEvent('processing-start'));

        fetch('{{ route('payment.buyNow') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var options = {
                    "key": data.key,
                    "amount": data.amount * 100, 
                    "currency": "INR",
                    "name": "SKSolutions",
                    "description": "Payment for " + data.service_name,
                    "order_id": data.razorpay_order_id,
                    "handler": function (response){
                        let verifyForm = document.createElement('form');
                        verifyForm.method = 'POST';
                        verifyForm.action = '{{ route('payment.verify') }}';
                        
                        let csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        verifyForm.appendChild(csrf);

                        let orderId = document.createElement('input');
                        orderId.type = 'hidden';
                        orderId.name = 'order_id';
                        orderId.value = data.order_id;
                        verifyForm.appendChild(orderId);

                        let rzpPayId = document.createElement('input');
                        rzpPayId.type = 'hidden';
                        rzpPayId.name = 'razorpay_payment_id';
                        rzpPayId.value = response.razorpay_payment_id;
                        verifyForm.appendChild(rzpPayId);

                        let rzpOrderId = document.createElement('input');
                        rzpOrderId.type = 'hidden';
                        rzpOrderId.name = 'razorpay_order_id';
                        rzpOrderId.value = response.razorpay_order_id;
                        verifyForm.appendChild(rzpOrderId);

                        let rzpSig = document.createElement('input');
                        rzpSig.type = 'hidden';
                        rzpSig.name = 'razorpay_signature';
                        rzpSig.value = response.razorpay_signature;
                        verifyForm.appendChild(rzpSig);

                        document.body.appendChild(verifyForm);
                        verifyForm.submit();
                    },
                    "prefill": {
                        "name": data.name,
                        "email": data.email,
                        "contact": data.contact
                    },
                    "theme": {
                        "color": "#4f46e5"
                    },
                    "modal": {
                        "ondismiss": function(){
                            window.dispatchEvent(new CustomEvent('processing-end'));
                        }
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
                window.dispatchEvent(new CustomEvent('processing-end'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('A network error occurred. Please try again.');
            window.dispatchEvent(new CustomEvent('processing-end'));
        });
    });
</script>
@endpush

@endsection
