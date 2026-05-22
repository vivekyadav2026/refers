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
            'phone' => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'address_house' => 'required|string|max:255',
            'address_street' => 'required|string|max:255',
            'address_city' => 'required|string|max:255',
            'address_state' => 'required|string|max:255',
            'address_pin' => 'required|string|max:20',
            'address_country' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alternate_phone' => $request->alternate_phone,
            'gender' => $request->gender,
            'address_house' => $request->address_house,
            'address_street' => $request->address_street,
            'address_city' => $request->address_city,
            'address_state' => $request->address_state,
            'address_pin' => $request->address_pin,
            'address_country' => $request->address_country,
            // 'company_name' and 'business_type' are removed as per request
            'company_name' => 'Individual Partner', // provide a default since it was required before for step 1 completion check
            'business_type' => 'Individual',
        ]);

        return redirect()->route('partner.apply')->with('success', 'Step 1: Partner Application submitted successfully! Please complete your KYC verification next.');
    }
}
