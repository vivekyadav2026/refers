<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PartnerOnboardingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user || $user->role !== 'partner') {
            return redirect()->route('login');
        }

        $step1Complete = !empty($user->company_name);
        $step2Complete = $user->kyc_status !== 'unsubmitted';
        $step3Complete = $user->kyc_status === 'approved';
        $isUnlocked = $step1Complete && $step3Complete;

        return view('partner.apply', compact('user', 'step1Complete', 'step2Complete', 'step3Complete', 'isUnlocked'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
        ]);

        return redirect()->route('partner.apply')->with('success', 'Step 1: Partner Application submitted successfully! Please complete your KYC verification next.');
    }
}
