<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicDataSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $teacherUser = User::query()->where('email', 'guru@example.com')->first();
        $studentUser = User::query()->where('email', 'siswa@example.com')->first();

        if (! $teacherUser || ! $studentUser) {
            return;
        }

        $teacher = Teacher::query()->where('user_id', '=', $teacherUser->id)->first();

        if (! $teacher) {
            $teacher = Teacher::query()->create([
                'user_id' => $teacherUser->id,
                'nip' => 'TCH-001',
                'subject_id' => null,
                'phone' => null,
                'address' => null,
            ]);
        }

        $student = Student::query()->where('user_id', '=', $studentUser->id)->first();

        if (! $student) {
            $student = Student::query()->create([
                'user_id' => $studentUser->id,
                'student_number' => 'SMP13-001',
                'grade_level' => 'VIII',
            ]);
        }

        $classes = [
            ['name' => 'Matematika Dasar', 'room' => 'A1', 'schedule' => 'Senin, 07:00 - 08:30'],
            ['name' => 'Bahasa Indonesia', 'room' => 'B2', 'schedule' => 'Selasa, 08:45 - 10:15'],
            ['name' => 'IPA Terpadu', 'room' => 'C3', 'schedule' => 'Rabu, 10:30 - 12:00'],
        ];

        $academicClasses = collect($classes)->map(function ($classData) use ($teacher) {
            return AcademicClass::firstOrCreate([
                'teacher_id' => $teacher->id,
                'name' => $classData['name'],
            ], [
                'room' => $classData['room'],
                'schedule' => $classData['schedule'],
            ]);
        });

        foreach ($academicClasses as $academicClass) {
            $academicClass->students()->syncWithoutDetaching([$student->id]);
        }

        Grade::firstOrCreate([
            'student_id' => $student->id,
            'academic_class_id' => $academicClasses[0]->id,
            'assignment' => 'Ulangan Tengah Semester',
        ], [
            'score' => 88,
            'status' => 'Baik',
        ]);

        Grade::firstOrCreate([
            'student_id' => $student->id,
            'academic_class_id' => $academicClasses[1]->id,
            'assignment' => 'Tugas Presentasi',
        ], [
            'score' => 92,
            'status' => 'Sangat Baik',
        ]);

        Grade::firstOrCreate([
            'student_id' => $student->id,
            'academic_class_id' => $academicClasses[2]->id,
            'assignment' => 'Proyek Praktikum',
        ], [
            'score' => 85,
            'status' => 'Baik',
        ]);
    }
}
