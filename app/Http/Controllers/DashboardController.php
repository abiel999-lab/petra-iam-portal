<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('portal_user', []);

        $sections = [
            [
                'title' => 'Default',
                'items' => [
                    ['name' => 'GATE', 'url' => 'https://my.petra.ac.id', 'icon' => 'fas fa-torii-gate'],
                ],
            ],
            [
                'title' => 'Lainnya',
                'items' => [
                    ['name' => 'Event Website', 'url' => '#', 'icon' => 'fas fa-calendar'],
                    ['name' => 'Konseling', 'url' => '#', 'icon' => 'fas fa-user-friends'],
                ],
            ],
            [
                'title' => 'Akademik',
                'items' => [
                    ['name' => 'LEAP-MBKM', 'url' => '#', 'icon' => 'fas fa-graduation-cap'],
                ],
            ],
            [
                'title' => 'Link',
                'items' => [
                    ['name' => 'Shortener', 'url' => '#', 'icon' => 'fas fa-link'],
                    ['name' => 'Activate Security', 'url' => route('setting'), 'icon' => 'fas fa-shield-alt'],
                    ['name' => 'Support', 'url' => '#', 'icon' => 'fas fa-life-ring'],
                ],
            ],
            [
                'title' => 'Apps',
                'items' => [
                    ['name' => 'HSEP', 'url' => '#', 'icon' => 'fas fa-cubes'],
                ],
            ],
        ];

        return view('dashboard', [
            'user' => $user,
            'sections' => $sections,
            'currentRole' => $user['current_role'] ?? 'general',
            'availableRoles' => $user['available_roles'] ?? ['general'],
            'showMfaReminder' => false,
        ]);
    }
}
