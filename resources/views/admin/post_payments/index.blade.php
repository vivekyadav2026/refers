@extends('layouts.app')
@section('title', 'Customer Detail Forms - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Customer Detail Forms</h1>
        <p class="text-slate-500 mt-1">Review details submitted by customers.</p>
    </div>
    <a href="{{ route('admin.post-payments.export') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl transition-colors shadow-sm shrink-0">
        <i data-lucide="download" class="w-4 h-4"></i> Export to Excel (CSV)
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" x-data="{ openModal: null }">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID / Date</th>
                    <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Order</th>
                    <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Customer</th>
                    <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Service</th>
                    <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Files</th>
                    <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($details as $detail)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-900">#{{ $detail->id }}</div>
                            <div class="text-xs text-slate-500">{{ $detail->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <a href="{{ route('admin.orders.show', $detail->order_id) }}" class="text-indigo-600 font-bold hover:underline">
                                ORD-{{ str_pad($detail->order_id, 5, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-900">{{ $detail->user->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-slate-500">{{ $detail->user->phone ?? 'No Phone' }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded bg-indigo-50 text-indigo-700 text-xs font-black">
                                {{ $detail->service_name }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-1 text-slate-500 text-xs font-bold">
                                <i data-lucide="paperclip" class="w-3.5 h-3.5"></i>
                                {{ is_array($detail->uploaded_files) ? count($detail->uploaded_files) : 0 }} Files
                            </div>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <button @click="openModal = {{ $detail->id }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-lg transition-colors">
                                View Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-500">
                            <i data-lucide="file-question" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                            <p class="text-sm font-medium">No details have been submitted yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- View Modals (Placed outside table tags for valid HTML and correct rendering) -->
    @foreach($details as $detail)
        <div x-show="openModal === {{ $detail->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" style="display: none;" x-transition>
            <div @click.away="openModal = null" class="bg-white rounded-2xl shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden text-left">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Customer Details - ORD-{{ str_pad($detail->order_id, 5, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-xs text-slate-500 mt-1">Submitted by {{ $detail->user->name ?? 'Unknown' }}</p>
                    </div>
                    <button @click="openModal = null" class="p-2 text-slate-400 hover:text-red-500 rounded-lg hover:bg-red-50 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto flex-1">
                    <!-- Data Answers -->
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Customer Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        @if(is_array($detail->data) && count($detail->data) > 0)
                            @foreach($detail->data as $key => $value)
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">{{ str_replace('_', ' ', $key) }}</div>
                                    <div class="text-sm font-medium text-slate-900 whitespace-pre-wrap">{{ $value ?: '-' }}</div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-slate-500 italic">No textual data submitted.</p>
                        @endif
                    </div>

                    <!-- Uploaded Files -->
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Uploaded Files</h4>
                    @if(is_array($detail->uploaded_files) && count($detail->uploaded_files) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach($detail->uploaded_files as $file)
                                <a href="{{ asset($file['url']) }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-xl border border-slate-200 hover:border-blue-400 hover:bg-blue-50 transition-colors group">
                                    @if($file['type'] === 'image')
                                        <i data-lucide="image" class="w-8 h-8 text-blue-400 mb-2 group-hover:scale-110 transition-transform"></i>
                                    @else
                                        <i data-lucide="file-text" class="w-8 h-8 text-slate-400 mb-2 group-hover:scale-110 transition-transform"></i>
                                    @endif
                                    <span class="text-xs font-bold text-slate-700 text-center truncate w-full" title="{{ $file['name'] ?? 'File' }}">{{ $file['name'] ?? 'File' }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500 italic">No files uploaded.</p>
                    @endif
                </div>
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                    <button @click="openModal = null" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition-colors text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
