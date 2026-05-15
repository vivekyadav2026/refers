<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Referral;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ─────────────────────────────────────────
    // Shared: show the unified login page
    // ─────────────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    // ─────────────────────────────────────────
    // ADMIN: Email + Password login
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
    // PARTNER: Phone OTP — Step 1: Send OTP
    // ─────────────────────────────────────────
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
        ]);

        $phone = $request->phone;

        // Generate a random 4 digit OTP
        $otp = rand(1000, 9999);

        // Store in cache for 5 minutes
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(5));

        // In a real app, send this via SMS gateway. Here we mock it by logging.
        Log::info("MOCK SMS: Your SK Solutions OTP is {$otp} for phone {$phone}");

        return redirect()->route('verify.show', ['phone' => $phone])
                         ->with('success', 'OTP sent! (Check laravel.log to see it)');
    }

    // ─────────────────────────────────────────
    // PARTNER: Phone OTP — Step 2: Show verify
    // ─────────────────────────────────────────
    public function showVerify(Request $request)
    {
        if (!$request->has('phone')) {
            return redirect()->route('login');
        }
        return view('auth.verify', ['phone' => $request->phone]);
    }

    // ─────────────────────────────────────────
    // PARTNER: Phone OTP — Step 3: Verify OTP
    // ─────────────────────────────────────────
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'otp'   => 'required|numeric|digits:4',
        ]);

        $phone     = $request->phone;
        $cachedOtp = Cache::get('otp_' . $phone);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Clear OTP
        Cache::forget('otp_' . $phone);

        // Find or create user
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            // Check if they are registering with a referral
            $ref_id = session('ref_id');

            $user = User::create([
                'name'       => 'User ' . substr($phone, -4),
                'email'      => $phone . '@sksolutions.local',
                'phone'      => $phone,
                'password'   => Hash::make(Str::random(16)),
                'role'       => 'partner',
                'referred_by' => $ref_id,
            ]);

            Wallet::create(['user_id' => $user->id]);

            if ($ref_id) {
                Referral::create([
                    'referrer_id' => $ref_id,
                    'referred_id' => $user->id,
                    'status'      => 'pending',
                ]);
            }
        }

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Logged in as Admin.');
        }

        return redirect()->route('partner.dashboard')
                         ->with('success', 'Logged in successfully!');
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
}
