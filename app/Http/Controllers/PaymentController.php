<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
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
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)->with('error', 'This order is already processed.');
        }

        // Create Razorpay Order
        $orderData = [
            'receipt'         => 'rcptid_' . $order->id,
            'amount'          => $order->service->price * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        try {
            $razorpayOrder = $this->api->order->create($orderData);
            $razorpayOrderId = $razorpayOrder['id'];

            // We can store razorpay_order_id on the order if we want, or just pass it
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
            $order->update(['status' => 'paid']);

            // Record the transaction
            Transaction::create([
                'user_id' => auth()->id(),
                'type' => 'payment',
                'amount' => $order->service->price,
                'description' => 'Payment for Order #' . $order->id,
                'reference_id' => $request->razorpay_payment_id,
            ]);

            // Trigger commission calculations if a referral exists
            if ($order->lead_id && $order->lead && $order->lead->partner_id) {
                $commissionAmount = $order->service->price * 0.10; // Flat 10% for example

                \App\Models\Commission::create([
                    'user_id' => $order->lead->partner_id,
                    'order_id' => $order->id,
                    'type' => 'percentage',
                    'percentage' => 10,
                    'amount' => $commissionAmount,
                    'status' => 'pending'
                ]);
            }

            return redirect()->route('orders.show', $order)->with('success', 'Payment successful! Order is now paid.');
        } else {
            return redirect()->route('orders.index')->with('error', 'Payment verification failed.');
        }
    }

    public function webhook(Request $request)
    {
        // Handle Razorpay webhooks (async payment status updates)
        return response()->json(['status' => 'ok']);
    }
}
