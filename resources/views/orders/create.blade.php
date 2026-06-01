@extends('layouts.app')

@section('title', 'Place Order — {{ $service->name }} — SK Solutions')
@section('sidebar')

    <!-- This enables the sidebar -->

@endsection

@push('styles')
<style>
    .page-back { display: inline-flex; align-items: center; gap: .4rem; font-size: .82rem; font-weight: 600; color: #6366f1; text-decoration: none; margin-bottom: 1rem; }
    .page-back:hover { color: #4338ca; }

    .order-layout { display: grid; grid-template-columns: 1fr 320px; gap: 1.75rem; max-width: 1000px; }
    @media(max-width:860px) { .order-layout { grid-template-columns: 1fr; } }

    /* ── Main card ── */
    .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
    .card-header { padding: 1.1rem 1.5rem; border-bottom: 1px solid #f1f5f9; background: #fafbfc; display: flex; align-items: center; gap: .65rem; }
    .card-header h3 { font-size: .95rem; font-weight: 700; color: #0f172a; margin: 0; }
    .card-header-icon { width: 32px; height: 32px; border-radius: .5rem; background: #eef2ff; color: #6366f1; display: flex; align-items: center; justify-content: center; }
    .card-body { padding: 1.75rem; }

    /* ── Form ── */
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-size: .8rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .5rem; }
    .form-label span { color: #ef4444; }
    .form-input, .form-textarea {
        width: 100%;
        border: 1.5px solid #d1d5db;
        border-radius: .65rem;
        padding: .75rem 1rem;
        font-size: .9rem;
        color: #1e293b;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
        resize: vertical;
    }
    .form-input:focus, .form-textarea:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
    .form-input::placeholder, .form-textarea::placeholder { color: #9ca3af; }
    .field-error { margin-top: .4rem; font-size: .78rem; color: #ef4444; display: flex; align-items: center; gap: .3rem; }

    /* ── Hints & helpers ── */
    .info-box { background: #eef2ff; border: 1px solid #c7d2fe; border-radius: .65rem; padding: 1rem 1.25rem; font-size: .85rem; color: #4338ca; display: flex; align-items: flex-start; gap: .65rem; }
    .info-box i { flex-shrink: 0; margin-top: 1px; }

    /* ── Service Summary Card ── */
    .service-card { background: linear-gradient(135deg,#6366f1,#8b5cf6); border-radius: 1rem; padding: 1.5rem; color: #fff; margin-bottom: 1.25rem; }
    .service-name { font-size: 1.05rem; font-weight: 800; margin: 0 0 .4rem; }
    .service-desc { font-size: .82rem; color: #c7d2fe; margin: 0 0 1rem; }
    .service-price-label { font-size: .7rem; text-transform: uppercase; letter-spacing: .07em; color: #a5b4fc; margin-bottom: .2rem; }
    .service-price { font-size: 2rem; font-weight: 900; line-height: 1; }
    .service-price small { font-size: 1rem; font-weight: 500; }

    /* ── Steps ── */
    .steps { margin-bottom: 1.25rem; }
    .step { display: flex; align-items: flex-start; gap: .75rem; padding: .75rem 0; border-bottom: 1px solid #f1f5f9; }
    .step:last-child { border-bottom: none; }
    .step-num { width: 24px; height: 24px; border-radius: 50%; background: #6366f1; color: #fff; font-size: .72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
    .step-text { font-size: .82rem; color: #374151; }
    .step-title { font-weight: 700; color: #1e293b; font-size: .85rem; margin-bottom: .15rem; }

    /* ── Submit Button ── */
    .btn-submit { width: 100%; padding: .85rem 1.5rem; background: linear-gradient(135deg,#6366f1,#8b5cf6); color: #fff; border: none; border-radius: .7rem; font-size: .95rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 14px rgba(99,102,241,.35); transition: transform .15s, box-shadow .15s; display: flex; align-items: center; justify-content: center; gap: .5rem; font-family: 'Poppins', sans-serif; }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.45); }
    .btn-submit:active { transform: translateY(0); }
</style>
@endpush

@section('content')

<a href="{{ route('partner.services') }}" class="page-back">
    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Services
</a>

<h1 style="font-size:1.5rem;font-weight:800;color:#0f172a;margin:0 0 .35rem;">Place an Order</h1>
<p style="font-size:.875rem;color:#64748b;margin:0 0 2rem;">Fill in your requirements and we'll get started right away.</p>

<div class="order-layout">

    {{-- ── LEFT: Form ── --}}
    <div>
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="clipboard-list" class="w-4 h-4"></i></div>
                <h3>Order Requirements</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('partner.orders.store') }}" method="POST" id="order-form">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    {{-- Service display --}}
                    <div class="form-group">
                        <label class="form-label">Service Selected</label>
                        <input type="text" class="form-input" value="{{ $service->name }}" readonly style="background:#f8fafc;color:#64748b;cursor:default;">
                    </div>

                    {{-- Requirements textarea --}}
                    <div class="form-group">
                        <label class="form-label" for="requirements">
                            Describe Your Requirements <span>*</span>
                        </label>
                        <textarea id="requirements" name="requirements" rows="8" class="form-textarea"
                            placeholder="Please include:&#10;• Your business name &amp; industry&#10;• What you need specifically&#10;• Any deadlines or preferences&#10;• Any existing work / references&#10;&#10;The more detail you provide, the better we can serve you.">{{ old('requirements') }}</textarea>
                        @error('requirements')
                            <div class="field-error">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Info notice --}}
                    <div class="info-box" style="margin-bottom:1.75rem;">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        <div>After placing your order, you'll be directed to the payment page.
                        Your order will be processed once payment is confirmed.</div>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-place-order">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        Place Order &amp; Proceed to Payment
                    </button>

                </form>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Summary ── --}}
    <div>

        {{-- Service summary --}}
        <div class="service-card">
            <p class="service-name">{{ $service->name }}</p>
            <p class="service-desc">{{ $service->short_description }}</p>
            <div class="service-price-label">Starting from</div>
            <div class="service-price">₹<small></small>{{ number_format($service->min_price, 0) }}</div>
        </div>

        {{-- How it works --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i data-lucide="help-circle" class="w-4 h-4"></i></div>
                <h3>How It Works</h3>
            </div>
            <div class="card-body" style="padding:1.25rem 1.5rem;">
                <div class="steps">
                    <div class="step">
                        <div class="step-num">1</div>
                        <div class="step-text">
                            <div class="step-title">Submit Requirements</div>
                            Describe what you need in detail.
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-num">2</div>
                        <div class="step-text">
                            <div class="step-title">Confirm & Pay</div>
                            Review your order and make a secure payment.
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div class="step-text">
                            <div class="step-title">We Get to Work</div>
                            Our team starts processing immediately.
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-num">4</div>
                        <div class="step-text">
                            <div class="step-title">Delivery & Review</div>
                            You receive the output and can leave feedback.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trust badges --}}
        <div style="display:flex;flex-direction:column;gap:.5rem;margin-top:1rem;">
            <div style="display:flex;align-items:center;gap:.6rem;font-size:.8rem;color:#475569;">
                <i data-lucide="shield-check" class="w-4 h-4" style="color:#10b981;"></i>
                Secure Razorpay Payment
            </div>
            <div style="display:flex;align-items:center;gap:.6rem;font-size:.8rem;color:#475569;">
                <i data-lucide="clock" class="w-4 h-4" style="color:#6366f1;"></i>
                Order confirmed instantly
            </div>
            <!-- <div style="display:flex;align-items:center;gap:.6rem;font-size:.8rem;color:#475569;">
                <i data-lucide="headphones" class="w-4 h-4" style="color:#f59e0b;"></i>
                Experience Team team
            </div> -->
        </div>

    </div>

</div>
@endsection
