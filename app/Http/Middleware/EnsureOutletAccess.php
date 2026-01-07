<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOutletAccess
{
    /**
     * Handle an incoming request.
     * Ensure user has access to at least one outlet and set current outlet in session.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user belongs to a company
        if (!$user->company_id) {
            abort(403, 'User is not associated with any company.');
        }

        // Check if user has access to any outlet
        if ($user->outlets()->count() === 0) {
            abort(403, 'User does not have access to any outlet.');
        }

        // Set current outlet if not set
        if (!session()->has('current_outlet_id')) {
            $defaultOutlet = $user->defaultOutlet();
            if ($defaultOutlet) {
                session(['current_outlet_id' => $defaultOutlet->id]);
            }
        }

        // Verify user still has access to current outlet
        $currentOutletId = session('current_outlet_id');
        if ($currentOutletId && !$user->outlets()->where('outlet_id', $currentOutletId)->exists()) {
            // Reset to default outlet if access was revoked
            $defaultOutlet = $user->defaultOutlet();
            if ($defaultOutlet) {
                session(['current_outlet_id' => $defaultOutlet->id]);
            } else {
                abort(403, 'User does not have access to any outlet.');
            }
        }

        // Share current outlet with all views
        $currentOutlet = \App\Models\Outlet::find(session('current_outlet_id'));
        view()->share('currentOutlet', $currentOutlet);
        view()->share('userOutlets', $user->outlets);

        return $next($request);
    }
}
