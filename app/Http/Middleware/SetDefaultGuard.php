<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDefaultGuard
{
    /**
     * Handle an incoming request.
     * Sets the default auth guard based on the requested URL prefix, 
     * resolving conflicts when a user is logged into multiple panels on the same browser.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $referer = $request->headers->get('referer', '');

        $isAdminPath = $request->is('admin*') || str_contains($referer, '/admin');
        $isPartnerPath = $request->is('partner*') || str_contains($referer, '/partner');
        $isCustomerPath = $request->is('customer*') || $request->is('cart*') || $request->is('checkout*') || str_contains($referer, '/customer');

        $isAdmin = $isAdminPath && auth('admin')->check();
        $isPartner = $isPartnerPath && auth('partner')->check();
        $isCustomer = $isCustomerPath && auth('customer')->check();

        if ($isAdmin) {
            app('auth')->shouldUse('admin');
        } elseif ($isPartner) {
            app('auth')->shouldUse('partner');
        } elseif ($isCustomer) {
            app('auth')->shouldUse('customer');
        } else {
            // For public pages (home, services, etc.), prioritize Customer -> Partner -> Admin
            if (auth('customer')->check()) {
                app('auth')->shouldUse('customer');
            } elseif (auth('partner')->check()) {
                app('auth')->shouldUse('partner');
            } elseif (auth('admin')->check()) {
                app('auth')->shouldUse('admin');
            }
        }

        return $next($request);
    }
}
