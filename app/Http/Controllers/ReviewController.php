<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'completed') {
            return back()->with('error', 'You can only review completed orders.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['order_id' => $order->id, 'user_id' => auth()->id()],
            [
                'service_id' => $order->service_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Thank you for your feedback!');
    }
}
