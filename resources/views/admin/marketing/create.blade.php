@extends('layouts.app')
@section('title', 'Upload Asset — Admin')
@section('sidebar')
    <!-- enable sidebar -->
@endsection

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 mb-2">
        <a href="{{ route('admin.marketing.index') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Upload Asset</h1>
    </div>
    <p class="text-slate-500 text-sm pl-7">Add promotional banners, videos, or documents.</p>
</div>

<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
    <form action="{{ route('admin.marketing.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Asset Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50" placeholder="e.g. Diwali Mega Sale Banner">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Asset Type <span class="text-red-500">*</span></label>
                <select name="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                    <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image (Banner, Poster)</option>
                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video (Reel, Promo)</option>
                    <option value="document" {{ old('type') == 'document' ? 'selected' : '' }}>Document (PDF Guide)</option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Description <span class="text-slate-400">(Optional)</span></label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 focus:ring-2 focus:ring-indigo-500 bg-slate-50 resize-none" placeholder="Briefly describe how partners should use this asset...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider">Upload File <span class="text-red-500">*</span></label>
                <div class="mt-1 flex justify-center px-6 pt-8 pb-10 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50/50 cursor-pointer" onclick="document.getElementById('file').click()">
                    <div class="space-y-2 text-center">
                        <i data-lucide="upload-cloud" class="mx-auto h-10 w-10 text-slate-400"></i>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <span class="relative bg-transparent rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                <span>Click to upload</span>
                                <input id="file" name="file" type="file" class="sr-only" required>
                            </span>
                            <span class="ml-1">or drag and drop</span>
                        </div>
                        <p class="text-xs text-slate-500" id="file-name">PNG, JPG, MP4, PDF up to 10MB</p>
                    </div>
                </div>
                @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.marketing.index') }}" class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-3 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">Upload Asset</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('file').addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            document.getElementById('file-name').textContent = 'Selected: ' + e.target.files[0].name;
            document.getElementById('file-name').classList.add('text-indigo-600', 'font-bold');
        }
    });
</script>
@endpush
@endsection
