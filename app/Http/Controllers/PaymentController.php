<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\PartnerReferral;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function createPayment(Order $order)
    {
        $user = auth()->user();
        $isAllowed = false;
        if ($user) {
            if (in_array($user->role, ['admin', 'superadmin'])) {
                $isAllowed = true;
            } elseif ($order->user_id === $user->id) {
                $isAllowed = true;
            } elseif ($order->referred_by_partner === $user->id) {
                $isAllowed = true;
            }
        }

        if (!$isAllowed) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('customer.orders')->with('error', 'This order is already processed.');
        }

        // Create Razorpay Order
        $orderData = [
            'receipt'         => 'rcptid_' . $order->id,
            'amount'          => $order->amount * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        try {
            $razorpayOrder = $this->api->order->create($orderData);
            $razorpayOrderId = $razorpayOrder['id'];

            // Store razorpay_order_id
            $order->update(['razorpay_order_id' => $razorpayOrderId]);

            return view('payment.checkout', compact('order', 'razorpayOrderId'));
            
        } catch (\Exception $e) {
            Log::error('Razorpay Error: ' . $e->getMessage());
            return back()->with('error', 'Error initializing payment gateway.');
        }
    }

    public function verify(Request $request)
    {
        $success = true;

        try {
            $attributes = array(
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            );

            $this->api->utility->verifyPaymentSignature($attributes);
        } catch (\Exception $e) {
            $success = false;
            Log::error('Razorpay Signature Verification Failed: ' . $e->getMessage());
        }

        if ($success) {
            $order = Order::findOrFail($request->order_id);
            $order->update([
                'status' => 'paid',
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

            // Update lead status to won if linked to a lead
            if ($order->lead_id && $order->lead) {
                $order->lead->update(['status' => 'won']);
            }

            // Auto-generate commission if order was referred by a partner
            $this->generateReferralCommission($order);

            // Notify admin
            $this->notifyAdmin($order);

            $user = auth()->user();
            if ($user && in_array($user->role, ['admin', 'superadmin'])) {
                $redirectRoute = 'admin.orders.show';
            } elseif ($user && $user->isCustomer()) {
                $redirectRoute = 'customer.order.show';
            } else {
                $redirectRoute = 'partner.orders.show';
            }

            return redirect()->route($redirectRoute, $order)->with('success', 'Payment successful! Order is now paid.');
        } else {
            return redirect()->route('customer.orders')->with('error', 'Payment verification failed.');
        }
    }

    /**
     * Generate commission for the referring partner.
     */
    private function generateReferralCommission(Order $order)
    {
        $partnerId = $order->referred_by_partner;

        // Check through lead as well
        if (!$partnerId && $order->lead_id && $order->lead && $order->lead->partner_id) {
            $partnerId = $order->lead->partner_id;
        }

        if (!$partnerId) {
            return;
        }

        // Get commission rate from service or global settings
        $service = $order->service;
        $commissionRate = $service->commission_rate ?? Setting::get_val('default_commission', 20);
        $commissionType = $service->commission_type ?? 'percentage';

        if ($commissionType === 'fixed') {
            $commissionAmount = (float) $commissionRate;
        } else {
            $commissionAmount = $order->amount * ($commissionRate / 100);
        }

        \App\Models\Commission::create([
            'user_id' => $partnerId,
            'order_id' => $order->id,
            'type' => $commissionType,
            'percentage' => $commissionType === 'percentage' ? $commissionRate : 0,
            'amount' => $commissionAmount,
            'status' => 'pending'
        ]);

        // Update referral tracking
        PartnerReferral::where('partner_id', $partnerId)
            ->where('customer_id', $order->user_id)
            ->update([
                'order_id' => $order->id,
                'status' => 'purchased',
            ]);
    }

    /**
     * Notify admin of new order.
     */
    private function notifyAdmin(Order $order)
    {
        // Send notification to all admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            try {
                $admin->notify(new \App\Notifications\PaymentSuccessful($order));
            } catch (\Exception $e) {
                Log::warning('Failed to notify admin: ' . $e->getMessage());
            }
        }
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric|digits:10',
            'requirements' => 'required|string|min:5',
        ]);

        $service = \App\Models\Service::findOrFail($request->service_id);
        $total = $service->min_price;

        $referredByPartner = session('ref_partner_id');

        // Update user's name if they are using the default placeholder
        $user = auth()->user();
        $defaultName = 'User ' . substr($user->phone, -4);
        if ($user->name === $defaultName && $request->customer_name && $request->customer_name !== $defaultName) {
            $user->update(['name' => $request->customer_name]);
        }

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'amount' => max(0, $total),
            'status' => 'pending',
            'requirements' => $request->requirements,
            'customer_name' => $request->customer_name,
            'customer_email' => auth()->user()->email,
            'customer_phone' => $request->customer_phone,
            'referred_by_partner' => $referredByPartner,
        ]);

        // Create order item
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'service_id' => $service->id,
            'price' => $service->min_price,
            'quantity' => 1,
            'subtotal' => $service->min_price,
        ]);

        // Create Razorpay Order
        $orderData = [
            'receipt'         => 'rcptid_' . $order->id,
            'amount'          => $order->amount * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        try {
            $razorpayOrder = $this->api->order->create($orderData);
            $razorpayOrderId = $razorpayOrder['id'];

            // Store razorpay_order_id
            $order->update(['razorpay_order_id' => $razorpayOrderId]);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrderId,
                'amount' => $order->amount,
                'key' => env('RAZORPAY_KEY'),
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'contact' => $request->customer_phone,
                'service_name' => $service->name
            ]);
            
        } catch (\Exception $e) {
            Log::error('Razorpay Error in Buy Now: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error initializing payment gateway.'], 500);
        }
    }

    public function webhook(Request $request)
    {
        // Handle Razorpay webhooks (async payment status updates)
        return response()->json(['status' => 'ok']);
    }
}
