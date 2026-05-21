@extends('layouts.app')
@section('title', 'Marketing Materials — Admin')
@section('sidebar')
    <!-- enable sidebar -->
@endsection

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Marketing Materials</h1>
        <p class="text-slate-500 text-sm mt-1">Upload and manage promotional assets for partners.</p>
    </div>
    <div>
        <a href="{{ route('admin.marketing.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2.5 flex items-center gap-2 text-sm font-medium shadow-sm transition-colors">
            <i data-lucide="upload-cloud" class="w-4 h-4"></i>
            Upload Asset
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
    @forelse($materials as $material)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col group">
        {{-- Preview Area --}}
        <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
            @if($material->type == 'image')
                <img src="{{ asset('storage/' . $material->file_path) }}" alt="{{ $material->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            @elseif($material->type == 'video')
                <div class="absolute inset-0 bg-slate-900/10 flex items-center justify-center z-10">
                    <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                        <i data-lucide="play" class="w-5 h-5 text-indigo-600 ml-1"></i>
                    </div>
                </div>
                <video src="{{ asset('storage/' . $material->file_path) }}" class="w-full h-full object-cover"></video>
            @else
                <i data-lucide="file-text" class="w-16 h-16 text-slate-300"></i>
            @endif
            
            {{-- Type Badge --}}
            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur border border-slate-200 shadow-sm rounded-lg px-2.5 py-1 flex items-center gap-1.5 z-20">
                @if($material->type == 'image')
                    <i data-lucide="image" class="w-3.5 h-3.5 text-blue-600"></i>
                    <span class="text-xs font-bold text-slate-700">Image</span>
                @elseif($material->type == 'video')
                    <i data-lucide="video" class="w-3.5 h-3.5 text-purple-600"></i>
                    <span class="text-xs font-bold text-slate-700">Video</span>
                @else
                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-amber-600"></i>
                    <span class="text-xs font-bold text-slate-700">Document</span>
                @endif
            </div>
        </div>

        {{-- Content Area --}}
        <div class="p-5 flex-1 flex flex-col">
            <h3 class="font-bold text-slate-900 mb-1 truncate" title="{{ $material->title }}">{{ $material->title }}</h3>
            @if($material->description)
                <p class="text-sm text-slate-500 line-clamp-2 mb-4 flex-1">{{ $material->description }}</p>
            @else
                <p class="text-sm text-slate-400 italic mb-4 flex-1">No description</p>
            @endif
            
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    Preview
                </a>
                
                <div class="flex gap-2">
                    <a href="{{ route('admin.marketing.edit', $material) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                    </a>
                    <form action="{{ route('admin.marketing.destroy', $material) }}" method="POST" onsubmit="return confirm('Delete this asset?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center bg-white border border-slate-200 border-dashed rounded-2xl">
        <i data-lucide="image" class="w-12 h-12 mx-auto text-slate-300 mb-4"></i>
        <h3 class="text-lg font-bold text-slate-900 mb-1">No Marketing Materials</h3>
        <p class="text-slate-500 text-sm mb-4">Upload promotional banners, videos, or PDFs for your partners.</p>
        <a href="{{ route('admin.marketing.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2 text-sm font-medium transition-colors">
            <i data-lucide="upload-cloud" class="w-4 h-4"></i>
            Upload First Asset
        </a>
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $materials->links() }}
</div>
@endsection
