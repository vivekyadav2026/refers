<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KycDocument;
use App\Models\User;
use App\Notifications\KycStatusChanged;

class AdminKycController extends Controller
{
    // ─── LIST ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = KycDocument::with('user')->orderBy('created_at', 'desc');

        // Search
        if ($search = $request->input('search')) {
            $query->whereHas('user', fn($u) =>
                $u->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', $search)
            );
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $kycDocuments = $query->paginate(15)->withQueryString();

        // Summary counts
        $totalCount    = KycDocument::count();
        $pendingCount  = KycDocument::where('status', 'pending')->count();
        $approvedCount = KycDocument::where('status', 'approved')->count();
        $rejectedCount = KycDocument::where('status', 'rejected')->count();

        return view('admin.kyc', compact(
            'kycDocuments', 'totalCount', 'pendingCount', 'approvedCount', 'rejectedCount'
        ));
    }

    // ─── DETAIL VIEW ─────────────────────────────────────────────────────────
    public function show(KycDocument $kyc)
    {
        $kyc->load('user');
        return view('admin.kyc-show', compact('kyc'));
    }

    // ─── APPROVE ─────────────────────────────────────────────────────────────
    public function approve(Request $request, KycDocument $kyc)
    {
        $kyc->update(['status' => 'approved', 'rejection_reason' => null]);
        $kyc->user->update(['kyc_status' => 'approved']);

        // Notify the partner
        $kyc->user->notify(new KycStatusChanged($kyc, 'approved'));

        return back()->with('success', "KYC for {$kyc->user->name} approved successfully.");
    }

    // ─── REJECT ──────────────────────────────────────────────────────────────
    public function reject(Request $request, KycDocument $kyc)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $kyc->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->reason,
        ]);
        $kyc->user->update(['kyc_status' => 'rejected']);

        // Notify the partner
        $kyc->user->notify(new KycStatusChanged($kyc, 'rejected'));

        return back()->with('success', "KYC for {$kyc->user->name} rejected. Partner has been notified.");
    }

    // ─── DELETE ──────────────────────────────────────────────────────────────
    public function destroy(KycDocument $kyc)
    {
        $name = $kyc->user->name ?? 'Unknown';
        // Reset user KYC status
        if ($kyc->user) {
            $kyc->user->update(['kyc_status' => 'unsubmitted']);
        }
        $kyc->delete();
        return back()->with('success', "KYC record for {$name} deleted. Their status reset to unsubmitted.");
    }
}
