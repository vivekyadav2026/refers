<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\BusinessDetail;
use Illuminate\Support\Facades\Storage;

class BusinessDetailController extends Controller
{
    public function create(Order $order)
    {
        // Check if user is authorized to view this order
        if ($order->user_id !== auth()->id() && !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403);
        }

        // If business details already exist, maybe redirect back with a message
        // Or we could let them view/edit it. For now, if exists, just redirect to order detail.
        if ($order->businessDetail) {
            return redirect()->route('customer.order.show', $order)->with('info', 'Business details have already been submitted.');
        }

        return view('customer.business-details.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        // Check if user is authorized to view this order
        if ($order->user_id !== auth()->id() && !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403);
        }

        if ($order->businessDetail) {
            return redirect()->route('customer.order.show', $order)->with('info', 'Business details already submitted.');
        }

        $request->validate([
            'business_name' => 'required|string|max:255',
            'domain_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048', // max 2MB
            'product_images' => 'nullable|array|max:10',
            'product_images.*' => 'image|max:5120', // max 5MB per image
            'support_phone' => 'nullable|string|max:20',
            'support_email' => 'nullable|email|max:255',
            'office_address' => 'nullable|string',
        ]);

        $data = $request->only([
            'business_name', 'domain_name', 'support_phone', 'support_email', 'office_address'
        ]);
        $data['order_id'] = $order->id;

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('business_logos', 'public');
        }

        if ($request->hasFile('product_images')) {
            $images = [];
            foreach ($request->file('product_images') as $file) {
                $images[] = $file->store('product_images', 'public');
            }
            $data['product_images'] = $images;
        }

        BusinessDetail::create($data);

        return redirect()->route('customer.order.show', $order)->with('success', 'Business details submitted successfully! We will begin your project shortly.');
    }
}
