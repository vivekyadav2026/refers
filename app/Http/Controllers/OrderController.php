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

        // Resolve referring partner: session → cookie → user's referred_by
        $referredByPartner = session('ref_partner_id')
            ?? $request->cookie('ref_partner_id')
            ?? auth()->user()->referred_by;

        // Validate the partner actually exists and is active
        if ($referredByPartner) {
            $partnerExists = \App\Models\User::where('id', $referredByPartner)
                ->where('role', 'partner')
                ->where('status', 'active')
                ->exists();
            if (!$partnerExists) {
                $referredByPartner = null;
            }
        }

        $order = Order::create([
            'user_id'              => auth()->id(),
            'service_id'           => $service->id,
            'amount'               => $service->min_price,
            'status'               => 'pending',
            'requirements'         => $request->requirements,
            'referred_by_partner'  => $referredByPartner,
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
        $user = auth()->user();
        $isAllowed = false;
        
        if ($user) {
            if (in_array($user->role, ['admin', 'superadmin'])) {
                $isAllowed = true;
            } elseif ($order->user_id === $user->id) {
                $isAllowed = true;
            } elseif ($order->lead && $order->lead->partner_id === $user->id) {
                $isAllowed = true;
            }
        }

        if (!$isAllowed) {
            abort(403, 'You do not have permission to view this invoice.');
        }

        $pdf = Pdf::loadView('orders.pdf_invoice', compact('order'));

        return $pdf->download('Invoice-ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
