<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login')
                ->with('error', 'No tienes permiso para acceder a esa página.');
        }

        if ($user->role->type !== $role) {
            return redirect()->route($user->role->type . '.dashboard')
                ->with('error', 'No tienes permiso para acceder a esa página.');
        }

        return $next($request);
    }
}
