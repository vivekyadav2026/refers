<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // Load settings to pass to the view
        $settings = [
            'default_commission' => Setting::get_val('default_commission', 30),
            'referral_override' => Setting::get_val('referral_override', 5),
            'min_withdrawal' => Setting::get_val('min_withdrawal', 100),
            'clearance_period' => Setting::get_val('clearance_period', 5),
            'require_kyc' => Setting::get_val('require_kyc', 1),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'default_commission' => 'required|numeric|min:0|max:100',
            'referral_override' => 'required|numeric|min:0|max:100',
            'min_withdrawal' => 'required|numeric|min:0',
            'clearance_period' => 'required|numeric|min:0',
        ]);

        Setting::set_val('default_commission', $request->default_commission);
        Setting::set_val('referral_override', $request->referral_override);
        Setting::set_val('min_withdrawal', $request->min_withdrawal);
        Setting::set_val('clearance_period', $request->clearance_period);
        Setting::set_val('require_kyc', $request->has('require_kyc') ? 1 : 0);

        return redirect()->back()->with('success', 'Global settings updated successfully.');
    }
}
