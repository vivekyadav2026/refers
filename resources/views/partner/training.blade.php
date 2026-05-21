@extends('layouts.app')

@section('title', 'Training Center - SKSolutions Partner Network')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Training Center</h1>
        <p class="text-slate-500 mt-1">Learn how to maximize your earnings and master our services.</p>
    </div>
</div>

@if($trainings->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($trainings as $training)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
            <!-- Thumbnail / Video Link -->
            <a href="{{ $training->video_url }}" target="_blank" class="block relative aspect-video bg-slate-900 group">
                @if($training->thumbnail)
                    <img src="{{ asset('storage/' . $training->thumbnail) }}" alt="{{ $training->title }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900 to-slate-900 text-white/50">
                        <i data-lucide="video" class="w-12 h-12"></i>
                    </div>
                @endif
                <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/10 transition-colors">
                    <div class="w-12 h-12 rounded-full bg-white/90 text-indigo-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform backdrop-blur-sm">
                        <i data-lucide="play" class="w-5 h-5 ml-1"></i>
                    </div>
                </div>
            </a>
            
            <!-- Details -->
            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-bold text-slate-900 text-lg mb-2 line-clamp-2">
                    <a href="{{ $training->video_url }}" target="_blank" class="hover:text-indigo-600 transition-colors">{{ $training->title }}</a>
                </h3>
                <p class="text-slate-500 text-sm mb-4 line-clamp-3">{{ $training->description }}</p>
                
                <div class="mt-auto pt-4 border-t border-slate-100">
                    <a href="{{ $training->video_url }}" target="_blank" class="inline-flex items-center justify-center w-full gap-2 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-xl transition-colors">
                        <i data-lucide="external-link" class="w-4 h-4"></i> Watch Video
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="graduation-cap" class="w-8 h-8"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-2">Check back later!</h3>
        <p class="text-slate-500 max-w-md mx-auto">We are currently preparing highly informative training modules to help you succeed. New videos will appear here soon.</p>
    </div>
@endif

@endsection
