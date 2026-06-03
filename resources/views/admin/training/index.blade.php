@extends('layouts.app')

@section('title', 'Training Center Management')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-9xl mx-auto">

    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight">Training Center Management</h1>
            <p class="text-slate-500 mt-1">Manage training modules and videos for partners.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button onclick="document.getElementById('addModal').classList.remove('hidden'); document.getElementById('addModal').classList.add('flex');"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Training Video
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold tracking-wider">Order</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Thumbnail</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Title & Video</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($trainings as $training)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $training->order_column }}</td>
                        <td class="px-6 py-4">
                            @if($training->thumbnail)
                                <img src="{{ asset('storage/' . $training->thumbnail) }}" alt="Thumbnail" class="w-24 h-16 object-cover rounded-lg shadow-sm border border-slate-200">
                            @else
                                <div class="w-24 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200">
                                    <i data-lucide="video" class="w-6 h-6"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $training->title }}</div>
                            <div class="text-xs text-slate-500 mt-1 max-w-md truncate">{{ $training->description ?? 'No description' }}</div>
                            <a href="{{ $training->video_url }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-flex items-center gap-1">
                                <i data-lucide="external-link" class="w-3 h-3"></i> View Video
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.training.toggle', $training) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $training->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    <i data-lucide="{{ $training->is_active ? 'check-circle' : 'power' }}" class="w-3 h-3"></i>
                                    {{ $training->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" onclick="openEditModal({{ $training->id }}, '{{ addslashes($training->title) }}', '{{ addslashes($training->description) }}', '{{ $training->video_url }}', {{ $training->order_column }})"
                                    class="p-2 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.training.destroy', $training) }}" onsubmit="return confirm('Delete this training module?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            No training modules found. Click "Add Training Video" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-900 text-lg">Add Training Video</h3>
            <button onclick="document.getElementById('addModal').classList.add('hidden'); document.getElementById('addModal').classList.remove('flex');" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.training.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" required class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Video URL (YouTube/Vimeo)</label>
                    <input type="url" name="video_url" required class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border" placeholder="https://youtube.com/...">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Thumbnail Image (Optional)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Order Display</label>
                    <input type="number" name="order_column" value="0" class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden'); document.getElementById('addModal').classList.remove('flex');" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition-colors">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors">Save Video</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-900 text-lg">Edit Training Video</h3>
            <button onclick="document.getElementById('editModal').classList.add('hidden'); document.getElementById('editModal').classList.remove('flex');" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" id="edit_title" required class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Video URL</label>
                    <input type="url" name="video_url" id="edit_video_url" required class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Thumbnail (Leave empty to keep current)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Order</label>
                    <input type="number" name="order_column" id="edit_order" class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden'); document.getElementById('editModal').classList.remove('flex');" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition-colors">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors">Update Video</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, title, desc, url, order) {
    document.getElementById('editForm').action = '/admin/training/' + id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = desc;
    document.getElementById('edit_video_url').value = url;
    document.getElementById('edit_order').value = order;
    
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}
</script>
@endsection
