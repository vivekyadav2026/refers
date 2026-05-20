<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Lead;
use App\Models\Withdrawal;
use App\Models\Commission;
use App\Models\Service;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::whereIn('status', ['paid', 'completed', 'in_progress'])->sum('amount');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalPartners = User::where('role', 'partner')->count();
        $activePartners = User::where('role', 'partner')->where('status', 'active')->count();
        $pendingLeads = Lead::where('status', 'pending')->count();
        $totalPaidOut = Withdrawal::where('status', 'approved')->sum('amount');
        $pendingCommissions = Commission::where('status', 'pending')->sum('amount');
        $totalServices = Service::count();
        
        $recentOrders = Order::with(['user', 'service'])->latest()->take(5)->get();
        $recentActivity = Lead::with('partner')->orderBy('created_at', 'desc')->take(5)->get();

        // Dynamic Chart Data (Last 6 Months)
        $monthlyRevenue = [];
        $monthlyPartners = [];
        $monthsList = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthsList[] = $date->format('M');
            
            $monthlyRevenue[] = (float) Order::whereIn('status', ['paid', 'completed', 'in_progress'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
                
            $monthlyPartners[] = User::where('role', 'partner')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $chartMonths = json_encode($monthsList);
        $chartRevenue = json_encode($monthlyRevenue);
        $chartPartners = json_encode($monthlyPartners);

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalPartners',
            'activePartners',
            'pendingLeads',
            'totalPaidOut',
            'pendingCommissions',
            'totalServices',
            'recentOrders',
            'recentActivity',
            'chartMonths',
            'chartRevenue',
            'chartPartners'
        ));
    }
}
