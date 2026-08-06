<?php

namespace App\Services;

use App\Models\AcademicClass;
use Illuminate\Support\Collection;

class AcademicClassService
{
    public function all(): Collection
    {
        return AcademicClass::with('teacher')->orderBy('name')->get();
    }

    public function create(array $data): AcademicClass
    {
        if (empty($data['access_token'])) {
            $data['access_token'] = AcademicClass::generateUniqueToken();
        }

        if (! empty($data['teacher_name'])) {
            $teacherName = trim($data['teacher_name']);
            $teacher = \App\Models\Teacher::whereHas('user', function ($q) use ($teacherName) {
                $q->where('name', 'like', "%{$teacherName}%");
            })->first();

            if (! $teacher) {
                $user = \App\Models\User::create([
                    'name' => $teacherName,
                    'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $teacherName)) . '@smpn13.sch.id',
                    'password' => bcrypt('password123'),
                ]);
                $user->assignRole('teacher');
                $teacher = \App\Models\Teacher::create([
                    'user_id' => $user->id,
                    'nip' => 'NIP-' . rand(10000, 99999),
                ]);
            }

            $data['teacher_id'] = $teacher->id;
        }

        $class = AcademicClass::create($data);

        // app(TeacherAcademicService::class)->autoEnrollStudentsByGradeLevel($class);

        return $class;
    }

    public function update(AcademicClass $academicClass, array $data): AcademicClass
    {
        if (! empty($data['teacher_name'])) {
            $teacherName = trim($data['teacher_name']);
            $teacher = \App\Models\Teacher::whereHas('user', function ($q) use ($teacherName) {
                $q->where('name', 'like', "%{$teacherName}%");
            })->first();

            if (! $teacher) {
                $user = \App\Models\User::create([
                    'name' => $teacherName,
                    'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $teacherName)) . '@smpn13.sch.id',
                    'password' => bcrypt('password123'),
                ]);
                $user->assignRole('teacher');
                $teacher = \App\Models\Teacher::create([
                    'user_id' => $user->id,
                    'nip' => 'NIP-' . rand(10000, 99999),
                ]);
            }

            $data['teacher_id'] = $teacher->id;
        }

        $academicClass->fill($data)->save();

        return $academicClass;
    }

    public function delete(AcademicClass $academicClass): bool
    {
        return (bool) AcademicClass::destroy($academicClass->id);
    }
}
