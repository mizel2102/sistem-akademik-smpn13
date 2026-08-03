<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function view(User $user, Schedule $schedule): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('teacher') && $user->teacher) {
            return $schedule->teacher_id === $user->teacher->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Schedule $schedule): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Schedule $schedule): bool
    {
        return $user->hasRole('admin');
    }
}
