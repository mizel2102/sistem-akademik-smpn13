<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_notifications_page(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('notifications.index'));

        $response->assertOk();
        $response->assertViewIs('notifications.index');
        $response->assertSee('Tidak ada notifikasi saat ini');
    }

    public function test_guest_is_redirected_from_notifications_page(): void
    {
        $response = $this->get(route('notifications.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_settings_page(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.index'));

        $response->assertOk();
        $response->assertViewIs('settings.index');
        $response->assertViewHas('settings');
    }

    public function test_authenticated_user_can_update_settings(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('settings.update'), [
            'theme' => 'dark',
            'notifications' => true,
            'language' => 'en',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Pengaturan berhasil disimpan.');
        $this->assertTrue(session('user_settings')['notifications']);
        $this->assertSame('dark', session('user_settings')['theme']);
        $this->assertSame('en', session('user_settings')['language']);
    }

    public function test_settings_update_fails_with_invalid_language(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->from(route('settings.index'))->put(route('settings.update'), [
            'theme' => 'light',
            'notifications' => true,
            'language' => 'fr',
        ]);

        $response->assertRedirect(route('settings.index'));
        $response->assertSessionHasErrors(['language']);
    }
}
