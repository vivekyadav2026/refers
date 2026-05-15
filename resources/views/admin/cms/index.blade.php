@extends('layouts.app')

@section('title', 'Manage CMS Pages - Admin')

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
@if(session('error'))
    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
        <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
        {{ session('error') }}
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
        <h1 class="text-2xl font-bold text-slate-900">CMS Pages</h1>
        <p class="text-slate-500 mt-1">Manage content for Terms, Privacy Policy, About Us, etc.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Create Page Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-bold text-slate-900">Create New Page</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.cms.store') }}" method="POST">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Page Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required 
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                            <p class="text-xs text-slate-500 mt-1.5">Slug will be auto-generated (e.g. "About Us" -> "about-us")</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Content HTML <span class="text-red-500">*</span></label>
                            <textarea name="content" rows="8" required 
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-mono text-xs"></textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked 
                                class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                            <label for="is_active" class="text-sm font-medium text-slate-700">Publish Immediately</label>
                        </div>
                        <button type="submit" 
                            class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-indigo-600 py-2.5 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i> Save Page
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pages List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            @if($pages->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold tracking-wider">Title</th>
                                <th class="px-6 py-4 font-semibold tracking-wider">URL Slug</th>
                                <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                                <th class="px-6 py-4 font-semibold tracking-wider text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($pages as $page)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">{{ $page->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-mono">/{{ $page->slug }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($page->is_active)
                                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                <i data-lucide="check-circle" class="w-3 h-3"></i> Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                <i data-lucide="clock" class="w-3 h-3"></i> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="/{{ $page->slug }}" target="_blank" class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors" title="View Page">
                                                <i data-lucide="external-link" class="w-4 h-4"></i>
                                            </a>
                                            <a href="{{ route('admin.cms.edit', $page) }}" class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors" title="Edit Page">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.cms.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Delete this page permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $pages->links() }}
                </div>
            @else
                <div class="p-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i data-lucide="file-text" class="w-8 h-8"></i>
                    </div>
                    <p class="font-medium text-slate-900">No CMS pages created yet.</p>
                    <p class="text-sm mt-1">Use the form on the left to create your first page.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
