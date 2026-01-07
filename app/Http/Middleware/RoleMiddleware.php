<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user has one of the specified roles at current outlet.
     *
     * Usage in routes:
     * - Route::middleware('role:owner') - Only owners
     * - Route::middleware('role:owner,manager') - Owners or managers
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Get current outlet from session
        $currentOutletId = session('current_outlet_id');

        if (!$currentOutletId) {
            // Fallback to user's default outlet
            $outlet = $user->defaultOutlet();
            if ($outlet) {
                session(['current_outlet_id' => $outlet->id]);
                $currentOutletId = $outlet->id;
            }
        }

        if (!$currentOutletId) {
            abort(403, 'No outlet assigned to user.');
        }

        // Get user's role at current outlet
        $pivot = $user->outlets()->where('outlet_id', $currentOutletId)->first();

        if (!$pivot) {
            abort(403, 'User does not have access to this outlet.');
        }

        $userRole = $pivot->pivot->role;

        // Check if user's role is in allowed roles
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized. Required role: ' . implode(' or ', $roles));
        }

        return $next($request);
    }
}
