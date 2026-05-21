<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Notifications\OrderStatusNotification;

class AdminOrderController extends Controller
{
    // ─── LIST ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Order::with(['user', 'service', 'lead'])
            ->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                                                    ->orWhere('email', 'like', "%{$search}%"))
                  ->orWhereHas('service', fn($s) => $s->where('name', 'like', "%{$search}%"));
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15)->withQueryString();

        // Summary counts
        $totalOrders     = Order::count();
        $pendingCount    = Order::where('status', 'pending')->count();
        $paidCount       = Order::where('status', 'paid')->count();
        $inProgressCount = Order::where('status', 'in_progress')->count();
        $completedCount  = Order::where('status', 'completed')->count();
        $totalRevenue    = Order::where('status', '!=', 'pending')->sum('amount');

        return view('admin.orders.index', compact(
            'orders', 'totalOrders', 'pendingCount', 'paidCount', 'inProgressCount', 'completedCount', 'totalRevenue'
        ));
    }

    // ─── VIEW DETAIL ─────────────────────────────────────────────────────────
    public function show(Order $order)
    {
        $order->load(['user', 'service', 'lead.partner', 'commissions.user', 'review']);
        return view('admin.orders.show', compact('order'));
    }

    // ─── EDIT FORM ───────────────────────────────────────────────────────────
    public function edit(Order $order)
    {
        $order->load(['user', 'service', 'lead']);
        $services = Service::orderBy('name')->get();
        return view('admin.orders.edit', compact('order', 'services'));
    }

    // ─── UPDATE ──────────────────────────────────────────────────────────────
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status'       => 'required|in:pending,paid,in_progress,completed,cancelled',
            'amount'       => 'required|numeric|min:0',
            'requirements' => 'nullable|string|max:3000',
            'service_id'   => 'nullable|exists:services,id',
        ]);

        $order->update($request->only('status', 'amount', 'requirements', 'service_id'));

        if ($request->filled('status') && $order->user) {
            $order->user->notify(new OrderStatusNotification($order));
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' updated successfully.');
    }

    // ─── STATUS QUICK-UPDATE (dropdown on list) ───────────────────────────────
    public function status(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,in_progress,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        if ($order->user) {
            $order->user->notify(new OrderStatusNotification($order));
        }

        return back()->with('success', 'Order status updated.');
    }

    // ─── DELETE ──────────────────────────────────────────────────────────────
    public function destroy(Order $order)
    {
        $orderId = str_pad($order->id, 5, '0', STR_PAD_LEFT);
        $order->delete();

        return redirect()->route('admin.orders')
            ->with('success', "Order #ORD-{$orderId} has been deleted.");
    }
}
