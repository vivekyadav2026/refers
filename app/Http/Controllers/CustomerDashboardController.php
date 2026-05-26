<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders = $user->orders()->with('service', 'items.service')->latest()->get();

        $totalOrders     = $orders->count();
        $pendingOrders   = $orders->where('status', 'pending')->count();
        $inProgressOrders = $orders->where('status', 'in_progress')->count();
        $paidOrders      = $orders->where('status', 'paid')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $totalSpent      = $orders->whereIn('status', ['paid', 'completed', 'in_progress'])->sum('amount');

        $recentOrders = $orders->take(5);

        // Fetch some recommended/active services for them to explore
        $recommendedServices = Service::where('is_active', true)
                                      ->inRandomOrder()
                                      ->take(3)
                                      ->get();

        return view('customer.dashboard', compact(
            'totalOrders', 'pendingOrders', 'inProgressOrders', 'paidOrders',
            'completedOrders', 'totalSpent', 'recentOrders', 'recommendedServices'
        ));
    }

    public function orders(Request $request)
    {
        $query = auth()->user()->orders()->with('service', 'items.service')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('customer.orders', compact('orders'));
    }

    public function orderShow(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('service', 'items.service', 'review');

        return view('customer.order-detail', compact('order'));
    }

    public function profile()
    {
        $categories = \App\Models\BusinessCategory::whereNull('parent_id')
                        ->with(['subcategories' => function($q) {
                            $q->where('is_active', true);
                        }])
                        ->where('is_active', true)
                        ->get();
        return view('customer.profile', compact('categories'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . auth()->id(),
            'email' => 'nullable|email|max:255|unique:users,email,' . auth()->id(),
            'company_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'phone', 'email', 'company_name', 'business_type');

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        auth()->user()->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }
}
