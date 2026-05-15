@extends('layouts.app')

@section('title', 'Marketing Materials - SK Solutions')
@section('sidebar') 
    <!-- This enables the sidebar -->

@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Marketing Materials</h1>
    <p class="text-slate-500 mt-1">Download official brochures, posters, and assets to help you sell.</p>
</div>

<div class="mb-8 border-b border-slate-200">
    <nav class="-mb-px flex space-x-8">
        <a href="#" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Social Media Posters
        </a>
        <a href="#" class="border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Brochures & PDFs
        </a>
        <a href="#" class="border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Logos & Branding
        </a>
    </nav>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    <!-- Asset 1 -->
    <div class="group">
        <div class="aspect-[4/5] bg-slate-200 rounded-lg overflow-hidden relative mb-3 border border-slate-200">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex flex-col justify-end p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="w-full py-2 bg-white text-slate-900 text-sm font-bold rounded flex items-center justify-center shadow">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Download
                </button>
            </div>
            <!-- Dummy image placeholder -->
            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                <span class="text-xs font-medium">1080x1350</span>
            </div>
        </div>
        <h4 class="text-sm font-medium text-slate-900">Web Dev Promo (Instagram)</h4>
        <p class="text-xs text-slate-500">JPG • 2.4 MB</p>
    </div>

    <!-- Asset 2 -->
    <div class="group">
        <div class="aspect-[4/5] bg-slate-200 rounded-lg overflow-hidden relative mb-3 border border-slate-200">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex flex-col justify-end p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="w-full py-2 bg-white text-slate-900 text-sm font-bold rounded flex items-center justify-center shadow">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Download
                </button>
            </div>
            <!-- Dummy image placeholder -->
            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                <span class="text-xs font-medium">1080x1350</span>
            </div>
        </div>
        <h4 class="text-sm font-medium text-slate-900">SEO Services Bundle</h4>
        <p class="text-xs text-slate-500">JPG • 1.8 MB</p>
    </div>

    <!-- Asset 3 -->
    <div class="group">
        <div class="aspect-[4/5] bg-slate-200 rounded-lg overflow-hidden relative mb-3 border border-slate-200">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex flex-col justify-end p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="w-full py-2 bg-white text-slate-900 text-sm font-bold rounded flex items-center justify-center shadow">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Download
                </button>
            </div>
            <!-- Dummy image placeholder -->
            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                <span class="text-xs font-medium">1080x1080</span>
            </div>
        </div>
        <h4 class="text-sm font-medium text-slate-900">General Services (Square)</h4>
        <p class="text-xs text-slate-500">PNG • 3.1 MB</p>
    </div>

    <!-- Asset 4 -->
    <div class="group">
        <div class="aspect-[4/5] bg-slate-200 rounded-lg overflow-hidden relative mb-3 border border-slate-200">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex flex-col justify-end p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="w-full py-2 bg-white text-slate-900 text-sm font-bold rounded flex items-center justify-center shadow">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Download
                </button>
            </div>
            <!-- Dummy image placeholder -->
            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                <span class="text-xs font-medium">1920x1080</span>
            </div>
        </div>
        <h4 class="text-sm font-medium text-slate-900">App Development Cover</h4>
        <p class="text-xs text-slate-500">JPG • 1.5 MB</p>
    </div>
</div>

<div class="mt-12 bg-slate-900 text-white rounded-xl p-8 flex flex-col md:flex-row items-center justify-between">
    <div class="mb-6 md:mb-0 md:mr-8">
        <h3 class="text-xl font-bold mb-2">Share Your Referral Link</h3>
        <p class="text-slate-400 text-sm">Don't forget to attach your unique referral code to these marketing materials when posting on social media.</p>
    </div>
    <div class="shrink-0 flex items-center bg-slate-800 rounded-lg p-1 border border-slate-700">
        <code class="px-4 py-2 text-indigo-400 text-sm font-mono select-all">{{ url('/register?ref=' . auth()->user()->id) }}</code>
        <button class="ml-2 p-2 bg-indigo-600 hover:bg-indigo-700 rounded transition-colors" onclick="navigator.clipboard.writeText('{{ url('/register?ref=' . auth()->user()->id) }}'); alert('Copied!');">
            <i data-lucide="copy" class="w-4 h-4"></i>
        </button>
    </div>
</div>
@endsection
