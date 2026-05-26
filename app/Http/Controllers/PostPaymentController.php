<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\PostPaymentDetail;
use Illuminate\Support\Facades\Storage;

class PostPaymentController extends Controller
{
    public function create(Order $order)
    {
        // Ensure this user owns the order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // If they already submitted, redirect to order details
        if ($order->postPaymentDetail) {
            return redirect()->route('orders.show', $order)->with('info', 'You have already submitted details for this order.');
        }

        // We load a unified blade that dynamically shows questions based on service type.
        // The service name is usually saved in the order or its items.
        // If order->service is set, we use that. Otherwise default to a generic name.
        $serviceName = $order->service ? $order->service->name : 'General Service';

        return view('customer.post-payment.form', compact('order', 'serviceName'));
    }

    public function store(Request $request, Order $order)
    {
        // Ensure ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Prevent double submission
        if ($order->postPaymentDetail) {
            return back()->with('error', 'Details already submitted.');
        }

        // Exclude CSRF, files, and standard laravel inputs from JSON data
        $data = $request->except(['_token', 'images', 'documents', 'service_name']);
        
        $uploadedFiles = [];

        // Handle multiple image/file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('post_payments/images', 'public');
                $uploadedFiles[] = [
                    'type' => 'image',
                    'path' => $path,
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName()
                ];
            }
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('post_payments/documents', 'public');
                $uploadedFiles[] = [
                    'type' => 'document',
                    'path' => $path,
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName()
                ];
            }
        }

        PostPaymentDetail::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'service_name' => $request->input('service_name', 'General Service'),
            'data' => $data,
            'uploaded_files' => $uploadedFiles,
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Thank you! Your project details have been successfully submitted to our team.');
    }
}
