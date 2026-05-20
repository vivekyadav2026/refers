<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PartnerReferral;

class ReferralController extends Controller
{
    /**
     * Handle referral link click: /ref/{code}
     * Sets a session/cookie and redirects to homepage or services.
     */
    public function handleReferral($code)
    {
        $partner = User::where('referral_code', $code)
            ->where('role', 'partner')
            ->where('status', 'active')
            ->first();

        if (!$partner) {
            return redirect('/')->with('error', 'Invalid referral link.');
        }

        // Store referral in session and cookie (30 day cookie)
        session(['ref_id' => $partner->id, 'ref_code' => $code, 'ref_partner_id' => $partner->id]);

        // Track the click
        PartnerReferral::create([
            'partner_id' => $partner->id,
            'referral_code' => $code,
            'ip_address' => request()->ip(),
            'status' => 'clicked',
        ]);

        return redirect('/')
            ->cookie('ref_code', $code, 60 * 24 * 30) // 30 days
            ->cookie('ref_partner_id', $partner->id, 60 * 24 * 30);
    }
}
