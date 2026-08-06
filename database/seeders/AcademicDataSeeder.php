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

        // Seed real subjects
        $subjects = [
            ['name' => 'Matematika Dasar', 'code' => 'MTK-DSR'],
            ['name' => 'Bahasa Indonesia', 'code' => 'IND'],
            ['name' => 'IPA Terpadu', 'code' => 'IPA-TRP'],
        ];

        $subjectIds = [];
        foreach ($subjects as $subj) {
            $subject = \App\Models\Subject::firstOrCreate(
                ['code' => $subj['code']],
                ['name' => $subj['name']]
            );
            $subjectIds[$subj['name']] = $subject->id;
        }

        // Clean up dummy subject if it exists
        \App\Models\Subject::where('code', 'DUMMY-SUBJ')->orWhere('name', 'Uji Coba')->delete();

        $teacher = Teacher::query()->where('user_id', '=', $teacherUser->id)->first();

        if (! $teacher) {
            $teacher = Teacher::query()->create([
                'user_id' => $teacherUser->id,
                'nip' => 'TCH-001',
                'subject_id' => $subjectIds['Matematika Dasar'],
                'phone' => null,
                'address' => null,
            ]);
        } else {
            $teacher->update(['subject_id' => $subjectIds['Matematika Dasar']]);
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

        $activeSemesterId = \App\Models\Semester::active()?->id ?? \App\Models\Semester::first()?->id;

        Grade::firstOrCreate([
            'student_id' => $student->id,
            'academic_class_id' => $academicClasses[0]->id,
            'assignment' => 'Ulangan Tengah Semester',
        ], [
            'score' => 88,
            'status' => 'Baik',
            'subject_id' => $subjectIds['Matematika Dasar'],
            'semester_id' => $activeSemesterId,
        ]);

        Grade::firstOrCreate([
            'student_id' => $student->id,
            'academic_class_id' => $academicClasses[1]->id,
            'assignment' => 'Tugas Presentasi',
        ], [
            'score' => 92,
            'status' => 'Sangat Baik',
            'subject_id' => $subjectIds['Bahasa Indonesia'],
            'semester_id' => $activeSemesterId,
        ]);

        Grade::firstOrCreate([
            'student_id' => $student->id,
            'academic_class_id' => $academicClasses[2]->id,
            'assignment' => 'Proyek Praktikum',
        ], [
            'score' => 85,
            'status' => 'Baik',
            'subject_id' => $subjectIds['IPA Terpadu'],
            'semester_id' => $activeSemesterId,
        ]);
    }
}
