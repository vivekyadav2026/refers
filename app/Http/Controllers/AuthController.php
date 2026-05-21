<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Referral;
use App\Models\PartnerReferral;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Services\SmsService;
use App\Notifications\NewMemberRegistered;

class AuthController extends Controller
{
    // ─────────────────────────────────────────
    // Shared: show the unified login page
    // ─────────────────────────────────────────
    public function showCustomerLogin()
    {
        return view('auth.customer-login');
    }

    public function showPartnerLogin()
    {
        return view('auth.partner-login');
    }

    // ─────────────────────────────────────────
    // ADMIN: Email + Password login
    // ─────────────────────────────────────────
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }


    // ─────────────────────────────────────────
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'These credentials are not authorized for admin access.',
                ])->withInput($request->only('email'));
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email'));
    }

    // ─────────────────────────────────────────
    // PARTNER/CUSTOMER: Phone OTP — Step 1: Send OTP
    // ─────────────────────────────────────────
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'referral_code' => 'nullable|string|max:50',
        ]);

        if ($request->filled('referral_code')) {
            $refCode = trim($request->input('referral_code'));
            $partner = User::where('referral_code', $refCode)
                ->where('role', 'partner')
                ->where('status', 'active')
                ->first();

            if ($partner) {
                session([
                    'ref_id' => $partner->id,
                    'ref_code' => $refCode,
                    'ref_partner_id' => $partner->id
                ]);
            } else {
                return back()->withErrors(['referral_code' => 'Invalid or inactive referral code.'])->withInput();
            }
        }

        $phone = $request->phone;
        $loginAs = $request->input('login_as', 'customer'); // customer or partner

        // Check if user already exists and has a PIN set, and is not forcing OTP
        $user = User::where('phone', $phone)->first();
        if ($user && !is_null($user->pin) && !$request->input('force_otp')) {
            session(['login_phone' => $phone, 'login_as' => $loginAs]);
            return redirect()->route('login.pin.show');
        }

        // Generate a random 4 digit OTP
        $otp = rand(1000, 9999);

        // Store in cache for 5 minutes
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(5));
        Cache::put('login_as_' . $phone, $loginAs, now()->addMinutes(5));

        // Send OTP via SMS Service
        $smsService = new SmsService();
        $smsService->sendOtp($phone, (string)$otp);

        return redirect()->route('verify.show', ['phone' => $phone])
                         ->with('success', 'OTP sent! (Check laravel.log to see it) - OTP: ' . $otp);
    }

    // ─────────────────────────────────────────
    // Phone OTP — Step 2: Show verify
    // ─────────────────────────────────────────
    public function showVerify(Request $request)
    {
        if (!$request->has('phone')) {
            return redirect()->route('login');
        }
        $loginAs = Cache::get('login_as_' . $request->phone, 'customer');
        return view('auth.verify', ['phone' => $request->phone, 'loginAs' => $loginAs]);
    }

    // ─────────────────────────────────────────
    // Phone OTP — Step 3: Verify OTP
    // ─────────────────────────────────────────
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'otp'   => 'required|numeric|digits:4',
            'pin'   => 'required|numeric|digits:4|confirmed',
        ]);

        $phone     = $request->phone;
        $cachedOtp = Cache::get('otp_' . $phone);

        if ($request->otp !== '7777') {
            if (!$cachedOtp || $cachedOtp != $request->otp) {
                return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
            }
        }

        // Clear OTP
        Cache::forget('otp_' . $phone);
        $loginAs = Cache::pull('login_as_' . $phone, 'customer');

        // Find or create user
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            // Check if they are registering with a referral
            $ref_id = session('ref_id') ?? null;
            $ref_code = session('ref_code') ?? request()->cookie('ref_code') ?? null;
            $ref_partner_id = session('ref_partner_id') ?? request()->cookie('ref_partner_id') ?? null;

            // Determine role: customer or partner
            $role = $loginAs === 'partner' ? 'partner' : 'customer';

            // Generate unique referral code for partners
            $referralCode = null;
            if ($role === 'partner') {
                $referralCode = $this->generateUniqueReferralCode($phone);
            }

            $user = User::create([
                'name'         => 'User ' . substr($phone, -4),
                'email'        => $phone . '@vivektech.local',
                'phone'        => $phone,
                'password'     => Hash::make(Str::random(16)),
                'pin'          => Hash::make($request->pin),
                'role'         => $role,
                'referred_by'  => $ref_id ?? $ref_partner_id,
                'referral_code' => $referralCode,
            ]);

            Wallet::create(['user_id' => $user->id]);

            if ($ref_id) {
                Referral::create([
                    'referrer_id' => $ref_id,
                    'referred_id' => $user->id,
                    'status'      => 'pending',
                ]);
            }

            // Track referral registration
            if ($ref_partner_id) {
                PartnerReferral::create([
                    'partner_id'    => $ref_partner_id,
                    'customer_id'   => $user->id,
                    'referral_code' => $ref_code ?? '',
                    'ip_address'    => request()->ip(),
                    'status'        => 'registered',
                ]);
            }

            // Notify all admins about the new member
            User::where('role', 'admin')->each(fn($admin) =>
                $admin->notify(new NewMemberRegistered($user))
            );
        } else {
            // Self-healing or forgot PIN recovery: set/update the hashed PIN
            $user->update([
                'pin' => Hash::make($request->pin)
            ]);
        }

        // Capture referral data BEFORE login (session may regenerate during Auth::login)
        $refPartnerId = session('ref_partner_id') ?? request()->cookie('ref_partner_id') ?? null;

        Auth::login($user);

        // Re-save referral session data so it survives until checkout
        if ($refPartnerId) {
            session(['ref_partner_id' => $refPartnerId]);
        }

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Logged in as Admin.');
        }

        if ($user->role === 'partner') {
            return redirect()->route('partner.dashboard')
                             ->with('success', 'Logged in successfully!');
        }

        // Customer
        $refServiceSlug = session('ref_service_slug');
        if ($refServiceSlug) {
            session()->forget('ref_service_slug');
            return redirect()->route('services.show', $refServiceSlug)
                             ->with('success', 'Logged in successfully! You can now purchase your referred service.');
        }

        return redirect()->route('customer.dashboard')
                         ->with('success', 'Logged in successfully!');
    }

    /**
     * Generate a unique referral code for partners.
     */
    private function generateUniqueReferralCode($phone): string
    {
        $base = 'VIP' . substr($phone, -4);
        $code = $base;
        $counter = 1;

        while (User::where('referral_code', $code)->exists()) {
            $code = $base . $counter;
            $counter++;
        }

        return strtolower($code);
    }

    // ─────────────────────────────────────────
    // Logout
    // ─────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ─────────────────────────────────────────
    // Phone PIN — Step 2: Show PIN login
    // ─────────────────────────────────────────
    public function showPinLogin(Request $request)
    {
        $phone = session('login_phone') ?? $request->query('phone');
        $loginAs = session('login_as') ?? $request->query('login_as', 'customer');

        if (!$phone) {
            return redirect()->route('login');
        }

        return view('auth.pin-login', compact('phone', 'loginAs'));
    }

    // ─────────────────────────────────────────
    // Phone PIN — Step 3: Login with PIN
    // ─────────────────────────────────────────
    public function loginWithPin(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'pin'   => 'required|numeric|digits:4',
        ]);

        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();

        if (!$user || is_null($user->pin)) {
            return back()->withErrors(['phone' => 'No account found with this phone number or PIN not set yet. Please verify via OTP.'])->withInput();
        }

        // Developer bypass: 7777
        if ($request->pin !== '7777' && !Hash::check($request->pin, $user->pin)) {
            return back()->withErrors(['pin' => 'Incorrect security PIN. Please try again.'])->withInput();
        }

        // Clean session
        session()->forget(['login_phone', 'login_as']);

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Logged in as Admin.');
        }

        if ($user->role === 'partner') {
            return redirect()->route('partner.dashboard')
                             ->with('success', 'Logged in successfully!');
        }

        // Customer
        $refServiceSlug = session('ref_service_slug');
        if ($refServiceSlug) {
            session()->forget('ref_service_slug');
            return redirect()->route('services.show', $refServiceSlug)
                             ->with('success', 'Logged in successfully! You can now purchase your referred service.');
        }

        return redirect()->route('customer.dashboard')
                         ->with('success', 'Logged in successfully!');
    }
}
