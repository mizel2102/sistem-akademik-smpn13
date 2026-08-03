<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

uses(Tests\TestCase::class);

it('allows an authenticated user to update profile information and change password', function () {
    /** @var Tests\TestCase $this */
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed', ['--class' => 'RolePermissionSeeder']);

    /** @var User $user */
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    $user->assignRole('student');

    $response = $this->actingAs($user)
        ->put('/profile', [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

    $response->assertRedirect('/profile');
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name',
        'email' => 'new@example.com',
    ]);

    $response = $this->actingAs($user)
        ->put('/profile/password', [
            'current_password' => 'password',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

    $response->assertRedirect('/profile');
    $this->assertTrue(password_verify('new-password-123', $user->fresh()->password));
});
