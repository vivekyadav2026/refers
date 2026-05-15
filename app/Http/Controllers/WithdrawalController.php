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
            'status' => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request submitted successfully.');
    }
}
