<?php

namespace Tests\Unit;

use App\Services\NotificationService;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_service_returns_notifications_array(): void
    {
        $service = new NotificationService();

        $notifications = $service->getNotifications();

        $this->assertIsArray($notifications);
        $this->assertCount(3, $notifications);
        $this->assertSame('Jadwal Ujian Akhir', $notifications[0]['title']);
    }

    public function test_settings_service_returns_default_settings_when_session_is_empty(): void
    {
        $service = new SettingsService();

        $session = Session::driver('array');
        $settings = $service->getUserSettings($session);

        $this->assertSame('system', $settings['theme']);
        $this->assertTrue($settings['notifications']);
        $this->assertSame('id', $settings['language']);
    }

    public function test_settings_service_saves_validated_settings_to_session(): void
    {
        $service = new SettingsService();

        $session = Session::driver('array');
        $service->saveUserSettings($session, [
            'theme' => 'dark',
            'notifications' => true,
            'language' => 'en',
        ]);

        $this->assertSame('dark', $session->get('user_settings.theme'));
        $this->assertTrue($session->get('user_settings.notifications'));
        $this->assertSame('en', $session->get('user_settings.language'));
    }
}
