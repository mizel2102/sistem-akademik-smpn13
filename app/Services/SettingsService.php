<?php

namespace App\Services;

use Illuminate\Contracts\Session\Session;

class SettingsService
{
    public function getUserSettings(Session $session): array
    {
        return $session->get('user_settings', [
            'theme' => 'system',
            'notifications' => true,
            'language' => 'id',
        ]);
    }

    public function saveUserSettings(Session $session, array $validated): void
    {
        $session->put('user_settings', [
            'theme' => $validated['theme'],
            'notifications' => $validated['notifications'] ?? false,
            'language' => $validated['language'],
        ]);
    }
}
