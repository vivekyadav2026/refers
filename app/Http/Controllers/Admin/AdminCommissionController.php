<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\User;
use App\Models\Order;
use App\Models\PartnerReferral;
use App\Notifications\CommissionCredited;

class AdminCommissionController extends Controller
{
    /**
     * List all commissions.
     */
    public function index(Request $request)
    {
        $query = Commission::with(['user', 'order.service'])->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                                                    ->orWhere('phone', 'like', "%{$search}%"))
                  ->orWhereHas('order', fn($o) => $o->where('id', $search));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $commissions = $query->paginate(15)->withQueryString();

        $totalCommissions = Commission::sum('amount');
        $pendingCommissions = Commission::where('status', 'pending')->sum('amount');
        $clearedCommissions = Commission::where('status', 'cleared')->sum('amount');
        $paidCommissions = Commission::where('status', 'paid')->sum('amount');

        return view('admin.commissions.index', compact(
            'commissions', 'totalCommissions', 'pendingCommissions',
            'clearedCommissions', 'paidCommissions'
        ));
    }

    /**
     * Approve (clear) a commission.
     */
    public function approve(Commission $commission)
    {
        if ($commission->status !== 'pending') {
            return back()->with('error', 'This commission has already been processed.');
        }

        $commission->update(['status' => 'cleared']);

        // Credit to partner's wallet
        if ($commission->user && $commission->user->wallet) {
            $commission->user->wallet->increment('balance', $commission->amount);
        }

        // Notify partner that commission was credited
        if ($commission->user) {
            $commission->user->notify(new CommissionCredited($commission));
        }

        return back()->with('success', 'Commission of ₹' . number_format($commission->amount, 2) . ' approved and credited to ' . $commission->user->name . '.');
    }

    /**
     * Reject a commission.
     */
    public function reject(Request $request, Commission $commission)
    {
        if ($commission->status !== 'pending') {
            return back()->with('error', 'This commission has already been processed.');
        }

        $commission->update(['status' => 'rejected']);

        return back()->with('success', 'Commission rejected.');
    }

    /**
     * Mark commission as paid.
     */
    public function markPaid(Commission $commission)
    {
        if ($commission->status !== 'cleared') {
            return back()->with('error', 'Commission must be cleared before marking as paid.');
        }

        $commission->update(['status' => 'paid']);

        return back()->with('success', 'Commission marked as paid.');
    }

    /**
     * Referral analytics page.
     */
    public function analytics(Request $request)
    {
        // Top performing partners
        $topPartners = User::where('role', 'partner')
            ->withCount(['commissions as total_commissions'])
            ->withSum('commissions as total_earnings', 'amount')
            ->having('total_commissions', '>', 0)
            ->orderByDesc('total_earnings')
            ->take(20)
            ->get();

        // Referral stats
        $totalReferralClicks = PartnerReferral::count();
        $totalReferralRegistrations = PartnerReferral::where('status', 'registered')->count();
        $totalReferralPurchases = PartnerReferral::where('status', 'purchased')->count();

        $totalReferralSales = Order::whereNotNull('referred_by_partner')
            ->whereIn('status', ['paid', 'completed', 'in_progress'])
            ->sum('amount');

        $totalCommissionsPaid = Commission::where('status', 'paid')->sum('amount');
        $totalCommissionsPending = Commission::where('status', 'pending')->sum('amount');

        return view('admin.commissions.analytics', compact(
            'topPartners', 'totalReferralClicks', 'totalReferralRegistrations',
            'totalReferralPurchases', 'totalReferralSales',
            'totalCommissionsPaid', 'totalCommissionsPending'
        ));
    }
}
