<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function view(User $user, Subject $subject): bool
    {
        return $user->hasRole('admin') || ($user->hasRole('teacher') && $subject->teacher_id === $user->teacher?->id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Subject $subject): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Subject $subject): bool
    {
        return $this->update($user, $subject);
    }
}
