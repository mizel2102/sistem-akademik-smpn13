<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Collection;

class StudentService
{
    public function all(): Collection
    {
        return Student::with('user', 'academicClass')->orderBy('id')->get();
    }

    public function create(array $data): Student
    {
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'] ?? 'password123'),
        ]);

        $studentRole = \Spatie\Permission\Models\Role::findOrCreate('student', 'web');
        $user->assignRole($studentRole);

        $data['user_id'] = $user->id;

        $student = Student::create($data);

        if (! empty($data['academic_class_id'])) {
            $student->classes()->syncWithoutDetaching([$data['academic_class_id']]);
        }

        return $student;
    }

    public function update(Student $student, array $data): Student
    {
        if ($student->user) {
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];
            if (! empty($data['password'])) {
                $userData['password'] = bcrypt($data['password']);
            }
            $student->user->fill($userData)->save();
        }

        $student->fill($data)->save();

        if (! empty($data['academic_class_id'])) {
            $student->classes()->syncWithoutDetaching([$data['academic_class_id']]);
        }

        return $student;
    }

    public function delete(Student $student): bool
    {
        return (bool) Student::destroy($student->id);
    }
}
