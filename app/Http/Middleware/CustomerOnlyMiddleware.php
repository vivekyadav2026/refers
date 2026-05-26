<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerOnlyMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows customers through; redirects admins/partners away.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('customer')->user();

        if ($user && !$user->isCustomer()) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Only customers can access the shopping cart.');
            }
            return redirect()->route('partner.dashboard')
                ->with('error', 'Only customers can access the shopping cart.');
        }

        return $next($request);
    }
}
