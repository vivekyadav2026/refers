@extends('layouts.app')

@section('title', 'Edit CMS Page - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
            <div>
                @foreach($errors->all() as $err)
                    <p>{{ $err }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('admin.cms.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to CMS Pages
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="edit-3" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">Edit Page: {{ $cms->title }}</h3>
                <p class="text-slate-500 text-sm font-mono">/{{ $cms->slug }}</p>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('admin.cms.update', $cms) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Page Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $cms->title) }}" required 
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">URL Slug <span class="text-red-500">*</span></label>
                            <input type="text" name="slug" value="{{ old('slug', $cms->slug) }}" required 
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-mono">
                            <p class="text-xs text-slate-500 mt-1.5">Must be unique and URL-friendly (e.g. about-us)</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Content HTML <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="15" required 
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-mono text-xs leading-relaxed">{{ old('content', $cms->content) }}</textarea>
                    </div>
                    
                    <div class="flex items-center gap-2 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $cms->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                        <label for="is_active" class="text-sm font-medium text-slate-700">Published (Visible to users)</label>
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.cms.index') }}" 
                            class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm ml-auto">
                            <i data-lucide="save" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> Update Page
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
