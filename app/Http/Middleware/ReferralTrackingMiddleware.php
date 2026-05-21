<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\PartnerReferral;

class ReferralTrackingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('ref')) {
            $ref = $request->query('ref');

            $partner = User::where('role', 'partner')
                ->where('status', 'active')
                ->where(function($query) use ($ref) {
                    $query->where('id', $ref)
                          ->orWhere('referral_code', $ref);
                })
                ->first();

            if ($partner) {
                // Store in session
                session([
                    'ref_id' => $partner->id,
                    'ref_code' => $partner->referral_code,
                    'ref_partner_id' => $partner->id
                ]);

                // Track if they were referred to a specific service
                if ($request->is('services/*')) {
                    session(['ref_service_slug' => $request->segment(2)]);
                }

                // Track the click if not already tracked in this session
                $sessionKey = 'ref_tracked_' . $partner->id;
                if (!session()->has($sessionKey)) {
                    PartnerReferral::create([
                        'partner_id' => $partner->id,
                        'referral_code' => $partner->referral_code ?? '',
                        'ip_address' => $request->ip(),
                        'status' => 'clicked',
                    ]);
                    session([$sessionKey => true]);
                }

                // Queue cookies for 30 days
                Cookie::queue('ref_code', $partner->referral_code ?? '', 60 * 24 * 30);
                Cookie::queue('ref_partner_id', $partner->id, 60 * 24 * 30);
            }
        }

        return $next($request);
    }
}
