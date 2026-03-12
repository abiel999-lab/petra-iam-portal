<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('portal_user', []);
        $sessionInfo = $this->detectClient($request->userAgent() ?? '');

        return view('setting', [
            'user' => $user,
            'currentRole' => $user['current_role'] ?? 'general',
            'availableRoles' => $user['available_roles'] ?? ['general'],
            'sessionRows' => [
                [
                    'ip' => $request->ip(),
                    'device' => $sessionInfo['device'],
                    'os' => $sessionInfo['os'],
                    'browser' => $sessionInfo['browser'],
                ],
            ],
        ]);
    }

    private function detectClient(string $ua): array
    {
        $lower = strtolower($ua);

        $device = str_contains($lower, 'mobile') ? 'Mobile' : 'Desktop';

        $os = 'Unknown';
        if (str_contains($lower, 'windows')) {
            $os = 'Windows';
        } elseif (str_contains($lower, 'mac os') || str_contains($lower, 'macintosh')) {
            $os = 'macOS';
        } elseif (str_contains($lower, 'android')) {
            $os = 'Android';
        } elseif (str_contains($lower, 'iphone') || str_contains($lower, 'ipad') || str_contains($lower, 'ios')) {
            $os = 'iOS';
        } elseif (str_contains($lower, 'linux')) {
            $os = 'Linux';
        }

        $browser = 'Unknown';
        if (str_contains($lower, 'edg/')) {
            $browser = 'Edge';
        } elseif (str_contains($lower, 'opr/') || str_contains($lower, 'opera')) {
            $browser = 'Opera';
        } elseif (str_contains($lower, 'chrome/')) {
            $browser = 'Chrome';
        } elseif (str_contains($lower, 'firefox/')) {
            $browser = 'Firefox';
        } elseif (str_contains($lower, 'safari/') && ! str_contains($lower, 'chrome/')) {
            $browser = 'Safari';
        }

        return [
            'device' => $device,
            'os' => $os,
            'browser' => $browser,
        ];
    }
}
