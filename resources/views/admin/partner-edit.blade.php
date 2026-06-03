@extends('layouts.app')

@section('title', 'Edit Partner: ' . $user->name . ' - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-3xl mx-auto">

    <!-- Back -->
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.users.show', $user) }}"
           class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Partner Profile
        </a>
    </div>

    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Partner</h1>
        <p class="text-slate-500 mt-1">Update account details, role, KYC and status for <span class="font-semibold text-slate-700">{{ $user->name }}</span>.</p>
    </div>

    @php
        $words = array_filter(explode(' ', trim($user->name)));
        $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice($words, 0, 2))));
        $avatarColors = ['from-indigo-500 to-purple-600','from-emerald-500 to-teal-600','from-amber-500 to-orange-600','from-rose-500 to-pink-600','from-sky-500 to-blue-600'];
        $avatarGradient = $avatarColors[$user->id % count($avatarColors)];
    @endphp

    <form method="POST" action="{{ route('admin.users.update', $user) }}" id="edit-partner-form">
        @csrf
        @method('PUT')

        <!-- Avatar + ID Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6 flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $avatarGradient }} flex items-center justify-center text-white font-bold text-xl shadow shrink-0">
                {{ $initials }}
            </div>
            <div>
                <div class="font-bold text-slate-900 text-lg">{{ $user->name }}</div>
                <div class="text-slate-500 text-sm">{{ $user->email }}</div>
                <div class="text-slate-400 text-xs font-mono mt-1">ID: #{{ $user->id }} &nbsp;·&nbsp; Joined {{ $user->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        <!-- Flash Errors -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm">
                <div class="font-semibold mb-2 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    Please fix the following errors:
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Section: Basic Info -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-5">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4"></i> Basic Information
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Name -->
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border @error('name') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="Full name" required>
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border @error('email') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="email@example.com" required>
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full border @error('phone') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="+91 98765 43210">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Section: Account Settings -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-5">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                <i data-lucide="settings-2" class="w-4 h-4"></i> Account Settings
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="role" name="role"
                            class="w-full appearance-none border @error('role') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition
                            {{ $user->id === auth()->id() ? 'opacity-60 cursor-not-allowed' : '' }}"
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="partner" {{ old('role', $user->role) === 'partner' ? 'selected' : '' }}>Partner</option>
                            <option value="admin"   {{ old('role', $user->role) === 'admin'   ? 'selected' : '' }}>Admin</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <p class="mt-1 text-xs text-slate-400">Cannot change your own role.</p>
                    @endif
                    @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- KYC Status -->
                <div>
                    <label for="kyc_status" class="block text-sm font-semibold text-slate-700 mb-1.5">KYC Status <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="kyc_status" name="kyc_status"
                            class="w-full appearance-none border @error('kyc_status') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                            @foreach(['unsubmitted','pending','approved','rejected'] as $ks)
                                <option value="{{ $ks }}" {{ old('kyc_status', $user->kyc_status) === $ks ? 'selected' : '' }}>
                                    {{ ucfirst($ks) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @error('kyc_status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Account Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">Account Status <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="status" name="status"
                            class="w-full appearance-none border @error('status') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                            <option value="active"    {{ old('status', $user->status) === 'active'    ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Danger Zone: Delete -->
        @if($user->id !== auth()->id() && !in_array($user->role, ['admin','superadmin']))
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-6">
            <h2 class="text-sm font-bold text-red-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Danger Zone
            </h2>
            <p class="text-sm text-red-600 mb-4">Permanently delete this partner account. This action <strong>cannot be undone</strong>. All associated data (leads, wallet, commissions) will be removed.</p>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('⚠️ DELETE {{ addslashes($user->name) }}?\n\nThis action is permanent and cannot be undone. Type OK to confirm.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    Delete Partner Account
                </button>
            </form>
        </div>
        @endif

        <!-- Form Actions -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('admin.users.show', $user) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                Save Changes
            </button>
        </div>
    </form>

</div>
@endsection
