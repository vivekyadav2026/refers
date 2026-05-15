<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    // ─── LIST ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = User::withCount(['leads', 'referrals'])
            ->with('wallet')
            ->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        if ($status = $request->input('status')) {
            if ($status === 'kyc_pending') {
                $query->where('kyc_status', 'pending');
            } elseif ($status === 'active') {
                $query->where('status', 'active');
            } elseif ($status === 'suspended') {
                $query->where('status', 'suspended');
            }
        }

        $users          = $query->paginate(15)->withQueryString();
        $totalPartners  = User::where('role', 'partner')->count();
        $activePartners = User::where('role', 'partner')->where('status', 'active')->count();
        $kycPending     = User::where('kyc_status', 'pending')->count();
        $suspendedCount = User::where('status', 'suspended')->count();

        return view('admin.users', compact(
            'users', 'totalPartners', 'activePartners', 'kycPending', 'suspendedCount'
        ));
    }

    // ─── CREATE FORM ─────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.partner-create');
    }

    // ─── STORE NEW PARTNER ───────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,partner',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
            'status'   => 'active',
            'kyc_status' => 'unsubmitted',
        ]);

        // Create a wallet for the new partner
        $user->wallet()->create(['balance' => 0, 'pending_balance' => 0]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Partner \"" . $user->name . "\" created successfully.");
    }

    public function show(User $user)
    {
        $user->loadCount(['leads', 'referrals'])
             ->load(['wallet', 'leads' => fn($q) => $q->latest()->take(5), 'referrer']);

        return view('admin.partner-detail', compact('user'));
    }

    // ─── EDIT FORM ───────────────────────────────────────────────────────────
    public function edit(User $user)
    {
        return view('admin.partner-edit', compact('user'));
    }

    // ─── UPDATE (SAVE) ───────────────────────────────────────────────────────
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'role'       => 'required|in:admin,partner',
            'kyc_status' => 'required|in:unsubmitted,pending,approved,rejected',
            'status'     => 'required|in:active,suspended',
        ]);

        if ($user->id === auth()->id() && $request->role !== $user->role) {
            return back()->withInput()->with('error', 'You cannot change your own role.');
        }

        $user->update($request->only('name', 'email', 'phone', 'role', 'kyc_status', 'status'));

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Partner {$user->name} updated successfully.");
    }

    // ─── DELETE ──────────────────────────────────────────────────────────────
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if (in_array($user->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'Admin accounts cannot be deleted. Demote to partner first.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', "Partner \"{$userName}\" has been permanently deleted.");
    }

    // ─── SUSPEND / RESTORE ───────────────────────────────────────────────────
    public function suspend(User $user)
    {
        if (in_array($user->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'Cannot suspend an admin account.');
        }
        $user->update(['status' => 'suspended']);
        return back()->with('success', "Partner {$user->name} has been suspended.");
    }

    public function restore(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', "Partner {$user->name} has been restored.");
    }

    // ─── ROLE CHANGE ─────────────────────────────────────────────────────────
    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,partner']);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', "Role updated to {$request->role} for {$user->name}.");
    }
}
