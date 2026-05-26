<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * EnsureRole Middleware
 *
 * Restricts route access to users with a specific role.
 * Accepts one or more roles as comma-separated parameters.
 *
 * Registration in bootstrap/app.php:
 *   ->withMiddleware(function (Middleware $middleware) {
 *       $middleware->alias(['role' => \App\Http\Middleware\EnsureRole::class]);
 *   })
 *
 * Usage in routes/web.php:
 *   ->middleware('role:freelancer')
 *   ->middleware('role:admin')
 *   ->middleware('role:admin,freelancer')  // multiple allowed roles
 */
class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     * @param  string  ...$roles  One or more allowed role names
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Guard: user must be authenticated first
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Guard: user account must be active (not suspended by admin)
        if (! $request->user()->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan oleh administrator. Hubungi support untuk informasi lebih lanjut.']);
        }

        // Check if the user's role is in the allowed list
        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
