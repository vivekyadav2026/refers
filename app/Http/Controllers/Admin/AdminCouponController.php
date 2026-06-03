<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('service')->latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $services = \App\Models\Service::where('is_active', true)->orderBy('name')->get();
        return view('admin.coupons.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['service_id'] = $request->filled('service_id') ? $request->service_id : null;
        $data['expires_at'] = $request->filled('expires_at') ? $request->expires_at : null;
        $data['min_order_amount'] = $request->filled('min_order_amount') ? $request->min_order_amount : null;
        $data['max_uses'] = $request->filled('max_uses') ? $request->max_uses : null;
        
        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        $services = \App\Models\Service::where('is_active', true)->orderBy('name')->get();
        return view('admin.coupons.edit', compact('coupon', 'services'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['service_id'] = $request->filled('service_id') ? $request->service_id : null;
        $data['expires_at'] = $request->filled('expires_at') ? $request->expires_at : null;
        $data['min_order_amount'] = $request->filled('min_order_amount') ? $request->min_order_amount : null;
        $data['max_uses'] = $request->filled('max_uses') ? $request->max_uses : null;
        
        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
