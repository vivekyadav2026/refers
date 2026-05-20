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
        
        $totalEarnings = \App\Models\Commission::where('user_id', $user->id)
            ->whereIn('status', ['cleared', 'paid'])
            ->sum('amount');

        $totalLeads = Lead::where('partner_id', $user->id)->count();
        $conversions = Lead::where('partner_id', $user->id)->where('status', 'approved')->count();

        $recentLeads = Lead::where('partner_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Dynamic Chart Data (Last 7 Months)
        $monthlyEarnings = [];
        $monthlyLeads = [];
        $monthlyConversions = [];
        $monthsList = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthsList[] = $date->format('M');
            
            $monthlyEarnings[] = (float) \App\Models\Commission::where('user_id', $user->id)
                ->whereIn('status', ['cleared', 'paid'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
                
            $monthlyLeads[] = Lead::where('partner_id', $user->id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $monthlyConversions[] = Lead::where('partner_id', $user->id)
                ->where('status', 'approved')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $chartMonths = json_encode($monthsList);
        $chartEarnings = json_encode($monthlyEarnings);
        $chartLeads = json_encode($monthlyLeads);
        $chartConversions = json_encode($monthlyConversions);

        return view('dashboard', compact(
            'wallet',
            'totalEarnings',
            'totalLeads',
            'conversions',
            'recentLeads',
            'chartMonths',
            'chartEarnings',
            'chartLeads',
            'chartConversions'
        ));
    }
}
