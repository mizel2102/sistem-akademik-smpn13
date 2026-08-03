<?php

namespace App\Listeners;

use App\Events\AlphaThresholdReached;
use App\Services\NotificationService;

class NotifyGuruBK
{
    public function __construct(
        private NotificationService $notificationService,
    ) {
    }

    public function handle(AlphaThresholdReached $event): void
    {
        $this->notificationService->sendToGuruBK('alpha_warning', [
            'title' => 'Siswa Melebihi Ambang Alpha',
            'message' => "Siswa {$event->student->user?->name} telah mencapai {$event->alphaCount} kali alpha.",
            'student_id' => $event->student->id,
            'alpha_count' => $event->alphaCount,
        ]);
    }
}
