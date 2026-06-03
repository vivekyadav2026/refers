@extends('layouts.app')

@section('title', 'Send Notifications - SKSolutions Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-3xl mx-auto">
    {{-- Flash alerts --}}
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

    <form action="{{ route('admin.notifications.store') }}" method="POST">
        @csrf
        
        <!-- Header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl text-slate-900 font-bold tracking-tight flex items-center gap-2">
                    <i data-lucide="send" class="w-7 h-7 text-indigo-600"></i>
                    Send Notifications
                </h1>
                <p class="text-slate-500 mt-1">Broadcast system alerts or custom messages directly to customer or partner panels.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-5 h-5 text-indigo-500"></i>
                    Message Details
                </h2>
                <p class="text-sm text-slate-500 mt-1">Write your broadcast alert message and select targeted audiences.</p>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Target Audience -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Target Audience <span class="text-red-500">*</span></label>
                    <select name="target" id="targetSelect" required
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 outline-none transition-all cursor-pointer">
                        <option value="all">All Members (Customers & Partners)</option>
                        <option value="customers">All Customers Only</option>
                        <option value="partners">All Partners Only</option>
                        <optgroup label="Specific User">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }} - {{ $user->phone ?: $user->email }})</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Notification Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="e.g. System Maintenance Scheduled or Welcome to Portal!" value="{{ old('title') }}"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 outline-none transition-all">
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Notification Message <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="4" required placeholder="Type the message details here..."
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 outline-none transition-all resize-none">{{ old('message') }}</textarea>
                </div>

                <!-- Action URL -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Redirect Action URL (Optional)</label>
                    <input type="url" name="url" placeholder="e.g. https://sksolutionss.com/customer/orders" value="{{ old('url') }}"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent block p-3 outline-none transition-all">
                    <p class="text-xs text-slate-400 mt-1">If set, users clicking on the notification will be redirected to this URL.</p>
                </div>

                <!-- Hidden defaults for icon and color -->
                <input type="hidden" name="icon" value="bell">
                <input type="hidden" name="color" value="slate">
            </div>

            <!-- Submit footer bar -->
            <div class="p-6 bg-slate-50 border-t border-slate-200 flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-750 hover:bg-indigo-700 text-white rounded-xl px-6 py-3 flex items-center gap-2 text-sm font-semibold shadow-md transition-all duration-200 hover:-translate-y-0.5">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Send Notification Now
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
