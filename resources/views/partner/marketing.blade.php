@extends('layouts.app')

@section('title', 'Marketing Assets - SKSolutions Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Marketing Assets</h1>
        <p class="text-slate-500 mt-1">Download promotional materials, banners, and flyers to share with your audience.</p>
    </div>
</div>

@if($materials->count() > 0)
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
        @foreach($materials as $item)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow group">
            <!-- Preview -->
            <div class="relative aspect-[4/3] bg-slate-100 border-b border-slate-100 flex items-center justify-center p-4">
                @if($item->type === 'image')
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}" class="max-w-full max-h-full object-contain drop-shadow-sm group-hover:scale-105 transition-transform duration-300">
                @elseif($item->type === 'video')
                    <div class="w-16 h-16 rounded-full bg-white/90 text-indigo-600 flex items-center justify-center shadow-md">
                        <i data-lucide="play" class="w-6 h-6 ml-1"></i>
                    </div>
                @else
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-sm">
                        <i data-lucide="file-text" class="w-8 h-8"></i>
                    </div>
                @endif
                
                <div class="absolute top-3 right-3">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-white/90 backdrop-blur-sm text-slate-700 shadow-sm border border-slate-200/50">
                        {{ $item->type }}
                    </span>
                </div>
            </div>
            
            <!-- Details -->
            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-bold text-slate-900 text-base mb-1 truncate" title="{{ $item->title }}">
                    {{ $item->title }}
                </h3>
                @if($item->description)
                <p class="text-slate-500 text-xs mb-4 line-clamp-2" title="{{ $item->description }}">{{ $item->description }}</p>
                @endif
                
                <div class="mt-auto pt-4 flex gap-2">
                    <a href="{{ asset('storage/' . $item->file_path) }}" download class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i> Download
                    </a>
                    <button onclick="navigator.clipboard.writeText('{{ asset('storage/' . $item->file_path) }}'); alert('Link copied to clipboard!');" class="p-2 text-slate-400 hover:text-indigo-600 bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-xl transition-colors" title="Copy Link">
                        <i data-lucide="link" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="image" class="w-8 h-8"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-2">No assets available yet</h3>
        <p class="text-slate-500 max-w-md mx-auto">We are actively preparing new promotional materials. Please check back later to download banners, videos, and documents.</p>
    </div>
@endif

@endsection
