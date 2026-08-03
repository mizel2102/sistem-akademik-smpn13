<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Attendance $attendance): bool
    {
        return $user->hasRole('admin')
            || ($user->hasRole('student') && $attendance->student->user_id === $user->id)
            || ($user->hasRole('teacher') && $attendance->academicClass && $attendance->academicClass->teacher_id === $user->teacher?->id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('student');
    }
}
