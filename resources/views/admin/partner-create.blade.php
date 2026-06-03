@extends('layouts.app')

@section('title', 'Add New Partner - Admin')

@section('sidebar')
    <!-- This enables the sidebar -->
@endsection

@section('content')
<div class="py-8 w-full max-w-3xl mx-auto">

    <!-- Back -->
    <div class="mb-6">
        <a href="{{ route('admin.users') }}"
           class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Partners
        </a>
    </div>

    <!-- Page Title -->
    <div class="mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-sm shrink-0">
            <i data-lucide="user-plus" class="w-6 h-6"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Add New Partner</h1>
            <p class="text-slate-500 text-sm mt-0.5">Create a new partner or admin account manually.</p>
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

    <form method="POST" action="{{ route('admin.users.store') }}" id="create-partner-form">
        @csrf

        <!-- Section: Basic Info -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-5">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4"></i> Personal Information
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <!-- Name -->
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full border @error('name') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="e.g. Rahul Sharma" required autofocus>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full border @error('email') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="partner@example.com" required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Phone Number
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                        class="w-full border @error('phone') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="+91 98765 43210">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Referred By -->
                <div class="sm:col-span-2">
                    <label for="referred_by" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Referred By (Optional)
                    </label>
                    <div class="relative">
                        <select id="referred_by" name="referred_by"
                            class="w-full appearance-none border @error('referred_by') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                            <option value="">-- None --</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}" {{ old('referred_by') == $partner->id ? 'selected' : '' }}>
                                    {{ $partner->name }} ({{ $partner->phone ?? $partner->email }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @error('referred_by')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section: Password -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-5">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                <i data-lucide="lock" class="w-4 h-4"></i> Set Password
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full border @error('password') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                            placeholder="Min. 8 characters" required>
                        <button type="button" onclick="togglePassword('password', this)"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                            placeholder="Re-enter password" required>
                        <button type="button" onclick="togglePassword('password_confirmation', this)"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password strength tip -->
            <p class="mt-3 text-xs text-slate-400 flex items-center gap-1.5">
                <i data-lucide="info" class="w-3.5 h-3.5"></i>
                Use at least 8 characters with a mix of letters, numbers and symbols for a strong password.
            </p>
        </div>

        <!-- Section: Role & Settings -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                <i data-lucide="settings-2" class="w-4 h-4"></i> Account Settings
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="role" name="role"
                            class="w-full appearance-none border @error('role') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-slate-900 text-sm rounded-xl px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                            <option value="partner" {{ old('role', 'partner') === 'partner' ? 'selected' : '' }}>Partner</option>
                            <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1.5 text-xs text-slate-400">Partners can submit leads. Admins have full panel access.</p>
                </div>

                <!-- Info callout -->
                <div class="flex items-start gap-3 bg-indigo-50 border border-indigo-100 rounded-xl p-4">
                    <i data-lucide="info" class="w-5 h-5 text-indigo-500 shrink-0 mt-0.5"></i>
                    <div class="text-xs text-indigo-700">
                        <p class="font-semibold mb-1">Auto Defaults</p>
                        <p>KYC Status → <strong>Unsubmitted</strong></p>
                        <p>Account Status → <strong>Active</strong></p>
                        <p>Wallet → Created automatically</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('admin.users') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Create Partner
            </button>
        </div>
    </form>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const isHidden = field.type === 'password';
    field.type = isHidden ? 'text' : 'password';
    btn.querySelector('i').setAttribute('data-lucide', isHidden ? 'eye-off' : 'eye');
    if (window.lucide) lucide.createIcons();
}
</script>
@endsection
