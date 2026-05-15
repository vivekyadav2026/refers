<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Ensure wallet exists
        if (!$user->wallet) {
            $user->wallet()->create(['balance' => 0, 'pending_balance' => 0]);
            $user->refresh();
        }

        $wallet = $user->wallet;
        
        $totalEarnings = Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');
            
        $referralEarnings = Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->where('description', 'like', '%referral%')
            ->sum('amount');

        $totalLeads = Lead::where('partner_id', $user->id)->count();
        $conversions = Lead::where('partner_id', $user->id)->where('status', 'approved')->count();

        $recentLeads = Lead::where('partner_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'wallet',
            'totalEarnings',
            'totalLeads',
            'conversions',
            'referralEarnings',
            'recentLeads'
        ));
    }
}
