<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Service;
use App\Models\Coupon;
use App\Models\User;
use App\Notifications\NewOrderPlaced;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('service')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->service->min_price * $item->quantity;
        });

        $activeCoupons = Coupon::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->with('service')
            ->get();

        return view('cart.index', compact('cartItems', 'total', 'activeCoupons'));
    }

    /**
     * Add a service to cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $service = Service::findOrFail($request->service_id);

        // Check if already in cart
        $existing = Cart::where('user_id', auth()->id())
            ->where('service_id', $service->id)
            ->first();

        if ($existing) {
            return back()->with('info', 'This service is already in your cart.');
        }

        Cart::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'quantity' => 1,
            'notes' => $request->notes,
        ]);

        return back()->with('success', $service->name . ' added to cart!');
    }

    /**
     * Remove item from cart.
     */
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Show checkout form.
     */
    public function checkout()
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('service')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->service->min_price * $item->quantity;
        });

        $activeCoupons = Coupon::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->with('service')
            ->get();

        return view('cart.checkout', compact('cartItems', 'total', 'activeCoupons'));
    }

    /**
     * Process checkout and create order.
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric|digits:10',
            'customer_email' => 'nullable|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'requirements' => 'required|string|min:10',
            'file_upload' => 'nullable|file|max:10240', // 10MB max
        ]);

        $cartItems = auth()->user()->cartItems()->with('service')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->service->min_price * $item->quantity;
        });

        // Handle Coupon
        $discountAmount = 0;
        $couponCode = $request->input('coupon_code');
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                if ($coupon->service_id) {
                    // Check if the specific service is in the cart
                    $matchingItems = $cartItems->filter(function ($item) use ($coupon) {
                        return $item->service_id == $coupon->service_id;
                    });
                    
                    if ($matchingItems->isNotEmpty()) {
                        $matchingTotal = $matchingItems->sum(function ($item) {
                            return $item->service->min_price * $item->quantity;
                        });
                        
                        if ($coupon->isValid($matchingTotal, $coupon->service_id)) {
                            $discountAmount = $coupon->calculateDiscount($matchingTotal, $coupon->service_id);
                            $total -= $discountAmount;
                            $coupon->increment('current_uses');
                        } else {
                            return back()->withInput()->with('error', 'Coupon code is invalid or does not meet the minimum amount for the specific service.');
                        }
                    } else {
                        return back()->withInput()->with('error', 'Coupon code "' . $couponCode . '" is only valid for the service: ' . ($coupon->service->name ?? 'selected service') . '.');
                    }
                } else {
                    // General coupon
                    if ($coupon->isValid($total)) {
                        $discountAmount = $coupon->calculateDiscount($total);
                        $total -= $discountAmount;
                        $coupon->increment('current_uses');
                    } else {
                        return back()->withInput()->with('error', 'Coupon code is invalid or does not meet the minimum amount.');
                    }
                }
            } else {
                return back()->withInput()->with('error', 'Invalid coupon code.');
            }
        }

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $filePath = $request->file('file_upload')->store('order-uploads', 'public');
        }

        // Resolve the referring partner:
        // Priority: 1) Active session ref_partner_id, 2) Cookie ref_partner_id, 3) User's permanent referred_by
        $referredByPartner = session('ref_partner_id')
            ?? request()->cookie('ref_partner_id')
            ?? auth()->user()->referred_by;

        // Make sure the partner ID actually belongs to an active partner
        if ($referredByPartner) {
            $partnerExists = \App\Models\User::where('id', $referredByPartner)
                ->whereIn('role', ['partner'])
                ->where('status', 'active')
                ->exists();
            if (!$partnerExists) {
                $referredByPartner = null;
            }
        }

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'service_id' => $cartItems->first()->service_id, // primary service
            'amount' => max(0, $total), // Ensure amount doesn't go below 0
            'status' => 'pending',
            'requirements' => $request->requirements,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
            'file_upload' => $filePath,
            'referred_by_partner' => $referredByPartner,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $item->service_id,
                'price' => $item->service->min_price,
                'quantity' => $item->quantity,
                'subtotal' => $item->service->min_price * $item->quantity,
            ]);
        }

        // Clear cart
        auth()->user()->cartItems()->delete();

        // Notify all admins about the new order
        User::where('role', 'admin')->each(fn($admin) =>
            $admin->notify(new NewOrderPlaced($order))
        );

        // Update user profile if new info provided
        $user = auth()->user();
        $defaultName = 'User ' . substr($user->phone, -4);
        if ($user->name === $defaultName && $request->customer_name && $request->customer_name !== $defaultName) {
            $user->update(['name' => $request->customer_name]);
        }
        if ($request->company_name && !$user->company_name) {
            $user->update(['company_name' => $request->company_name]);
        }
        if ($request->business_type && !$user->business_type) {
            $user->update(['business_type' => $request->business_type]);
        }

        return redirect()->route('payment.create', $order)
            ->with('success', 'Order placed! Please complete your payment.');
    }
}
