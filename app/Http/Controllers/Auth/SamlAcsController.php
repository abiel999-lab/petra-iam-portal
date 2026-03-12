<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SamlAcsController extends Controller
{
    public function __invoke(Request $request)
    {
        if (session()->has('portal_user')) {
            return redirect()->route('dashboard');
        }

        if (session()->has('portal_user_forbidden')) {
            return redirect()->route('sso.forbidden');
        }

        return redirect()->route('login');
    }
}
