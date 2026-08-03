<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Student $student): bool
    {
        return $user->hasRole('admin') || $user->id === $student->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Student $student): bool
    {
        return $user->hasRole('admin') || $user->id === $student->user_id;
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasRole('admin');
    }
}
