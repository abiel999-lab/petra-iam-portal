<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Slides\Saml2\Events\SignedIn;

class SamlSignedInListener
{
    public function handle(SignedIn $event): void
    {
        $messageId = $event->getAuth()->getLastMessageId();
        $user = $event->getSaml2User();

        $attributes = $user->getAttributes();

        Log::info('saml.attributes.raw', [
            'attributes' => $attributes,
        ]);

        $name = $this->firstAttr($attributes, [
            'name',
            'displayName',
            'full_name',
            'fullName',
            'first_name',
            'username',
        ]);

        $email = $this->firstAttr($attributes, [
            'email',
            'mail',
            'emailAddress',
        ]);

        $username = $this->firstAttr($attributes, [
            'username',
            'preferred_username',
            'uid',
            'UserName',
        ]);

        $picture = $this->firstAttr($attributes, [
            'picture',
            'avatar',
            'avatar_uri',
            'Avatar URI',
            'AvatarURI',
        ]);

        $groups = $this->normalizeGroups(
            $this->collectAttr($attributes, [
                'groups',
                'group',
                'memberOf',
                'Group',
            ])
        );

        Log::info('saml.groups.resolved', [
            'email' => $email,
            'username' => $username,
            'groups' => $groups,
        ]);

        $availableRoles = collect($groups)
            ->filter(fn ($g) => Str::startsWith($g, 'role-'))
            ->map(fn ($g) => Str::after($g, 'role-'))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $currentRole = $availableRoles[0] ?? 'general';

        $portalUser = [
            'message_id' => $messageId,
            'name' => $name ?: ($username ?: 'Unknown User'),
            'email' => $email,
            'username' => $username,
            'picture' => $picture,
            'groups' => $groups,
            'available_roles' => $availableRoles,
            'current_role' => $currentRole,
            'raw' => $attributes,
        ];

        session([
            'portal_user_raw' => $portalUser,
        ]);

        if (! in_array('app-web', $groups, true)) {
            session([
                'portal_user_forbidden' => $portalUser,
            ]);

            session()->forget('portal_user');

            Log::warning('saml.login.forbidden', [
                'email' => $email,
                'username' => $username,
                'groups' => $groups,
            ]);

            return;
        }

        session()->forget('portal_user_forbidden');

        session([
            'portal_user' => $portalUser,
        ]);

        Log::info('saml.login.allowed', [
            'email' => $email,
            'username' => $username,
            'groups' => $groups,
        ]);
    }

    private function firstAttr(array $attributes, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (isset($attributes[$key]) && is_array($attributes[$key]) && isset($attributes[$key][0])) {
                $value = trim((string) $attributes[$key][0]);
                if ($value !== '') {
                    return $value;
                }
            }
        }

        return null;
    }

    private function collectAttr(array $attributes, array $keys): array
    {
        foreach ($keys as $key) {
            if (isset($attributes[$key]) && is_array($attributes[$key])) {
                return $attributes[$key];
            }
        }

        return [];
    }

    private function normalizeGroups(array $groups): array
    {
        return collect($groups)
            ->map(fn ($g) => trim((string) $g))
            ->map(fn ($g) => trim($g, '/'))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
