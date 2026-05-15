@extends('layouts.app')

@section('title', 'KYC Verification - VivekTech Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
@php
    $kycStatus = auth()->check() ? auth()->user()->kyc_status : 'unsubmitted';
@endphp

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">KYC Verification</h1>
            <p class="text-slate-500 mt-1">Complete your identity verification to start withdrawing your earnings.</p>
        </div>
    </div>

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
            </div>
        </div>
    @elseif($kycStatus === 'rejected')
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-8 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
            </div>
            <div class="w-full">
                <h3 class="text-red-800 font-semibold text-base">Verification Rejected</h3>
                <p class="text-red-700/80 text-sm mt-1 mb-3">We could not verify your identity due to the following reason: <strong class="font-semibold">The uploaded PAN card image was blurry and unreadable.</strong></p>
                <button class="text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 px-4 py-2 rounded-lg transition-colors">
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
                            <input type="text" name="aadhaar_number" placeholder="XXXX XXXX XXXX" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Aadhaar Front Image <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 @if($kycStatus == 'pending' || $kycStatus == 'approved') opacity-60 cursor-not-allowed @else cursor-pointer @endif">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="upload-cloud" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="aadhaar_front" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 @if($kycStatus == 'pending' || $kycStatus == 'approved') pointer-events-none @endif">
                                            <span>Upload a file</span>
                                            <input id="aadhaar_front" name="aadhaar_front" type="file" class="sr-only" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif>
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Aadhaar Back Image <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 @if($kycStatus == 'pending' || $kycStatus == 'approved') opacity-60 cursor-not-allowed @else cursor-pointer @endif">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="upload-cloud" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="aadhaar_back" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 @if($kycStatus == 'pending' || $kycStatus == 'approved') pointer-events-none @endif">
                                            <span>Upload a file</span>
                                            <input id="aadhaar_back" name="aadhaar_back" type="file" class="sr-only" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif>
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
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
                            <input type="text" name="pan_number" placeholder="ABCDE1234F" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors uppercase" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Upload PAN Card <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 @if($kycStatus == 'pending' || $kycStatus == 'approved') opacity-60 cursor-not-allowed @else cursor-pointer @endif">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="file-text" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="pan_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 @if($kycStatus == 'pending' || $kycStatus == 'approved') pointer-events-none @endif">
                                            <span>Upload a file</span>
                                            <input id="pan_image" name="pan_image" type="file" class="sr-only" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif>
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
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
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 @if($kycStatus == 'pending' || $kycStatus == 'approved') opacity-60 cursor-not-allowed @else cursor-pointer @endif">
                                <div class="space-y-1 text-center">
                                    <div class="mx-auto w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-2">
                                        <i data-lucide="camera" class="h-6 w-6"></i>
                                    </div>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="selfie" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 @if($kycStatus == 'pending' || $kycStatus == 'approved') pointer-events-none @endif">
                                            <span>Upload selfie</span>
                                            <input id="selfie" name="selfie" type="file" accept="image/*" capture="user" class="sr-only" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif>
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG up to 5MB</p>
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
                            <input type="text" name="account_name" placeholder="As per bank records" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Account Number <span class="text-red-500">*</span></label>
                            <input type="text" name="account_number" placeholder="Enter Account Number" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">IFSC Code <span class="text-red-500">*</span></label>
                            <input type="text" name="ifsc" placeholder="e.g. HDFC0001234" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 transition-colors uppercase" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif required>
                        </div>

                        <div class="md:col-span-2 mt-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Upload Cancelled Cheque / Passbook Front <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 @if($kycStatus == 'pending' || $kycStatus == 'approved') opacity-60 cursor-not-allowed @else cursor-pointer @endif">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="landmark" class="mx-auto h-8 w-8 text-slate-400"></i>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="bank_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 @if($kycStatus == 'pending' || $kycStatus == 'approved') pointer-events-none @endif">
                                            <span>Upload a file</span>
                                            <input id="bank_proof" name="bank_proof" type="file" class="sr-only" @if($kycStatus == 'pending' || $kycStatus == 'approved') disabled @endif>
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG, PDF up to 5MB</p>
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
                    Your data is securely encrypted and stored.
                </p>
                
                @if($kycStatus == 'unsubmitted' || $kycStatus == 'rejected')
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
