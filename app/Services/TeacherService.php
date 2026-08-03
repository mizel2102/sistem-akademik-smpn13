<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Collection;

class TeacherService
{
    public function all(): Collection
    {
        return Teacher::with('user')->orderBy('id')->get();
    }

    public function create(array $data): Teacher
    {
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'] ?? 'password123'),
        ]);

        $teacherRole = \Spatie\Permission\Models\Role::findOrCreate('teacher', 'web');
        $user->assignRole($teacherRole);

        $data['user_id'] = $user->id;

        if (! empty($data['subject_name'])) {
            $subject = \App\Models\Subject::firstOrCreate(['name' => trim($data['subject_name'])]);
            $data['subject_id'] = $subject->id;
        }

        return Teacher::create($data);
    }

    public function update(Teacher $teacher, array $data): Teacher
    {
        if ($teacher->user) {
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];
            if (! empty($data['password'])) {
                $userData['password'] = bcrypt($data['password']);
            }
            $teacher->user->fill($userData)->save();
        }

        if (! empty($data['subject_name'])) {
            $subject = \App\Models\Subject::firstOrCreate(['name' => trim($data['subject_name'])]);
            $data['subject_id'] = $subject->id;
        }

        $teacher->fill($data)->save();

        return $teacher;
    }

    public function delete(Teacher $teacher): bool
    {
        return (bool) Teacher::destroy($teacher->id);
    }
}
