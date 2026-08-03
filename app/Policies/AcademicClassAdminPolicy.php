<?php

namespace App\Policies;

use App\Models\AcademicClass;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicClassAdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, AcademicClass $academicClass): bool
    {
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, AcademicClass $academicClass): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, AcademicClass $academicClass): bool
    {
        return $user->hasRole('admin');
    }
}
