<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentOutlet
{
    /**
     * Handle an incoming request.
     * Switch current outlet if requested via query parameter or route.
     *
     * Usage:
     * - /dashboard?switch_outlet=5 - Switch to outlet ID 5
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Check if user wants to switch outlet
        $switchOutletId = $request->query('switch_outlet') ?? $request->route('switch_outlet');

        if ($switchOutletId) {
            // Verify user has access to this outlet
            $outlet = $user->outlets()->where('outlet_id', $switchOutletId)->first();

            if ($outlet) {
                session(['current_outlet_id' => (int) $switchOutletId]);

                // Redirect without the query parameter
                $redirectUrl = $request->url();
                $queryParams = $request->except('switch_outlet');
                if (!empty($queryParams)) {
                    $redirectUrl .= '?' . http_build_query($queryParams);
                }

                return redirect($redirectUrl)->with('success', 'Outlet berhasil diganti ke: ' . $outlet->name);
            }
        }

        return $next($request);
    }
}
