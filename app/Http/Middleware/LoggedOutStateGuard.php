<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoggedOutStateGuard
{
    public function handle(Request $request, Closure $next): Response
    {
        $cookie = $request->cookie('portal_logged_out');

        $allowedRoutes = [
            'logged.out',
            'session.start',
            'logout',
        ];

        if ($cookie === '1' && ! $request->routeIs($allowedRoutes)) {
            return redirect()->route('logged.out');
        }

        return $next($request);
    }
}
