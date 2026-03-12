<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class KeycloakController extends Controller
{
    public function login()
    {
        return Socialite::driver('keycloak')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback(Request $request)
    {
        $socialUser = Socialite::driver('keycloak')->user();

        $raw = $socialUser->user ?? [];
        $groups = $this->normalizeGroups($raw['groups'] ?? []);
        $availableRoles = $this->extractRolesFromGroups($groups);
        $defaultRole = $this->pickDefaultRole($availableRoles);

        $portalUser = [
            'id' => $socialUser->getId(),
            'name' => $socialUser->getName() ?: ($raw['preferred_username'] ?? $socialUser->getNickname() ?? 'Unknown User'),
            'email' => $socialUser->getEmail() ?: ($raw['email'] ?? null),
            'nickname' => $socialUser->getNickname(),
            'avatar' => $socialUser->getAvatar(),
            'groups' => $groups,
            'available_roles' => $availableRoles,
            'current_role' => $defaultRole,
            'raw' => $raw,
            'access_token' => $socialUser->token ?? null,
            'refresh_token' => $socialUser->refreshToken ?? null,
            'id_token' => $socialUser->accessTokenResponseBody['id_token'] ?? null,
        ];

        // simpan dulu context logout, bahkan jika nanti ternyata forbidden
        $request->session()->put('portal_logout', [
            'name' => $portalUser['name'],
            'email' => $portalUser['email'],
            'id_token' => $portalUser['id_token'],
        ]);

        if (! in_array('app-web', $groups, true)) {
            $request->session()->forget('portal_user');
            return redirect()->route('sso.forbidden');
        }

        $request->session()->put('portal_user', $portalUser);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $logoutContext = $request->session()->get('portal_logout', []);
        $portalUser = $request->session()->get('portal_user', []);

        $idTokenHint = $portalUser['id_token']
            ?? $logoutContext['id_token']
            ?? null;

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectUri = config('app.url');

        if ($idTokenHint) {
            return redirect(
                Socialite::driver('keycloak')->getLogoutUrl(
                    $redirectUri,
                    config('services.keycloak.client_id'),
                    $idTokenHint
                )
            );
        }

        return redirect(
            Socialite::driver('keycloak')->getLogoutUrl(
                $redirectUri,
                config('services.keycloak.client_id')
            )
        );
    }

    private function normalizeGroups(array $groups): array
    {
        return collect($groups)
            ->map(function ($group) {
                $group = trim((string) $group);
                $group = trim($group, '/');
                return $group;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function extractRolesFromGroups(array $groups): array
    {
        return collect($groups)
            ->filter(fn ($group) => Str::startsWith($group, 'role-'))
            ->map(fn ($group) => Str::after($group, 'role-'))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function pickDefaultRole(array $availableRoles): string
    {
        foreach (['staff', 'admin', 'student', 'alumni', 'external', 'general'] as $role) {
            if (in_array($role, $availableRoles, true)) {
                return $role;
            }
        }

        return $availableRoles[0] ?? 'general';
    }
}
