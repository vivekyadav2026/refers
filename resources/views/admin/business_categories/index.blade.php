@extends('layouts.app')
@section('title', 'Business Categories - Admin')

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
        <h1 class="text-2xl font-bold text-slate-900">Business Categories Manager</h1>
        <p class="text-slate-500 mt-1">Manage categories and subcategories used during partner registration.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Add Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-8">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-bold text-slate-900">Add Category</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.business-categories.store') }}" method="POST">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" placeholder="e.g., IT Services" required
                                class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Parent Category (Optional)</label>
                            <select name="parent_id" class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="">-- None (Make it a Top-Level Category) --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-400 mt-1">Select a parent if this is a subcategory.</p>
                        </div>
                        <button type="submit" 
                            class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-indigo-600 py-2.5 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i> Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category List -->
    <div class="lg:col-span-2 space-y-6">
        @forelse($categories as $category)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" x-data="{ editOpen: false }">
                <!-- Parent Category Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between {{ $category->is_active ? 'bg-slate-50' : 'bg-red-50' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl {{ $category->is_active ? 'bg-indigo-100 text-indigo-600' : 'bg-red-200 text-red-700' }} flex items-center justify-center font-black">
                            <i data-lucide="folder" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">{{ $category->name }}</h3>
                            <div class="text-xs font-semibold text-slate-500">{{ $category->subcategories->count() }} Subcategories</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('admin.business-categories.toggle', $category) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold transition-colors {{ $category->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' }}">
                                <i data-lucide="{{ $category->is_active ? 'check-circle' : 'power-off' }}" class="w-3 h-3"></i>
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                        <button @click="editOpen = true" class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </button>
                        <form action="{{ route('admin.business-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category and ALL its subcategories?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Subcategories -->
                @if($category->subcategories->count() > 0)
                <div class="px-6 py-4">
                    <ul class="space-y-3">
                        @foreach($category->subcategories as $sub)
                        <li class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-white hover:bg-slate-50 transition-colors" x-data="{ subEditOpen: false }">
                            <div class="flex items-center gap-3">
                                <i data-lucide="corner-down-right" class="w-4 h-4 text-slate-300"></i>
                                <span class="text-sm font-semibold text-slate-700">{{ $sub->name }}</span>
                                @if(!$sub->is_active)
                                    <span class="text-[10px] font-black uppercase text-red-500 bg-red-100 px-2 py-0.5 rounded-full">Inactive</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.business-categories.toggle', $sub) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold px-2 py-1 rounded {{ $sub->is_active ? 'text-emerald-600 hover:bg-emerald-50' : 'text-slate-500 hover:bg-slate-100' }}">Toggle</button>
                                </form>
                                <button @click="subEditOpen = true" class="text-slate-400 hover:text-indigo-600 p-1"><i data-lucide="edit" class="w-3.5 h-3.5"></i></button>
                                <form action="{{ route('admin.business-categories.destroy', $sub) }}" method="POST" onsubmit="return confirm('Delete subcategory?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 p-1"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                                </form>
                            </div>

                            <!-- Subcategory Edit Modal -->
                            <div x-show="subEditOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" style="display: none;">
                                <div @click.away="subEditOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-left">
                                    <h3 class="text-lg font-bold mb-4">Edit Subcategory</h3>
                                    <form action="{{ route('admin.business-categories.update', $sub) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="mb-4">
                                            <input type="text" name="name" value="{{ $sub->name }}" class="w-full border border-slate-200 rounded-xl px-4 py-2" required>
                                        </div>
                                        <div class="mb-4 hidden">
                                            <input type="hidden" name="parent_id" value="{{ $category->id }}">
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" @click="subEditOpen = false" class="px-4 py-2 text-sm bg-slate-100 rounded-xl">Cancel</button>
                                            <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-xl">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Edit Parent Modal -->
                <div x-show="editOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" style="display: none;">
                    <div @click.away="editOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                        <h3 class="text-lg font-bold mb-4">Edit Category</h3>
                        <form action="{{ route('admin.business-categories.update', $category) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-4">
                                <label class="block text-sm font-semibold mb-1">Name</label>
                                <input type="text" name="name" value="{{ $category->name }}" class="w-full border border-slate-200 rounded-xl px-4 py-2" required>
                                <input type="hidden" name="parent_id" value="">
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" @click="editOpen = false" class="px-4 py-2 text-sm bg-slate-100 rounded-xl">Cancel</button>
                                <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-xl">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center text-slate-500 border border-slate-200">
                <i data-lucide="layers" class="w-12 h-12 mx-auto mb-4 text-slate-300"></i>
                <h3 class="text-lg font-bold text-slate-900">No Categories Found</h3>
                <p class="text-sm mt-1">Start by adding a top-level category on the left.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
