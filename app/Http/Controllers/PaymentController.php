<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\PartnerReferral;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;

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

            // Send Invoice Email to Customer and Admin
            $this->emailInvoice($order);

            $customer = \Illuminate\Support\Facades\Auth::guard('customer')->user();
            $partner  = \Illuminate\Support\Facades\Auth::guard('partner')->user();
            $admin    = \Illuminate\Support\Facades\Auth::guard('admin')->user();

            if ($customer && $order->user_id == $customer->id) {
                // If the logged-in customer is the owner of the order, prioritize the business details form
                return redirect()->route('customer.business-details.create', $order)->with('success', 'Payment successful! Please provide your business details to start the project.');
            } elseif ($admin) {
                $redirectRoute = 'admin.orders.show';
                return redirect()->route($redirectRoute, $order)->with('success', 'Payment successful! Order is now paid.');
            } elseif ($partner) {
                $redirectRoute = 'partner.orders.show';
                return redirect()->route($redirectRoute, $order)->with('success', 'Payment successful! Order is now paid.');
            } else {
                // Fallback using the order owner's role
                if ($order->user && $order->user->isCustomer()) {
                    return redirect()->route('customer.business-details.create', $order)->with('success', 'Payment successful! Please provide your business details to start the project.');
                }
                return redirect()->route('customer.orders')->with('success', 'Payment successful! Order is now paid.');
            }
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

        // Fallback: check through lead
        if (!$partnerId && $order->lead_id && $order->lead && $order->lead->partner_id) {
            $partnerId = $order->lead->partner_id;
        }

        if (!$partnerId) {
            Log::info('Commission skipped: no partner linked to order #' . $order->id);
            return;
        }

        // Prevent duplicate commission for the same order
        $alreadyExists = \App\Models\Commission::where('order_id', $order->id)
            ->where('user_id', $partnerId)
            ->exists();
        if ($alreadyExists) {
            Log::info('Commission already exists for order #' . $order->id . ', skipping.');
            return;
        }

        // Load the service — fall back to first order item's service if not set
        $service = $order->service;
        if (!$service && $order->items->isNotEmpty()) {
            $service = $order->items->first()->service;
        }

        // Get commission rate: service-level → global setting → default 10%
        $commissionRate = null;
        $commissionType = 'percentage';

        if ($service) {
            $commissionRate = $service->commission_rate;
            $commissionType = $service->commission_type ?? 'percentage';
        }

        if (!$commissionRate) {
            $commissionRate = Setting::get_val('default_commission', 10);
            $commissionType = 'percentage';
        }

        if ($commissionType === 'fixed') {
            $commissionAmount = (float) $commissionRate;
        } else {
            $commissionAmount = round($order->amount * ($commissionRate / 100), 2);
        }

        // Safety: don't create a ₹0 commission
        if ($commissionAmount <= 0) {
            Log::warning('Commission amount is 0 for order #' . $order->id . '. Rate: ' . $commissionRate . '%. Skipping.');
            return;
        }

        $commission = \App\Models\Commission::create([
            'user_id'    => $partnerId,
            'order_id'   => $order->id,
            'type'       => $commissionType,
            'percentage' => $commissionType === 'percentage' ? $commissionRate : 0,
            'amount'     => $commissionAmount,
            'status'     => 'pending',
        ]);

        Log::info('Commission of ₹' . $commissionAmount . ' created for partner #' . $partnerId . ' on order #' . $order->id);

        // Update referral tracking record
        PartnerReferral::where('partner_id', $partnerId)
            ->where('customer_id', $order->user_id)
            ->update([
                'order_id' => $order->id,
                'status'   => 'purchased',
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

    /**
     * Email Invoice to Customer and Admin
     */
    private function emailInvoice(Order $order)
    {
        try {
            $customerEmail = $order->user->email ?? $order->customer_email;
            $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email')->toArray();
            
            if ($customerEmail) {
                $mail = Mail::to($customerEmail);
                if (!empty($adminEmails)) {
                    $mail->cc($adminEmails);
                }
                $mail->queue(new OrderInvoiceMail($order));
            }
        } catch (\Exception $e) {
            Log::error('Invoice email failed: ' . $e->getMessage());
        }
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric|digits:10',
            'requirements' => 'nullable|string',
        ]);

        $service = \App\Models\Service::findOrFail($request->service_id);
        
        // Calculate price based on selected plan
        $plans = $service->plans ?? [];
        $selectedPlanKey = $request->plan_selected ?? 'basic';

        $planName = $selectedPlanKey;
        $planPrice = (float) $service->min_price;

        if (isset($plans[$selectedPlanKey])) {
            $planName = $plans[$selectedPlanKey]['name'] ?? $selectedPlanKey;
            $planPrice = (float) ($plans[$selectedPlanKey]['price'] ?? $planPrice);
        }

        // Handle platform selection
        $platformPrice = 0.0;
        $platformChoice = null;
        if ($service->enable_platforms && $request->filled('platform_choice')) {
            $platformInput = $request->platform_choice;
            $platforms = $service->platforms ?? [];
            
            if (is_numeric($platformInput) && isset($platforms[$platformInput])) {
                $platformChoice = $platforms[$platformInput]['name'];
                $platformPrice = (float) ($platforms[$platformInput]['price'] ?? 0);
            } else {
                foreach ($platforms as $p) {
                    if (isset($p['name']) && $p['name'] === $platformInput) {
                        $platformChoice = $p['name'];
                        $platformPrice = (float) ($p['price'] ?? 0);
                        break;
                    }
                }
            }
        }

        // Apply Dynamic Pricing Matrix if it exists
        if ($platformChoice && !empty($service->pricing_matrix)) {
            $matrix = $service->pricing_matrix;
            if (isset($matrix[$platformChoice][$planName])) {
                $planPrice = (float) $matrix[$platformChoice][$planName];
                $platformPrice = 0.0; // Matrix price is the complete price
            }
        }

        // Calculate domain charge if required and enabled
        $domainCharge = 0.0;
        $enableDomain = (bool) $service->requires_domain;
        if ($enableDomain && $request->domain_choice) {
            if ($request->domain_choice === 'in') {
                $domainCharge = (float) ($service->domain_in_charge ?? 599.00);
            } elseif ($request->domain_choice === 'com') {
                $domainCharge = (float) ($service->domain_com_charge ?? 999.00);
            }
        }

        // Calculate GST
        $gstAmount = 0.0;
        $enableGst = (bool) $service->enable_gst;
        if ($enableGst) {
            $gstPercent = (float) ($service->gst_percent ?? 18.00);
            $gstAmount = ($planPrice + $platformPrice) * ($gstPercent / 100);
        }

        $total = $planPrice + $platformPrice + $gstAmount + $domainCharge;

        // Apply coupon discount if provided
        $couponDiscount = 0.0;
        $appliedCoupon = null;
        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', strtoupper(trim($request->coupon_code)))
                ->where('is_active', true)
                ->where(function($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>', now()); })
                ->where(function($q) use ($service) { $q->whereNull('service_id')->orWhere('service_id', $service->id); })
                ->first();
            if ($coupon) {
                if ($coupon->discount_type === 'percent') {
                    $couponDiscount = round($total * $coupon->discount_value / 100, 2);
                } else {
                    $couponDiscount = min((float)$coupon->discount_value, $total);
                }
                $total = max(0, $total - $couponDiscount);
                $appliedCoupon = $coupon;
            }
        }
        // Resolve the referring partner with proper fallback chain
        $referredByPartner = session('ref_partner_id')
            ?? request()->cookie('ref_partner_id')
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

        // Update user's name if they are using the default placeholder
        $user = auth()->user();
        $defaultName = 'User ' . substr($user->phone, -4);
        if ($user->name === $defaultName && $request->customer_name && $request->customer_name !== $defaultName) {
            $user->update(['name' => $request->customer_name]);
        }

        $requirements = $request->requirements ?? '';
        if ($platformChoice) {
            $platformText = "Selected Platform: " . $platformChoice;
            if ($platformPrice > 0) {
                $platformText .= " (+₹" . $platformPrice . ")";
            }
            $requirements = $platformText . "\n\n" . $requirements;
        }

        if ($enableDomain && $request->filled('domain_choice')) {
            $choiceLabel = match($request->domain_choice) {
                'in' => '.in Extension',
                'com' => '.com Extension',
                default => 'Already Have Domain'
            };
            $domainText = "Selected Domain Option: " . $choiceLabel . "\n";
            if ($request->filled('domain_name')) {
                $domainText .= "Domain Name: " . $request->domain_name . "\n";
            }
            $domainText .= "\n";
            $requirements = $domainText . $requirements;
        }

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'amount' => max(0, $total),
            'status' => 'pending',
            'requirements' => $requirements,
            'customer_name' => $request->customer_name,
            'customer_email' => auth()->user()->email,
            'customer_phone' => $request->customer_phone,
            'referred_by_partner' => $referredByPartner,
            'platform_choice' => $platformChoice,
            'platform_price' => $platformPrice,
            'domain_choice' => $request->domain_choice,
            'domain_charge' => $domainCharge,
            'gst_amount' => $gstAmount,
            'coupon_code' => $appliedCoupon ? $appliedCoupon->code : null,
            'coupon_discount' => $couponDiscount,
        ]);

        // Increment coupon usage
        if ($appliedCoupon) {
            $appliedCoupon->increment('used_count');
        }

        // Create business details if domain name is submitted
        if ($enableDomain && $request->filled('domain_name')) {
            \App\Models\BusinessDetail::create([
                'order_id' => $order->id,
                'business_name' => $request->customer_name . "'s Business",
                'domain_name' => $request->domain_name,
            ]);
        }

        // Create order item
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'service_id' => $service->id,
            'price' => $planPrice,
            'quantity' => 1,
            'subtotal' => $planPrice,
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
