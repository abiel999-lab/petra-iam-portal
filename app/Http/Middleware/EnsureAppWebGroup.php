<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAppWebGroup
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->session()->get('portal_user', []);
        $groups = $user['groups'] ?? [];

        if (! in_array('app-web', $groups, true)) {
            $request->session()->put('portal_user_forbidden', $user);
            $request->session()->forget('portal_user');

            return redirect()->route('sso.forbidden');
        }

        return $next($request);
    }
}
