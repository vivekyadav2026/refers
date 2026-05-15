<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Lead;
use App\Models\Withdrawal;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('amount');
        $activePartners = User::where('role', 'partner')->where('status', 'active')->count();
        $pendingLeads = Lead::where('status', 'pending')->count();
        $totalPaidOut = Withdrawal::where('status', 'approved')->sum('amount');
        
        $recentActivity = Lead::with('partner')->orderBy('created_at', 'desc')->take(5)->get(); // Example

        return view('admin.dashboard', compact(
            'totalRevenue',
            'activePartners',
            'pendingLeads',
            'totalPaidOut',
            'recentActivity'
        ));
    }
}
