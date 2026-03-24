<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SsoController extends Controller
{
    public function forbidden(Request $request)
    {
        if (! session()->has('portal_user_forbidden')) {
            return redirect()->route('home');
        }

        return response()->view('auth.forbidden', [
            'user' => session('portal_user_forbidden'),
        ], 403);
    }
}
