<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->orders()->with('service')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function create(Service $service)
    {
        return view('orders.create', compact('service'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id'   => 'required|exists:services,id',
            'requirements' => 'required|string|min:10',
        ]);

        $service = Service::findOrFail($request->service_id);

        $order = Order::create([
            'user_id'      => auth()->id(),
            'service_id'   => $service->id,
            'amount'       => $service->min_price,
            'status'       => 'pending',
            'requirements' => $request->requirements,
        ]);

        return redirect()->route('payment.create', $order)
                         ->with('success', 'Order placed! Please complete your payment.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && $order->lead?->partner_id !== auth()->id()) {
            abort(403, 'You do not have permission to view this order.');
        }

        $order->load('service', 'user', 'lead', 'review');

        return view('orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== auth()->id() && $order->lead?->partner_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('orders.pdf_invoice', compact('order'));

        return $pdf->download('Invoice-ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
