<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleSwitchController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->session()->get('portal_user', []);
        $availableRoles = $user['available_roles'] ?? [];

        $validated = $request->validate([
            'role' => ['required', 'string', Rule::in($availableRoles)],
        ]);

        $user['current_role'] = $validated['role'];

        $request->session()->put('portal_user', $user);

        return back()->with('success', 'Role berhasil diganti ke ' . strtoupper($validated['role']));
    }
}
