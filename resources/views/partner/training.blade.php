@extends('layouts.app')

@section('title', 'Training Center - SK Solutions')
@section('sidebar') 
    <!-- This enables the sidebar -->

@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Training Center</h1>
    <p class="text-slate-500 mt-1">Learn how to generate leads, close sales, and maximize your commissions.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Video 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
        <div class="aspect-video bg-slate-800 relative group flex items-center justify-center">
            <i data-lucide="play-circle" class="w-16 h-16 text-white/80 group-hover:text-white transition-colors"></i>
            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">10:45</div>
        </div>
        <div class="p-5 flex-1 flex flex-col">
            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-2">Getting Started</span>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Platform Walkthrough</h3>
            <p class="text-sm text-slate-500 mb-4 flex-1">Learn how to navigate your dashboard, submit new leads, and track your pending commissions effectively.</p>
            <button class="w-full py-2 bg-slate-100 text-slate-700 font-medium rounded hover:bg-slate-200 transition-colors">Watch Now</button>
        </div>
    </div>

    <!-- Video 2 -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
        <div class="aspect-video bg-slate-800 relative group flex items-center justify-center">
            <i data-lucide="play-circle" class="w-16 h-16 text-white/80 group-hover:text-white transition-colors"></i>
            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">15:20</div>
        </div>
        <div class="p-5 flex-1 flex flex-col">
            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-2">Sales Strategy</span>
            <h3 class="text-lg font-bold text-slate-900 mb-2">How to Sell Web Services</h3>
            <p class="text-sm text-slate-500 mb-4 flex-1">A comprehensive guide on explaining the value of E-Commerce and Informative websites to local businesses.</p>
            <button class="w-full py-2 bg-slate-100 text-slate-700 font-medium rounded hover:bg-slate-200 transition-colors">Watch Now</button>
        </div>
    </div>

    <!-- Video 3 -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
        <div class="aspect-video bg-slate-800 relative group flex items-center justify-center">
            <i data-lucide="play-circle" class="w-16 h-16 text-white/80 group-hover:text-white transition-colors"></i>
            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">08:15</div>
        </div>
        <div class="p-5 flex-1 flex flex-col">
            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-2">Marketing</span>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Generating Leads via Social Media</h3>
            <p class="text-sm text-slate-500 mb-4 flex-1">Learn simple organic strategies to find potential clients on Facebook, Instagram, and LinkedIn.</p>
            <button class="w-full py-2 bg-slate-100 text-slate-700 font-medium rounded hover:bg-slate-200 transition-colors">Watch Now</button>
        </div>
    </div>
</div>

<div class="mt-12 bg-indigo-50 border border-indigo-100 rounded-xl p-8 text-center">
    <h3 class="text-xl font-bold text-indigo-900 mb-2">Need More Help?</h3>
    <p class="text-indigo-700 mb-6 max-w-2xl mx-auto">Our support team is always ready to assist you with any questions about services, leads, or commissions.</p>
    <a href="{{ route('partner.tickets.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
        <i data-lucide="message-square" class="w-5 h-5 mr-2"></i>
        Open a Support Ticket
    </a>
</div>
@endsection
