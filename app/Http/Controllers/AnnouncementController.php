<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(AnnouncementService $service): View
    {
        $this->authorize('viewAny', Announcement::class);

        $announcements = $service->all();

        return view('admin.announcements', compact('announcements'));
    }

    public function show(Announcement $announcement): View
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function store(StoreAnnouncementRequest $request, AnnouncementService $service): RedirectResponse
    {
        $this->authorize('create', Announcement::class);

        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $service->create($data);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement, AnnouncementService $service): RedirectResponse
    {
        $this->authorize('update', $announcement);

        $service->update($announcement, $request->validated());

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $this->authorize('delete', $announcement);

        Announcement::destroy($announcement->getKey());

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
