<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalStatusNotification;

class AdminWithdrawalController extends Controller
{
    // ─── LIST ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Withdrawal::with(['user', 'user.wallet'])->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                                                    ->orWhere('email', 'like', "%{$search}%")
                                                    ->orWhere('phone', 'like', "%{$search}%"));
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $withdrawals = $query->paginate(15)->withQueryString();

        // Summary counts
        $totalCount    = Withdrawal::count();
        $pendingCount  = Withdrawal::where('status', 'pending')->count();
        $approvedCount = Withdrawal::where('status', 'approved')->count();
        $rejectedCount = Withdrawal::where('status', 'rejected')->count();
        $pendingAmount = Withdrawal::where('status', 'pending')->sum('amount');
        $paidAmount    = Withdrawal::where('status', 'approved')->sum('amount');

        return view('admin.withdrawals.index', compact(
            'withdrawals', 'totalCount', 'pendingCount', 'approvedCount',
            'rejectedCount', 'pendingAmount', 'paidAmount'
        ));
    }

    // ─── APPROVE ─────────────────────────────────────────────────────────────
    public function approve(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $withdrawal->update([
            'status'      => 'approved',
            'admin_notes' => $request->admin_notes,
        ]);

        if ($withdrawal->user) {
            $withdrawal->user->notify(new WithdrawalStatusNotification($withdrawal));
        }

        return back()->with('success', "Withdrawal of ₹" . number_format($withdrawal->amount, 2) . " approved for {$withdrawal->user->name}.");
    }

    // ─── REJECT ──────────────────────────────────────────────────────────────
    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $withdrawal->update([
            'status'      => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        if ($withdrawal->user) {
            $withdrawal->user->notify(new WithdrawalStatusNotification($withdrawal));
        }

        // Refund the amount back to wallet
        if ($withdrawal->user && $withdrawal->user->wallet) {
            $withdrawal->user->wallet->increment('balance', $withdrawal->amount);
        }

        return back()->with('success', "Withdrawal rejected. ₹" . number_format($withdrawal->amount, 2) . " refunded to {$withdrawal->user->name}'s wallet.");
    }

    // ─── DELETE ──────────────────────────────────────────────────────────────
    public function destroy(Withdrawal $withdrawal)
    {
        if ($withdrawal->status === 'pending') {
            // Refund if deleting a pending request
            if ($withdrawal->user && $withdrawal->user->wallet) {
                $withdrawal->user->wallet->increment('balance', $withdrawal->amount);
            }
        }
        $withdrawal->delete();
        return back()->with('success', 'Withdrawal request deleted.');
    }
}
