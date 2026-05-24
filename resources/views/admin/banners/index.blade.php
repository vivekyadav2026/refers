@extends('layouts.app')

@section('title', 'Manage Banners - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
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

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Manage Banners</h1>
        <p class="text-slate-500 mt-1">Upload and manage promotional banners for the public website.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Upload Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-bold text-slate-900">Upload New Banner</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Banner Title (Optional)</label>
                            <input type="text" name="title" 
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Target Link (Optional)</label>
                            <input type="text" name="link" placeholder="https://example.com or /services" 
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Image <span class="text-red-500">*</span></label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-400 mb-2"></i>
                                        <p class="text-sm text-slate-500 font-medium">Click to upload image</p>
                                        <p class="text-xs text-slate-400 mt-1">PNG, JPG or WEBP (Max 5MB)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" name="image" accept="image/*" class="hidden" required />
                                </label>
                            </div>
                        </div>
                        <button type="submit" 
                            class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-indigo-600 py-2.5 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                            <i data-lucide="upload" class="w-4 h-4"></i> Upload Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Banners List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            @if($banners->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold tracking-wider">Preview</th>
                                <th class="px-6 py-4 font-semibold tracking-wider">Details</th>
                                <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                                <th class="px-6 py-4 font-semibold tracking-wider text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($banners as $banner)
                                <tr x-data="{ editOpen: false }" class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-20 w-36 rounded-lg overflow-hidden border border-slate-200 shadow-sm relative group cursor-pointer">
                                            <img src="{{ Storage::url($banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                            <a href="{{ Storage::url($banner->image_path) }}" target="_blank" class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <i data-lucide="external-link" class="w-5 h-5 text-white"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-slate-900">{{ $banner->title ?: 'Untitled Banner' }}</div>
                                        @if($banner->link)
                                            <a href="{{ $banner->link }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-flex items-center gap-1">
                                                <i data-lucide="link" class="w-3 h-3"></i> View Link
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400 mt-1 block">No Link Attached</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold transition-colors {{ $banner->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                                <i data-lucide="{{ $banner->is_active ? 'check-circle' : 'power-off' }}" class="w-3 h-3"></i>
                                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="editOpen = true" class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors" title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline" onsubmit="return confirm('Delete this banner permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>

                                        <!-- Edit Modal -->
                                        <div x-show="editOpen" 
                                             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
                                             x-transition.opacity
                                             style="display: none;">
                                            <div @click.away="editOpen = false" class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden text-left">
                                                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                                                    <h3 class="text-lg font-bold text-slate-900">Edit Banner</h3>
                                                    <button @click="editOpen = false" type="button" class="text-slate-400 hover:text-slate-600">
                                                        <i data-lucide="x" class="w-5 h-5"></i>
                                                    </button>
                                                </div>
                                                <div class="p-6">
                                                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="space-y-4">
                                                            <div>
                                                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Banner Title</label>
                                                                <input type="text" name="title" value="{{ $banner->title }}" class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Target Link</label>
                                                                <input type="text" name="link" value="{{ $banner->link }}" placeholder="/services or https://example.com" class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Update Image (Optional)</label>
                                                                <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                                                <p class="text-xs text-slate-400 mt-1">Leave empty to keep current image</p>
                                                            </div>
                                                            <div class="pt-2 flex justify-end gap-3">
                                                                <button type="button" @click="editOpen = false" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancel</button>
                                                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors shadow-sm">Save Changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i data-lucide="image" class="w-8 h-8"></i>
                    </div>
                    <p class="font-medium text-slate-900">No banners uploaded yet.</p>
                    <p class="text-sm mt-1">Use the form on the left to upload your first promotional banner.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
