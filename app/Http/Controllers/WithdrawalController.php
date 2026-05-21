<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\Wallet;

class WithdrawalController extends Controller
{
    public function index()
    {
        $wallet = auth()->user()->wallet ?? Wallet::firstOrCreate(['user_id' => auth()->id()], ['balance' => 0, 'pending_balance' => 0]);
        $withdrawals = auth()->user()->withdrawals()->latest()->paginate(10);
        
        return view('withdrawals.index', compact('withdrawals', 'wallet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|in:upi,bank',
            'payment_details' => 'required|string',
        ]);

        $wallet = auth()->user()->wallet;
        if (!$wallet || $wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        // Deduct from balance
        $wallet->decrement('balance', $request->amount);

        // Create withdrawal request
        Withdrawal::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_details' => $request->payment_details,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request submitted successfully.');
    }
}
