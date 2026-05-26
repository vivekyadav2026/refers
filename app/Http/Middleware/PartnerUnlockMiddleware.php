<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerUnlockMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('partner')->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Admin and Superadmin bypass lock
        if (in_array($user->role, ['admin', 'superadmin'])) {
            return $next($request);
        }

        if ($user->role !== 'partner') {
            return redirect()->route('customer.dashboard');
        }

        // If partner has not filled company_name or kyc_status is not approved, lock access
        if (empty($user->company_name) || $user->kyc_status !== 'approved') {
            return redirect()->route('partner.apply');
        }

        return $next($request);
    }
}
