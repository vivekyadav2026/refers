@extends('layouts.app')

@section('title', 'New Support Ticket — SK Solutions')
@section('sidebar')
    <!-- This enables the sidebar -->

@endsection

@push('styles')
<style>
    .page-back { display:inline-flex; align-items:center; gap:.4rem; font-size:.82rem; font-weight:600; color:#6366f1; text-decoration:none; margin-bottom:1rem; }
    .page-back:hover { color:#4338ca; }

    .form-wrap { max-width:680px; }

    .card { background:#fff; border:1px solid #e2e8f0; border-radius:1rem; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.04); }
    .card-header { padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; background:#fafbfc; display:flex; align-items:center; gap:.65rem; }
    .card-header h3 { font-size:.95rem; font-weight:700; color:#0f172a; margin:0; }
    .card-header-icon { width:32px; height:32px; border-radius:.5rem; background:#eef2ff; color:#6366f1; display:flex; align-items:center; justify-content:center; }
    .card-body { padding:1.75rem; }

    .form-group { margin-bottom:1.5rem; }
    .form-label { display:block; font-size:.8rem; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.5rem; }
    .form-label span { color:#ef4444; }
    .form-input, .form-select, .form-textarea {
        width:100%; border:1.5px solid #d1d5db; border-radius:.65rem;
        padding:.75rem 1rem; font-size:.9rem; color:#1e293b; background:#fff;
        transition:border-color .2s,box-shadow .2s; box-sizing:border-box; font-family: 'Poppins', sans-serif;
    }
    .form-textarea { resize:vertical; }
    .form-input:focus,.form-select:focus,.form-textarea:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.15); }
    .field-error { margin-top:.4rem; font-size:.78rem; color:#ef4444; display:flex; align-items:center; gap:.3rem; }

    /* Priority Radio Buttons */
    .priority-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:.75rem; }
    .priority-option { position:relative; }
    .priority-option input[type="radio"] { position:absolute; opacity:0; width:0; height:0; }
    .priority-label {
        display:flex; flex-direction:column; align-items:center; gap:.4rem;
        padding:.85rem .5rem; border-radius:.75rem; border:1.5px solid #e2e8f0;
        cursor:pointer; font-size:.8rem; font-weight:700; transition:all .15s; text-align:center;
    }
    .priority-option input:checked + .priority-label.low    { border-color:#3b82f6; background:#eff6ff; color:#1d4ed8; }
    .priority-option input:checked + .priority-label.medium { border-color:#f59e0b; background:#fffbeb; color:#92400e; }
    .priority-option input:checked + .priority-label.high   { border-color:#ef4444; background:#fef2f2; color:#991b1b; }
    .priority-label:hover { border-color:#a5b4fc; background:#f5f3ff; }

    /* Submit */
    .btn-submit { width:100%; padding:.85rem 1.5rem; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:.7rem; font-size:.95rem; font-weight:800; cursor:pointer; box-shadow:0 4px 14px rgba(99,102,241,.35); transition:transform .15s,box-shadow .15s; display:flex; align-items:center; justify-content:center; gap:.5rem; font-family: 'Poppins', sans-serif; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(99,102,241,.45); }

    .info-box { background:#eef2ff; border:1px solid #c7d2fe; border-radius:.65rem; padding:1rem 1.25rem; font-size:.85rem; color:#4338ca; display:flex; align-items:flex-start; gap:.65rem; margin-bottom:1.5rem; }
    .info-box i { flex-shrink:0; margin-top:1px; }
</style>
@endpush

@section('content')

<a href="{{ route('partner.tickets') }}" class="page-back">
    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Tickets
</a>

<h1 style="font-size:1.5rem;font-weight:800;color:#0f172a;margin:0 0 .35rem;">Open Support Ticket</h1>
<p style="font-size:.875rem;color:#64748b;margin:0 0 2rem;">Describe your issue and we'll get back to you as soon as possible.</p>

<div class="form-wrap">

    <div class="info-box">
        <i data-lucide="info" class="w-4 h-4"></i>
        <div>Our support team typically responds within <strong>2–4 business hours</strong>. For urgent issues, set priority to <strong>High</strong>.</div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-header-icon"><i data-lucide="life-buoy" class="w-4 h-4"></i></div>
            <h3>New Ticket Details</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('partner.tickets.store') }}" method="POST" id="ticket-form">
                @csrf

                {{-- Subject --}}
                <div class="form-group">
                    <label class="form-label" for="subject">Subject <span>*</span></label>
                    <input type="text" id="subject" name="subject" class="form-input"
                        placeholder="Brief summary of your issue"
                        value="{{ old('subject') }}" required>
                    @error('subject')
                        <div class="field-error"><i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Priority --}}
                <div class="form-group">
                    <label class="form-label">Priority <span>*</span></label>
                    <div class="priority-grid">
                        <div class="priority-option">
                            <input type="radio" name="priority" id="p-low" value="low" {{ old('priority','medium') === 'low' ? 'checked' : '' }}>
                            <label class="priority-label low" for="p-low">
                                <i data-lucide="arrow-down" style="width:18px;height:18px;color:#3b82f6;"></i>
                                Low
                            </label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" name="priority" id="p-medium" value="medium" {{ old('priority','medium') === 'medium' ? 'checked' : '' }}>
                            <label class="priority-label medium" for="p-medium">
                                <i data-lucide="minus" style="width:18px;height:18px;color:#f59e0b;"></i>
                                Medium
                            </label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" name="priority" id="p-high" value="high" {{ old('priority') === 'high' ? 'checked' : '' }}>
                            <label class="priority-label high" for="p-high">
                                <i data-lucide="alert-triangle" style="width:18px;height:18px;color:#ef4444;"></i>
                                High
                            </label>
                        </div>
                    </div>
                    @error('priority')
                        <div class="field-error"><i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Message --}}
                <div class="form-group">
                    <label class="form-label" for="message">Describe Your Issue <span>*</span></label>
                    <textarea id="message" name="message" rows="8" class="form-textarea"
                        placeholder="Please provide as much detail as possible:&#10;• What were you trying to do?&#10;• What happened instead?&#10;• Any error messages?&#10;• Steps to reproduce the issue" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="field-error"><i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit" id="btn-submit-ticket">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    Submit Ticket
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
