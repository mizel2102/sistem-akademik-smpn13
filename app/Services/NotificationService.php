<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NotificationService
{
    public function getNotifications(?User $user = null): Collection
    {
        return $user?->notifications()->latest()->get() ?? collect();
    }

    public function sendToGuruBK(string $type, array $data): void
    {
        User::role('guru-bk')->each(function (User $user) use ($type, $data): void {
            $user->notifications()->create([
                'id' => (string) Str::uuid(),
                'type' => $type,
                'data' => $data,
            ]);
        });
    }
}
