<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service)
    {
    }

    public function index(): View
    {
        $notifications = $this->service->getNotifications(Auth::user());

        return view('notifications.index', compact('notifications'));
    }

    public function markAllRead(): RedirectResponse
    {
        if ($user = Auth::user()) {
            $user->unreadNotifications->markAsRead();
        }

        return redirect()->route('notifications.index')->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
