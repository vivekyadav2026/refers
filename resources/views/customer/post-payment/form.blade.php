@extends('layouts.app')
@section('title', 'Project Details - ' . $serviceName)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6">
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Project Requirements Form</h1>
        <p class="text-slate-500 text-sm mt-1">Please provide the details below so our team can start working on your project: <span class="font-bold text-indigo-600">{{ $serviceName }}</span></p>
        <p class="text-xs text-slate-400 mt-1">Note: All fields are optional. Fill out whatever information you currently have.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl text-sm font-medium border border-red-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ route('post-payment.store', $order) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            <input type="hidden" name="service_name" value="{{ $serviceName }}">

            <div class="space-y-10">
                <!-- Section 1: Basic Information -->
                <div>
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-5">1. Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Company / Brand Name</label>
                            <input type="text" name="company_name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm bg-slate-50 outline-none" placeholder="Enter your company name">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Tagline / Slogan</label>
                            <input type="text" name="tagline" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm bg-slate-50 outline-none" placeholder="e.g. Innovating the future">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">About Your Business</label>
                            <textarea name="about_business" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm bg-slate-50 outline-none resize-none" placeholder="Briefly describe what your business does, your target audience, etc."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Design & Content -->
                <div>
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-5">2. Design & Content Preferences</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Preferred Color Scheme</label>
                            <input type="text" name="color_scheme" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm bg-slate-50 outline-none" placeholder="e.g. Blue & White, Dark Mode">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Reference Websites</label>
                            <input type="text" name="reference_websites" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm bg-slate-50 outline-none" placeholder="Links to websites you like">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Dynamic E-commerce Fields -->
                @if(stripos($serviceName, 'ecommerce') !== false || stripos($serviceName, 'e-commerce') !== false || stripos($serviceName, 'store') !== false)
                <div class="bg-indigo-50/50 -mx-8 px-8 py-6 border-y border-indigo-100">
                    <h3 class="text-lg font-bold text-indigo-900 border-b border-indigo-200/60 pb-3 mb-5">3. E-commerce Specific Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-indigo-700 mb-2 uppercase tracking-wider">Types of Products</label>
                            <input type="text" name="product_types" class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:ring-2 focus:ring-indigo-500 text-sm bg-white outline-none" placeholder="e.g. Clothing, Electronics, Digital Goods">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-indigo-700 mb-2 uppercase tracking-wider">Number of Products (Approx)</label>
                            <input type="number" name="product_count" class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:ring-2 focus:ring-indigo-500 text-sm bg-white outline-none" placeholder="e.g. 50">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-indigo-700 mb-2 uppercase tracking-wider">Payment Gateway Preference</label>
                            <input type="text" name="payment_gateway" class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:ring-2 focus:ring-indigo-500 text-sm bg-white outline-none" placeholder="e.g. Razorpay, Stripe, Cash on Delivery">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Section 4: File Uploads -->
                <div>
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-5">Upload Assets</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Logo & Images (Multiple)</label>
                            <div class="w-full border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors bg-slate-50">
                                <input type="file" name="images[]" multiple accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200">
                                <p class="text-[10px] text-slate-400 mt-2">Upload your logo, banner images, or product photos (PNG, JPG).</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Documents / Content (Multiple)</label>
                            <div class="w-full border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors bg-slate-50">
                                <input type="file" name="documents[]" multiple accept=".pdf,.doc,.docx,.txt,.zip" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200">
                                <p class="text-[10px] text-slate-400 mt-2">Upload written content, pricing lists, or project briefs (PDF, DOCX).</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Additional Comments -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Any other instructions?</label>
                    <textarea name="additional_comments" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm bg-slate-50 outline-none resize-none" placeholder="Tell us anything else we should know..."></textarea>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-0.5 flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Submit Project Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
