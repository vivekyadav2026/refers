@extends('layouts.app')

@section('title', 'KYC Verification - SKSolutions Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
@php
    $kycStatus = auth()->check() ? auth()->user()->kyc_status : 'unsubmitted';
    $aadhaarData = null;
    $panData = null;
    if ($kycDocument) {
        $aadhaarData = is_string($kycDocument->aadhaar_path) ? json_decode($kycDocument->aadhaar_path, true) : $kycDocument->aadhaar_path;
        $panData = is_string($kycDocument->pan_path) ? json_decode($kycDocument->pan_path, true) : $kycDocument->pan_path;
    }
    $isEditable = ($kycStatus === 'unsubmitted' || $kycStatus === 'rejected');
@endphp

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">KYC Verification</h1>
            <p class="text-slate-500 mt-1">Complete your identity verification to start withdrawing your earnings.</p>
        </div>
        <div class="flex items-center gap-3 mt-4 sm:mt-0">
            <a href="{{ route('partner.apply') }}" class="bg-white border border-slate-200 hover:border-indigo-300 text-slate-700 font-bold rounded-xl px-4 py-2.5 flex items-center gap-2 text-sm shadow-sm transition-colors">
                <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600"></i>
                View Onboarding & Unlock Status
            </a>
        </div>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-8 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
            <div>
                <h4 class="font-bold text-red-950 mb-1">Please fix the following validation errors:</h4>
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Status Banners -->
    @if($kycStatus === 'pending')
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-8 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-amber-800 font-semibold text-base">Verification Pending</h3>
                <p class="text-amber-700/80 text-sm mt-1">Your documents are currently under review by our team. This usually takes 1-2 business days. You will be notified once the process is complete.</p>
            </div>
        </div>
    @elseif($kycStatus === 'approved')
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-8 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-emerald-800 font-semibold text-base">Verification Approved</h3>
                <p class="text-emerald-700/80 text-sm mt-1">Your identity has been successfully verified. You now have full access to withdraw your earnings and participate fully in the partner network.</p>
                <a href="{{ route('partner.kyc.download') }}" class="inline-flex items-center gap-2 mt-3 text-sm font-medium text-emerald-700 bg-emerald-100 hover:bg-emerald-200 px-4 py-2 rounded-lg transition-colors">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Download Digital ID Card
                </a>
            </div>
        </div>
    @elseif($kycStatus === 'rejected')
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-8 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
            </div>
            <div class="w-full">
                <h3 class="text-red-800 font-semibold text-base">Verification Rejected</h3>
                <p class="text-red-700/80 text-sm mt-1 mb-3">We could not verify your identity due to the following reason: <strong class="font-semibold">{{ $kycDocument->rejection_reason ?? 'One or more of the uploaded document images were blurry and unreadable.' }}</strong></p>
                <button type="button" class="text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 px-4 py-2 rounded-lg transition-colors">
                    Resubmit Documents
                </button>
            </div>
        </div>
    @else
        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5 mb-8 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="shield-alert" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-indigo-900 font-semibold text-base">Action Required</h3>
                <p class="text-indigo-700/80 text-sm mt-1">Please submit your KYC documents below to unlock withdrawals. Ensure all uploaded images are clear and readable.</p>
            </div>
        </div>
    @endif

    <!-- KYC Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('partner.kyc.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-10">
                <!-- Aadhaar Section -->
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                            <span class="font-bold text-sm">1</span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">Aadhaar Card</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-0 sm:pl-10">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Aadhaar Number <span class="text-red-500">*</span></label>
                            <input type="text" name="aadhaar_number" value="{{ $aadhaarData['number'] ?? '' }}" placeholder="XXXX XXXX XXXX" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors" @if(!$isEditable) disabled @endif required>
                        </div>
                        
                        {{-- Aadhaar Front Image --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Aadhaar Front Image <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 relative overflow-hidden group @if(!$isEditable) opacity-100 cursor-default @else cursor-pointer @endif">
                                
                                <label for="aadhaar_front" class="cursor-pointer space-y-1 text-center w-full flex flex-col items-center justify-center {{ $aadhaarData && isset($aadhaarData['front']) ? 'hidden' : '' }}">
                                    <i data-lucide="upload-cloud" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <span class="font-medium text-indigo-600 hover:text-indigo-500">Upload Aadhaar Front</span>
                                        <input id="aadhaar_front" name="aadhaar_front" type="file" accept="image/*" class="sr-only file-input" @if(!$isEditable) disabled @else required @endif>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
                                </label>

                                <div class="upload-preview {{ $aadhaarData && isset($aadhaarData['front']) ? '' : 'hidden' }} flex flex-col items-center justify-center space-y-2 w-full h-full min-h-[100px]">
                                    <img class="preview-img max-h-32 rounded-lg object-contain shadow-sm" src="{{ $aadhaarData && isset($aadhaarData['front']) ? asset('storage/' . $aadhaarData['front']) : '' }}" alt="Aadhaar Front Preview">
                                    <span class="text-xs text-slate-500 truncate max-w-[200px] filename-span">
                                        {{ $aadhaarData && isset($aadhaarData['front']) ? basename($aadhaarData['front']) : '' }}
                                    </span>
                                    @if($isEditable)
                                        <button type="button" class="text-xs font-bold text-red-500 hover:text-red-700 remove-btn">Remove</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Aadhaar Back Image --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Aadhaar Back Image <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 relative overflow-hidden group @if(!$isEditable) opacity-100 cursor-default @else cursor-pointer @endif">
                                
                                <label for="aadhaar_back" class="cursor-pointer space-y-1 text-center w-full flex flex-col items-center justify-center {{ $aadhaarData && isset($aadhaarData['back']) ? 'hidden' : '' }}">
                                    <i data-lucide="upload-cloud" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <span class="font-medium text-indigo-600 hover:text-indigo-500">Upload Aadhaar Back</span>
                                        <input id="aadhaar_back" name="aadhaar_back" type="file" accept="image/*" class="sr-only file-input" @if(!$isEditable) disabled @else required @endif>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
                                </label>

                                <div class="upload-preview {{ $aadhaarData && isset($aadhaarData['back']) ? '' : 'hidden' }} flex flex-col items-center justify-center space-y-2 w-full h-full min-h-[100px]">
                                    <img class="preview-img max-h-32 rounded-lg object-contain shadow-sm" src="{{ $aadhaarData && isset($aadhaarData['back']) ? asset('storage/' . $aadhaarData['back']) : '' }}" alt="Aadhaar Back Preview">
                                    <span class="text-xs text-slate-500 truncate max-w-[200px] filename-span">
                                        {{ $aadhaarData && isset($aadhaarData['back']) ? basename($aadhaarData['back']) : '' }}
                                    </span>
                                    @if($isEditable)
                                        <button type="button" class="text-xs font-bold text-red-500 hover:text-red-700 remove-btn">Remove</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                <!-- PAN Section -->
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                            <span class="font-bold text-sm">2</span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">PAN Card</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-0 sm:pl-10">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">PAN Number <span class="text-red-500">*</span></label>
                            <input type="text" name="pan_number" value="{{ $panData['number'] ?? '' }}" placeholder="ABCDE1234F" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors uppercase" @if(!$isEditable) disabled @endif required>
                        </div>
                        
                        {{-- PAN Image --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Upload PAN Card <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 relative overflow-hidden group @if(!$isEditable) opacity-100 cursor-default @else cursor-pointer @endif">
                                
                                <label for="pan_image" class="cursor-pointer space-y-1 text-center w-full flex flex-col items-center justify-center {{ $panData && isset($panData['image']) ? 'hidden' : '' }}">
                                    <i data-lucide="file-text" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <span class="font-medium text-indigo-600 hover:text-indigo-500">Upload PAN Card</span>
                                        <input id="pan_image" name="pan_image" type="file" accept="image/*" class="sr-only file-input" @if(!$isEditable) disabled @else required @endif>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
                                </label>

                                <div class="upload-preview {{ $panData && isset($panData['image']) ? '' : 'hidden' }} flex flex-col items-center justify-center space-y-2 w-full h-full min-h-[100px]">
                                    <img class="preview-img max-h-32 rounded-lg object-contain shadow-sm" src="{{ $panData && isset($panData['image']) ? asset('storage/' . $panData['image']) : '' }}" alt="PAN Card Preview">
                                    <span class="text-xs text-slate-500 truncate max-w-[200px] filename-span">
                                        {{ $panData && isset($panData['image']) ? basename($panData['image']) : '' }}
                                    </span>
                                    @if($isEditable)
                                        <button type="button" class="text-xs font-bold text-red-500 hover:text-red-700 remove-btn">Remove</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                <!-- Selfie Section -->
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                            <span class="font-bold text-sm">3</span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">Selfie</h2>
                    </div>
                    
                    <div class="pl-0 sm:pl-10">
                        <p class="text-sm text-slate-500 mb-4">Please upload a clear selfie of yourself. Ensure your face is clearly visible and well-lit.</p>
                        
                        <div class="w-full md:w-1/2">
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 relative overflow-hidden group @if(!$isEditable) opacity-100 cursor-default @else cursor-pointer @endif">
                                
                                <label for="selfie" class="cursor-pointer space-y-1 text-center w-full flex flex-col items-center justify-center {{ $kycDocument && isset($kycDocument->photo_path) ? 'hidden' : '' }}">
                                    <div class="mx-auto w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-2">
                                        <i data-lucide="camera" class="h-6 w-6"></i>
                                    </div>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <span class="font-medium text-indigo-600 hover:text-indigo-500">Take or Upload selfie</span>
                                        <input id="selfie" name="selfie" type="file" accept="image/*" capture="user" class="sr-only file-input" @if(!$isEditable) disabled @else required @endif>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
                                </label>

                                <div class="upload-preview {{ $kycDocument && isset($kycDocument->photo_path) ? '' : 'hidden' }} flex flex-col items-center justify-center space-y-2 w-full h-full min-h-[100px]">
                                    <img class="preview-img max-h-32 rounded-lg object-contain shadow-sm" src="{{ $kycDocument && isset($kycDocument->photo_path) ? asset('storage/' . $kycDocument->photo_path) : '' }}" alt="Selfie Preview">
                                    <span class="text-xs text-slate-500 truncate max-w-[200px] filename-span">
                                        {{ $kycDocument && isset($kycDocument->photo_path) ? basename($kycDocument->photo_path) : '' }}
                                    </span>
                                    @if($isEditable)
                                        <button type="button" class="text-xs font-bold text-red-500 hover:text-red-700 remove-btn">Remove</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                <!-- Bank Details Section -->
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                            <span class="font-bold text-sm">4</span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">Bank Details</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-0 sm:pl-10">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Account Holder Name <span class="text-red-500">*</span></label>
                            <input type="text" name="account_name" value="{{ $kycDocument ? ($kycDocument->bank_details['account_name'] ?? '') : '' }}" placeholder="As per bank records" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors" @if(!$isEditable) disabled @endif required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Account Number <span class="text-red-500">*</span></label>
                            <input type="text" name="account_number" value="{{ $kycDocument ? ($kycDocument->bank_details['account_number'] ?? '') : '' }}" placeholder="Enter Account Number" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors" @if(!$isEditable) disabled @endif required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">IFSC Code <span class="text-red-500">*</span></label>
                            <input type="text" name="ifsc" value="{{ $kycDocument ? ($kycDocument->bank_details['ifsc'] ?? '') : '' }}" placeholder="e.g. HDFC0001234" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors uppercase" @if(!$isEditable) disabled @endif required>
                        </div>

                        {{-- Bank Proof --}}
                        <div class="md:col-span-2 mt-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Upload Cancelled Cheque / Passbook Front <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 relative overflow-hidden group @if(!$isEditable) opacity-100 cursor-default @else cursor-pointer @endif">
                                
                                <label for="bank_proof" class="cursor-pointer space-y-1 text-center w-full flex flex-col items-center justify-center {{ $kycDocument && isset($kycDocument->bank_details['proof_path']) ? 'hidden' : '' }}">
                                    <i data-lucide="landmark" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <span class="font-medium text-indigo-600 hover:text-indigo-500">Upload Cancelled Cheque / Passbook</span>
                                        <input id="bank_proof" name="bank_proof" type="file" accept="image/*,application/pdf" class="sr-only file-input" @if(!$isEditable) disabled @else required @endif>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG, PDF up to 5MB</p>
                                </label>

                                <div class="upload-preview {{ $kycDocument && isset($kycDocument->bank_details['proof_path']) ? '' : 'hidden' }} flex flex-col items-center justify-center space-y-2 w-full h-full min-h-[100px]">
                                    @php
                                        $proofPath = $kycDocument && isset($kycDocument->bank_details['proof_path']) ? $kycDocument->bank_details['proof_path'] : '';
                                        $isPdf = Str::endsWith(strtolower($proofPath), '.pdf');
                                    @endphp
                                    
                                    <img class="preview-img max-h-32 rounded-lg object-contain shadow-sm {{ $isPdf ? 'hidden' : '' }}" src="{{ $proofPath && !$isPdf ? asset('storage/' . $proofPath) : '' }}" alt="Bank Proof Preview">
                                    
                                    @if($isPdf)
                                        <div class="doc-placeholder w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-2">
                                            <i data-lucide="file-text" class="w-6 h-6"></i>
                                        </div>
                                    @endif

                                    <span class="text-xs text-slate-500 truncate max-w-[200px] filename-span">
                                        {{ $proofPath ? basename($proofPath) : '' }}
                                    </span>
                                    @if($isEditable)
                                        <button type="button" class="text-xs font-bold text-red-500 hover:text-red-700 remove-btn">Remove</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Submit Action -->
            <div class="p-6 sm:p-8 border-t border-slate-200 bg-slate-50 flex items-center justify-between">
                <p class="text-sm text-slate-500 flex items-center gap-2">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                    
                </p>
                
                @if($isEditable)
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-8 py-3 flex items-center justify-center gap-2 text-sm font-medium shadow-sm transition-all focus:ring-4 focus:ring-indigo-600/20">
                        Submit KYC Documents
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                @else
                    <button type="button" disabled class="bg-slate-300 text-slate-500 rounded-xl px-8 py-3 flex items-center justify-center gap-2 text-sm font-medium cursor-not-allowed">
                        Submission Received
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInputs = document.querySelectorAll('.file-input');

    fileInputs.forEach(input => {
        input.addEventListener('change', function (e) {
            const file = e.target.files[0];
            const container = input.closest('.border-2'); // Find parent container
            const label = container.querySelector('label');
            const previewContainer = container.querySelector('.upload-preview');
            const previewImg = previewContainer.querySelector('.preview-img');
            const filenameSpan = previewContainer.querySelector('.filename-span');

            if (file) {
                // Display filename
                filenameSpan.textContent = file.name;

                // Clean up any old doc-placeholder first
                const oldDocPlaceholder = previewContainer.querySelector('.doc-placeholder');
                if (oldDocPlaceholder) oldDocPlaceholder.remove();

                // Check if file is image or PDF
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    // Show a PDF document icon instead of image
                    previewImg.classList.add('hidden');
                    
                    const docPlaceholder = document.createElement('div');
                    docPlaceholder.className = 'doc-placeholder w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-2';
                    docPlaceholder.innerHTML = '<i data-lucide="file-text" class="w-6 h-6"></i>';
                    previewContainer.insertBefore(docPlaceholder, filenameSpan);
                    
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }

                // Toggle visibility
                label.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            }
        });
    });

    // Handle remove buttons
    const removeButtons = document.querySelectorAll('.remove-btn');
    removeButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const container = btn.closest('.border-2');
            const input = container.querySelector('.file-input');
            const label = container.querySelector('label');
            const previewContainer = container.querySelector('.upload-preview');
            const previewImg = previewContainer.querySelector('.preview-img');
            
            // Reset input
            input.value = '';
            
            // Hide preview, show label
            previewContainer.classList.add('hidden');
            label.classList.remove('hidden');

            // Clean up PDF/doc placeholder if any
            const docPlaceholder = previewContainer.querySelector('.doc-placeholder');
            if (docPlaceholder) docPlaceholder.remove();
        });
    });
});
</script>
@endpush
