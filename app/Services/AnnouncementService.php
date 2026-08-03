<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Support\Collection;

class AnnouncementService
{
    public function all(): Collection
    {
        return Announcement::with('user')->orderByDesc('published_at')->get();
    }

    public function create(array $data): Announcement
    {
        return Announcement::create($data);
    }

    public function update(Announcement $announcement, array $data): Announcement
    {
        $announcement->update($data);
        return $announcement;
    }

    public function delete(Announcement $announcement): bool
    {
        Announcement::destroy($announcement->id);
        return true;
    }
}
