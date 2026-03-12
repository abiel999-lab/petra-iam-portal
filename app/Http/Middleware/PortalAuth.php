<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PortalAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kalau ada state logged out, tahan di halaman logged out
        if ($request->cookie('portal_logged_out') === '1') {
            return redirect()->route('logged.out');
        }

        // Kalau user forbidden, arahkan ke forbidden
        if (session()->has('portal_user_forbidden')) {
            return redirect()->route('sso.forbidden');
        }

        // Kalau tidak ada session user, lempar ke login
        if (! session()->has('portal_user')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
