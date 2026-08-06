<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GradePolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->hasRole('teacher') || $user->hasRole('admin') || $user->can('manage academic records');
    }

    public function update(User $user, Grade $grade): bool
    {
        if ($user->hasRole('admin') || $user->can('manage academic records')) {
            return true;
        }

        if ($user->hasRole('teacher') && $user->teacher) {
            $teacher = $user->teacher;
            $subjectId = $teacher->subject_id ?? \App\Models\Subject::query()->first()?->id;
            return $grade->academicClass->teacher_id === $teacher->id || (
                $grade->subject_id === $subjectId &&
                ($grade->academicClass->teacher_id === $teacher->id || $grade->academicClass->schedules()->where('teacher_id', $teacher->id)->exists())
            );
        }

        return false;
    }

    public function delete(User $user, Grade $grade): bool
    {
        return $this->update($user, $grade);
    }
}
