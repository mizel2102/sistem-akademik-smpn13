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

    public function test_notification_service_returns_notifications_collection(): void
    {
        $service = new NotificationService();

        $notifications = $service->getNotifications();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $notifications);
        $this->assertCount(0, $notifications);

        // With a user that has notifications
        $user = \App\Models\User::factory()->create();
        $user->notifications()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'type' => 'test_type',
            'data' => ['message' => 'test_data'],
        ]);

        $userNotifications = $service->getNotifications($user);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $userNotifications);
        $this->assertCount(1, $userNotifications);
        $this->assertSame('test_type', $userNotifications[0]->type);
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
