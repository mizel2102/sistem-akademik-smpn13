<?php

namespace App\Policies;

use App\Models\AcademicClass;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicClassPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']) || $user->can('manage academic records');
    }

    public function view(User $user, AcademicClass $academicClass): bool
    {
        if ($user->hasRole('admin') || $user->can('manage academic records')) {
            return true;
        }

        if ($user->hasRole('teacher') && $user->teacher) {
            return $academicClass->teacher_id === $user->teacher->id
                || $academicClass->schedules()->where('teacher_id', $user->teacher->id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('teacher') || $user->hasRole('admin') || $user->can('manage academic records');
    }

    public function update(User $user, AcademicClass $academicClass): bool
    {
        if ($user->hasRole('admin') || $user->can('manage academic records')) {
            return true;
        }

        return $user->hasRole('teacher') && $user->teacher && $academicClass->teacher_id === $user->teacher->id;
    }

    public function delete(User $user, AcademicClass $academicClass): bool
    {
        return $this->update($user, $academicClass);
    }
}
