<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class SamlAuthController extends Controller
{
    private string $tenantUuid = '95ecb6fe-c677-4063-9451-0103c44bca28';

    public function login(Request $request)
    {
        $request->session()->forget('portal_user_forbidden');
        Session::forget('portal_user_forbidden');

        return redirect("/saml2/{$this->tenantUuid}/login");
    }

    public function reloginForce(Request $request)
    {
        $this->destroyPortalSessionOnly($request);

        return redirect("/saml2/{$this->tenantUuid}/login");
    }

    public function logout(Request $request)
    {
        $sessionCookie = config('session.cookie', 'laravel_session');
        $cookieDomain = config('session.domain');

        $this->destroyPortalSessionOnly($request);

        return redirect("/saml2/{$this->tenantUuid}/logout")
            ->withCookie(Cookie::forget($sessionCookie, '/', $cookieDomain))
            ->withCookie(Cookie::forget('XSRF-TOKEN', '/', $cookieDomain))
            ->withCookie(Cookie::forget('my-petra-session', '/', $cookieDomain));
    }

    private function destroyPortalSessionOnly(Request $request): void
    {
        $request->session()->forget([
            'portal_user',
            'portal_user_raw',
            'portal_user_forbidden',
        ]);

        Session::forget('portal_user');
        Session::forget('portal_user_raw');
        Session::forget('portal_user_forbidden');

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
